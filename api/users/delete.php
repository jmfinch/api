<?php
// required headers
header("Content-Type: application/json; charset=UTF-8");

//includes
include_once '../config/database.php';
include_once '../shared/utilities.php';
include_once '../config/core.php';
include_once '../objects/users.php';
  
//initialize/instantiate objects
$users = new users($db);
$utilities = new utilities();

   if(
    !empty($data->users_id) 
	)
	{
		// set users property values
		$users->users_id = $data->users_id;
	
		// read one user
		$response_arr=$users->delete();
		  
		//set status
		if($response_arr["status"])
		{ 
			$response_arr["status"]=$utilities->setMessageArray(false,200,"success","User was deleted.");
		}
		else
		{
			$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","User was not deleted.");
		}
	}
	//data is incomplete - set status
	else{
		$response_arr["status"] = $utilities->setMessageArray(true,400,"failure","User was not deleted. Data is incomplete");
	}
// show users data
echo json_encode($response_arr);
?>