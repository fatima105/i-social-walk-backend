<?php

header('Content-Type:application/json');
header('Acess-Control-Allow-Origin:*');
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$challenge_id = $data['challenge_id'];

$sql = "SELECT *
FROM challenges
where id='$challenge_id';";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('error' => false, 'Message' => 'Succesfully fetched Challenge Info', 'Challenge' => $output));
} else {
    echo json_encode(array('error' => true, 'Message' => 'No record found'));
}
