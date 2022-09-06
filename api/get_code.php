<?php
	// required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include database and object files
    include_once './config/database.php';
    include_once './class/member.php';
    include_once './class/mfa.php';

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
 
    $mfa = new Mfa();
    $mfa->getCode($data->email);

    if($mfa->secret != ''){        
        http_response_code(200);
        echo json_encode(array("error" => false, "message" => "Welcome to RestFul example by Gligorije", 'data' => $mfa->secret));
    }
    else{
        http_response_code(200);
        $msg = ($item->msg != '') ? $item->msg : "No Code found.";
        echo json_encode(array("error" => false, "message" => $msg, 'data' => array()));
    }
?>