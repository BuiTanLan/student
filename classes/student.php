<?php

class Student {
    public $name;
    public $email;
    public $mobile;
    public $id;

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
        $this->id = htmlspecialchars(strip_tags($this->id));

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

    public function get_single_student()
    {
        $query = "SELECT * FROM $this->table_name where id = ?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param('i', $this->id);
        $obj->execute();
        $data = $obj->get_result();
        return $data->fetch_assoc();
    }

    public function update_student()
    {

        // query
        $update_query = "UPDATE tbl_students SET name = ?, email = ?, mobile = ? WHERE id = ?";

        // prepare statement
        $query_object = $this->conn->prepare($update_query);

        //sanitizing inputs
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // binding parameters with the query
        $query_object->bind_param("sssi", $this->name, $this->email, $this->mobile, $this->id);

        //execute query
        if ($query_object->execute()) {
            return true;
        }
        return false;
    }

    // delete student
    public function delete_student()
    {

        $delete_query = "DELETE from " . $this->table_name . " WHERE id = ?";

        // prepare $query
        $delete_obj = $this->conn->prepare($delete_query);

        //sanitize inputs
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind parameter
        $delete_obj->bind_param("i", $this->id);

        // executing query
        if ($delete_obj->execute()) {

            return true;
        }

        return false;
    }
}
