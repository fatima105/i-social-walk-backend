
<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
print_r($EncodeData = file_get_contents('php://input'));
print_r($DecodeData = json_decode($EncodeData, true));

$id = $DecodeData['id'];
$password = $DecodeData['password'];

$newpassword = md5($password);



$sql = "UPDATE users SET password='$newpassword' WHERE id='$id'";

$run = mysqli_query($conn, $sql);
if ($run) {
    $response[] = array(
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
