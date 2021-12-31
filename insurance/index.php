<?php
include_once '../config/Database.php';
include_once '../class/Insurance.php';

$database = new Database();
$db = $database->getConnection();

$insurance = new Insurance($db);

$insurance->insuranceId = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

$result = $insurance->read();

if($result->num_rows > 0){
    $insuranceRecords=[]; 
	while ($insurance = $result->fetch_assoc()) {
        extract($insurance); 
        $insuranceDetails=array(
            "insuranceId" => $insuranceId,
            "insurance_amount" => $insurance_amount,
            "insurance_type" => $insurance_type,
			"agent_name" => $agent_name,
			"duration" => $duration
        ); 

        $insuranceRecords[] = $insuranceDetails;
    }

    http_response_code(200);
    echo json_encode( ['result' => $insuranceRecords]);
}else{
    http_response_code(404);
    echo json_encode( array("message" => "No insurance found.") );
} 