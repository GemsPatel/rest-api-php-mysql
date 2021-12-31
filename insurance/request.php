<?php
include_once '../config/Database.php';
include_once '../class/User.php';
include_once '../class/insurance.php';

$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
$insurance = new insurance($db);
$data = $_POST;

$success = true;

if( empty($data['id'] ) ){
    http_response_code(400);
    echo json_encode( ["message" => "Select insurance." ] );
    $success = false;
}

if( empty($data['insuranceId'] ) ){
    http_response_code(400);
    echo json_encode( ["message" => "Select insurance ID." ] );
    $success = false;
}

if( empty($data['insurance_status'] ) ){
    http_response_code(400);
    echo json_encode( ["message" => "Select insurance status." ] );
    $success = false;
}


if( $success ){
    $user->userId = $data['id'];
    $result = $user->read();
    if($result->num_rows > 0){

        $user = $result->fetch_assoc(); 
        if($user['agent'] == "yes"){
            $insurance->insuranceId = $data['insuranceId'];
            $insurance->insurance_status = $data['insurance_status'];
            $res = $insurance->checkInsurance();
            
            if($res->num_rows > 0){
                if($insurance->request()){
                    http_response_code(200);
                    echo json_encode( [ "message" => "insurance was accetpted." ] );
                }else{
                    http_response_code(503);
                    echo json_encode( ["message" => "Unable to accetpted/rejected status insurance." ]);
                }
            }else{
                http_response_code(404);
                echo json_encode( [ "message" => "No insurance found." ] );
            }
        }else{
            http_response_code(400);
            echo json_encode( ["message" => "Only agent are accetpted/rejected insurance." ] );
        }
    }else{
        http_response_code(404);
        echo json_encode( [ "message" => "No user found." ] );
    } 
}
// else {
//     http_response_code(400);
//     echo json_encode(array("message" => "Unable to update transaction. Data is incomplete."));
// }