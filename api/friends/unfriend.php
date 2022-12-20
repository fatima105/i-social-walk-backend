<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$this_user_id = $DecodeData['this_user_id'];
$friend_user_id = $DecodeData['friend_user_id'];

$sql = "Delete from friend_list where friend_user_id='$friend_user_id' AND  this_user_id='$this_user_id'";

$run = mysqli_query($conn, $sql);
if ($run) {
    $response[] = array(
        "message" => 'Removed friend Successfully',
        "this_user_id " => $this_user_id,
        "friend_user_id " => $friend_user_id,
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
