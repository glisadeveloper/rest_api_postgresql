<?php
	// required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	// include database and object files
    include_once './config/database.php';
    include_once './class/member.php';

    // get posted data
    $data = json_decode(file_get_contents("php://input"));

    /** 
     * We are checking validations for request, else return error msg
    */
    $validations = array();

    if(!isset($data->email)){
        $validations['email'] = 'Please enter email';
    }    

    if(count($validations) > 0){
        // set response code - 500 Internal Server Error
        http_response_code(500);
      
        // show error data in json format
        echo json_encode(array("error" => true, "message" => "One or more fields are not entered", 'data' => $validations));
        exit();
    }

    $database = new Database();
    $db = $database->getInstance()->getConnection();
    $item = new Member($db);
    $item->email = $data->email;
  
    if($item->Logout()){
        http_response_code(200);
        echo json_encode(array("error" => false, "message" => "User logged out successfully.", 'data' => array()), JSON_PRETTY_PRINT);
    } else{
        http_response_code(500);
        $msg = ($item->msg != '') ? $item->msg : "You have already logged out or incorrect details !";
        echo json_encode(array("error" => true, "message" => $msg, 'data' => array()), JSON_PRETTY_PRINT);
    }
?>