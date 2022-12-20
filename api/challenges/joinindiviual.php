<?php


include('../include/connection.php');
$date = date('d-m-y h:i:s');
$noti_type = "user to indiviual challenge";
//id is the group id
//userid the one who wants to join 
$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$challenge_id = $data['challenge_id'];
$user_id = $data['user_id'];
$created_date =  date('d-m-y h:i:s');
$sql = "SELECT * from challenges where id='$challenge_id'";

$result = mysqli_query($conn, $sql);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $image = $row['image'];
        $challenge_type = $row['challenge_type'];

        $created_by_user_id = $row['created_by_user_id'];
        $challenge_privacy = $row['challenge_privacy'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $challenge_metric_no = $row['challenge_metric_no'];
        $challenge_metric_step_type = $row['challenge_metric_step_type'];
    }
    if ($challenge_privacy == "private") {

        $noti_type = "user to indiviual challenge";
        $uniqid = uniqid();

        $sql1 = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('$noti_type','$uniqid','$user_id','$created_by_user_id','$date','unread')";
        $result = mysqli_query($conn, $sql1);
        if ($result) {

            $sql1 = "SELECT * from notification where uniqid='$uniqid'";
            $result2 = mysqli_query($conn, $sql1);
            if ($result2) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    $id = $row['id'];
                }
            }
            $sql = "Insert into individual_challenge_notification(noti_type_id,challenge_id,status,created_date) Values ('{$id}','{$challenge_id}','requested','$date')";
            $result = mysqli_query($conn, $sql);
            $sql1 = "Insert into challenges_participants(challenge_id,user_id,status) Values ('{$challenge_id}','{$user_id}','requested')";
            $result2 = mysqli_query($conn, $sql1);
            if ($result2) {
                $response[] = array(
                    'message' => 'Request for Challenge Sended',
                    'error' => 'false',
                    'name' => $name,
                    'image' => $image,
                    'user_id' => $user_id,
                    'created_by_user_id' => $created_by_user_id,

                    'start_date' => $start_date

                );
            }
        }
    } else {
        $sql = "Insert into challenges_participants(challenge_id,user_id,status) Values ('{$challenge_id}','{$user_id}','membered')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $response[] = array(
                'message' => 'Challenge Joined',
                'error' => 'false',
                'name' => $name,
                'created_at' => $created_date,
                'created_by_user_id' => $created_by_user_id,
                'image' => $image




            );
        }

        $uniqid = uniqid();

        $sql1 = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('$noti_type','$uniqid','$user_id','$created_by_user_id','$date','unread')";
        $result = mysqli_query($conn, $sql1);
        if ($result) {

            $sql1 = "SELECT * from notification where uniqid='$uniqid'";
            $result2 = mysqli_query($conn, $sql1);
            if ($result2) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    $id = $row['id'];
                }
            }
            $sql = "Insert into individual_challenge_notification(noti_type_id,challenge_id,status,created_date) Values ('{$id}','{$challenge_id}','membered','$date')";
            $result3 = mysqli_query($conn, $sql);
            if ($result3) {
                $response[] = array(
                    'message' => 'User ' . $user_id . 'Joined your Challenge admin ' . $created_by_user_id,
                    'error' => 'false',
                    'Notification id' => $id,
                    'name' => $name,
                    'image' => $image,
                    'user_id' => $user_id,
                    'created_by_user_id' => $created_by_user_id,

                    'start_date' => $start_date

                );
            }
        }
    }
} else {
    $response[] = array(
        'message' => 'This Challenge Does not Exists',
        'error' => true
    );
}
echo json_encode($response);
