<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$user_id = $data['user_id'];
$sql = "SELECT * FROM users WHERE  id='$user_id' ";

$resultquery = mysqli_query($conn, $sql);
$rowcount = mysqli_num_rows($resultquery);
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($resultquery)) {
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $profile_image = $row['profile_image'];
        $email = $row['email'];
    }
}
$device_name = $data['device_name'];
$device_modal_name = $data['device_modal_name'];


$watch_connection_name = $data['watch_connection_name'];


$sql = "Insert into user_watches(device_name,device_modal_name,watch_connection_name,user_id) Values ('{$device_name}','{$device_modal_name}','{$watch_connection_name}','{$user_id}')";

if (mysqli_query($conn, $sql)) {
    $sqlqu = "Select * from user_watches where user_id='$user_id' ORDER BY id DESC limit 1";
    $sqlquery = mysqli_query($conn, $sqlqu);
    if ($sqlquery) {
        while ($row = mysqli_fetch_assoc($sqlquery)) {
            $id = $row['id'];
        }
    }
    echo json_encode(array(
        'id' => $id, 'device_name' => $device_name, 'user_id' => $user_id, 'device_modal_name' => $device_modal_name, 'watch_connection_name' => $watch_connection_name, '' => $watch_connection_name, 'message' => 'Device Added', 'error' => false,
        'First Name' =>  $first_name, 'Last Name' => $last_name, 'profile_image' => $profile_image, 'email' => $email
    ));
} else {
    echo json_encode(array('message' => 'Not Added', 'error' => true));
}
