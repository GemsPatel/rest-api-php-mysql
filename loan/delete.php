<?php
include_once '../config/Database.php';
include_once '../class/loan.php';
 
$database = new Database();
$db = $database->getConnection();
 
$loan = new Loan($db);
 
$data = $_POST;

if(!empty($data['id'])) {
	$loan->loanId = $data['id'];
	if($loan->delete()){
		http_response_code(200); 
		echo json_encode( [ "message" => "Loan was deleted." ] );
	} else {
		http_response_code(503);   
		echo json_encode( [ "message" => "Unable to delete loan." ] );
	}
} else {
	http_response_code(400);
	echo json_encode( [ "message" => "Unable to delete loan. Data is incomplete." ] );
}
?>