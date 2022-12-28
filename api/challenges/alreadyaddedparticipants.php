<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);

$challenge_id = $data['challenge_id'];
$sql = "Select * from challenges_participants where challenge_id='$challenge_id' and status='membered'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('error' => false, 'Message' => 'Succesfully fetched Challenges Members', 'Challenges' => $output));
} else {
    echo json_encode(array('error' => true, 'Message' => 'No record found'));
}
