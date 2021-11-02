<?php
// required headers
header("Content-Type: application/json; charset=UTF-8");

//includes
include_once '../config/database.php';
include_once '../shared/utilities.php';
include_once '../config/core.php';
include_once '../objects/watchers.php';
  
//initialize/instantiate objects
$watchers = new watchers($db);
$utilities = new utilities();

   if(
    !empty($data->watchers_id) 
	)
	{
		// set watchers property values
		$watchers->watchers_id = $data->watchers_id;
	
		// read one watchers
		$response_arr=$watchers->delete();
		  
		//set status
		if($response_arr["status"])
		{ 
			$response_arr["status"]=$utilities->setMessageArray(false,200,"success","Watcher was deleted.");
		}
		else
		{
			$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","Watcher was not deleted.");
		}
	}
	//data is incomplete - set status
	else{
		$response_arr["status"] = $utilities->setMessageArray(true,400,"failure","Watcher was not deleted. Data is incomplete");
	}
// show watchers data
echo json_encode($response_arr);
?>