
<?php

include('../include/connection.php');
// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin:*');
// header('Access-Control-Allow-Methods:POST');
// header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
$EncodeData = file_get_contents('php://input');
$Data = json_decode($EncodeData, true);



$email = $Data['email'];
$password = $Data['password'];
$pass = md5($password);
$sql = "SELECT * FROM users ";
$run = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($run)) {
    if ($row['email'] == $email && $row['password'] == $pass) {
        $response[] = array(
            "id" => $row['id'],
            "email" => $row['email'],

            "error" => "false",
            "status" => "You are Successuly Logged In",
        );
    } else {
        $response[] = array(
            "error" => "true",
            "message" => "Invalid Credientals",
        );
    }
}


echo json_encode($response);

?>