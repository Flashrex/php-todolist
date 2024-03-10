<?php

require_once '../includes/database/config.php';
require_once '../includes/database/user.php';

$user = new User($pdo);

if ($user->isLoggedIn()) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($user->register($username, $password)) {
        header('Location: ./login.php');
        exit;
    } else {
        $error = 'Username is already taken';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Todo App - Login</title>

    <link rel="stylesheet" type="text/css" href="../assets/css/global.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/auth.css">
</head>

<body>
    <main>
        <div class="content">
            <h1>Register</h1>
            <form method="post">
                <div>
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>
                <button type="submit">Register</button>
            </form>
            <?php if (isset($error)) : ?>
                <p><?= $error ?></p>
            <?php endif; ?>
            <p class="footerText">Already got an account? <a href=" login.php">Login</a></p>
        </div>
    </main>

</body>

</html>