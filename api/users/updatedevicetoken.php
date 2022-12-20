
<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$id = $DecodeData['id'];
$device_token = rand(2000, 9999);

$sql = "UPDATE users SET device_token='$device_token' WHERE id=$id";

$run = mysqli_query($conn, $sql);
if ($run) {
    $response[] = array(
        "message" => 'Device token updated successfully',
        "token" => $device_token,
        "id" => $id,

        "error" => false


    );
    echo json_encode($response);
} else {
    $response[] = array(
        "message" => 'Not Updated',
        "error" => true
    );
    echo json_encode($response);
}







?>