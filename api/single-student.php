<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once('../config/database.php');
include_once('../classes/student.php');

$db = new Database();
$connection = $db->connect();

$student = new Student($connection);

if($_SERVER['REQUEST_METHOD'] === 'GET'){

    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data->id)){
        $student->id = $data->id;
        $student_data = $student->get_single_student();
        if(!empty($student_data)){
            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "data" => $student_data
            ));
        }else{
            http_response_code(404);
            echo json_encode(array(
                "status" => 0,
                "message" => 'Not Found'
            ));
        }
    }
    
} else{
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => 'Access denied'
    ));
}
