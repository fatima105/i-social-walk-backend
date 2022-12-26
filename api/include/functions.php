<?php

function getname($user_id)
{
    global $conn;
    $query = mysqli_query($conn, "SELECT first_name,last_name,profile_image from users where id='$user_id'");
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {

            $name = $row['first_name'] . '  ' . $row['last_name'];
            $image = $row['profile_image'];
        }
        return $name;
    }
}
