<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['user_id'];
$challenge_id = $data['challenge_id'];

$sql = "SELECT *
FROM challenges
INNER JOIN  challenges_participants
ON challenges.id = challenges_participants.challenge_id  INNER JOIN users
  ON users.id = challenges_participants.user_id  where user_id='$user_id' AND challenge_id='$challenge_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('error' => false, 'Message' => 'Challenge Participants', 'Challenges' => $output));
} else {
    echo json_encode(array('error' => true, 'Message' => 'No record found'));
}
