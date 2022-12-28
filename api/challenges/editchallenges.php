<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$id = $DecodeData['id'];
$name = $DecodeData['name'];
$challenge_type = $DecodeData['challenge_type'];

$challenge_type = $DecodeData['challenge_type'];
$challenge_visibility = $DecodeData['challenge_visibility'];
$challenge_privacy = $DecodeData['challenge_privacy'];
$start_date = $DecodeData['start_date'];
$end_date = $DecodeData['end_date'];
$challenge_metric_no = $DecodeData['challenge_metric_no'];
$challenge_metric_step_type = $DecodeData['challenge_metric_step_type'];
$sqlquery = "select * from challenges where id='$id'";
$Resultquery = mysqli_query($conn, $sqlquery);
if (mysqli_num_rows($Resultquery) > 0) {
    $sql = "UPDATE challenges SET 
name='$name',
challenge_visibility='$challenge_visibility', 
challenge_privacy='$challenge_privacy', 
start_date='$start_date',
end_date='$end_date', 
challenge_metric_no='$challenge_metric_no', 
challenge_metric_step_type='$challenge_metric_step_type'


WHERE id ='$id '";

    $run = mysqli_query($conn, $sql);
    if ($run) {
        $response[] = array(
            "message" => 'challenge Name Updated',
            'name' => $name,

            'challenge_type' => $challenge_type,
            'challenge_visibility' => $challenge_visibility,
            'challenge_privacy' => $challenge_privacy,

            'start_date' => $start_date,
            'end_date' => $end_date,
            'challenge_metric_no' => $challenge_metric_no,
            'challenge_metric_step_type' => $challenge_metric_step_type,
            "error" => 'false'


        );
        echo json_encode($response);
    } else {
        $response[] = array(
            "message" => 'Not updated',
            "error" => 'true',
        );
        echo json_encode($response);
    }
} else {
    $response[] = array(
        "message" => 'This challenge doesnot exist',
        "error" => 'true',
    );
    echo json_encode($response);
}
