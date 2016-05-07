<?php
/**
 * Created by PhpStorm.
 * User: nejindal
 * Date: 5/6/2016
 * Time: 11:01 PM
 */

class subjectServices{

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/../config/config.php';
        require_once dirname(__FILE__) . '/../config/mongoConnect.php';

        // opening db connection
        $this->mongoConnect = new mongoConnect();
    }

    /**
     *	getSubjects
     *  @return object
     **/
    public function getSubjects(){

        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collection = $database->selectCollection(COLLECTION_SUBJECTS);
        
        $cursor = $collection->find(array(),array("_id"=>0,"name"=>1,"classes"=>1));
        $result = iterator_to_array($cursor);
        var_dump($result);
        return $result;

    }

    public function getSubjectByName($subName){
        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collection = $database->selectCollection(COLLECTION_SUBJECTS);

        $result = $collection->findOne(array("name"=> $subName));
        return $result;
    }

    /**
     *	addSubject
     * @param item
     *  @return object
     **/
    public function addSubject($item){

        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collection = $database->selectCollection(COLLECTION_SUBJECTS);


        $array = array();
        $array['name'] = $item->newSubject;
        $array['classNames'] = $item->classNames;
        $result = $collection->insert($array);
        return $result;

    }

    public function updateSubjectClass($item){

        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collection = $database->selectCollection(COLLECTION_SUBJECTS);

        $result = $collection->update(array("name"=>$item->name),array('$addToSet' => array('members' => $item->class)));
        return $result;
    }
}