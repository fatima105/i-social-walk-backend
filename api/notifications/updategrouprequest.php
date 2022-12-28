<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);
$status = $data['status'];
$noti_type_id = $data['noti_type_id'];
$sql = "Select * from notification where id='$noti_type_id' ";
$query = mysqli_query($conn, $sql);
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {

        $noti_type = $row['noti_type'];
        $to_id = $row['to_id'];
        $from_id = $row['from_id'];
    }
}

$noti_type = "user to group";
$uniqid = uniqid();
$date = date('d-m-y h:i:s');
$sql = "update group_notification  SET status='$status' where noti_type_id='$noti_type_id'";
$query = mysqli_query($conn, $sql);
if ($query) {
    $sql = "Select * from group_notification where noti_type_id='$noti_type_id' ";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $noti_type_id = $row['noti_type_id'];
            $group_id = $row['group_id'];
        }
        $sql = "update group_member  SET status='$status' where user_id='$from_id' AND group_id='$group_id'";
        $query = mysqli_query($conn, $sql);
        $sqlqu = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('group admin to user','{$uniqid}','{$to_id}','{$from_id}','$date','unread')";
        $result = mysqli_query($conn, $sqlqu);
        if ($result) {
            $response[] =
                array('error' => false, 'Message' => 'Request Accepted');
        }
    }
}

echo json_encode($response);
