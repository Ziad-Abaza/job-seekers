<?php
require 'database/config.php';
require 'Traits/ValidatorTrait.php';
require 'Traits/CrudOperationsTrait.php';
require 'Traits/HandleFileTrait.php';
require 'ErrorHandlerController.php';

class DatabaseOperations
{
    use ValidatorTrait, CrudOperationsTrait, HandleFileTrait;

    private $connection;

    public function __construct($conn)
    {
        $this->connection = $conn;
    }

    /*
    |--------------------------------------------------------------------------
    | Validate Company Form Data
    |--------------------------------------------------------------------------
    */
    public function validateCompanyFormData($data)
    {
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required',
            'category' => 'required',
            'location' => 'required',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
        ];

        // Perform validation
        return $this->validateRequestData($data, $rules);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Company Details
    |--------------------------------------------------------------------------
    */
    public function getCompanyDetails($id)
    {
        // Retrieve company details including social links
        $sql = "SELECT companies.*, social_links.name AS social_link_name, social_links.url AS social_link_url
                FROM companies 
                LEFT JOIN social_links ON companies.id = social_links.company_id
                WHERE companies.id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $companyDetails = $result->fetch_assoc();

        $socialLinks = [];
        while ($row = $result->fetch_assoc()) {
            $socialLinks[] = [
                'name' => $row['social_link_name'],
                'url' => $row['social_link_url']
            ];
        }

        $companyDetails['social_links'] = $socialLinks;

        return $companyDetails;
    }

    /*
    |--------------------------------------------------------------------------
    | Save Company
    |--------------------------------------------------------------------------
    */
    public function saveCompany($name, $description, $image, $category, $location, $email, $phone, $userId, $companyId = null)
    {
        $imagePath = $this->UploadFiles($image['tmp_name'], $image['name'], 'image');

        if ($companyId === null) {
            $query = "INSERT INTO `companies` (`name`, `description`, `image`, `category`, `location`, `email`, `phone`, `user_id`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("sssssssi", $name, $description, $imagePath, $category, $location, $email, $phone, $userId);
            $stmt->execute();

            $companyId = $stmt->insert_id;
        } else {
            $query = "UPDATE companies SET name=?, description=?, image=?, category=?, location=?, email=?, phone=?, user_id=?, updated_at=NOW() WHERE id=?";

            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("sssssssii", $name, $description, $imagePath, $category, $location, $email, $phone, $userId, $companyId);
            $stmt->execute();
        }

        if ($companyId !== null) {
            header("Location: company-detail.php?companyId=$companyId");
        } else {
            header("Location: company-detail.php");
        }
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Company
    |--------------------------------------------------------------------------
    */
    public function deleteCompany($table, $id)
    {
        // Delete company
        $sql = "DELETE FROM $table WHERE id = $id";
        return $this->executeQuery($sql);
    }


    /*
    |--------------------------------------------------------------------------
    | Get Unique Job Categories
    |--------------------------------------------------------------------------
    */
    public function getJobCategories()
    {
        $sql = "SELECT DISTINCT category FROM companies WHERE category IS NOT NULL AND category != ''";
        $result = $this->executeQuery($sql);

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row['category'];
        }

        return $categories;
    }
}

$databaseOperations = new DatabaseOperations($conn);
$error_messages = [];
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_id = isset($_POST['id']) ? $_POST['id'] : null;
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $image = $_FILES['image'];

    $data = [
        "name" => $name,
        "description" => $description,
        "image" => $image,
        "category" => $category,
        "location" => $location,
        "email" => $email,
        "phone" => $phone,
    ];

    $result = $databaseOperations->validateCompanyFormData($data);

    if (!$result) {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $databaseOperations->saveCompany($name, $description, $image, $category, $location, $email, $phone, $userId, $company_id);
    }
}

if (isset($_GET['id'])) {
    $companyId = $_GET['id'];
    $jobData = $databaseOperations->getCompanyDetails($companyId);
}

if (isset($_GET['delete'])) {
    $companyId = $_GET['delete'];
    $result = $databaseOperations->deleteCompany("companies", $companyId);

    if ($result) {
        $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'profile.php';
        header("Location: $redirect_url");
        exit;
    } else {
        $error_messages['Failed']="Failed to delete job.";
    }
}
?>
