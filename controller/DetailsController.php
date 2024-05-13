<?php
include("database/config.php");
include("Traits/CrudOperationsTrait.php");
require 'controller/ErrorHandlerController.php';


class DatabaseOperations
{
    use CrudOperationsTrait;

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /*
    |--------------------------------------------------------------------------
    | Find Job by ID
    |--------------------------------------------------------------------------
    */
    public function findJobById($id)
    {
        $sql = "SELECT job_postings.*, 
        companies.name as company_name, companies.id as company_id, companies.location as company_location, companies.image as company_image, companies.category as company_category, companies.description as company_description,
        users.name as recruiter_name, 
        job_requirements.title as job_requirement_title, job_requirements.description as job_requirement_description
        FROM job_postings
        JOIN companies ON job_postings.company_id = companies.id
        JOIN users ON job_postings.user_id = users.id
        LEFT JOIN job_requirements ON job_postings.id = job_requirements.job_posting_id
        WHERE job_postings.id = $id";

        return $this->executeQuery($sql);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Comments by Job ID
    |--------------------------------------------------------------------------
    */
    public function getCommentsByJobId($jobId)
    {
        $sql = "SELECT comments.*, users.name AS user_name 
                FROM comments 
                INNER JOIN users ON comments.user_id = users.id 
                WHERE job_posting_id = $jobId AND comments.status = 1 
                ORDER BY comments.created_at DESC";
        return $this->executeQuery($sql);
    }

    /*
    |--------------------------------------------------------------------------
    | User Application
    |--------------------------------------------------------------------------
    */
    public function userApplication($user_id)
    {
        $sql = "SELECT users.*, user_details.*
                FROM users
                LEFT JOIN user_details ON users.user_details_id = user_details.id
                WHERE users.id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /*
    |--------------------------------------------------------------------------
    | Get Applications for a Job Posting
    |--------------------------------------------------------------------------
    */
    public function getApplications($post_id)
    {
        $sql = "SELECT applications.*, users.name, users.email, users.phone, user_details.*
        FROM applications
        INNER JOIN users ON applications.user_id = users.id
        LEFT JOIN user_details ON users.user_details_id = user_details.id
        WHERE applications.job_posting_id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $applications = array();
        while ($row = $result->fetch_assoc()) {
            $applications[] = $row;
        }
        return $applications;
    }

    /*
    |--------------------------------------------------------------------------
    | Add Comment to a Job Posting
    |--------------------------------------------------------------------------
    */
    public function addComment($content, $jobPostingId, $userId)
    {
        $sql = "INSERT INTO comments (content, job_posting_id, user_id) VALUES ('$content', $jobPostingId, $userId)";
        return $this->executeQuery($sql);
    }

    /*
    |--------------------------------------------------------------------------
    | Find Company by ID
    |--------------------------------------------------------------------------
    */
    public function findCompanyById($id)
    {
        $sql = "SELECT companies.*, 
        GROUP_CONCAT(DISTINCT social_links.name) as social_name,
        GROUP_CONCAT(DISTINCT social_links.url SEPARATOR '<br>') as social_link,
        GROUP_CONCAT(DISTINCT job_postings.title SEPARATOR '<br>') as job_titles,
        GROUP_CONCAT(DISTINCT job_postings.id SEPARATOR '<br>') as job_ids,
        users.name as owner_name, users.image as owner_image, users.email as owner_email
        FROM companies
        LEFT JOIN social_links ON companies.id = social_links.company_id
        LEFT JOIN job_postings ON companies.id = job_postings.company_id
        JOIN users ON companies.user_id = users.id
        WHERE companies.id = $id
        GROUP BY companies.id";


        return $this->executeQuery($sql);
    }
}

$databaseOperations = new DatabaseOperations($conn);

if (isset($_GET['companyId'])) {
    $companyId = $_GET['companyId'];
    $companyData = $databaseOperations->findCompanyById($companyId);

    if (!$companyData) {
        header('location: index.php');
        exit;
    }
}

$jobData = null; 

if (isset($_GET['jobId'])) {
    $jobId = $_GET['jobId'];
    $jobData = $databaseOperations->findJobById($jobId);
    $comments = $databaseOperations->getCommentsByJobId($jobId);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
        $content = $_POST['comment'];
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $result = $databaseOperations->addComment($content, $jobId, $userId);
        if ($result) {
            header("Refresh:0") ? header("Refresh:0") : header("Refresh:0");
            exit;
        }
    }
}

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
}

if (isset($userId)) {
    $user_details = $databaseOperations->userApplication($userId);
}

if ($jobData !== null) {
    $jobDataArray = $jobData->fetch_assoc();
    if (empty($jobDataArray)) {
        header("Refresh:0") ? header("Refresh:0") : header("location: index.php");
        exit;
    }

    if (isset($userId) && $userId == $jobDataArray['user_id']) {
        $applications = $databaseOperations->getApplications($jobId);
    }
}
?>
