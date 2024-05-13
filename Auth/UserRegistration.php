<?php
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

        // Insert user data into the database
        $insert_user_query = "INSERT INTO `$table` (name, email, password, image,role, phone) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_user_stmt = $this->conn->prepare($insert_user_query);
        $insert_user_stmt->bind_param('ssssss', $name, $email, $hashed_password, $image, $role, $phone);
        $insert_user_result = $insert_user_stmt->execute();

        // Check if user registration was successful
        if ($insert_user_result) {
            $user_id = $insert_user_stmt->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = $role;
            return self::REGISTRATION_SUCCESS;
        } else {
            return self::INTERNAL_SERVER_ERROR;
        }
    }
}
?>
