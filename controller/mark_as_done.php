<?php

session_start();

require_once '../includes/database/config.php';
require_once '../includes/database/user.php';
require_once '../includes/database/todo.php';

header('Content-Type: application/json');

$user = new User($pdo);
$todo = new Todo($pdo);

if (!$user->isLoggedIn()) {
    echo json_encode(['success' => false]);
    exit;
}

try {
    $id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) : null;
    $status = isset($_GET['status']) ? filter_var($_GET['status'], FILTER_SANITIZE_NUMBER_INT) : null;

    if ($id === null || $status === null) {
        echo json_encode(['success' => false]);
        exit;
    }

    $todo->updateStatus($id, $status);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
