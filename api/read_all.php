<?php
	// required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include database and object files
    include_once './config/database.php';
    include_once './class/member.php';
    include_once './class/mfa.php';

    $database = new Database();
    $db = $database->getInstance()->getConnection();
    $items = new Member($db);
    $stmt = $items->getMembers();
    $itemCount = $stmt->rowCount();

    if($itemCount > 0){        
        $memberArr = array();
        $memberArr["data"] = array();
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $mfa = new Mfa();
            $mfa->getCode($email);
            $e = array(
                "id" => $id,
                "firstname" => $firstname,
                "lastname" => $lastname,  
                "email" => $email, 
                'admin' => $admin,
                'state' => $state,
                'code' => $mfa->secret              
            );
            array_push($memberArr["data"], $e);
        }
        http_response_code(200);
        echo json_encode(array("error" => false, "message" => "Welcome to RestFul example by Gligorije", 'data' => $memberArr["data"]));
    }
    else{
        http_response_code(200);
        $msg = ($items->msg != '') ? $items->msg : "No users found.";
        echo json_encode(array("error" => false, "message" => $msg, 'data' => array()));
    }
?>