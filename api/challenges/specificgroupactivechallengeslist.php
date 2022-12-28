<?php

header('Content-Type:application/json');
header('Acess-Control-Allow-Origin:*');
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$group_id = $data['group_id'];

$sql = "SELECT *
FROM challenges_groups
where group_id='$group_id';";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('error' => false, 'Message' => 'Succesfully fetched Groups of Challenges', 'challenges' => $output));
} else {
    echo json_encode(array('error' => true, 'Message' => 'No Active Challenge'));
}
