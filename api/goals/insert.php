<?php
include('../include/connection.php');
$Data = json_decode(file_get_contents("php://input"), true);
$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$user_id = $data['user_id'];
$daily_goal_steps = $data['daily_goal_steps'];
$weekly_goal_steps = $data['weekly_goal_steps'];

$sql = "Insert into goals(user_id,daily_goal_steps,weekly_goal_steps) Values ('{$user_id}','{$daily_goal_steps}','{$weekly_goal_steps}')";

if (mysqli_query($conn, $sql)) {
    $sqlqu = "SELECT * from users where id='$user_id'";
    $queryresponse = mysqli_query($conn, $sqlqu);
    if ($queryresponse) {
        while ($row = mysqli_fetch_assoc($queryresponse)) {
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $active_watch = $row['active_watch'];
            $profile_image = $row['profile_image'];
        }
    }
    echo json_encode(array('First Name' => $first_name, 'Last Name' => $last_name, 'Active Watch' => $active_watch, 'message' => 'Goal Added', 'error' => false));
} else {
    echo json_encode(array('message' => 'Not Added', 'error' => true));
}
