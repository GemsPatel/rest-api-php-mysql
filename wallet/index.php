<?php
include_once '../config/Database.php';
include_once '../class/Wallet.php';

$database = new Database();
$db = $database->getConnection();
 
$Wallet = new Wallet($db);

$Wallet->walletId = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

$result = $Wallet->read();

if($result->num_rows > 0){
    $walletRecords = []; 
	while ($Wallet = $result->fetch_assoc()) {
        extract($Wallet); 
        $walletDetails=array(
            "walletId" => $walletId,
            "userId" => $userId,
            "coin" => $coin	
        ); 
       
        $walletRecords[] = $walletDetails;
    }
    http_response_code(200);
    echo json_encode( [ 'result' => $walletRecords ] );
}else{
    http_response_code(404);
    echo json_encode( array("message" => "No Wallet found.") );
} 