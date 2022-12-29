
<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$friend_user_id = $DecodeData['friend_user_id'];
$this_user_id = $DecodeData['this_user_id'];
$noti_type_id = $DecodeData['noti_type_id'];
$sqlqu = "UPDATE friends_notifications SET status='unapproved' WHERE noti_type_id='$noti_type_id'";

$run1 = mysqli_query($conn, $sqlqu);
$sql = "UPDATE friend_list SET status='unapproved' WHERE this_user_id='$this_user_id' AND friend_user_id='$friend_user_id'";

$run = mysqli_query($conn, $sql);
if ($run) {
    $response[] = array(
        "message" => 'Cancel Request',


        "error" => false


    );
    echo json_encode($response);
} else {
    $response[] = array(
        "message" => 'Not Cancel',
        "error" => true
    );
}
echo json_encode($response);
