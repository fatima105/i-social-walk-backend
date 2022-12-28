<?php
header('Content-Type:application/json');
header('Acess-Control-Allow-Origin:*');
include('../include/connection.php');

$sql = "Select * from challenges where challenge_type='indiviual'";
$result = mysqli_query($conn, $sql) or die("Query failed");
if (mysqli_num_rows($result) > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('error' => false, 'Message' => 'Succesfully fetched Challenges', 'Challenges' => $output));
} else {
    echo json_encode(array('error' => true, 'message' => 'No record found', 'status' => false));
}
