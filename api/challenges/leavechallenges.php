<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$user_id = $DecodeData['user_id'];
$challenge_id = $DecodeData['challenge_id'];
$sql = "Delete from challenges_participants where user_id='$user_id' AND challenge_id='$challenge_id'";

$run = mysqli_query($conn, $sql);
if ($run) {
    $response[] = array(
        "message" => 'Lefted Challenge Successfully',
        "user_id" => $user_id,
        "challenge_id" => $challenge_id,
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
