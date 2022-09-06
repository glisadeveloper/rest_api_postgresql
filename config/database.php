<?php 
/** 
 * Creating a class for the database connection - Wrapper with the Singleton Pattern
*/
    class Database {
        public static $instance;
        private $host = "localhost";
        private $database_name = "restful";
        private $username = "postgres";
        private $password = "root";
        public $conn;

        // Magic method clone is empty to prevent duplication of connection
        private function __clone() { }

        public static function getInstance(){
            if(!isset(self::$instance)){
                self::$instance = new self();
            }
            return self::$instance;
        }
            
        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }  
?>