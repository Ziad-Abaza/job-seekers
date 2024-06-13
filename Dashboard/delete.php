<?php
include(__DIR__ . '/../database/config.php');

$data = json_decode(file_get_contents("php://input"), true);

$userId = isset($data['user_id']) ? $data['user_id'] : null;
$jobId = isset($data['job_id']) ? $data['job_id'] : null;
$companyId = isset($data['company_id']) ? $data['company_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($userId !== null) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            echo "User deleted successfully";
        } else {
            echo "Error deleting user: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($jobId !== null) {
        $sql = "DELETE FROM job_postings WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $jobId);

        if ($stmt->execute()) {
            echo "Job deleted successfully";
        } else {
            echo "Error deleting job: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($companyId !== null) {
        $sql = "DELETE FROM companies WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $companyId);

        if ($stmt->execute()) {
            echo "company deleted successfully";
        } else {
            echo "Error deleting company: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid ID";
    }
}

$conn->close();
?>
