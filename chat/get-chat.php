<?php
session_start();
if (isset($_SESSION['user_id'])) {
    include(__DIR__ . '/../database/config.php');
    $outgoing_id = $_SESSION['user_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";
    $sql = "SELECT * FROM messages JOIN users ON users.id = messages.sender_id
                WHERE (sender_id = {$outgoing_id} AND receiver_id = {$incoming_id})
                OR (sender_id = {$incoming_id} AND receiver_id = {$outgoing_id}) ORDER BY messages.id";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            if ($row['sender_id'] == $outgoing_id) {
                $output .= '
                        <div class="msg">
                        <div class="chat outgoing">
                            <p>' . $row['message'] . '</p>
                        </div>
                        </div>';
            } else {
                $output .= '
                    <div class="msg">
                    <div class="chat incoming">
                            <p>' . $row['message'] . '</p>
                        </div> </div>';
            }
        }
    } else {
        $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
    }
    echo $output;
} else {
    header("location: login.php");
}
