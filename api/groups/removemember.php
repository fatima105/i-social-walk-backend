<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$user_id = $DecodeData['user_id'];
$group_id = $DecodeData['group_id'];
$sql = "Delete from group_member where user_id='$user_id' AND group_id='$group_id'";

$run = mysqli_query($conn, $sql);
if ($run) {
    $response[] = array(
        "message" => 'Removed Member Successfully',
        "user_id" => $user_id,
        "group_id" => $group_id,
        "error" => 'false'


    );
    echo json_encode($response);
} else {
    $response[] = array(
        "message" => 'Not Removed Member ',
        "error" => 'true',
    );
    echo json_encode($response);
}
