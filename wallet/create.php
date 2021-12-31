<?php
include_once '../config/Database.php';
include_once '../class/Wallet.php';
 
$database = new Database();
$db = $database->getConnection();
 
$wallet = new Wallet($db);
 
$data = $_POST;
if(!empty($data['userId']) && !empty($data['coin']) ){ 
    
    $wallet->userId = $data['userId'];
    $wallet->coin = $data['coin'];

    if($wallet->create()){
        http_response_code(201);
        echo json_encode(array("message" => "wallet was created."));
    } else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create wallet."));
    }
}else{    
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create wallet. Data is incomplete."));
}
?>