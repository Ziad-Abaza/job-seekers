<?php
include(__DIR__ . '/../database/config.php');

// Function to fetch user data
function fetchUsers($conn) {
    $sql = "SELECT id, name, email, role, status, phone, image, created_at FROM users";
    $result = $conn->query($sql);

    $users = [];
    if ($result->num_rows > 0) {
        // Fetch data for each row
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

// Delete user if POST request is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $userId = $data['user_id'];

    if ($userId) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            echo "User deleted successfully";
        } else {
            echo "Error deleting user: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Invalid user ID";
    }
    exit;
}

$users = fetchUsers($conn);
$conn->close();
?>

<div class="container mt-5">
    <div class="row" id="user-list">
        <?php if (!empty($users)) { ?>
            <?php foreach ($users as $user) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img class="img-fluid border rounded-circle" src="<?php echo $user['image']; ?>" alt="" style="width: 50px; height: 50px;">
                                <div class="ms-3">
                                    <h5 class="card-title mb-1">
                                        <i class="fas fa-user text-primary"></i> <?php echo $user['name']; ?>
                                    </h5>
                                    <p class="card-text mb-0">
                                        <i class="fas fa-envelope text-primary"></i> <?php echo $user['email']; ?>
                                    </p>
                                    <p class="card-text mb-0">
                                        <i class="fas fa-briefcase text-primary"></i> <?php echo ucfirst($user['role']); ?>
                                    </p>
                                    <p class="card-text mb-0">
                                        <i class="fas fa-phone text-primary"></i> <?php echo $user['phone']; ?>
                                    </p>
                                    <p class="card-text mb-0">
                                        <i class="fas fa-toggle-<?php echo $user['status'] ? 'on' : 'off'; ?> text-primary"></i> <?php echo $user['status'] ? 'Active' : 'Inactive'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="far fa-calendar-alt text-primary me-2"></i><?php echo $user['created_at']; ?>
                            </small>
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php } else { ?>
            <p>No Users Found!</p>
        <?php } ?>
    </div>
</div>
