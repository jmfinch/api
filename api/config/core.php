<?php
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
  
// home page url
$home_url="https://phpapi.wpengine.com/api/";
  
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// get data from payload
$data = json_decode(file_get_contents("php://input"));

// get database connection
$database = new Database();
$db = $database->getConnection();

//response array
$response_arr=array();
$response_arr["status"]=false;
$response_arr["data"]=array();

// set number of records per page
$records_per_page = 5;
  
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>