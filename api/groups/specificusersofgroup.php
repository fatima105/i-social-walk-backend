<?php

header('Content-Type:application/json');
header('Acess-Control-Allow-Origin:*');
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$user_id = $data['user_id'];

$sql = "SELECT *
FROM group_member
where user_id='$user_id';";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('error' => false, 'Message' => 'Succesfully fetched Groups of User', 'Group' => $output));
} else {
    echo json_encode(array('error' => true, 'Message' => 'No record found'));
}
