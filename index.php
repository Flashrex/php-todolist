<?php
session_start();

require_once './includes/database/config.php';
require_once './includes/database/user.php';
require_once './includes/database/todo.php';

$user = new User($pdo);
$todo = new Todo($pdo);

if (!$user->isLoggedIn()) {
    header('Location: ./pages/login.php');
    exit;
}

$todos = $todo->getTodosByUserId($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="assets/css/global.css">
    <link rel="stylesheet" type="text/css" href="assets/css/index.css">
</head>

<body>
    <main>
        <div class="content">
            <ul>
                <?php foreach ($todos as $todo) : ?>
                    <li>
                        <div>
                            <input type="checkbox" id="checkbox<?= $todo['id'] ?>" name="checkbox" onchange="markAsDone(<?= $todo['id'] ?>, !this.checked)" <?= $todo['isDone'] ? 'checked' : '' ?>>
                            <label for="checkbox<?= $todo['id'] ?>"></label>
                        </div>
                        <div class="flex-column">
                            <h2><?= $todo['title'] ?></h2>
                            <p><?= $todo['description'] ?></p>
                        </div>
                        <div class="buttonContainer">
                            <button class="button_round" onclick="deleteTodo(<?= $todo['id'] ?>)">
                                <img src="./assets/images/trash.svg">
                            </button>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <a class="button" href="./pages/create_todo.php">Create Todo</a>
        </div>
    </main>

    <script>
        function markAsDone(id, status) {
            fetch(`./controller/mark_as_done.php?id=${id}&status=${status ? 0 : 1}`, {
                    method: 'POST',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to mark as done');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        function deleteTodo(id) {
            fetch(`./controller/delete_todo.php?id=${id}`, {
                    method: 'POST',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // If the server responded with success, reload the page
                        location.reload();
                    } else {
                        // If the server responded with an error, show an alert
                        alert('Failed to delete todo');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>

</html>