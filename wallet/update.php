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

if( empty($data['walletId'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter wallet id" ] );
	$success = false;
}

if( $success ){
	$wallet->walletId = $data['walletId']; 
	$wallet->userId = $data['userId'];
	$wallet->coin = $data['coin'];

	if($wallet->update()){
		http_response_code(200);
		echo json_encode( [ "message" => "wallet was updated." ] );
	}else{
		http_response_code(503);
		echo json_encode( [ "message" => "Unable to update wallet." ] );
	}
} else {
	http_response_code(400);    
	echo json_encode( [ "message" => "Unable to update wallet. Data is incomplete." ] );
}
?>