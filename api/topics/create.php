<?php
// required headers
header("Content-Type: application/json; charset=UTF-8");
  
//includes
include_once '../config/database.php';
include_once '../shared/utilities.php';
include_once '../config/core.php';
include_once '../objects/topics.php';
include_once '../objects/watchers.php';

//initialize/instantiate objects
$topics = new Topics($db);
$utilities = new utilities();
$watchers = new Watchers($db);
  
// make sure data is not empty
if(
    !empty($data->topics_subject) &&
    !empty($data->topics_body) &&
    !empty($data->users_id) 
){
    // set topics property values
    $topics->topics_subject = $data->topics_subject;
    $topics->topics_body = $data->topics_body;
    $topics->users_id = $data->users_id;
    $topics->topics_created_when = date('Y-m-d H:i:s');
    $topics->topics_updated_when = date('Y-m-d H:i:s');
  
    // create the topics
    $response_arr=$topics->create();
	
	//set status
	if($response_arr["status"])
	{ 
		$response_arr["status"]=$utilities->setMessageArray(false,201,"success","Topic was created.");
		
		//OnSuccess Add as Watcher
		$noReturn=$watchers->create();
	}
	else
	{
		$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","Topic was not created.");
	}
}
  //data is incomplete - set status
else{
	$response_arr["status"] = $utilities->setMessageArray(true,400,"failure","Topic was not created. Data is incomplete");
}

// show topics data
echo json_encode($response_arr);
?>