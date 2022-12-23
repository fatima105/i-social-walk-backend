<?php
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$codeuser = $DecodeData['code'];
$email = $DecodeData['email'];
$sql = "SELECT email FROM users where otp_code='$codeuser' and email='$email'";

$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run) > 0) {

    $sql1 = "UPDATE users SET otp_code='0' where email = '$email'";
    $query1 = mysqli_query($conn, $sql1);
    if ($query1) {


        $response[] = array(
            'messsage' => 'You are Verified',
            'error' => 'false',
        );
    }
} else {

    $response[] = array(
        'messsage' => 'Not Correct code',
        'error' => 'true',
    );
}

echo json_encode($response);
