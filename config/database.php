<?php 
class Database {
    private $hostname;
    private $database;
    private $username;
    private $password;
    private $conn;

    public function connect(){
        $this->hostname = "localhost";
        $this->username = "root";
        $this->password = null;
        $this->database = "rest_php_api";


        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if($this->conn->connect_errno){
            print_r($this->conn->connect_error);
            exit;
        } else{
            return $this->conn;
        }
    }
}

$db = new Database();
$db->connect();
?>