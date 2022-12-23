<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$id = $DecodeData['id'];
$npassword = $DecodeData['password'];
$newpassword = md5($npassword);
$oldpassword = $DecodeData['oldpassword'];
$oldpass = md5($oldpassword);
$sql = "Select * from users where id='$id' AND password='$oldpass'";
$run1 = mysqli_query($conn, $sql);
if (mysqli_num_rows($run1) > 0) {
    while ($row = mysqli_fetch_assoc($run1)) {
        $id = $row['id'];
        $email = $row['email'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $device_token = $row['device_token'];
        $profile_image = $row['profile_image'];
    }
}
$row = mysqli_num_rows($run1);
if ($row) {
    $sql = "UPDATE users SET password='$newpassword' WHERE id='$id'";

    $run = mysqli_query($conn, $sql);

    if ($run) {
        $response[] = array(
            "email" => $email,
            "id" => $id,
            "device_token" => $device_token,
            "profile_image" => $profile_image,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "message" => 'Password Updated successfully',
            "error" => 'false',


        );
        echo json_encode($response);
    } else {
        $response[] = array(
            "message" => 'not updated',
            "error" => 'true',
        );
        echo json_encode($response);
    }
} else {
    $response[] = array(
        "message" => 'old password is wrong',
        "error" => 'true',
    );
    echo json_encode($response);
}
