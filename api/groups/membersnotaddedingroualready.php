<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);
$group_id = $data['group_id'];
$user_id = $data['user_id'];
$sql = "SELECT *
FROM users
INNER JOIN  group_member
ON users.id = group_member.user_id where users.id != group_member.user_id AND group_member.group_id= '1'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('error' => false, 'Message' => 'Succesfully fetched Groups', 'Groups' => $output));
} else {
    echo json_encode(array('error' => true, 'Message' => 'No record found'));
}
