<?php
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];

$sql1 = "Select * from users where id='$this_user_id'";

$resultquery = mysqli_query($conn, $sql1);
$rowcount = mysqli_num_rows($resultquery);
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($resultquery)) {
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $profile_image = $row['profile_image'];
        $email = $row['email'];
    }


    $sql = "Select * from user_watches where user_id='$this_user_id'  ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            $device_id = $row['id'];
            $device_name = $row['device_name'];
            $device_modal_name = $row['device_modal_name'];
            $watch_connection_name = $row['watch_connection_name'];
        }

        $response[] = array(
            'id' => $device_id, 'device_name' => $device_name,'device_modal_name' => $device_modal_name, 'watch_connection_name' => $watch_connection_name, '' => $watch_connection_name, 'message' => 'Device Added', 'error' => false,
            'First Name' =>  $first_name, 'Last Name' => $last_name, 'profile_image' => $profile_image, 'email' => $email
        );
    } else {
        $response[] = array('message' => 'This user doesnot have any watch connected', 'error' => 'true');
    }
} else {
    $response[] = array('message' => 'This user doesnot Exists', 'error' => 'true');
}

echo json_encode($response);
