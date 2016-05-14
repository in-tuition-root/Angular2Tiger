<?php

/**
 * Created by PhpStorm.
 * User: praverma
 * Date: 5/7/2016
 * Time: 9:49 AM
 */
class tutorServices
{
    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/../config/config.php';
        require_once dirname(__FILE__) . '/../config/mongoConnect.php';

        // opening db connection
        $this->mongoConnect = new mongoConnect();
    }

    public function getAllTutors(){
        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collection = $database->selectCollection(COLLECTION_USER);

        $result = $collection->find(array('tutor' => array('$exists' => true)));
        return $result;
    }

    public function getAvailableTutorsPerClass_Subject(){
        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collection = $database->selectCollection(COLLECTION_USER);

        $operators = array(
            array('$match' => array('tutor' => array('$exists' => true))),
            array('$unwind' => '$tutor.teaches'),
            array('$unwind' => '$tutor.teaches.class'),
            array('$unwind' => '$tutor.teaches.subject'),
            array('$group' => array('_id' => array('class' => '$tutor.teaches.class', 'subject' => '$tutor.teaches.subject'),'total_tutors' => array('$sum' => 1))),
            array('$sort' => array('total_tutors' => -1))
        );
        $option = array('allowDiskUse' => true);
        $result = $collection->aggregate($operators,$option);
        return $result;
    }

    public function getTutorsByClass_Subject($class, $subject, $student_long, $student_lat){
        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collection = $database->selectCollection(COLLECTION_USER);
        $query = array('tutor.teaches' =>
            array('$elemMatch' =>
                array('class' => $class, 'subject' => $subject)), 'location' =>
            array('$near' =>
                array('$geometry' =>
                    array('type' => 'Point' , 'coordinates' =>
                        array(intval($student_long),intval($student_lat))
                    )
                )
            )
        );
        $result = $collection->find($query);
        return $result;
    }

    public function getTutors($filterParamsArray){
        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collection = $database->selectCollection(COLLECTION_USER);

        $query = array();
        array_push($query,array('tutor' => array('$exists' => true)));

        foreach($filterParamsArray as $key => $value){
            $filter = array();
            if(isset($value)){        //check if the value of the filter is null
                if(is_array($value) && ($key !== "location")){   //check if the value is an array
                    $array = array();
                    foreach($value as $val){       //create an array to make a 'or' where clause
                        array_push($array,array($key => $val));
                    }
                    $filter['$or'] = $array;
                    array_push($query,$filter);
                    continue;
                }

                if($key == "location"){
                    $filter[$key] =  array('$near'=>array('$geometry'=>array('type'=>"Point",'coordinates'=>array($val[0],$val[1]))));
                    array_push($query,$filter);
                    continue;
                }

                $filter[$key] = $value;
                array_push($query,$filter);
            }
        }

        $cursor = $collection->find(array('$and'=> $query));
        $cursor->limit(1);


        $result = iterator_to_array($cursor);

        return $result;
    }
}