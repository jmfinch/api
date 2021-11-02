<?php
include_once '../objects/watchers.php';

class Replies{
  
    // database connection and table name
    private $conn;
    private $table_name = "Replies";
  
    // object properties
    public $replies_id;
    public $topics_id;
    public $replies_body;
    public $replies_created_when;
    public $replies_updated_when;
    public $users_id;
  
    // constructor with $db as database connection
    public function __construct($db)
	{
        $this->conn = $db;
    }
	// create replies
	function create(){
  
		// query to insert record
		$query = "INSERT INTO " . $this->table_name . "
				SET 
				topics_id=:topics_id,
				replies_body=:replies_body,
				users_id=:users_id,
				replies_created_when=:replies_created_when,
				replies_updated_when=:replies_updated_when ";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->topics_id=htmlspecialchars(strip_tags($this->topics_id));
		$this->replies_body=htmlspecialchars(strip_tags($this->replies_body));
		$this->users_id=htmlspecialchars(strip_tags($this->users_id));
		$this->replies_created_when=htmlspecialchars(strip_tags($this->replies_created_when));
		$this->replies_updated_when=htmlspecialchars(strip_tags($this->replies_updated_when));
	  
		// bind values
		$stmt->bindParam(":topics_id", $this->topics_id);
		$stmt->bindParam(":replies_body", $this->replies_body);
		$stmt->bindParam(":users_id", $this->users_id);
		$stmt->bindParam(":replies_created_when", $this->replies_created_when);
		$stmt->bindParam(":replies_updated_when", $this->replies_updated_when);
	  
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
			
			$replies_item=array(
				"replies_id" => $last_id,
				"topics_id" => $this->topics_id,
				"replies_body" => $this->replies_body,
				"users_id" => $this->users_id,
				"replies_created_when" => $this->replies_created_when,
				"replies_updated_when" => $this->replies_updated_when,
			);
			array_push($response_arr["data"], $replies_item);
		}
		return $response_arr;
	}
	// read all replies
	function read()
	{  
		$query = "SELECT replies_id, topics_id, replies_body, users_id, replies_created_when, replies_updated_when
				FROM " . $this->table_name ;
	  
		// prepare query statement
		$stmt = $this->conn->prepare($query);
		
		// userss array
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
				
				 // Set Data
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
			  
					$replies_item=array(
						"replies_id" => $replies_id,
						"topics_id" => $topics_id,
						"replies_body" => $replies_body,
						"users_id" => $users_id,
						"replies_created_when" => $replies_created_when,
						"replies_updated_when" => $replies_updated_when
					);
					array_push($response_arr["data"], $replies_item);
				}
			}
		}
		return $response_arr;	
	}
	// read one replies
	function readOne(){
	  
		// query to read single record
		
		$query = "SELECT replies_id, topics_id, replies_body, users_id, replies_created_when, replies_updated_when
				FROM " . $this->table_name . " 
				WHERE
					replies_id = :replies_id
				LIMIT
					0,1";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	  
		// sanitize
		$this->replies_id=htmlspecialchars(strip_tags($this->replies_id));
		
		// bind values
		$stmt->bindParam(":replies_id", $this->replies_id);
		
		// repliess array
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
				
				 // Set Data
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
			  
					$replies_item=array(
						"replies_id" => $replies_id,
						"topics_id" => $topics_id,
						"replies_body" => $replies_body,
						"users_id" => $users_id,
						"replies_created_when" => $replies_created_when,
						"replies_updated_when" => $replies_updated_when
					);
					array_push($response_arr["data"], $replies_item);
				}
			}
		}
		return $response_arr;
	}
	// update the replies
	function update(){
	  
		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					topics_id = :topics_id,
					replies_body = :replies_body,
					replies_updated_when = :replies_updated_when
				WHERE
					replies_id = :replies_id";
	  
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->replies_id=htmlspecialchars(strip_tags($this->replies_id));
		$this->topics_id=htmlspecialchars(strip_tags($this->topics_id));
		$this->replies_body=htmlspecialchars(strip_tags($this->replies_body));
		$this->replies_updated_when=htmlspecialchars(strip_tags($this->replies_updated_when));
	  
		// bind values
		$stmt->bindParam(":replies_id", $this->replies_id);
		$stmt->bindParam(":topics_id", $this->topics_id);
		$stmt->bindParam(":replies_body", $this->replies_body);
		$stmt->bindParam(":replies_updated_when", $this->replies_updated_when);
	  
		// userss array
		$response_arr=array();
		$response_arr["status"]=false;
		$response_arr["data"]=array();
		
		// execute query
		if($stmt->execute())
		{
			//check for updated data
			if($stmt->rowCount()>0)
			{
				//Set Status
				$response_arr["status"]= true;
				
				$replies_item=array(
					"replies_id" => $this->replies_id,
					"topics_id" => $this->topics_id,
					"replies_body" => $this->replies_body,
					"replies_updated_when" => $this->replies_updated_when
				);
				array_push($response_arr["data"], $replies_item);
			}
		}
		return $response_arr;
	}
	// delete the replies
	function delete(){
	  
	  	// delete query
		$query = "DELETE 
				  FROM " . $this->table_name . " 
				  WHERE replies_id = :replies_id";
				
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->replies_id=htmlspecialchars(strip_tags($this->replies_id));
		
		// bind values
		$stmt->bindParam(":replies_id", $this->replies_id);
		
		// repliess array
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
	// search replies by topics_id
	function search(){
	  
		//This can be utilized to be more extensive with different values being searched
		// select all query
		$query = "SELECT replies_id, topics_id, replies_body, users_id, replies_created_when, replies_updated_when
				FROM " . $this->table_name . " 
				WHERE
					topics_id = :topics_id
				ORDER BY
					replies_updated_when DESC";
	  
	  
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	  
		// sanitize
		$this->topics_id=htmlspecialchars(strip_tags($this->topics_id));
		
		// bind values
		$stmt->bindParam(":topics_id", $this->topics_id);
		
		// repliess array
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
				
				 // Set Data
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
			  
					$replies_item=array(
						"replies_id" => $replies_id,
						"topics_id" => $topics_id,
						"replies_body" => $replies_body,
						"users_id" => $users_id,
						"replies_created_when" => $replies_created_when,
						"replies_updated_when" => $replies_updated_when
					);
					array_push($response_arr["data"], $replies_item);
				}
			}
		}
		return $response_arr;
	}
	// fetch all replies by topics_id
	function fetch(){
	  
		//This can be utilized to be more extensive with different values being searched
		// select all query
		$query = "SELECT Distinct u.users_email
				FROM " . $this->table_name . " AS r
				INNER JOIN `Users` AS u ON r.users_id = u.users_id
				WHERE
					topics_id = :topics_id ";
	  
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	  
		// sanitize
		$this->topics_id=htmlspecialchars(strip_tags($this->topics_id));
		
		// bind values
		$stmt->bindParam(":topics_id", $this->topics_id);
		
		// repliess array
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
				
				 // Set Data
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
			  
					$replies_item=array(
						"users_email" => $users_email
					);
					array_push($response_arr["data"], $replies_item);
				}
			}
		}
		return $response_arr;
	}
	
	
	// read replies with pagination
	public function readPaging($from_record_num, $records_per_page){
	  
		// select query
		$query = "SELECT a.replies_id, a.topics_id, a.replies_body, a.users_id, a.replies_created_when, a.replies_updated_when
				FROM
					" . $this->table_name . " a
					
				ORDER BY a.replies_updated_when DESC
				LIMIT ?, ?";
	  
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	  
		// bind variable values
		$stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
	  
		// execute query
		$stmt->execute();
	  
		// return values from database
		return $stmt;
	}
	// used for paging replies
	public function count(){
		$query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
	  
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	  
		return $row['total_rows'];
	}
}
?>