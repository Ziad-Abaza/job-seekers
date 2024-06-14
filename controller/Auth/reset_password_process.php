<?php
include('./database/config.php');
include('./controller/ErrorHandlerController.php');

$success_messages = [];
$error_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error_messages['Password'] = 'Password confirmation does not match the new password. Please try again.';
        exit;
    }

    // Validate reset token and its expiration
    $current_time = date('Y-m-d H:i:s');
    $sql_check_reset_token = "SELECT * FROM users WHERE email = '$email' AND token = '$token' AND token_expiration > '$current_time'";
    $result_check_reset_token = mysqli_query($conn, $sql_check_reset_token);

    if (mysqli_num_rows($result_check_reset_token) === 1) {
        // Change the password
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $sql_reset_password = "UPDATE users SET password = '$hashed_password', token = NULL, token_expiration = NULL WHERE email = '$email'";
        if (mysqli_query($conn, $sql_reset_password)) {
            $success_messages['Success'] = 'Password has been successfully changed!';
            header('location: login.php');
        } else {
            $error_messages['Error'] = 'An error occurred while changing the password. Please try again.';
        }
    } else {
        $error_messages['Token'] = 'Invalid or expired password reset token.';
    }
}
?>
