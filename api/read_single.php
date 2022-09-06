<?php
	// required headers
	header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    
    // include database and object files
    include_once './config/database.php';
    include_once './class/member.php';
    include_once './class/mfa.php';

	// get data
	$data = json_decode(file_get_contents("php://input"));

	/** 
	 * We are checking validations for request, else return error msg
	*/

	$validations = array();

	if(!isset($data->id)){
		$validations['id'] = 'Please enter user id';
	}
	
	if(count($validations) > 0){
	    // set response code - 500 Internal Server Error
	    http_response_code(500);
	  
	    // show error data in json format
	    echo json_encode(array("error" => true, "message" => "One or more fields are not entered", 'data' => $validations));
	    exit();
	}

	//Convert the predefined characters 
	$id =  htmlspecialchars(strip_tags($data->id));

    $database = new Database();
    $db = $database->getInstance()->getConnection();
    $item = new Member($db);
    $item->id = ((int)$id > 0) ? $id : die();
  
    $item->getSingleUser();

    if($item->firstname != null){

        $mfa = new Mfa();
        $mfa->getCode($item->email);

        // user array
        $user_arr = array(
                "id" => $id,
                "firstname" => $item->firstname,
                "lastname" => $item->lastname,  
                "email" => $item->email, 
                'admin' => $item->admin,
                'state' => $item->state,
                'code' => $mfa->secret            
        );
      
        http_response_code(200);
         echo json_encode(array("error" => false, "message" => "Fetch data for user is successfully done", 'data' => $user_arr), JSON_PRETTY_PRINT);
    
    }else{        
        http_response_code(404);
        $msg = ($item->msg != '') ? $item->msg : "The requested user does not exist";
        echo json_encode(array("error" => true, "message" => $msg, 'data' => array()));
    }
?>