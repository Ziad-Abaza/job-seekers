<?php
/*
|--------------------------------------------------------------------------
| Redirect if User is Already Logged In
|--------------------------------------------------------------------------
*/
if (isset($_SESSION['user_id'])) {
    $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header("Location: $redirect_url");
    exit;
}

/*
|--------------------------------------------------------------------------
| Include Required Files
|--------------------------------------------------------------------------
*/
require 'Auth/UserLogin.php';
require 'Traits/ValidatorTrait.php';
require 'database/config.php';
require 'controller/ErrorHandlerController.php';

/*
|--------------------------------------------------------------------------
| Database Operations Class
|--------------------------------------------------------------------------
*/
class DatabaseOperations
{
    use ValidatorTrait;

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /*
    |--------------------------------------------------------------------------
    | Validate Form Data
    |--------------------------------------------------------------------------
    */
    public function validateFormData($data)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];

        return $this->validateRequestData($data, $rules);
    }
}

/*
|--------------------------------------------------------------------------
| Initialize Database Operations and User Login
|--------------------------------------------------------------------------
*/
$databaseOperations = new DatabaseOperations($conn);
$userLogin = new UserLogin($conn);
$error_messages = [];
$result = null;

/*
|--------------------------------------------------------------------------
| Process Login Form Submission
|--------------------------------------------------------------------------
*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';

    $data = [
        "email" => $email,
        "password" => $password
    ];

    $result = $databaseOperations->validateFormData($data);

    if (!$result) {
        $response = $userLogin->loginUser('users', $data);
        if ($response === UserLogin::LOGIN_SUCCESS) {
            header("Location: index.php");
            exit;
        } elseif ($response === UserLogin::INVALID_PASSWORD) {
            $error_messages['password'] = "Invalid password.";
        } elseif ($response === UserLogin::USER_NOT_FOUND) {
            $response = $userLogin->loginUser('admins', $data);
            if ($response === UserLogin::LOGIN_SUCCESS) {
                header("Location: index.php");
                exit;
            } elseif ($response === UserLogin::INVALID_PASSWORD) {
                $error_messages['password'] = "Invalid password.";
            } elseif ($response === UserLogin::USER_NOT_FOUND) {
                $error_messages['email'] = "User not found.";
            }
        }
    }
}
?>
