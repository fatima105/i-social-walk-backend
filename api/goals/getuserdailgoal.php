<?php
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];

$sql1 = "Select * from users where id='$this_user_id'";

$result = mysqli_query($conn, $sql1);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $sql = "Select daily_goal_steps from goals where user_id='$this_user_id'  ";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                $daily_goal_steps = $row['daily_goal_steps'];
            }
            $sql = "Select * from users where id='$this_user_id'";
            $resultforuser = mysqli_query($conn, $sql);
            $outputuser = mysqli_fetch_all($resultforuser, MYSQLI_ASSOC);
            $response[] = array('error' => false, 'Message' => 'Daily And Weekly Goalss', 'details of user whose goals are displayed' => $outputuser, 'Daily Goal Steps' =>   $daily_goal_steps);
        } else {
            $response[] = array('message' => 'No goals found', 'error' => 'true');
        }
    }
}

echo json_encode($response);
