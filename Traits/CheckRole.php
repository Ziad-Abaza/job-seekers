<?php
require_once 'database/config.php';

function checkPermission($userId, $requiredRole)
{
    global $conn;

    /*
    |--------------------------------------------------------------------------
    | Query to fetch user role
    |--------------------------------------------------------------------------
    */
    $query = "SELECT role FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    /*
    |--------------------------------------------------------------------------
    | Check if user has required role
    |--------------------------------------------------------------------------
    */
    if ($user && $user['role'] === $requiredRole) {
        return true;
    } else {
        return false;
    }
}

// Using
// $userId = $_SESSION['user_id']; 
// if (checkPermission($userId, 'editor')) {
//     echo "You have the required permission.";
// } else {
//     echo "You don't have the required permission.";
// }
?>
