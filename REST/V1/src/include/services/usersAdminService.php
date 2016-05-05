<?php

/**
 * @author Pramod Kumar Raghav
 *
 */
class usersAdminService {
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
	public function createUsers($item){
		$this->mongoConnect->connect();
		$this->conn = $this->mongoConnect->connection;
		$database 	= $this->conn->{DATABASE_NAME};
		$collection = $database->selectCollection(COLLECTION_USER);
		
		$array = array();
		
		// Set the default values

		$array["mobileNumber"] = $item->mobileNumber;
		$array["name"] = $item->name;
		$array["createdAt"] = new MongoDate();
		$array["defaultProfile"] = true;
		$array["defaultProfileImage"] = true;
		
		// If an array literal is used, there is no way to access the generated _id
		$result = $collection->insert($array);
		return $result;
	}
	
	/**
     *	Update users
     *  @param $item
     *  @return object
	**/
	public function updateUsers($item){

		$this->mongoConnect->connect();
		$this->conn = $this->mongoConnect->connection;
		$database 	= $this->conn->{DATABASE_NAME};
		$collection = $database->selectCollection(COLLECTION_USER);

		$array = array();
		//array $criteria , array $new_object [, array $options = array() ]
		foreach ($item  as $key=>$value){
			$array[$key] = $value;
		}
		
		//New data
		$newdata = array('$set' => $array);
		
		// Where mobileNumber is equal to $item->mobileNumber
		$result = $collection->update(array('mobileNumber' => "$item->mobileNumber"), $newdata);

		return $result;
	}


    /**
     *  Delete the user from user collection
     *  @param $item
     *  @return bool
     */
    public function deleteUser($item){
        $this->mongoConnect->connect();
        $this->conn = $this->mongoConnect->connection;
        $database 	= $this->conn->{DATABASE_NAME};
        $collection = $database->selectCollection(COLLECTION_USER);

        // Where mobileNumber is equal to $item->mobileNumber
        $result = $collection->remove(array('mobileNumber' => "$item->mobileNumber"));

        return $result;
    }

	/**
     *	getUserByMobile
     *  @param $item
     *  @return object
	**/
	public function getUserByMobile($item){
		$this->mongoConnect->connect();
		$this->conn = $this->mongoConnect->connection;
		$database 	= $this->conn->{DATABASE_NAME};
		$collection = $database->selectCollection(COLLECTION_USER);
		
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
	
	public function isUserExists($item){
		$this->mongoConnect->connect();
		$this->conn = $this->mongoConnect->connection;
		$database 	= $this->conn->{DATABASE_NAME};
		$collection = $database->selectCollection(COLLECTION_USER);
		
		//how to find a single document in a collection by some condition and limiting the returned fields.
		//$result = $collection->findOne(array('mobileNumber' => $item->mobileNumber));
		$result = $collection->findOne(array('mobileNumber' => $item->mobileNumber),array('_id' => 0,'mobileNumber' => 1));
		
		return $result;
	}
	
	/**
     *	isThisValidUser
     *  @param $item
     *  @return object
	**/
	public function isThisValidUser($item){

		$this->mongoConnect->connect();
		$this->conn = $this->mongoConnect->connection;
		$database 	= $this->conn->{DATABASE_NAME};
		$collection = $database->selectCollection(COLLECTION_USER);
		
		//how to find a single document in a collection by some condition and limiting the returned fields.
		$result = $collection->findOne(array('mobileNumber' => $item->mobileNumber),array('_id' => 0));
		return $result;
	}
}
?>