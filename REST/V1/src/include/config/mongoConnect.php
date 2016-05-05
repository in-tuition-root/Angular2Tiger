<?php

/**
 * Handling database connection
 *
 * @author Pramod Kumar Raghav
 */
class mongoConnect {

    private $conn;

    function __construct() {        
    }

    /**
     * Establishing database connection
     * @return database connection handler
     */
    function connect() {
        include_once dirname(__FILE__) . '/config.php';

		if(DATABASE_USERNAME != "" && DATABASE_PASSWORD != ""){
			$db_cred = DATABASE_USERNAME.":".DATABASE_PASSWORD."@";
		}else{
			$db_cred = "";
		}
        
		#construct port query only if port is defined
		if(DATABASE_PORT != ""){
			$db_port = ":".DATABASE_PORT;
		}else{
			$db_port = "";
		}
		
		#pass argument only if server is defined
		if(DATABASE_SERVER){
			$db_server = DATABASE_SERVER;
			$this->connection = new MongoClient("mongodb://".$db_cred.$db_server.$db_port);
		}else{
			$this->connection = new MongoClient();
		}

		date_default_timezone_set(TIMEZONE);
        // returing connection resource
        return $this->conn;
    }
}
