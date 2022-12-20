<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$user_id = $data['user_id'];
$challenge_id = $data['challenge_id'];
$created_by_user_id = $data['created_by_user_id'];
$status = "Membered";

$date =  date('d-m-y h:i:s');
$noti_type = "admin to user for challenges";

foreach ($user_id as $user_id_list) {
    $uniqid = uniqid();
    $sql = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('{$noti_type}','{$uniqid}','{$created_by_user_id}','{$user_id_list}','{$date}','unread')";
    $query1 = mysqli_query($conn, $sql);
}
if ($query1) {
    $response[] = array(
        "message" => 'admin users added to challenge',
        "Challenges" => $challenge_id,
        "user" => $user_id,
        "created_by_user_id" => $created_by_user_id,
        "error" => false

    );
}
foreach ($user_id as $user_id_list) {
    $sql = "Insert into challenges_participants(challenge_id,user_id,status) Values ('{$challenge_id}','{$user_id_list}','membered')";
    $query = mysqli_query($conn, $sql);
}

if ($query) {
    $response[] = array(
        "message" => 'Successfully Added All Participants in Challenges',
        "Challenges" => $challenge_id,

        "error" => false

    );
} else {
    $response[] = array(
        "message" => 'Not Added',

        "error" => false

    );
}
echo json_encode($response);
