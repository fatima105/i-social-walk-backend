<?php
include('../include/connection.php');
include('../include/functions.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$user_id = $DecodeData['user_id'];
$user_name = getname($user_id);

$date = date('Y-m-d');
$sub = date('Y-m-d', strtotime('-7 days'));


$sql = "SELECT steps,date FROM daily_steps_records WHERE date BETWEEN  '$sub' and '$date' AND user_id='$user_id' ";

$result = mysqli_query($conn, $sql);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {

    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response[] = array('error' => 'false', 'Message' => 'Succesfully fetched History of One Week', 'History' => $output,   "user name" => $user_name,);
} else {
    $response[] =  array('message' => 'No record found', 'error' => true);
}
echo json_encode($response);
