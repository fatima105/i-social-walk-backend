<?php
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];

$sql1 = "Select * from friend_list where  this_user_id='this_user_id' and status='friend'";
$result = mysqli_query($conn, $sql1);
if ($result) {

    $sql = "Select * from daily_steps_records where user_id='$user_id' ORDER BY calories_burnt desc LIMIT 50 ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('error' => false, 'Message' => 'Daily Ranking', 'daily Ranking' => $output));
    } else {
        echo json_encode(array('message' => 'No record found', 'error' => false));
    }
} else {
    echo json_encode(array('message' => 'No record found', 'error' => true));
}
