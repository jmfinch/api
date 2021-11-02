<?php
// required headers
header("Content-Type: application/json; charset=UTF-8");
  
//includes
include_once '../config/database.php';
include_once '../shared/utilities.php';
include_once '../config/core.php';
include_once '../objects/replies.php';

//initialize/instantiate objects
$replies = new Replies($db);
$utilities = new utilities();
  // make sure data is not empty
if(
    !empty($data->topics_id) &&
    !empty($data->replies_body) &&
    !empty($data->users_id) 
){
    // set replies property values
    $replies->topics_id = $data->topics_id;
    $replies->replies_body = $data->replies_body;
    $replies->users_id = $data->users_id;
    $replies->replies_created_when = date('Y-m-d H:i:s');
    $replies->replies_updated_when = date('Y-m-d H:i:s');
  
    // create the replies
    $response_arr=$replies->create();
	
	//set status
	if($response_arr["status"])
	{ 
		$response_arr["status"]=$utilities->setMessageArray(false,201,"success","Reply was created.");
		
		// This could just be handled by a flag and server process
		// grab the emails and output for now
		echo 'BEGIN EMAIL PROCESSING', PHP_EOL;
		echo json_encode($emails=$replies->fetch()), PHP_EOL;
		echo 'END EMAIL PROCESSING' , PHP_EOL;
	}
	else
	{
		$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","Reply was not created.");
	}
}
  //data is incomplete - set status
else{
	$response_arr["status"] = $utilities->setMessageArray(true,400,"failure","Reply was not created. Data is incomplete");
}

// show replies data
echo json_encode($response_arr);

?>