<?php

header('Content-Type: application/json');

include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$sql = "SELECT * 
FROM groups

ORDER BY RAND()";

$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run)) {
    while ($row = mysqli_fetch_assoc($run)) {
        $group_id = $row['id'];

        $query = "Select * from group_member where group_id='$group_id' AND user_id='$this_user_id'";
        $run2 = mysqli_query($conn, $query);
        if (mysqli_num_rows($run2) <= 0) {
            $id = $row['id'];
            $name = $row['name'];
            $admin = $row['created_by_user_id'];
            $group_privacy = $row['group_privacy'];
            $group_visibility = $row['group_visibility'];
            $created_at = $row['created_at'];

            $response[] = array(
                "Group ID" =>  $group_id,
                "Group Name" =>  $name,
                "admin" => $admin,
                "status" => 'groups for suggestions',
                "group privacy" => $group_privacy,
                "group visibility" =>  $group_visibility,
                "error" => false,
            );
        }
    }
}



echo json_encode($response);
