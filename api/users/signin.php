
<?php

include('../include/connection.php');
// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin:*');
// header('Access-Control-Allow-Methods:POST');
// header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
$EncodeData = file_get_contents('php://input');
$Data = json_decode($EncodeData, true);

print_r($EncodeData);
// print_r($Data);

die();
$email = $Data['email'];
$password = $Data['password'];
$sql = "SELECT * FROM users where email=$email AND password=$password";
$run = mysqli_query($conn, $sql);
if ($run) {
    while ($row = mysqli_fetch_assoc($run)) {
        $response[] = array(
            "id" => $row['id'],
            "email" => $row['email'],
            "password" => $row['password'],
            "error" => "false",
            "status" => "You are Successuly Logged In",
        );
    }
} else {

    $response[] = array(

        "error" => "true",
        "status" => "Invalid Credientals",
    );
}

echo json_encode($response);

?>