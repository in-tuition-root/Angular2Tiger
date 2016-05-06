<?php

/**
 * @author Pramod Kumar Raghav
 *
 */
class authServices {
	private $conn;
	
	function __construct() {
		require_once dirname(__FILE__) . '/../config/config.php';
		require_once dirname(__FILE__) . '/../config/mongoConnect.php';

        // opening db connection
		$this->mongoConnect = new mongoConnect();
    }
	
	/**
	 *	Create a new users
	 *
	 *	Required parameter
	 *		@param object $item
	 *  $item->mobileNumber : User mobile number
     *  $item->name : User Name
     *  $item->password : User password
     *
	 * 	@return object
	*/
	public function createMobileAuth($item){
		$authData = new stdClass();

        $authData->accessLevel = "Full";

		$this->mongoConnect->connect();
		$this->conn = $this->mongoConnect->connection;
		$database 	= $this->conn->{DATABASE_NAME};
		$collection = $database->selectCollection(COLLECTION_AUTH);
		
		$array = array();
		
		// Set the default values
		$hash = hashSSHA($item->password);
		$encryptedPassword = $hash["encrypted"]; // encrypted password
		$salt = $hash["salt"]; // salt

		$array["mobileNumber"] 			=	$item->mobileNumber;
		$array["encryptedPassword"] 	=	$encryptedPassword;
		$array["salt"] 					=	$salt;

		$array["createdAt"] 			= new MongoDate();
        $array["authData"] 			= $authData;
		
		// If an array literal is used, there is no way to access the generated _id
		$result = $collection->insert($array);
		return $result;
	}
	
	/**
     *	Update mobileAuth
     *  We will update the user password
     *  @param $item
     *  @return object
	**/
	public function updateMobileAuth($item){

		$this->mongoConnect->connect();
		$this->conn = $this->mongoConnect->connection;
		$database 	= $this->conn->{DATABASE_NAME};
		$collection = $database->selectCollection(COLLECTION_AUTH);

		$array = array();

        // Set the default values
        $hash = hashSSHA($item->password);
        $encryptedPassword = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $array["encryptedPassword"] 	=	$encryptedPassword;
        $array["salt"] 					=	$salt;

        $array["updatedAt"] 			= new MongoDate();

		
		//New data
		$newdata = array('$set' => $array);
		
		// Where mobileNumber is equal to $item->mobileNumber
		$result = $collection->update(array('mobileNumber' => "$item->mobileNumber"), $newdata);

		return $result;
	}
	

	/**
     *	getUserByMobile
     *  @param $item
     *  @return object
	**/
	public function getUserByMobile($item){
		$result = new stdClass();
		$this->mongoConnect->connect();
		$this->conn = $this->mongoConnect->connection;
		$database 	= $this->conn->{DATABASE_NAME};
		$collection = $database->selectCollection(COLLECTION_AUTH);
		
		//how to find a single document in a collection by some condition and limiting the returned fields.
		//$result = $collection->findOne(array('mobile_number' => $item->mobile_number));
		$result = $collection->findOne(array('mobileNumber' => $item->mobileNumber),array('_id' => 0));
		
		return $result;
	}
	
	
	/**
     *	Is user exits
     *  @param object $item
     *  @return object 
	**/
	
	public function isUsersExists($item){
		$this->mongoConnect->connect();
		$this->conn = $this->mongoConnect->connection;
		$database 	= $this->conn->{DATABASE_NAME};
		$collection = $database->selectCollection(COLLECTION_AUTH);
		
		//how to find a single document in a collection by some condition and limiting the returned fields.
		//$result = $collection->findOne(array('mobileNumber' => $item->mobileNumber));
		$result = $collection->findOne(array('mobileNumber' => $item->mobileNumber),array('_id' => 0,'mobileNumber' => 1));
		
		return $result;
	}
	
	/**
     *	isThisValidUser : This used for validate the user id and password are correct 
     *  @param $item
     *  @return object
	**/
	public function isThisValidUser($item){
		$this->mongoConnect->connect();
		$this->conn = $this->mongoConnect->connection;
		$database 	= $this->conn->{DATABASE_NAME};
		$collection = $database->selectCollection(COLLECTION_AUTH);
		
		//how to find a single document in a collection by some condition and limiting the returned fields.
        $output = $collection->findOne(array('mobileNumber' => $item->mobileNumber),array('_id' => 0));


        if($output){
            // verifying user password
            $salt = $output['salt'];
            $encryptedPassword = $output['encryptedPassword'];

            $hash = checkhashSSHA($salt, $item->password);

            // check for password equality
            if ($encryptedPassword == $hash) {
                // user authentication details are correct
                $output['result'] = true;
                $output['message'] = "user authentication details are correct";
            }else{
                $output['result'] = false;
                $output['message'] = "Wrong password";
            }
        }else{
            $output['result']= false;
            $output['message']  = "Access Denied... User does not exits or invalid user";;
        }

		return $output;
	}
    
}