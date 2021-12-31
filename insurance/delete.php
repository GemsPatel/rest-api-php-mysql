<?php
include_once '../config/Database.php';
include_once '../class/insurance.php';
 
$database = new Database();
$db = $database->getConnection();
 
$insurance = new Insurance($db);
 
$data = $_POST;

if(!empty($data['id'])) {
	$insurance->insuranceId = $data['id'];
	if($insurance->delete()){
		http_response_code(200);
		echo json_encode(array("message" => "insurance was deleted."));
	} else {
		http_response_code(503);
		echo json_encode(array("message" => "Unable to delete insurance."));
	}
} else {
	http_response_code(400);
	echo json_encode(array("message" => "Unable to delete insurance. Data is incomplete."));
}
?>