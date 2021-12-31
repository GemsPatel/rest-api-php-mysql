<?php
include_once '../config/Database.php';
include_once '../class/loan.php';
 
$database = new Database();
$db = $database->getConnection();

$loan = new Loan($db);
 
$data = $_POST;
$success = true;
if( empty($data['id'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Select loan." ] );
	$success = false;
}

if( empty($data['loan_amount'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter loan amount." ] );
	$success = false;
}

if( empty($data['loan_type'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Select your loan type." ] );
	$success = false;
}

if( empty($data['agent_name'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter agent name." ] );
	$success = false;
}

if( empty($data['rate_of_Interest'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter rate of interest." ] );
	$success = false;
}

if( empty($data['duration'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter your loan duration in month." ] );
	$success = false;
}

if( $success ){
	$loan->loanId = $data['id']; 
	$loan->loan_amount = $data['loan_amount'];
	$loan->loan_type = $data['loan_type'];
	$loan->agent_name = $data['agent_name'];
	$loan->rate_of_Interest = $data['rate_of_Interest'];
	$loan->duration = $data['duration']; 
	
	if($loan->update()){
		http_response_code(200);
		echo json_encode( [ "message" => "Loan was updated." ] );
	}else{
		http_response_code(503);
		echo json_encode( [ "message" => "Unable to update loan." ] );
	}
} else {
	http_response_code(400);
	echo json_encode( [ "message" => "Unable to update loan. Data is incomplete." ] );
}
?>