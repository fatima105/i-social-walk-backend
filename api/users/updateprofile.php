<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$phoneno = $DecodeData['phoneno'];
$first_name = $DecodeData['first_name'];
$last_name = $DecodeData['last_name'];
$id = $DecodeData['id'];
$sql = "UPDATE users SET phoneno='$phoneno' ,first_name='$first_name',last_name='$last_name' WHERE id='$id'";

$run = mysqli_query($conn, $sql);
if ($run) {
    $response[] = array(
        "first_name" => $first_name,
        "last_name" => $last_name,
        "phoneno" => $phoneno,
        "id" => $id,
        "message" => 'Profile Updated successfully',
        //

        "error" => false


    );
    echo json_encode($response);
} else {
    $response[] = array(
        "message" => 'Not Updated',
        "error" => true
    );
    echo json_encode($response);
}
