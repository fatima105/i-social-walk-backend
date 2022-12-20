<?php
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$codeuser = $DecodeData['code'];
$email = $DecodeData['email'];
$newpass = $DecodeData['newpass'];
$confirmpass = $DecodeData['confirmpass'];
$newpassword = md5($newpass);
$sql = "SELECT email FROM users where otp_code='$codeuser'";

$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run) > 0) {
    $sql1 = "UPDATE users SET otp_code='0' where email = '$email'";
    $query1 = mysqli_query($conn, $sql1);
    if ($query1) {
        if ($newpass == $confirmpass) {
            $sql1 = "UPDATE users SET password='$newpassword' where email = '$email'";
            $run = mysqli_query($conn, $sql1);
            if ($run) {
                $response[] = array(
                    'messsage' => 'Password Changed',
                    'error' => 'false',
                );
            }
        } else {

            $response[] = array(
                'messsage' => 'Password doesnot Match',
                'errors' => 'true',
            );
        }
    }
} else {

    $response[] = array(
        'messsage' => 'Your four digit code is not correct',
        'errors' => 'true',
    );
}
echo json_encode($response);
