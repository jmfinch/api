<?php
// required headers
header("Content-Type: application/json; charset=UTF-8");

//includes
include_once '../config/database.php';
include_once '../shared/utilities.php';
include_once '../config/core.php';
include_once '../objects/replies.php';
  
//initialize/instantiate objects
$replies = new replies($db);
$utilities = new utilities();
  
  if(
    !empty($data->topics_id) 
	)
	{
		// set replies property values
		$replies->topics_id = $data->topics_id;
	
		// read one replies
		$response_arr=$replies->search();
		  
		//set status
		if($response_arr["status"])
		{ 
			$response_arr["status"]=$utilities->setMessageArray(false,200,"success","Reply was found");
		}
		else
		{
			$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","Reply was not found");
		}
	}
	//data is incomplete - set status
	else{
		$response_arr["status"] = $utilities->setMessageArray(true,400,"failure","Reply was not found. Data is incomplete");
	}
// show replies data
echo json_encode($response_arr);

?>