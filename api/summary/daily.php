<?php
header('Content-Type:application/json');
header('Acess-Control-Allow-Origin:*');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$friend_user_id = $DecodeData['friend_user_id'];
$friends = "friend";
$sql1 = "Select * from friend_list where this_user_id ='$this_user_id' AND status='$friends' ";

$result = mysqli_query($conn, $sql1);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {

    $date = date('Y-m-d');
    $sub = date('Y-m-d', strtotime('-7 days'));

    while ($row = mysqli_fetch_assoc($result)) {

        $sql = "Select * from daily_steps_records WHERE date BETWEEN  '$sub' and '$date' AND user_id='$friend_user_id'  ";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $response[] = array('error' => false, 'Message' => 'Daily And Weekly Goalss', 'Goals' => $output);
        } else {
            $response[] = array('message' => 'Weekly Details', 'error' => 'true');
        }
    }
} else {
    $response[] = array('message' => 'No Details', 'error' => true);
}

echo json_encode($response);
