<?php

require '../database/config.php';
require '../Traits/ValidatorTrait.php';
require '../Traits/HandleFileTrait.php';

class DatabaseOperations
{
    use ValidatorTrait, HandleFileTrait;

    private $connection;

    public function __construct($conn)
    {
        $this->connection = $conn;
    }
    
    /*
    |--------------------------------------------------------------------------
    | Create Application
    |--------------------------------------------------------------------------
    */
    public function createApplication($name, $specialization, $education, $type, $cv, $location, $email, $phone, $userId, $jobPostingId)
    {
        // Upload CV file
        $filePath = $this->uploadFiles($cv['tmp_name'], $cv['name'], 'cv');

        // Check if user details exist
        $userDetailsId = $this->getUserDetailsId($userId);

        // Insert or update user details
        $this->insertOrUpdateUserDetails($userDetailsId, $specialization, $education, $filePath, $location, $userId);

        // Insert application
        $this->insertApplication($type, $userId, $jobPostingId);

        // Redirect to index page
        $this->redirectToIndex($jobPostingId);
    }

    /*
    |--------------------------------------------------------------------------
    | Private Methods
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    | Get User Details ID
    |--------------------------------------------------------------------------
    */
    private function getUserDetailsId($userId)
    {
        $query = "SELECT user_details_id FROM users WHERE id = $userId AND user_details_id IS NULL";
        $result = mysqli_query($this->connection, $query);
        return ($result && mysqli_num_rows($result) > 0) ? null : $this->getUserDetailsIdFromUsers($userId);
    }

    /*
    |--------------------------------------------------------------------------
    | Get User Details ID from Users Table
    |--------------------------------------------------------------------------
    */
    private function getUserDetailsIdFromUsers($userId)
    {
        $query = "SELECT user_details_id FROM users WHERE id = $userId";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['user_details_id'];
    }

    /*
    |--------------------------------------------------------------------------
    | Insert or Update User Details
    |--------------------------------------------------------------------------
    */
    private function insertOrUpdateUserDetails($userDetailsId, $specialization, $education, $filePath, $location, $userId)
    {
        if ($userDetailsId === null) {
            $this->insertUserDetails($specialization, $education, $filePath, $location, $userId);
        } else {
            $this->updateUserDetails($specialization, $education, $filePath, $location, $userDetailsId);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Insert User Details
    |--------------------------------------------------------------------------
    */
    private function insertUserDetails($specialization, $education, $filePath, $location, $userId)
    {
        $query = "INSERT INTO `user_details` (`specialization`, `education`, `cv`, `location`, `created_at`, `updated_at`) VALUES ('$specialization', '$education', '$filePath', '$location', NOW(), NOW())";
        mysqli_query($this->connection, $query);
        $userDetailsId = mysqli_insert_id($this->connection);
        $this->updateUserWithDetailsId($userDetailsId, $userId);
    }

    /*
    |--------------------------------------------------------------------------
    | Update User Details
    |--------------------------------------------------------------------------
    */
    private function updateUserDetails($specialization, $education, $filePath, $location, $userDetailsId)
    {
        $query = "UPDATE `user_details` SET `specialization`='$specialization', `education`='$education', `cv`='$filePath', `location`='$location', `updated_at`=NOW() WHERE `id`='$userDetailsId'";
        mysqli_query($this->connection, $query);
    }

    /*
    |--------------------------------------------------------------------------
    | Update User with Details ID
    |--------------------------------------------------------------------------
    */
    private function updateUserWithDetailsId($userDetailsId, $userId)
    {
        $query = "UPDATE users SET user_details_id = $userDetailsId WHERE id = $userId";
        mysqli_query($this->connection, $query);
    }

    /*
    |--------------------------------------------------------------------------
    | Insert Application
    |--------------------------------------------------------------------------
    */
    private function insertApplication($type, $userId, $jobPostingId)
    {
        $query = "INSERT INTO `applications` (`type`, `user_id`, `job_posting_id`, `created_at`, `updated_at`) VALUES ('$type', $userId, $jobPostingId, NOW(), NOW())";
        mysqli_query($this->connection, $query);
    }

    /*
    |--------------------------------------------------------------------------
    | Redirect to Index Page
    |--------------------------------------------------------------------------
    */
    private function redirectToIndex($jobPostingId)
    {
        header('location: ../job-detail.php?jobId='.$jobPostingId);
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $cv = $_FILES['cv'];
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $education = mysqli_real_escape_string($conn, $_POST['education']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $jobPostingId = mysqli_real_escape_string($conn, $_POST['job_posting_id']);

    $databaseOperations = new DatabaseOperations($conn);

    $databaseOperations->createApplication($name, $specialization, $education, $type, $cv, $location, $email, $phone, $user_id, $jobPostingId);
}
