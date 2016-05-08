<?php

/**
 * Created by PhpStorm.
 * User: praverma
 * Date: 5/8/2016
 * Time: 11:58 PM
 */
require_once __DIR__ . '/../services/usersAdminService.php';

class indexCreation
{
    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/../config/config.php';
        require_once dirname(__FILE__) . '/../config/mongoConnect.php';

        // opening db connection
        $this->mongoConnect = new mongoConnect();
    }

    private function isCollectionCreated($coll){
        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collections = $database->listCollections();
        foreach ($collections as $collection) {
            if($collection == DATABASE_NAME.'.'.$coll){
                return true;
            }
        }
        return false;
    }
    private function createIndex($coll,$index){

        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collection = $database->selectCollection($coll);

        //how to find a single document in a collection by some condition and limiting the returned fields.
        $result = $collection->createIndex($index);
    }
    public function createIndexOnCollection($collection, $index){
        if($this->isCollectionCreated($collection) == false){
            $this->createIndex($collection,$index);
        }
    }
}