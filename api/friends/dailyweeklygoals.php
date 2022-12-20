<?php
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$friend_user_id = $DecodeData['friend_user_id'];
$friends = "friend";
$sql1 = "Select * from friend_list where friend_user_id='$friend_user_id' AND this_user_id='$this_user_id' ";

$result = mysqli_query($conn, $sql1);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['status'] = "friends") {
            $sql = "Select * from goals where user_id='$friend_user_id'  ";

            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {

                $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $sql = "Select * from users where id='$friend_user_id'";
                $resultforuser = mysqli_query($conn, $sql);
                $outputuser = mysqli_fetch_all($resultforuser, MYSQLI_ASSOC);
                $response[] = array('error' => false, 'Message' => 'Daily And Weekly Goalss', 'Goals' => $output, 'Detailsoffriends' => $outputuser);
            } else {
                $response[] = array('message' => 'No goals found', 'error' => 'true');
            }
        } else {
            $response[] = array('message' => 'Not Friends', 'error' => true);
        }
    }
} else {
    $response[] = array('message' => 'no user in this friendlist', 'error' => true);
}
echo json_encode($response);
