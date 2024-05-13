<?php
require 'database/config.php';
require 'Traits/ValidatorTrait.php';
include("Traits/CrudOperationsTrait.php");
require 'Traits/HandleFileTrait.php';
require 'controller/ErrorHandlerController.php';

class DatabaseOperations
{
    use ValidatorTrait, CrudOperationsTrait, HandleFileTrait;

    private $connection;

    public function __construct($conn)
    {
        $this->connection = $conn;
    }

    public function getJobs($table, $relations = [], $conditions = [])
    {
        $sql = "SELECT job.*, company.location 
                FROM $table AS job";

        if (!empty($relations)) {
            foreach ($relations as $relation) {
                list($relatedTable, $relatedRecord) = explode(':', $relation);
                $sql .= " LEFT JOIN $relatedTable AS related ON job.$relatedRecord = related.$relatedRecord";
            }
        }

        $sql .= " LEFT JOIN companies AS company ON job.company_id = company.id";

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" OR ", $conditions);
        }
        return $this->executeQuery($sql);
    }

    public function findJobById($id)
    {
        $sql = "SELECT job_postings.*, 
            GROUP_CONCAT(job_requirements.title) as job_requirement_title, 
            GROUP_CONCAT(job_requirements.description) as job_requirement_description
            FROM job_postings
            LEFT JOIN job_requirements ON job_postings.id = job_requirements.job_posting_id
            WHERE job_postings.id = ?
            GROUP BY job_postings.id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function validateFormData($data)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'nullable|numeric',
            'type' => 'required|string',
            'category' => 'required',
            'image' => 'required',
            'requirement_title' => 'array',
            'requirement_description' => 'array',
        ];

        return $this->validateRequestData($data, $rules);
    }

    public function saveJob($title, $description, $salary, $type, $category, $image, $requirement_title, $requirement_description, $userId, $companyID, $id = null)
    {
        $imagePath = $this->UploadFiles($image['tmp_name'], $image['name'], 'image');

        if ($id === null) {
            $query = "INSERT INTO `job_postings`(`title`, `description`, `salary`, `status`, `type`, `category`, `image`, `user_id`, `company_id`, `created_at`, `updated_at`) 
            VALUES (?, ?, ?, '1', ?, ?, ?, ?, ?, NOW(), NOW())";

            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("ssisssii", $title, $description, $salary, $type, $category, $imagePath, $userId, $companyID);
            $stmt->execute();

            $id = $stmt->insert_id;
        } else {
            $query = "UPDATE job_postings SET 
                            title = ?,
                            description = ?,
                            salary = ?,
                            type = ?,
                            category = ?,
                            image = ?
                            WHERE id = ?";

            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("ssisssi", $title, $description, $salary, $type, $category, $imagePath, $id);
            $stmt->execute();

            $deleteRequirementsQuery = "DELETE FROM job_requirements WHERE job_posting_id = ?";
            $stmt = $this->connection->prepare($deleteRequirementsQuery);
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }

        foreach ($requirement_title as $key => $title) {
            $description = $requirement_description[$key];
            $query = "INSERT INTO job_requirements (title, description, job_posting_id, created_at, updated_at) 
                      VALUES (?, ?, ?, NOW(), NOW())";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("ssi", $title, $description, $id);
            $stmt->execute();
        }

        if ($id === null) {
            header("Location: post-job.php");
        } else {
            header("Location: job-detail.php?jobId=$id");
        }
        exit;
    }

    public function deleteJob($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = $id";
        return $this->executeQuery($sql);
    }
}

$databaseOperations = new DatabaseOperations($conn);
$error_messages = [];
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    $queryCompanyID = "SELECT id FROM companies WHERE user_id = ?";
    $stmt = $conn->prepare($queryCompanyID);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $resultCompanyID = $stmt->get_result();

    if ($resultCompanyID && $resultCompanyID->num_rows === 1) {
        $row = $resultCompanyID->fetch_assoc();
        $companyID = $row['id'];

        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $salary = mysqli_real_escape_string($conn, $_POST['salary']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $image = $_FILES['image'];

        $requirement_title = isset($_POST['requirement_title']) ? $_POST['requirement_title'] : [];
        $requirement_description = isset($_POST['requirement_description']) ? $_POST['requirement_description'] : [];

        if (is_array($requirement_title) && is_array($requirement_description)) {
            $requirement_title = array_map(function ($item) use ($conn) {
                return mysqli_real_escape_string($conn, $item);
            }, $requirement_title);

            $requirement_description = array_map(function ($item) use ($conn) {
                return mysqli_real_escape_string($conn, $item);
            }, $requirement_description);
        }

        $databaseOperations->saveJob($title, $description, $salary, $type, $category, $image, $requirement_title, $requirement_description, $userId, $companyID, $id);
    } else {
        header("Location: add-company.php");
        exit;
    }
}

if (isset($_GET['jobId'])) {
    $jobId = $_GET['jobId'];
    $jobData = $databaseOperations->findJobById($jobId);
}

if (isset($_GET['delete'])) {
    $jobId = $_GET['delete'];
    $result = $databaseOperations->deleteJob("job_postings", $jobId);

    if ($result) {
        $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'recruiter-posts.php';
        header("Location: $redirect_url");
        exit;
    } else {
        $error_messages['Failed'] = "Failed to delete job.";
    }
}

if (isset($_GET['submit'])) {
    $keyword = $_GET['keyword'];
    $category = $_GET['category'];
    $location = $_GET['location'];

    $conditions = [];
    if (!empty($keyword)) {
        $conditions[] = "job.title LIKE '%$keyword%'";
    }
    if (!empty($category)) {
        $conditions[] = "job.category = '$category'";
    }
    if (!empty($location)) {
        $conditions[] = "company.location LIKE '%$location%'";
    }

    $results = $databaseOperations->getJobs('job_postings', ['companies:id'], $conditions);
} else {
    $conditions = [];
    $results = $databaseOperations->getJobs('job_postings', ['companies:id'], $conditions);
}
