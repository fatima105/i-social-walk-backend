<?php
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$friend_user_id = $DecodeData['friend_user_id'];

$sql = "Select * from friend_list where this_user_id='$this_user_id' AND friend_user_id='$friend_user_id'  ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        $friends_id = $row['id'];
        $this_user_id = $row['this_user_id'];
        $friend_user_id = $row['friend_user_id'];
        $status = $row['status'];
    }

    $response[] = array(
        'id' =>  $friends_id,
        'this_user_id' => $this_user_id,
        'friend_user_id' => $friend_user_id, 'status' => $status,

    );
} else {
    $response[] = array('message' => 'This record doesnot exist in our record', 'error' => 'true');
}
echo json_encode($response);
