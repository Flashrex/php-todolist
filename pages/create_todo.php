<head>
    <title>Todo App - Create Todo</title>

    <link rel="stylesheet" type="text/css" href="../assets/css/global.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/create_todo.css">
</head>

<?php

session_start();

require_once '../includes/database/config.php';
require_once '../includes/database/user.php';
require_once '../includes/database/todo.php';

$user = new User($pdo);
$todo = new Todo($pdo);

if (!$user->isLoggedIn()) {
    echo json_encode(['success' => false]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($title && $description) {
        $todo->create($_SESSION['user_id'], $title, $description);
        header('Location: ../index.php');
        exit;
    } else {
        $error = 'Title and description are required';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Todo</title>
</head>

<body>
    <main>
        <div class="content">
            <h1>Create Todo</h1>
            <form method="post">
                <div>
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title">
                </div>
                <div>
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description"></input>
                </div>
                <div class="buttonContainer">
                    <button type="submit">Create</button>
                    <button type="button" onclick="window.location.href='../index.php'">Cancel</button>
                </div>
            </form>
            <?php if (isset($error)) : ?>
                <p><?= $error ?></p>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>