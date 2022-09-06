<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

	// set response code - 200 OK 
	http_response_code(200);
	  
	// show index page in json format
	echo json_encode(array("error" => false, "message" => "Welcome to RestFul example by Gligorije", 'data' => array()), JSON_PRETTY_PRINT);

?>