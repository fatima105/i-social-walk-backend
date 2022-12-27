<?php
header('Content-Type:application/json');
header('Acess-Control-Allow-Origin:*');
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$user_id = $DecodeData['user_id'];
$friend_user_id = $DecodeData['friend_user_id'];
$sql = "SELECT * FROM group_member where user_id='$user_id'  AND status='membered'";
$run = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($run)) {

    $results0[] = $row['group_id'];
}
$sql1 = "SELECT * FROM group_member where user_id='$friend_user_id' AND status='membered'";
$run1 = mysqli_query($conn, $sql1);
while ($row1 = mysqli_fetch_assoc($run1)) {

    $results1[] = $row1['group_id'];
}
$result[] = array_intersect($results0, $results1);
if (empty($result)) {
    $response = array(
        "Message" => 'You Dont Have Any Mutual Groups',
        "error" => 'true',
    );
} else {
    $response = array(
        "Groups in Common" => $result,
        "error" => 'false',
    );
}
echo json_encode($response);
