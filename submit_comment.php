<?php
session_start();
include("controller/DetailsController.php");

header('Content-Type: application/json');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    if (!isset($_SESSION['user_id'])) {
        $response['status'] = 'error';
        $response['message'] = 'User not logged in.';
        echo json_encode($response);
        exit;
    }

    $comment = $_POST['comment'];
    $userId = $_SESSION['user_id'];
    $jobId = $_POST['job_id'];

    include_once "database/config.php";

    $query = "INSERT INTO comments (user_id, job_posting_id, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        $response['status'] = 'error';
        $response['message'] = 'Prepare statement failed: ' . $conn->error;
        echo json_encode($response);
        exit;
    }

    $stmt->bind_param("iis", $userId, $jobId, $comment);

    if ($stmt->execute()) {
        $query = "SELECT name FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            $response['status'] = 'error';
            $response['message'] = 'Prepare statement failed: ' . $conn->error;
            echo json_encode($response);
            exit;
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($userName);
        $stmt->fetch();

        $response['status'] = 'success';
        $response['user_name'] = $userName;
        $response['content'] = $comment;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to submit comment: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
}

echo json_encode($response);
