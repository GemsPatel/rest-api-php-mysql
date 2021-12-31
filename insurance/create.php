<?php
include_once '../config/Database.php';
include_once '../class/insurance.php';
 
$database = new Database();
$db = $database->getConnection();
 
$insurance = new Insurance($db);
 
$data = $_POST;

$success = true;

if( empty($data['insurance_amount'] ) ){
    http_response_code(400);
    echo json_encode( ["message" => "Enter your insurance amount." ] );
    $success = false;
}

if( empty($data['insurance_type'] ) ){
    http_response_code(400);
    echo json_encode( ["message" => "Enter your insurance type." ] );
    $success = false;
}

if( empty($data['agent_name'] ) ){
    http_response_code(400);
    echo json_encode( ["message" => "Enter your agent name." ] );
    $success = false;
}

if( empty($data['duration'] ) ){
    http_response_code(400);
    echo json_encode( ["message" => "Enter your insurance duration in month." ] );
    $success = false;
}

if( $success ){
    $insurance->insurance_amount = $data['insurance_amount'];
    $insurance->insurance_type = $data['insurance_type'];
    $insurance->agent_name = $data['agent_name'];
    $insurance->duration = $data['duration'];
    
    if($insurance->create()){
        http_response_code(201);
        echo json_encode( ["message" => "insurance was created." ] );
    } else{
        http_response_code(503);
        echo json_encode( ["message" => "Unable to create insurance." ] );
    }
}
// else{
//     http_response_code(400);
//     echo json_encode( ["message" => "Unable to create insurance. Data is incomplete." ] );
// }
?>