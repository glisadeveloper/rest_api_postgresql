<?php
require_once './2fa/vendor/autoload.php';
include_once './class/member.php';

use Vectorface\GoogleAuthenticator;

class Mfa{

	public $secret;
	private $ga;

	public function __construct(){
		$this->ga = new GoogleAuthenticator();
    }

    public function getCode($email){
		$database = new Database();
        $db = $database->getInstance()->getConnection();
        $member = new Member($db);
        $member->email = $email;
		
		$dt = new DateTime();

        if($member->getCode()){    
            $date1 = new DateTime($member->created_at);
			$date2 = new DateTime($dt->format('Y-m-d H:i:s'));
			$diff_mins = abs($date1->getTimestamp() - $date2->getTimestamp()) / 60;

			//2fa is allowed on 2 minutes 
			if(round($diff_mins) > 2){	
				$this->secret = $this->ga->createSecret();
				$member->code = $this->secret;
			    $member->updateCode();
			}else{
				$this->secret = $member->code_2fa;
			} 
          
        }else{
        	$this->secret = $this->ga->createSecret();
			$member->code = $this->secret;
        	$member->addCode();
        }		

		// the message
		$msg = "Your access code: ".$this->secret;
		// use wordwrap() if lines are longer than 70 characters
		$msg = wordwrap($msg,70);
		// send email
		mail($email, "Your access code", $msg);		

		return $this->secret;
    }

}