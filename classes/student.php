<?php

class Student {
    public $name;
    public $email;
    public $mobile;

    private $conn;
    private $table_name;

    public function __construct(mysqli $db) {
        $this->conn = $db;
        $this->table_name = 'tbl_students';
    }

    public function create_data(){
        $query = "INSERT INTO $this->table_name (name, email, mobile) VALUES (?,?,?)";
        $obj = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));

        $obj->bind_param('sss', $this->name, $this->email, $this->mobile);

        if($obj->execute()) {
            return true;
        } else false;

    }


    public function get_all_data() {
        $query = "SELECT * FROM $this->table_name";
        $obj = $this->conn->prepare($query);
        $obj->execute();
        return $obj->get_result();
    }
}
