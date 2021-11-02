<?php 
// required headers
header("Content-Type: application/json; charset=UTF-8");

//includes
include_once '../config/database.php';
include_once '../shared/utilities.php';
include_once '../config/core.php';
include_once '../objects/replies.php';
  
// initialize object
$replies = new replies($db);
$utilities = new utilities();
  
// read all replies
$response_arr = $replies->read();

//set status
if($response_arr["status"])
{ 
	$response_arr["status"]=$utilities->setMessageArray(false,200,"success","Reply was found");
}
else
{
	$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","Reply was not found");
}

// show replies data
echo json_encode($response_arr);
?>