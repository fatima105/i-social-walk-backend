
<?php

$data = json_decode(file_get_contents("php://input"), true);
$this_user_id = $data['this_user_id'];
include('../include/connection.php');
$group_id = $data['group_id'];
$sql = "Select * from friend_list WHERE  this_user_id='$this_user_id'";

$result1 = mysqli_query($conn, $sql);

$rowcount = mysqli_num_rows($result1);
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $friend_user_id = $row['friend_user_id'];

        $sql = "Select * from group_member WHERE  group_id='$group_id' AND user_id ='$friend_user_id'";

        $result = mysqli_query($conn, $sql);

        $rowcount = mysqli_num_rows($result);
        if ($rowcount <= 0) {

            $array[] = $row['friend_user_id'];
        }
    }
    $response[] = array(
        "message" => 'Add your Friends',
        "array of Members" => $array,
        "group_id" => $group_id,
        "this_user_id" => $this_user_id,
        "error" => false

    );
} else {

    $response[] = array(
        "message" => 'No friends found',

        "error" => false

    );
}
echo json_encode($response);
?>
