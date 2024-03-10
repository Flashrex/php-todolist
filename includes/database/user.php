<?php

class User
{
    private $pdo; // database connection

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function register($username, $password)
    {
        if (empty($username) || empty($password)) {
            return false;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('INSERT INTO users (name, password) VALUES (?, ?)');
        $success = $stmt->execute([$username, $hash]);

        return $success ? true : false;
    }

    public function login($username, $password)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE name = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
}
