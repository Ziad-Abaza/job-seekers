<?php
include(__DIR__ . '/database/config.php');

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        handleRequest('GET');
        break;
    case 'POST':
        handleRequest('POST');
        break;
    default:
        echo json_encode(['error' => 'Invalid request method']);
}

function handleRequest($method) {
    $requestData = ($method === 'GET') ? $_GET : json_decode(file_get_contents("php://input"), true);

    if (!isset($requestData['action'])) {
        echo json_encode(['error' => 'No action specified']);
        return;
    }

    switch ($requestData['action']) {
        case 'fetchItems':
            if (!isset($requestData['table'])) {
                echo json_encode(['error' => 'No table specified']);
                return;
            }
            $type = isset($requestData['type']) ? $requestData['type'] : null;
            fetchItems($requestData['table'], $type);
            break;
        case 'deleteItem':
            if (!isset($requestData['id'])) {
                echo json_encode(['error' => 'No item ID specified']);
                return;
            }
            deleteItem($requestData['table'], $requestData['id']);
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
}

function fetchItems($table, $type = null) {
    global $conn;

    $sql = "SELECT * FROM $table";
    if ($type && $table === 'job_postings') {
        $sql .= " WHERE type = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $type);
    } else {
        $stmt = $conn->prepare($sql);
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        echo json_encode($items);
    } else {
        echo json_encode(['error' => 'Error fetching data']);
    }

    $stmt->close();
}

function deleteItem($table, $itemId) {
    global $conn;

    if (!$itemId) {
        echo json_encode(['error' => 'Invalid item ID']);
        return;
    }

    $sql = "DELETE FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemId);

    if ($stmt->execute()) {
        echo json_encode(['message' => ucfirst(substr($table, 0, -1)) . ' deleted successfully', 'id' => $itemId]);
    } else {
        echo json_encode(['error' => 'Error deleting ' . $table . ': ' . $conn->error]);
    }

    $stmt->close();
}

$conn->close();
?>
