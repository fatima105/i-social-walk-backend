<?php

header('Content-Type:application/json');
header('Acess-Control-Allow-Origin:*');
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$challenge_id = $data['challenge_id'];
$user_id = $data['user_id'];
$sql = "DELETE FROM  challenges_participants
where challenge_id='$challenge_id' AND user_id='$user_id';";
$result = mysqli_query($conn, $sql);
if ($result) {
    echo json_encode(array('error' => false, 'Message' => 'Removed Member From Challenge'));
} else {
    echo json_encode(array('error' => true, 'Message' => 'Not Removed'));
}
