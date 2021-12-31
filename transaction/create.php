<?php
include_once '../config/Database.php';
include_once '../class/transaction.php';
 
$database = new Database();
$db = $database->getConnection();
 
$transaction = new Transaction($db);
 
$data = $_POST;
$success = true;

if( empty($data['transaction_amount'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter your transaction amount." ] );
	$success = false;
}

if( empty($data['transaction_time'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter transaction date." ] );
	$success = false;
}

if( empty($data['from_account'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter from account number." ] );
	$success = false;
}

if( empty($data['to_account'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter to account number." ] );
	$success = false;
}


if(  $success ){
    $transaction->transaction_amount = $data['transaction_amount'];
    $transaction->transaction_time = $data['transaction_time'];
    $transaction->from_account = $data['from_account'];
    $transaction->to_account = $data['to_account'];

    if($transaction->create()){
        http_response_code(201);
        echo json_encode( [ "message" => "transaction was created." ] );
    } else{
        http_response_code(503);
        echo json_encode( [ "message" => "Unable to create transaction." ] );
    }
}
// else{
//     http_response_code(400);
//     echo json_encode(array("message" => "Unable to create transaction. Data is incomplete."));
// }
?>