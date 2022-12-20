<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$id = $data['id'];
$user_id = $data['user_id'];
$device_name = $data['device_name'];
$device_modal_name = $data['device_modal_name'];
$watch_connection_name = $data['watch_connection_name'];

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


    $sql = "UPDATE user_watches SET device_name='$device_name' ,device_modal_name='$device_modal_name ',watch_connection_name='$watch_connection_name' WHERE id='$id'";

    $querysql = mysqli_query($conn, $sql);

    if ($querysql) {
        $sqlqu = "SELECT * from user_watches where id='$id'";
        $final = mysqli_query($conn, $sqlqu);
        if ($final) {
            while ($row = mysqli_fetch_assoc($final)) {
                $device_name = $row['device_name'];
                $device_modal_name = $row['device_modal_name'];
                $watch_connection_name = $row['watch_connection_name'];
            }
            $response[] = array(
                'id' => $id, 'device_name' => $device_name, 'user_id' => $user_id, 'device_modal_name' => $device_modal_name, 'watch_connection_name' => $watch_connection_name, '' => $watch_connection_name, 'message' => 'Device Added', 'error' => false,
                'First Name' =>  $first_name, 'Last Name' => $last_name, 'profile_image' => $profile_image, 'email' => $email
            );
        }
    } else {
        $response = json_encode(array('message' => 'Not Updated', 'error' => true));
    }
} else {
    $response = json_encode(array('message' => 'User Doesnot Exist', 'error' => true));
}



echo json_encode($response);
