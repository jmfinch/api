<?php
class Topics{
  
    // database connection and table name
    private $conn;
    private $table_name = "Topics";
  
    // object properties
    public $topics_id;
    public $topics_subject;
    public $topics_body;
    public $topics_created_when;
    public $topics_updated_when;
    public $users_id;
  
    // constructor with $db as database connection
    public function __construct($db)
	{
        $this->conn = $db;
    }
	// create topics
	function create(){
  
		$query = "INSERT INTO " . $this->table_name . "
				SET 
				topics_subject=:topics_subject,
				topics_body=:topics_body,
				users_id=:users_id,
				topics_created_when=:topics_created_when,
				topics_updated_when=:topics_updated_when ";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->topics_subject=htmlspecialchars(strip_tags($this->topics_subject));
		$this->topics_body=htmlspecialchars(strip_tags($this->topics_body));
		$this->users_id=htmlspecialchars(strip_tags($this->users_id));
		$this->topics_created_when=htmlspecialchars(strip_tags($this->topics_created_when));
		$this->topics_updated_when=htmlspecialchars(strip_tags($this->topics_updated_when));
	  
		// bind values
		$stmt->bindParam(":topics_subject", $this->topics_subject);
		$stmt->bindParam(":topics_body", $this->topics_body);
		$stmt->bindParam(":users_id", $this->users_id);
		$stmt->bindParam(":topics_created_when", $this->topics_created_when);
		$stmt->bindParam(":topics_updated_when", $this->topics_updated_when);
	  
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
			
			$topics_item=array(
				"topics_id" => $last_id,
				"topics_subject" => $this->topics_subject,
				"topics_body" => $this->topics_body,
				"users_id" => $this->users_id,
				"topics_created_when" => $this->topics_created_when,
				"topics_updated_when" => $this->topics_updated_when,
			);
			array_push($response_arr["data"], $topics_item);
		}
		return $response_arr;
	}
	// read topics
	function read()
	{  
		// select all query
		$query = "SELECT topics_id, topics_subject, topics_body, users_id, topics_created_when, topics_updated_when
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
			  
					$topics_item=array(
						"topics_id" => $topics_id,
						"topics_subject" => $topics_subject,
						"topics_body" => $topics_body,
						"users_id" => $users_id,
						"topics_created_when" => $topics_created_when,
						"topics_updated_when" => $topics_updated_when
					);
					array_push($response_arr["data"], $topics_item);
				}
			}
		}
		return $response_arr;	
	}
	// read one topics
	function readOne(){
	  
		// query to read single record
		
		$query = "SELECT topics_id, topics_subject, topics_body, users_id, topics_created_when, topics_updated_when
				FROM " . $this->table_name . "
				WHERE
					topics_id = :topics_id
				LIMIT
					0,1";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	  
		// sanitize
		$this->topics_id=htmlspecialchars(strip_tags($this->topics_id));
		
		// bind values
		$stmt->bindParam(":topics_id", $this->topics_id);
		
		// topicss array
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
			  
					$topics_item=array(
						"topics_id" => $topics_id,
						"topics_subject" => $topics_subject,
						"topics_body" => $topics_body,
						"users_id" => $users_id,
						"topics_created_when" => $topics_created_when,
						"topics_updated_when" => $topics_updated_when
					);
					array_push($response_arr["data"], $topics_item);
				}
			}
		}
		return $response_arr;	
	}
	// update the topics
	function update(){
	  
		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					topics_subject = :topics_subject,
					topics_body = :topics_body,
					topics_updated_when = :topics_updated_when
				WHERE
					topics_id = :topics_id";
	  
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	  
	  // sanitize
		$this->topics_id=htmlspecialchars(strip_tags($this->topics_id));
		$this->topics_subject=htmlspecialchars(strip_tags($this->topics_subject));
		$this->topics_body=htmlspecialchars(strip_tags($this->topics_body));
		$this->topics_updated_when=htmlspecialchars(strip_tags($this->topics_updated_when));
	  
		// bind values
		$stmt->bindParam(":topics_id", $this->topics_id);
		$stmt->bindParam(":topics_subject", $this->topics_subject);
		$stmt->bindParam(":topics_body", $this->topics_body);
		$stmt->bindParam(":topics_updated_when", $this->topics_updated_when);
	  
		// topics array
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
				
				$topics_item=array(
					"topics_id" => $this->topics_id,
					"topics_subject" => $this->topics_subject,
					"topics_body" => $this->topics_body,
					"topics_updated_when" => $this->topics_updated_when
				);
				array_push($response_arr["data"], $topics_item);
			}
		}
		return $response_arr;
	}
	// delete the topics
	function delete(){
	  
		// delete query
		$query = "DELETE 
				  FROM " . $this->table_name . " 
				  WHERE topics_id = :topics_id";
				
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->topics_id=htmlspecialchars(strip_tags($this->topics_id));
	  
		// bind values
		$stmt->bindParam(":topics_id", $this->topics_id);
		
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
			}
		}
		return $response_arr;
	}
	// search topics
	function search($keywords){
	  
		// select all query
		$query = "SELECT topics_id, topics_subject, topics_body, users_id, topics_created_when, topics_updated_when
				FROM " . $this->table_name . " t
				WHERE
					topics_subject LIKE ?
				ORDER BY
					topics_updated_when DESC";
	  
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$keywords=htmlspecialchars(strip_tags($keywords));
		$keywords = "%{$keywords}%";
	  
		// bind
		$stmt->bindParam(1, $keywords);
	  
		// execute query
		$stmt->execute();
	  
		return $stmt;
	}
	// read topics with pagination
	public function readPaging($from_record_num, $records_per_page){
	  
		// select query
		$query = "SELECT a.topics_id, a.topics_subject, a.topics_body, a.users_id, a.topics_created_when, a.topics_updated_when
				FROM
					" . $this->table_name . " a
					
				ORDER BY a.topics_updated_when DESC
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
	// used for paging topics
	public function count(){
		$query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
	  
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	  
		return $row['total_rows'];
	}
}
?>