<?php

/*
|--------------------------------------------------------------------------
| Redirect If User Already Logged In
|--------------------------------------------------------------------------
*/
if (isset($_SESSION['user_id'])) {
    $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header("Location: $redirect_url");
    exit;
}

include(__DIR__ . '/../database/config.php');
include(__DIR__ . '/../Traits/ValidatorTrait.php');
include(__DIR__ . '/../Traits/CrudOperationsTrait.php');
include(__DIR__ . '/../Traits/HandleFileTrait.php');
include(__DIR__ . '/../controller/ErrorHandlerController.php');
include(__DIR__ . '/../Auth/UserRegistration.php');

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
    $role = 'employee';
    $imagePath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath = $databaseOperations->saveImage($imageTmp, $_FILES['image']['name']);
    } else {
        $imagePath = "img/profile_picture.png";
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
    $result = $databaseOperations->validateFormData($data);

    /*
    |--------------------------------------------------------------------------
    | Process User Registration
    |--------------------------------------------------------------------------
    */
    if (!$result) {
        $response  = $userRegistration->registerUser('users', $data);
        switch ($response) {
            case UserRegistration::REGISTRATION_SUCCESS:
                header('location: index.php');
                exit;
                break;
            case UserRegistration::PASSWORD_MISMATCH:
                $error_messages['password'] = 'Invalid password.';
                break;
            case UserRegistration::EMAIL_ALREADY_EXISTS:
                $error_messages['email'] = 'Sorry, this email is already in use.';
                break;
            case UserRegistration::BAD_REQUEST:
                $error_messages['request'] = 'Bad request, please make sure to fill all fields correctly.';
                break;
            case UserRegistration::INTERNAL_SERVER_ERROR:
                $error_messages['Internal server error'] = 'Please try again later.';
                break;
            default:
                $error_messages[] = "Unknown error occurred";
        }
    }
}

?>
