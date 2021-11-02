<?php
class Watchers{
  
    // database connection and table name
    private $conn;
    private $table_name = "Watchers";
  
    // object properties
    public $watchers_id;
    public $users_id;
	public $topics_id;
  
    // constructor with $db as database connection
    public function __construct($db)
	{
        $this->conn = $db;
    }
	
	// create watchers
	function create(){
  
		// query to insert record
		$query = "INSERT INTO " . $this->table_name . "
				SET 
				users_id=:users_id,
				topics_id=:topics_id";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->users_id=htmlspecialchars(strip_tags($this->users_id));
		$this->topics_id=htmlspecialchars(strip_tags($this->topics_id));
		
		// bind values
		$stmt->bindParam(":users_id", $this->users_id);
		$stmt->bindParam(":topics_id", $this->topics_id);
		
		// response array
		$response_arr=array();
		$response_arr["status"]=false;
		$response_arr["data"]=array();
		// execute query
		if($stmt->execute())
		{						
			//Set Status - to be used for setting Status array in response
			$response_arr["status"]= true;			
			//Get last id inserted 
			$last_id = $this->conn->lastInsertId();
			
			$watchers_item=array(
				"watchers_id" => $last_id,
				"users_id" => $this->users_id,
				"topics_id" => $this->topics_id
			);
			array_push($response_arr["data"], $watchers_item);
		}
		return $response_arr;
	}
	
	// delete the watchers
	function delete(){
	  
	  	// delete query
		$query = "DELETE 
				  FROM " . $this->table_name . " 
				  WHERE watchers_id = :watchers_id";
				
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->watchers_id=htmlspecialchars(strip_tags($this->watchers_id));
		
		// bind values
		$stmt->bindParam(":watchers_id", $this->watchers_id);
		
		// watcherss array
		$response_arr=array();
		$response_arr["status"]=false;
		$response_arr["data"]=array();
		
		// execute query
		if($stmt->execute())
		{
			$num = $stmt->rowCount();
			// check if more than 0 record found
			if($num>0)
			{
				//Set Status
				$response_arr["status"]= true;
			}
		}
		return $response_arr;
	}


}
?>