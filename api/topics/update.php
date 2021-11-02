<?php
// required headers
header("Content-Type: application/json; charset=UTF-8");
  
//includes
include_once '../config/database.php';
include_once '../shared/utilities.php';
include_once '../config/core.php';
include_once '../objects/topics.php';

// prepare topics object
$topics = new Topics($db);
$utilities = new utilities();
  
 
  if(
    !empty($data->topics_id) 
	)
	{
		// set topics property values
		$topics->topics_id = $data->topics_id;
		$topics->topics_subject = $data->topics_subject;
		$topics->topics_body = $data->topics_body;
		$topics->topics_updated_when = date('Y-m-d H:i:s');
		
		// read one topics
		$response_arr=$topics->update();
		  
		//set status
		if($response_arr["status"])
		{ 
			$response_arr["status"]=$utilities->setMessageArray(false,200,"success","Topic was updated");
		}
		else
		{
			$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","Topic was not updated");
		}
	}
	//data is incomplete - set status
	else{
		$response_arr["status"] = $utilities->setMessageArray(true,400,"failure","Topic was not updated. Data is incomplete");
	}
// show topics data
echo json_encode($response_arr);

?>