<?php
include('../include/connection.php');
include('../include/functions.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$user_id = $DecodeData['user_id'];
$daily_goal_steps = $DecodeData['daily_goal_steps'];
$date = date("Y-m-d");
$user_name = getname($user_id);

$sqlquery = "select * from goals  where user_id='$user_id' AND date='$date'";
$querfinal = mysqli_query($conn, $sqlquery);
if (mysqli_num_rows($querfinal) > 0) {
    while ($row = mysqli_fetch_assoc($querfinal)) {
        $dail_goal_steps1 = $row['daily_goal_steps'];
        $daily_goal_stepsnew = $dail_goal_steps1 + $daily_goal_steps;
        $sql1 = "UPDATE goals SET daily_goal_steps='$daily_goal_stepsnew' WHERE user_id ='$user_id ' and date='$date'";

        $run1 = mysqli_query($conn, $sql1);
        if ($run1) {
            $response[] = array(
                "message" => 'Goals Updated successfully',
                "error" => 'false',

                "user_id" => $user_id,
                "daily_goal_steps" =>   $daily_goal_stepsnew,

            );
        }
    }
} else {
    $sqlquery = "Insert into goals(user_id,daily_goal_steps,date) Values ('{$user_id}','{$daily_goal_steps}','{$date}')";
    $run1 = mysqli_query($conn, $sqlquery);
    if ($run1) {
        $response[] = array(
            "message" => 'Goals Added',
            "user_id" => $user_id,
            "daily_goal_steps" => $daily_goal_steps,

            "error" => 'true',
        );
    }
}
echo json_encode($response);
