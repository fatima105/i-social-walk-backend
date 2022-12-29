<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$friend_user_id = $DecodeData['friend_user_id'];
$noti_type_id = $DecodeData['noti_type_id'];
$date = date('d-m-y h:i:s');
$sql = "UPDATE friends_notifications SET status='approved' WHERE noti_type_id='$noti_type_id'";

$run1 = mysqli_query($conn, $sql);

$sql = "UPDATE friend_list SET status='friends' WHERE this_user_id='$this_user_id' AND friend_user_id='$friend_user_id'";

$run1 = mysqli_query($conn, $sql);
if ($run1) {
    $sqlquery = "INSERT INTO friend_list (this_user_id,friend_user_id,date,status,noti_type_id)VALUES('$friend_user_id','$this_user_id','$date','friends','$noti_type_id')";
    $runquery = mysqli_query($conn, $sqlquery);
    $response[] = array(
        "your id" => $this_user_id,
        "friend id" => $friend_user_id,
        "message" => 'friend Added in your friend list ',


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

$sqlquery = "insert into notification(noti_type,uniqid,from_id,to_id,date,status) VALUES ('$noti_type','$uniqid','$friend_user_id','$this_user_id','$date','read')";

$run1 = mysqli_query($conn, $sqlquery);
if ($run1) {
    $response[] = array(
        "message" => 'Friend Request Accepted ',
        "error" => false
    );
}

echo json_encode($response);
