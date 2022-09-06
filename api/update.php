<?php
	// required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    
    // include database and object files
    include_once './config/database.php';
    include_once './class/member.php';

     // get data
    $data = json_decode(file_get_contents("php://input"));

    /** 
     * We are checking validations for request, else return error msg
    */
    $validations = array();

    if(!isset($data->firstname)){
        $validations['firstname'] = 'Please enter name';
    }

    if(!isset($data->lastname)){
        $validations['lastname'] = 'Please enter lastname';
    }

    if(!isset($data->email)){
        $validations['email'] = 'Please enter email';
    }

    if(!isset($data->password)){
        $validations['password'] = 'Please enter password';
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
       
    $item->id = $data->id;
    
    // user values
    $item->firstname = $data->firstname;
    $item->lastname = $data->lastname;
    $item->email = $data->email;
    $item->password = $data->password;
    
    if($item->updateUser()){
        http_response_code(200);
        echo json_encode(array("error" => false, "message" => "User data updated.", 'data' => array()), JSON_PRETTY_PRINT);
    } else{
        http_response_code(500);
        $msg = ($item->msg != '') ? $item->msg : "User data could not be updated.";
        echo json_encode(array("error" => true, "message" => $msg, 'data' => array()), JSON_PRETTY_PRINT);
    }
?>