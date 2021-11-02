<?php
//required headers
header("Content-Type: application/json; charset=UTF-8");

//includes
include_once '../config/database.php';
include_once '../shared/utilities.php';
include_once '../config/core.php';
include_once '../objects/users.php';

//initialize/instantiate objects
$users = new Users($db);
$utilities = new utilities();

// check for data
if(
    !empty($data->users_email) &&
    !empty($data->users_pass) &&
    !empty($data->users_alias) 
)
{
    // set users property values
    $users->users_email = $data->users_email;
    $users->users_pass = password_hash($data->users_pass, PASSWORD_DEFAULT);
    $users->users_alias = $data->users_alias;
    $users->users_created_when = date('Y-m-d H:i:s');
    $users->users_updated_when = date('Y-m-d H:i:s');
  
    // create the users
    $response_arr=$users->create();
	
	//set status
	if($response_arr["status"])
	{ 
		$response_arr["status"]=$utilities->setMessageArray(false,201,"success","User was created.");
	}
	else
	{
		$response_arr["status"]=$utilities->setMessageArray(true,400,"failure","User was not created.");
	}
}
  
//data is incomplete - set status
else{
	$response_arr["status"] = $utilities->setMessageArray(true,400,"failure","User was not created. Data is incomplete");
}

// show users data
echo json_encode($response_arr);
?>