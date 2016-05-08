<?php

/**
 * Created by PhpStorm.
 * User: praverma
 * Date: 5/8/2016
 * Time: 8:43 AM
 */
class studentServices
{
    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/../config/config.php';
        require_once dirname(__FILE__) . '/../config/mongoConnect.php';

        // opening db connection
        $this->mongoConnect = new mongoConnect();
    }

    public function getTrendingSubjectsPerClass_Subject(){
        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collection = $database->selectCollection(COLLECTION_USER);

        $operators = array(
            array('$match' => array('student' => array('$exists' => true))),
            array('$unwind' => '$student.studies'),
            array('$unwind' => '$student.studies.class'),
            array('$unwind' => '$student.studies.subject'),
            array('$group' => array('_id' => array('class' => '$student.studies.class', 'subject' => '$student.studies.subject'),'total_students' => array('$sum' => 1))),
            array('$sort' => array('total_students' => -1))
        );
        $option = array('allowDiskUse' => true);
        $result = $collection->aggregate($operators,$option);
        return $result;
    }
}