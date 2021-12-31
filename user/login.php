<?php
include_once '../config/Database.php';
include_once '../class/user.php';

$database = new Database();
$db = $database->getConnection();
 
$user = new user($db);

$data = $_POST;

$result = $user->login($data['email'],md5($data['password']));

if($result->num_rows > 0){
    $userRecords=[];
	while ($user = $result->fetch_assoc()) {
        extract($user); 
        $userDetails=array(
            "userId" => $userId,
            "name" => $name,
            "email" => $email
        ); 

       $userRecords[] = $userDetails;
    }
    http_response_code(200);
    echo json_encode( [ 'result' => $userRecords, 'message' => 'Login successfully.' ] );
}else{
    http_response_code(404);
    echo json_encode( array("message" => "Incorrect username or password.") );
}