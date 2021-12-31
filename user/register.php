<?php
include_once '../config/Database.php';
include_once '../class/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new user($db);
 
$data = $_POST;
$success = true;
if( empty($data['email'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter your email address" ] );
	$success = false;
}

if( empty($data['name'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter your name" ] );
	$success = false;
}

if( empty($data['phone_num'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter your phone number" ] );
	$success = false;
}

if( empty($data['password'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter your password" ] );
	$success = false;
}

if( empty($data['occupation'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter your occupation" ] );
	$success = false;
}

if( empty($data['adhar_number'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter your adhar number" ] );
	$success = false;
}

if( empty($data['annual_Income'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter your annual income" ] );
	$success = false;
}

if( empty($data['agent'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter your agent" ] );
	$success = false;
}

if( empty($data['dob'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Select your Date of Birth" ] );
	$success = false;
}

if( empty($data['address'] ) ){
	http_response_code(400);
	echo json_encode( ["message" => "Enter your address" ] );
	$success = false;
}


if( $success ){
    $user->email = $data['email'];
    $user->name = $data['name'];
    $user->phone_num = $data['phone_num'];
    $user->password = md5($data['password']);
    $user->occupation = $data['occupation'];
    $user->adhar_number = $data['adhar_number']; 
    $user->annual_Income = $data['annual_Income']; 
    $user->agent = $data['agent'];
    $user->dob = $data['dob']; 
    $user->address = $data['address'];

    $result = $user->checkEmail($data['email']);

    if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(503);
        echo json_encode( [ "message" => "Invalid email format." ] );
    }elseif($result->num_rows > 0){
        http_response_code(503);
            echo json_encode( [ "message" => "Email already exist." ] );
    }else{
        if($user->register()){
            http_response_code(201);
            echo json_encode( [ "message" => "Register created successfully." ] );
        } else{
            http_response_code(503);
            echo json_encode( [ "message" => "Unable to create user." ] );
        }
    }
}
// else{    
//     http_response_code(400);
//     echo json_encode( [ "message" => "Unable to create user. Data is incomplete." ] );
// }
?>