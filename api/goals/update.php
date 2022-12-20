<?php
include('../include/connection.php');
include('../include/functions.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$user_id = $DecodeData['user_id'];
$daily_goal_steps = $DecodeData['daily_goal_steps'];
$weekly_goal_steps = $DecodeData['weekly_goal_steps'];

$user_name = getname($user_id);
$sql = "UPDATE goals SET weekly_goal_steps='$weekly_goal_steps',daily_goal_steps='$daily_goal_steps ' WHERE user_id ='$user_id '";

$run = mysqli_query($conn, $sql);
if ($run) {
    $response[] = array(
        "message" => 'Goals Updated successfully',
        "error" => 'false',
        "user name" => $user_name,
        "user_id" => $user_id,
        "daily_goal_steps" => $daily_goal_steps,
        "weekly_goal_steps" => $weekly_goal_steps,
    );
} else {
    $response[] = array(
        "message" => 'This Goals of User Doesnot exist',
        "error" => 'true',
    );
}
echo json_encode($response);
