
<?php
session_start();
include('../include/connection.php');

$id = $_POST["id"];
// user data
$id = '';
$email = '';
$password = '';
$username = '';
$image = '';
$dob = '';
$login = 1;




$target_dir = "../assets/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);


if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {


    $dbpath = 'assets/' . basename($_FILES["image"]["name"]);

    $sql = "UPDATE groups SET image='$dbpath' WHERE  id='$id'";
    $run = mysqli_query($conn, $sql);
    if ($run) {
        $sql_user = "SELECT * FROM groups WHERE id='$id'";
        $run_user = mysqli_query($conn, $sql_user);

        while ($row_user = mysqli_fetch_assoc($run_user)) {
            $id = $row_user['id'];
            $email = $row_user['EmailAddress'];
            $password = $row_user['Password'];
            $username = $row_user['UserName'];
            $image = $row_user['image'];
            $dob = $row_user['dob'];
            $login = 1;
            break;
        }
        if ($login == 1) {
            $response[] = array(
                "message" => 'Image Update Successful',
                "email" => $email,
                "password" => $password,
                "id" => $id,
                "username" => $username,
                "dob" => $dob,
                "image" => $image,
                "error" => false,
            );
            echo json_encode($response);
        } else {
            $response[] = array(
                "message" => 'Error uploading Image',
                "error" => $user_id,
            );
            echo json_encode($response);
        }
    } else {

        $response[] = array(
            "message" => 'Error uploading Image',
            "error" => $user_id,
        );
        echo json_encode($response);
    }
}

?>