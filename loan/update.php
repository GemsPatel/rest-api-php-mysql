<?php
include_once '../config/Database.php';
include_once '../class/loan.php';
 
$database = new Database();
$db = $database->getConnection();

$loan = new Loan($db);
 
$data = $_POST;

if(!empty($data['id']) && !empty($data['loan_amount']) && !empty($data['loan_type']) && !empty($data['agent_name']) && !empty($data['rate_of_Interest']) && !empty($data['duration'])){
	$loan->loanId = $data['id']; 
	$loan->loan_amount = $data['loan_amount'];
	$loan->loan_type = $data['loan_type'];
	$loan->agent_name = $data['agent_name'];
	$loan->rate_of_Interest = $data['rate_of_Interest'];
	$loan->duration = $data['duration']; 
	
	if($loan->update()){
		http_response_code(200);
		echo json_encode(array("message" => "Loan was updated."));
	}else{
		http_response_code(503);
		echo json_encode(array("message" => "Unable to update loan."));
	}
} else {
	http_response_code(400);
	echo json_encode(array("message" => "Unable to update loan. Data is incomplete."));
}
?>