<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$active_watch = $DecodeData['active_watch'];

$id = $DecodeData['id'];
$sql = "UPDATE users SET active_watch='$active_watch '  WHERE id='$id'";

$run = mysqli_query($conn, $sql);

if ($run) {
    $response[] = array(
        "active_watch" => $active_watch,
        "message" => 'Watch Updated successfully',
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
