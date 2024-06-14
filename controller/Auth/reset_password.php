<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('./database/config.php');
include('./lib/PHPMailer/src/Exception.php');
include('./lib/PHPMailer/src/PHPMailer.php');
include('./lib/PHPMailer/src/SMTP.php');
include('./Traits/HandleFileTrait.php');
include('./controller/ErrorHandlerController.php');

$success_messages = [];
$error_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if the user account exists with the provided email
    $sql_check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) === 1) {
        // Generate a random token for password reset
        $reset_token = bin2hex(random_bytes(32));
        $reset_token_expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $user = mysqli_fetch_assoc($result_check_email);
        $name = $user['name'];
        // Save the password reset token in the database
        $sql_save_reset_token = "UPDATE users SET token = '$reset_token', token_expiration = '$reset_token_expiration' WHERE email = '$email'";
        if (mysqli_query($conn, $sql_save_reset_token)) {
            $mail = new PHPMailer(true);

            try {
                // إعدادات البريد الإلكتروني الصادر
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'IT.club.BATU@gmail.com'; 
                $mail->Password = 'acthvgcxuwuduxbp'; 
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';

                $mail->setFrom('IT.club.BATU@gmail.com', 'EgyTech Team');

                $mail->addAddress($email, $name);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset';
                $mail->Body = '
                    <html>
                    <head>
                        <link rel="stylesheet" href="css/style.css">
                    </head>                    
                    <body>
                        <div class="email-sender">
                            <div class="email-header">
                                <h2>EgyTech Team</h2>
                            </div>
                            <div class="email-send-body">
                                <p>Hello ' . $name . ',</p>
                                <p>We received a request to reset your password. Please click the button below to reset your password:</p>
                                <a href="http://127.0.0.1/project/php%20for%20college/web%20project%20php%20-%20email/reset-password.php?email=' . urlencode($email) . '&token=' . urlencode($reset_token) . '" class="btn-sender">Reset Password</a>
                                <p>If you did not request a password reset, please ignore this email.</p>
                                <p>Thank you,<br>The EgyTech Team</p>
                            </div>
                            <div class="email-send-footer">
                                <p>&copy; ' . date('Y') . ' EgyTech. All rights reserved.</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ';

                $mail->send();

                $success_messages['Success'] = 'A password reset link has been sent to your email.';
            } catch (Exception $e) {
                $error_messages['Error'] = 'An error occurred while sending the password reset email. Please try again.';
            }
        } else {
            $error_messages['request'] = 'An error occurred while requesting a password reset. Please try again.';
        }
    } else {
        $error_messages['email'] = 'No user account associated with this email.';
    }
}
?>
