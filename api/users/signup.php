<?php
include('../include/connection.php');
// Headers
$Data = json_decode(file_get_contents("php://input"), true);
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$email = $DecodeData['email'];
$password = $DecodeData['password'];
$first_name = $DecodeData['first_name'];
$last_name = $DecodeData['last_name'];
$phoneno = $DecodeData['phoneno'];
$created_date = date('d-m-Y');
$devicetoken = rand(1000, 9000);
$sql_checkemail = "SELECT * FROM users";
$run_checkemail = mysqli_query($conn, $sql_checkemail);
$checkemail_result = 0;
while ($row_checkemail = mysqli_fetch_assoc($run_checkemail)) {
    if ($row_checkemail['email'] == $email) {
        $checkemail_result = 1;
        break;
    }
}

if ($checkemail_result == 1) {
    $message = 'Email Already Exist';
    $response[] = array(
        "message" => $message,
        "error" => true,

    );
    echo json_encode($response);
} else {
    $password = md5($password);
    $sql = "INSERT INTO users(email,password,phoneno,first_name,last_name,status,device_token,created_at) 
	VALUES ('$email','$password','$phoneno','$first_name','$last_name','active','$devicetoken','$created_date')";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        $sql_id = "SELECT * FROM users";
        $run_id = mysqli_query($conn, $sql_id);
        $id_result = 0;
        while ($row_id = mysqli_fetch_assoc($run_id)) {
            if ($row_id['email'] == $email) {
                $id_result = $row_id['id'];
                break;
            } else {
                continue;
            }
        }
    } else {
        $message = 'error';
    }

    $_SESSION["email"] = $email;
    $_SESSION["id"] = $id_result;

    $response[] = array(
        "message" => 'Signup Successful',
        "email" => $email,
        "password" => $password,
        "id" => $id_result,
        "first_name" => $first_name,
        "last_name" => $last_name,
        "devicetoken" => $devicetoken,
        "error" => false,
    );
    echo json_encode($response);
}
