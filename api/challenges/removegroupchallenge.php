<?php

header('Content-Type:application/json');
header('Acess-Control-Allow-Origin:*');
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$group_id = $data['group_id'];
$challenge_id = $data['challenge_id'];
$sql = "DELETE FROM  challenges_groups
where group_id='$group_id' AND challenge_id='$challenge_id';";
$result = mysqli_query($conn, $sql);
if ($result) {
    echo json_encode(array('error' => false, 'Message' => 'Removed Group From Challenge'));
} else {
    echo json_encode(array('error' => true, 'Message' => 'Not Removed'));
}
