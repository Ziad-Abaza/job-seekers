<?php

include("./database/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {

    $content = $_POST['comment'];
    $jobPostingId = $_POST['job_id']; 
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    $sql = "INSERT INTO comments (content, job_posting_id, user_id) VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sii", $content, $jobPostingId, $userId);
        
        if ($stmt->execute()) {

            $response = array(
                'status' => 'success',
                'message' => 'Comment added successfully.'
            );
            echo json_encode($response);
        } else {

            $response = array(
                'status' => 'error',
                'message' => 'Failed to add comment.'
            );
            echo json_encode($response);
        }
    } else {

        $response = array(
            'status' => 'error',
            'message' => 'Failed to prepare statement.'
        );
        echo json_encode($response);
    }

    $stmt->close();
}

$conn->close();
?>
