<?php
session_start();
include('../include/connection.php');

$id = $_POST['id'];


$email = '';
$password = '';
$first_name = '';
$last_name = '';

$login = 1;

$target_dir = "../assets/";
$target_file = $target_dir . basename($_FILES["profile_image"]["name"]);


if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {


    $dbpath = '../assets/' . basename($_FILES["profile_image"]["name"]);

    $sql = "UPDATE users SET profile_image='$dbpath' WHERE  id='$id' ";
    $run = mysqli_query($conn, $sql);
    if ($run) {
        $sql_user = "SELECT * FROM users WHERE id='$id'";
        $run_user = mysqli_query($conn, $sql_user);

        while ($row_user = mysqli_fetch_assoc($run_user)) {
            $email = $row_user['email'];
            $id = $row_user['id'];
            $first_name = $row_user['first_name'];
            $last_name = $row_user['last_name'];
            $phoneno = $row_user['phoneno'];
            $active_watch = $row_user['active_watch'];

            $login = 1;
            break;
        }
        if ($login == 1) {
            $response[] = array(
                "message" => 'Image Update Successful',
                "image" =>  $dbpath,
                "active watch" => $active_watch,
                "id" => $id,
                "phone number" => $phoneno,
                "email" => $email,
                "first_name" => $first_name,
                "last_name" => $last_name,

                "error" => false,
            );
            echo json_encode($response);
        } else {
            $response[] = array(
                "message" => 'Error uploading Image',
                "error" => true,
            );
            echo json_encode($response);
        }
    } else {

        $response[] = array(
            "message" => 'Error uploading Image',
            "error" => true,
        );
        echo json_encode($response);
    }
}
