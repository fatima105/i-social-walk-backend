<?php

header('Content-Type: application/json');
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$date = date('Y-m-d');
$sub = date('Y-m-d', strtotime('-7 days'));
$date = date("Y-m-d");
$sql = "SELECT * 
FROM friend_list 
where this_user_id='$this_user_id'";
$date = date('Y-m-d');
$finalsteps = 0;
$sub = date('Y-m-d', strtotime('-7 days'));
$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run)) {
    while ($row = mysqli_fetch_assoc($run)) {
        $friend_user_id = $row['friend_user_id'];
        $query = "Select sum(steps),user_id,id from daily_steps_records where date BETWEEN  '$sub' and '$date' AND user_id='$friend_user_id'  ";
        $run2query = mysqli_query($conn, $query);
        if (mysqli_num_rows($run2query) > 0) {
            while ($row2 = mysqli_fetch_assoc($run2query)) {
                $id = $row2['id'];
                $steps = $row2['sum(steps)'];
                $user_id = $row2['user_id'];
            }

            $response[] = array(
                "id" =>  $id,

                "user id" => $user_id,

                "steps" => $steps,

                "message" => 'Weekly Users Ranking',


                "error" => false,
            );
        }
    }
} else {
    $response[] = array(

        "message" => 'No friends',

        "error" => true,
    );
}


echo json_encode($response);
