<?php
include_once '../config/Database.php';
include_once '../class/insurance.php';
 
$database = new Database();
$db = $database->getConnection();
 
$insurance = new Insurance($db);
 
$data = $_POST;

if(!empty($data['insurance_amount']) && !empty($data['insurance_type']) && !empty($data['agent_name']) && !empty($data['duration'])){
    $insurance->insurance_amount = $data['insurance_amount'];
    $insurance->insurance_type = $data['insurance_type'];
    $insurance->agent_name = $data['agent_name'];
    $insurance->duration = $data['duration'];
    
    if($insurance->create()){
        http_response_code(201);
        echo json_encode(array("message" => "insurance was created."));
    } else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create insurance."));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create insurance. Data is incomplete."));
}
?>