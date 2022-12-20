<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$friend_user_id = $DecodeData['friend_user_id'];
$noti_type_id = $DecodeData['noti_type_id'];
$sql = "UPDATE friends_notifications SET status='approved' WHERE noti_type_id='$noti_type_id'";

$run1 = mysqli_query($conn, $sql);

$sql = "UPDATE friend_list SET status='approved' WHERE this_user_id='$this_user_id' AND friend_user_id='$friend_user_id'";

$run1 = mysqli_query($conn, $sql);
if ($run1) {
    $response[] = array(
        "message" => 'friend Added',


        "error" => false


    );
} else {
    $response[] = array(
        "message" => 'Not Added',
        "error" => true
    );
}

$noti_type = "friends to friends";
$uniqid = uniqid();
$date = date('d-m-y h:i:s');
$sqlquery = "insert into notification(noti_type,uniqid,from_id,to_id,date,status) VALUES ('$noti_type','$uniqid','$friend_user_id','$this_user_id','$date','read')";

$run1 = mysqli_query($conn, $sqlquery);
if ($run1) {
    $response[] = array(
        "message" => 'Friend Request Accepted ',
        "error" => false
    );
}

echo json_encode($response);
