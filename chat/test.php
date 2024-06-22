<?php
include(__DIR__ . '/../database/config.php');

if (isset($_REQUEST['user'])) {
    $user_id = mysqli_real_escape_string($conn, $_REQUEST['user']);
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE id = {$user_id}");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        echo json_encode($row); 
    } else {
        echo json_encode(['error' => 'User not found']);
    }
}
