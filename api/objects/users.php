<?php
class Users{
  
    // database connection and table name
    private $conn;
    private $table_name = "Users";
  
    // object properties
    public $users_id;
    public $users_email;
    public $users_pass;
    public $users_alias;
    public $users_created_when;
    public $users_updated_when;
  
    // constructor with $db as database connection
    public function __construct($db)
	{
        $this->conn = $db;
    }
	// create users
	function create(){
  
		$query = "INSERT INTO " . $this->table_name . "
				SET 
				users_email=:users_email,
				users_pass=:users_pass,
				users_alias=:users_alias,
				users_created_when=:users_created_when,
				users_updated_when=:users_updated_when ";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->users_email=htmlspecialchars(strip_tags($this->users_email));
		$this->users_pass=htmlspecialchars(strip_tags($this->users_pass));
		$this->users_alias=htmlspecialchars(strip_tags($this->users_alias));
		$this->users_created_when=htmlspecialchars(strip_tags($this->users_created_when));
		$this->users_updated_when=htmlspecialchars(strip_tags($this->users_updated_when));
	  
		// bind values
		$stmt->bindParam(":users_email", $this->users_email);
		$stmt->bindParam(":users_pass", $this->users_pass);
		$stmt->bindParam(":users_alias", $this->users_alias);
		$stmt->bindParam(":users_created_when", $this->users_created_when);
		$stmt->bindParam(":users_updated_when", $this->users_updated_when);
	  
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
			
			$users_item=array(
				"users_id" => $last_id,
				"users_email" => $this->users_email,
				"users_pass" => $this->users_pass,
				"users_alias" => $this->users_alias,
				"users_created_when" => $this->users_created_when,
				"users_updated_when" => $this->users_updated_when,
			);
			array_push($response_arr["data"], $users_item);
		}
		return $response_arr;
	}
	// read users
	function read()
	{  
		// read all users
		$query = "SELECT users_id, users_email, users_pass, users_alias, users_created_when, users_updated_when
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
			  
					$users_item=array(
						"users_id" => $users_id,
						"users_email" => $users_email,
						"users_pass" => $users_pass,
						"users_alias" => $users_alias,
						"users_created_when" => $users_created_when,
						"users_updated_when" => $users_updated_when
					);
					array_push($response_arr["data"], $users_item);
				}
			}
		}
		return $response_arr;	
	}
	// read one users
	function readOne(){
		// read one user
		$query = "SELECT users_id, users_email, users_pass, users_alias, users_created_when, users_updated_when
				FROM " . $this->table_name . " 
				WHERE
					users_id = :users_id
				LIMIT
					0,1";
		
		// prepare query
		$stmt = $this->conn->prepare( $query );
	  
		// sanitize
		$this->users_id=htmlspecialchars(strip_tags($this->users_id));
		
		// bind values
		$stmt->bindParam(":users_id", $this->users_id);
		
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
			  
					$users_item=array(
						"users_id" => $users_id,
						"users_email" => $users_email,
						"users_pass" => $users_pass,
						"users_alias" => $users_alias,
						"users_created_when" => $users_created_when,
						"users_updated_when" => $users_updated_when
					);
					array_push($response_arr["data"], $users_item);
				}
			}
		}
		return $response_arr;
	}
	// update the users
	function update(){
	  
		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					users_email = :users_email,
					users_pass = :users_pass,
					users_alias = :users_alias,
					users_updated_when = :users_updated_when
				WHERE
					users_id = :users_id";
	  
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->users_id=htmlspecialchars(strip_tags($this->users_id));
		$this->users_email=htmlspecialchars(strip_tags($this->users_email));
		$this->users_pass=htmlspecialchars(strip_tags($this->users_pass));
		$this->users_alias=htmlspecialchars(strip_tags($this->users_alias));
		$this->users_updated_when=htmlspecialchars(strip_tags($this->users_updated_when));
	  
		// bind values
		$stmt->bindParam(":users_id", $this->users_id);
		$stmt->bindParam(":users_email", $this->users_email);
		$stmt->bindParam(":users_pass", $this->users_pass);
		$stmt->bindParam(":users_alias", $this->users_alias);
		$stmt->bindParam(":users_updated_when", $this->users_updated_when);
	  
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
				
				$users_item=array(
					"users_id" => $this->users_id,
					"users_email" => $this->users_email,
					"users_pass" => $this->users_pass,
					"users_alias" => $this->users_alias,
					"users_updated_when" => $this->users_updated_when
				);
				array_push($response_arr["data"], $users_item);
			}
		}
		return $response_arr;
	}
	// delete the users
	function delete(){
	  
		// delete query
		$query = "DELETE 
				  FROM " . $this->table_name . " 
				  WHERE users_id = :users_id";
				
		// prepare query
		$stmt = $this->conn->prepare( $query );
		
		// sanitize
		$this->users_id=htmlspecialchars(strip_tags($this->users_id));
		
		// bind values
		$stmt->bindParam(":users_id", $this->users_id);
		
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
	// search users
	function search($keywords){
	  
		// select all query
		$query = "SELECT a.users_id, a.users_email, a.users_pass, a.users_alias, a.users_created_when, a.users_updated_when
				FROM " . $this->table_name . " a
				WHERE
					a.users_alias LIKE ?
				ORDER BY
					a.users_updated_when DESC";
	  
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
	// read users with pagination
	public function readPaging($from_record_num, $records_per_page){
	  
		// select query
		$query = "SELECT a.users_id, a.users_email, a.users_pass, a.users_alias, a.users_created_when, a.users_updated_when
				FROM
					" . $this->table_name . " a
					
				ORDER BY a.users_updated_when DESC
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
	// used for paging users
	public function count(){
		$query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
	  
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	  
		return $row['total_rows'];
	}
}
?>