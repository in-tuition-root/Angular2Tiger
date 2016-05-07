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

}