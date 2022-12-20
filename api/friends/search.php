
<?php

$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'];
$this_user_id = $data['this_user_id'];
include('../include/connection.php');
$sql = "Select * from friend_list WHERE  this_user_id='$this_user_id' AND status='approved'";

$result = mysqli_query($conn, $sql);

$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['friend_user_id'];

        $sql = "Select * from users WHERE  first_name LIKE '%$name%' AND id='$user_id'";

        $output = mysqli_query($conn, $sql);

        $rowcount = mysqli_num_rows($output);
        if ($rowcount > 0) {
            $output1 = mysqli_fetch_all($output, MYSQLI_ASSOC);
            $response[] = array('error' => 'false', 'Message' => 'Succesfully fetched friend', 'friends' => $output1);
            break;
        } else {

            $response[] = array(
                "message" => 'No friends Found of this name',

                "error" => false

            );
            break;
        }
    }
} else {

    $response[] = array(
        "message" => 'Empty friendlist',

        "error" => false

    );
}
echo json_encode($response);
?>
