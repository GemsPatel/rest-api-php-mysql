<?php
include_once '../config/Database.php';
include_once '../class/Wallet.php';
 
$database = new Database();
$db = $database->getConnection();
 
$wallet = new Wallet($db);
 
$data = $_POST;
$success = true;
if( empty($data['userId'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter user id" ] );
	$success = false;
}

if( empty($data['coin'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter coin" ] );
	$success = false;
}

if( $success ){
    $wallet->userId = $data['userId'];
    $wallet->coin = $data['coin'];

    if($wallet->create()){
        http_response_code(201);
        echo json_encode( [ "message" => "wallet was created." ] );
    } else{
        http_response_code(503);
        echo json_encode( [ "message" => "Unable to create wallet." ] );
    }
}
// else{    
//     http_response_code(400);
//     echo json_encode(array("message" => "Unable to create wallet. Data is incomplete."));
// }
?>