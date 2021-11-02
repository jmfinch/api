<?php
// required headers
header("Content-Type: application/json; charset=UTF-8");

//includes
include_once '../config/database.php';
include_once '../shared/utilities.php';
include_once '../config/core.php';
include_once '../objects/topics.php';
  
//initialize/instantiate objects
$topics = new Topics($db);
$utilities = new utilities();

   if(
    !empty($data->topics_id) 
	)
	{
		// set topics property values
		$topics->topics_id = $data->topics_id;
	
		// read one topics
		$response_arr=$topics->delete();
		  
		//set status
		if($response_arr["status"])
		{ 
			$response_arr["status"]=$utilities->setMessageArray(false,200,"success","Topic was deleted.");
		}
		else
		{
			$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","Topic was not deleted.");
		}
	}
	//data is incomplete - set status
	else{
		$response_arr["status"] = $utilities->setMessageArray(true,400,"failure","Topic was not deleted. Data is incomplete");
	}
// show topics data
echo json_encode($response_arr);
?>