<?php
// required headers
header("Content-Type: application/json; charset=UTF-8");
  
//includes
include_once '../config/database.php';
include_once '../shared/utilities.php';
include_once '../config/core.php';
include_once '../objects/replies.php';

// prepare replies object
$replies = new replies($db);
$utilities = new utilities();
  
 
  if(
    !empty($data->replies_id) 
	)
	{
		// set replies property values
		$replies->replies_id = $data->replies_id;
		$replies->topics_id = $data->topics_id;
		$replies->replies_body = $data->replies_body;
		$replies->replies_updated_when = date('Y-m-d H:i:s');
		
		// read one replies
		$response_arr=$replies->update();
		  
		//set status
		if($response_arr["status"])
		{ 
			$response_arr["status"]=$utilities->setMessageArray(false,200,"success","Reply was updated");
		}
		else
		{
			$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","Reply was not updated");
		}
	}
	//data is incomplete - set status
	else{
		$response_arr["status"] = $utilities->setMessageArray(true,400,"failure","Reply was not updated. Data is incomplete");
	}
// show replies data
echo json_encode($response_arr);
?>