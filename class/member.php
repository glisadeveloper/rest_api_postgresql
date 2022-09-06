<?php
    class Member{
        // Connection
        private $conn;
        // Table names
        private $db_table = "users";
        private $db_codes = "codes";
        // Columns
        public $id;
        public $firstname;
        public $lastname;
        public $email;
        public $password;
        public $admin;
        public $state;
        public $code;
        public $created_at;
        public $code_2fa;
        public $msg;
        private $dt;

        // DB connection
        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function getMembers()
        {
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();     
            return $stmt;      
        }

        // Create/Add user
        public function createUser()
        {  

            $sqlQuery = "INSERT INTO ". $this->db_table ." (firstname,lastname,email,password,admin,state) VALUES (?,?,?,?,?,?)";  
            $stmt = $this->conn->prepare($sqlQuery);  

            // sanitize      
            $this->firstname = htmlspecialchars(strip_tags($this->firstname));
            $this->lastname = htmlspecialchars(strip_tags($this->lastname));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $this->admin; 
            $this->state = true; 

            // bind data
            $stmt->bindParam(1,  $this->firstname);
            $stmt->bindParam(2,  $this->lastname);
            $stmt->bindParam(3,  $this->email);
            $stmt->bindParam(4,  $this->password);
            $stmt->bindParam(5,  $this->admin);
            $stmt->bindParam(6,  $this->state);

            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // Read single user
        public function getSingleUser()
        {
            $sqlQuery = "SELECT * FROM ". $this->db_table ." WHERE id = ? LIMIT 1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!empty($dataRow['firstname'])){
                $this->firstname = $dataRow['firstname'];
                $this->lastname = $dataRow['lastname'];
                $this->email = $dataRow['email'];
                $this->admin = $dataRow['admin'];
                $this->state = $dataRow['state'];
                return true;
            }
        }  

        // Update single user
        public function updateUser()
        {
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        firstname = :firstname, 
                        lastname = :lastname, 
                        email = :email,
                        password = :password
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->firstname = htmlspecialchars(strip_tags($this->firstname));
            $this->lastname = htmlspecialchars(strip_tags($this->lastname));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
                    
            // bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":firstname", $this->firstname);
            $stmt->bindParam(":lastname", $this->lastname);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->execute();
            $updated = $stmt->rowCount(); 

            if($updated){
               return true;
            }
            return false;
        }

        // Create/Add user by admin
        public function createUserByAdmin()
        {  
            if(isset($_SESSION['auth'])){
                if($_SESSION['auth']['admin'] != true){     
                    $this->msg = 'You do not have admin privileges for this action !';
                    return false;
                }     

                $sqlQuery = "INSERT INTO ". $this->db_table ." (firstname,lastname,email,password,admin,state) VALUES (?,?,?,?,?,?)";  
                $stmt = $this->conn->prepare($sqlQuery);  

                // sanitize      
                $this->firstname = htmlspecialchars(strip_tags($this->firstname));
                $this->lastname = htmlspecialchars(strip_tags($this->lastname));
                $this->email = htmlspecialchars(strip_tags($this->email));
                $this->password = password_hash($this->password, PASSWORD_DEFAULT);
                $this->admin = htmlspecialchars(strip_tags($this->admin));
                $this->state = htmlspecialchars(strip_tags($this->state));

                // bind data
                $stmt->bindParam(1,  $this->firstname);
                $stmt->bindParam(2,  $this->lastname);
                $stmt->bindParam(3,  $this->email);
                $stmt->bindParam(4,  $this->password);
                $stmt->bindParam(5,  $this->admin);
                $stmt->bindParam(6,  $this->state);

                if($stmt->execute()){
                   return true;
                }            
            }
            return false;
        }


        // Update single user by admin
        public function updateUserByAdmin()
        {
            if(isset($_SESSION['auth'])){
                if($_SESSION['auth']['admin'] != true){   
                    $this->msg = 'You do not have admin privileges for this action  !';
                    return false;
                }         
                $sqlQuery = "UPDATE
                            ". $this->db_table ."
                        SET
                            firstname = :firstname, 
                            lastname = :lastname, 
                            email = :email,
                            password = :password,
                            admin = :admin,
                            state = :state
                        WHERE 
                            id = :id";
            
                $stmt = $this->conn->prepare($sqlQuery);
            
                $this->id = htmlspecialchars(strip_tags($this->id));
                $this->firstname = htmlspecialchars(strip_tags($this->firstname));
                $this->lastname = htmlspecialchars(strip_tags($this->lastname));
                $this->email = htmlspecialchars(strip_tags($this->email));
                $this->password = password_hash($this->password, PASSWORD_DEFAULT);
                $this->admin = htmlspecialchars(strip_tags($this->admin));
                $this->state = htmlspecialchars(strip_tags($this->state));
                        
                // bind data
                $stmt->bindParam(":id", $this->id);
                $stmt->bindParam(":firstname", $this->firstname);
                $stmt->bindParam(":lastname", $this->lastname);
                $stmt->bindParam(":email", $this->email);
                $stmt->bindParam(":password", $this->password);
                $stmt->bindParam(":admin", $this->admin);
                $stmt->bindParam(":state", $this->state);
                $stmt->execute();
                $updated = $stmt->rowCount(); 

                if($updated){
                   return true;
                }
            }
            return false;
        }

        // Delete single user by admin
        function deleteUserByAdmin()
        {
            if(isset($_SESSION['auth'])){
                if($_SESSION['auth']['admin'] != true){     
                    $this->msg = 'You do not have admin privileges for this action !';
                    return false;
                }           

                $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
                $stmt = $this->conn->prepare($sqlQuery);        
                $this->id = htmlspecialchars(strip_tags($this->id));        
                $stmt->bindParam(1, $this->id);
                $stmt->execute(); 
                $deleted = $stmt->rowCount();       

                if($deleted){                           
                    return true;
                }                
            }
            return false;
        }

        function addCode()
        {
            $sqlQuery = "INSERT INTO ". $this->db_codes ." (email, code, created_at) VALUES (?,?,?)";        
            $stmt = $this->conn->prepare($sqlQuery);  

            // sanitize      
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->code = htmlspecialchars(strip_tags($this->code));
            $this->dt = new DateTime();

            // bind data
            $stmt->bindParam(1,  $this->email);
            $stmt->bindParam(2,  $this->code);
            $stmt->bindValue(3,  $this->dt->format('Y-m-d H:i:s'));

            if($stmt->execute()){
               return true;
            }
            return false;
        }

        function getCode()
        {
            $sqlQuery = "SELECT * FROM ". $this->db_codes ." WHERE email = ? LIMIT 1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->email);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!empty($dataRow['email'])){
                $this->id = $dataRow['id'];
                $this->code_2fa = preg_replace('/\s+/', '', $dataRow['code']);  
                $this->created_at = $dataRow['created_at'];                           
                return true;
            }
        }

        public function updateCode()
        {
            $sqlQuery = "UPDATE
                        ". $this->db_codes ."
                    SET                         
                        code = :code,
                        created_at = :created_at
                    WHERE 
                        id = :id";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->code = htmlspecialchars(strip_tags($this->code));
            $date = new DateTime();

            $data = [
                        'id' => $this->id,
                        'code' => $this->code,
                        'created_at' => $date->format('Y-m-d H:i:s')
                    ];
            $stmt->execute($data);
            $updated = $stmt->rowCount(); 

            if($updated){
               return true;
            }
            return false;
        }


        function Login()
        {
            $sqlQuery = "SELECT * FROM ". $this->db_table ." WHERE email = ? LIMIT 1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->email);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!empty($dataRow['email']) && password_verify($this->password, preg_replace('/\s+/', '', $dataRow['password']))){    
                
                if($dataRow['state'] == false){
                    $this->msg = 'Your account is deactivated !';
                    return false;
                }   

                if($this->getCode() == true && $this->code_2fa == $this->code){

                    $dt = new DateTime();
                    $date1 = new DateTime($this->created_at);
                    $date2 = new DateTime($dt->format('Y-m-d H:i:s'));
                    $diff_mins = abs($date1->getTimestamp() - $date2->getTimestamp()) / 60;

                    //2fa is allowed on 2 minutes 
                    if(round($diff_mins) > 2){
                        $this->msg = 'Your 2fa code has expired (it lasts 2 minutes), request a new one';
                        return false;
                    }

                    $this->id = $dataRow['id'];
                    // Session for authentication
                    $_SESSION['auth'] = array('email' => preg_replace('/\s+/', '', $dataRow['email']), 'admin' => $dataRow['admin']);
                    return true;
                }else{

                    if($this->code_2fa == ''){
                        $this->msg = 'You have not applied for 2fa code, please request a new one!';
                        return false;
                    }

                    $this->msg = 'Your 2fa code entered it incorrectly, please try again !';
                    return false;
                }                
            }
        }


        function Logout()
        {           
            if(isset($_SESSION['auth'])){
                if($_SESSION['auth']['email'] != $this->email){
                    return false;
                }
                unset($_SESSION['auth']);
                return true;
            }            
            return false;
        }
    }
?>