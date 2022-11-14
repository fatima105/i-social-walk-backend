<?php

$server = 'localhost';
$username = 'root';
$password = '';
$db = 'isocialwalk';
$conn = mysqli_connect($server, $username, $password, $db);
if (!$conn) {
    //  echo 'error';
} else {
    // echo 'connected';
}
