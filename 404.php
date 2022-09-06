<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

    // set response code - 404 Not Found
    http_response_code(404);
  
    // show error data in json format
    echo json_encode(array("error" => true, "message" => "The requested endpoint was not found !", 'data' => array()));

?>