<?php

/*
|--------------------------------------------------------------------------
| Redirect If User Already Logged In
|--------------------------------------------------------------------------
*/
require 'controller/ErrorHandlerController.php';
if (isset($_SESSION['user_id'])) {
    $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header("Location: $redirect_url");
    exit;
}

require 'database/config.php';
require 'Auth/UserRegistration.php';
require 'Traits/ValidatorTrait.php';
require 'Traits/HandleFileTrait.php';

class DatabaseOperations
{
    use ValidatorTrait, HandleFileTrait;

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /*
    |--------------------------------------------------------------------------
    | Validate Form Data
    |--------------------------------------------------------------------------
    */
    public function validateFormData($data)
    {
        $rules = [
            'name' => 'required|string|max:45',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:11|min:11',
        ];

        return $this->validateRequestData($data, $rules);
    }

    /*
    |--------------------------------------------------------------------------
    | Save Image
    |--------------------------------------------------------------------------
    */
    public function saveImage($file, $name = null)
    {
        return $this->UploadFiles($file, $name, 'image');
    }
}

$databaseOperations = new DatabaseOperations($conn);
$userRegistration = new UserRegistration($conn);
$error_messages = [];
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $role = 'recruiter';

    $imagePath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath = $databaseOperations->saveImage($imageTmp, $_FILES['image']['name']);
    } else {
        $imagePath = "img/profile_picture.pngZ";
    }
    $data = [
        "name" => $name,
        "email" => $email,
        "image" => $imagePath,
        "password" => $password,
        "confirm_password" => $confirm_password,
        "role" => $role,
        "phone" => $phone
    ];

    /*
    |--------------------------------------------------------------------------
    | Process User Registration
    |--------------------------------------------------------------------------
    */
    $result = $databaseOperations->validateFormData($data);
    if (!$result) {
        $response  = $userRegistration->registerUser('users', $data);
        if ($response == 200) {
            header("Location: add-company.php");
            exit;
        }
    }
}
?>
