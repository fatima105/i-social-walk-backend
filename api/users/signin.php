
<?php
session_start();
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$email = $DecodeData['email'];
$password = $DecodeData['password'];
$pass = md5($password);


// json 
$id = '';

$first_name = '';
$last_name = '';
$device_token = '';
$created_at = '';
$login = 0;


$sql = "SELECT * FROM users where email='$email' AND password='$pass'";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {


        $id = $row['id'];
        $email = $row['email'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $device_token = $row['device_token'];
        $profile_image = $row['profile_image'];
    }
    $response[] = array(
        "message" => 'Login Successful',
        "email" => $email,
        "password" => $password,
        "id" => $id,
        "device_token" => $device_token,
        "profile_image" => $profile_image,
        "first_name" => $first_name,
        "last_name" => $last_name,
        "error" => false,
    );
    echo json_encode($response);
} else {
    $response[] = array(
        "message" => 'Email or Password is Wrong',
        "error" => true,
    );
    echo json_encode($response);
}






?>