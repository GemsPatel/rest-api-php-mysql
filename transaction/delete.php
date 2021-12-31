<?php
include_once '../config/Database.php';
include_once '../class/transaction.php';
 
$database = new Database();
$db = $database->getConnection();
 
$transaction = new Transaction($db);
 
$data = $_POST;

if(!empty($data['id'])) {
	$transaction->transactionId = $data['id'];
	if($transaction->delete()){
		http_response_code(200); 
		echo json_encode(array("message" => "transaction was deleted."));
	} else {    
		http_response_code(503);
		echo json_encode(array("message" => "Unable to delete transaction."));
	}
} else {
	http_response_code(400);
	echo json_encode(array("message" => "Unable to delete transaction. Data is incomplete."));
}
?>