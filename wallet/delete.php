<?php
include_once '../config/Database.php';
include_once '../class/Wallet.php';
 
$database = new Database();
$db = $database->getConnection();
 
$wallet = new Wallet($db);
 
$data = $_POST;

if(!empty($data['walletId'])) {
	$wallet->walletId = $data['walletId'];
	if($wallet->delete()){
		http_response_code(200);
		echo json_encode( [ "message" => "wallet was deleted." ] );
	} else {    
		http_response_code(503);
		echo json_encode( [ "message" => "Unable to delete wallet." ] );
	}
} 
else {
	http_response_code(400);
	echo json_encode( [ "message" => "Unable to delete wallet. Data is incomplete." ] );
}
?>