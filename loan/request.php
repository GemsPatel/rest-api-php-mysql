<?php
include_once '../config/Database.php';
include_once '../class/User.php';
include_once '../class/Loan.php';

$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
$loan = new Loan($db);
$data = $_POST;

$success = true;
if( empty($data['id'] ) ){
    http_response_code(400);
    echo json_encode( ["message" => "Select loan." ] );
    $success = false;
}

if( empty($data['loanId'] ) ){
    http_response_code(400);
    echo json_encode( ["message" => "Select loan id." ] );
    $success = false;
}

if( empty($data['loan_status'] ) ){
    http_response_code(400);
    echo json_encode( ["message" => "Select loan status." ] );
    $success = false;
}

if(  $success ){
    $user->userId = $data['id'];
    $result = $user->read();
    if($result->num_rows > 0){   

        $user = $result->fetch_assoc(); 
        if($user['agent'] == "yes"){
            $loan->loanId = $data['loanId'];
            $loan->loan_status = $data['loan_status'];
            $res = $loan->checkInsurance();
            
            if($res->num_rows > 0){
                if($loan->request()){
                    http_response_code(200);
                    echo json_encode( [ "message" => "loan was accetpted." ] );
                }else{
                    http_response_code(503);
                    echo json_encode( [ "message" => "Unable to accetpted/rejected status loan." ] );
                }
            }else{
                http_response_code(404);
                echo json_encode( [ "message" => "No loan found." ] );
            }
        }else{
            http_response_code(400);
            echo json_encode( [ "message" => "Only agent are accetpted/rejected loan." ] );
        }
    }else{
        http_response_code(404);
        echo json_encode( [ "message" => "No user found." ]  );
    } 
}
// else {
//     http_response_code(400);
//     echo json_encode( [ "message" => "Unable to update transaction. Data is incomplete." ] );
// }