<!-- verify.php -->
<?php
include('./database/config.php');
include('./controller/ErrorHandlerController.php');

$success_messages = [];
$error_messages = [];

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    // Verify the validity and expiration of the token
    $current_time = date('Y-m-d H:i:s');
    $sql_check_token = "SELECT * FROM users WHERE email = '$email' AND token = '$token' AND token_expiration > '$current_time'";
    $result_check_token = mysqli_query($conn, $sql_check_token);

    if (mysqli_num_rows($result_check_token) === 1) {
        // Confirm the account
        $sql_confirm_account = "UPDATE users SET token = NULL, token_expiration = NULL, status = 1 WHERE email = '$email'";
        if (mysqli_query($conn, $sql_confirm_account)) {
            $success_messages['Success'] = 'Account successfully confirmed!';
            $_SESSION['user_status'] = 1;
        } else {
            $error_messages['Error'] = 'An error occurred while confirming the account. Please try again.';
        }
    } else {
        $error_messages['Token'] = 'Invalid or expired verification token.';
    }
} else {
    $error_messages['link'] = 'Invalid verification link.';
}
?>
