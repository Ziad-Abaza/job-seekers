<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require './database/config.php';

class UserLogin
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    const LOGIN_SUCCESS = 200;
    const INVALID_PASSWORD = 401;
    const USER_NOT_FOUND = 404;

    /*
    |--------------------------------------------------------------------------
    | Login User Function
    |--------------------------------------------------------------------------
    */
    public function loginUser($table, $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        // Check if user exists
        $check_user_query = "SELECT * FROM `$table` WHERE email = ?";
        $check_user_stmt = $this->conn->prepare($check_user_query);
        $check_user_stmt->bind_param('s', $email);
        $check_user_stmt->execute();
        $check_user_result = $check_user_stmt->get_result();

        // Check if user exists and password is correct
        if ($check_user_result->num_rows == 1) {
            $user = $check_user_result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                return self::LOGIN_SUCCESS;
            } else {
                return self::INVALID_PASSWORD;
            }
        } else {
            return self::USER_NOT_FOUND;
        }
    }
}
?>
