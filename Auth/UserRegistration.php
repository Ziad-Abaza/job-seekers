<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './lib/PHPMailer/src/Exception.php';
require './lib/PHPMailer/src/PHPMailer.php';
require './lib/PHPMailer/src/SMTP.php';
require './database/config.php';
class UserRegistration
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    const REGISTRATION_SUCCESS = 200;
    const BAD_REQUEST = 400;
    const INTERNAL_SERVER_ERROR = 500;
    const EMAIL_ALREADY_EXISTS = 600;
    const PASSWORD_MISMATCH = 401;

    /*
    |--------------------------------------------------------------------------
    | Register User Function
    |--------------------------------------------------------------------------
    */
    public function registerUser($table, $request)
    {
        $name = $request['name'];
        $email = $request['email'];
        $image = $request['image'];
        $password = $request['password'];
        $confirm_password = $request['confirm_password'];
        $phone = $request['phone'];
        $role = $request['role'];

        // Check if passwords match
        if ($password !== $confirm_password) {
            return self::PASSWORD_MISMATCH;
        }

        // Check if email already exists
        $check_email_query = "SELECT * FROM `$table` WHERE email = ?";
        $check_email_stmt = $this->conn->prepare($check_email_query);
        $check_email_stmt->bind_param('s', $email);
        $check_email_stmt->execute();
        $check_email_result = $check_email_stmt->get_result();

        if ($check_email_result->num_rows > 0) {
            return self::EMAIL_ALREADY_EXISTS;
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32)); 
        $token_expiration = date('Y-m-d H:i:s', strtotime('+1 hour')); 

        // Insert user data into the database
        $insert_user_query = "INSERT INTO `$table` (name, email, password, image,role, phone, token, token_expiration) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_user_stmt = $this->conn->prepare($insert_user_query);
        $insert_user_stmt->bind_param('ssssssss', $name, $email, $hashed_password, $image, $role, $phone, $token, $token_expiration);
        $insert_user_result = $insert_user_stmt->execute();

        // Check if user registration was successful
        if ($insert_user_result) {
            $user_id = $insert_user_stmt->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = $role;
            $_SESSION['user_status'] = 0;

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'IT.club.BATU@gmail.com'; 
                $mail->Password = 'acthvgcxuwuduxbp'; 
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';

                // عنوان المرسل
                $mail->setFrom('IT.club.BATU@gmail.com', 'EgyTech Team');

                // عنوان المستلم
                $mail->addAddress($email, $name);

                // Message content
                $mail->isHTML(true);
                $mail->Subject = 'Account Activation';
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
                                        <p>To activate your account, please click on the button below:</p>
                                        <a href="http://127.0.0.1/project/php%20for%20college/web%20project%20php%20-%20email/verify.php?email=' . urlencode($email) . '&token=' . urlencode($token) . '" class="btn-sender">Activate Account</a>
                                        <p>If you did not request this activation, please ignore this email.</p>
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
                    $_SESSION['reg_message'] = "Account successfully created. Please check your email to activate your account.";
                    return self::REGISTRATION_SUCCESS;
            } catch (Exception $e) {
                // An error occurred while sending the email
                $_SESSION['reg_message'] = 'An error occurred while sending the email: ' . $mail->ErrorInfo;
            }
        } else {
            return self::INTERNAL_SERVER_ERROR;
        }
    }
}
?>
