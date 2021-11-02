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
  // make sure data is not empty
if(
    !empty($data->topics_id) &&
    !empty($data->users_id) 
){
    // set watchers property values
    $watchers->topics_id = $data->topics_id;
    $watchers->users_id = $data->users_id;
  
    // create the watchers
    $response_arr=$watchers->create();
	
	//set status
	if($response_arr["status"])
	{ 
		$response_arr["status"]=$utilities->setMessageArray(false,201,"success","Watchers was created.");
	}
	else
	{
		$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","Watchers was not created.");
	}
}
  //data is incomplete - set status
else{
	$response_arr["status"] = $utilities->setMessageArray(true,400,"failure","Watchers was not created. Data is incomplete");
}

// show watchers data
echo json_encode($response_arr);

?>