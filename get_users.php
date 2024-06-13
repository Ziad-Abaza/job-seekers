<?php
session_start();
include_once "./database/config.php";
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}
?>

<?php
$sql = mysqli_query($conn, "SELECT * FROM users");
if (mysqli_num_rows($sql) > 0) {
    while ($user = mysqli_fetch_assoc($sql)) {
        if($user["id"] != $_SESSION['user_id']){
            $data[] = $user;
        }
    }
    $json_data = json_encode($data);
    echo $json_data;
}
?>