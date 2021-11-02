<?php 
// required headers
header("Content-Type: application/json; charset=UTF-8");

//includes
include_once '../config/database.php';
include_once '../shared/utilities.php';
include_once '../config/core.php';
include_once '../objects/topics.php';
  
// initialize object
$topics = new Topics($db);
$utilities = new utilities();
  
// read all topics
$response_arr = $topics->read();

//set status
if($response_arr["status"])
{ 
	$response_arr["status"]=$utilities->setMessageArray(false,200,"success","Topic was found");
}
else
{
	$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","Topic was not found");
}

// show topics data
echo json_encode($response_arr);
?>