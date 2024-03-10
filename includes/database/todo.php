<?php

class Todo
{
    private $pdo; // database connection

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getTodosByUserId($userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM todos WHERE created_by = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function create($userid, $title, $description)
    {
        $stmt = $this->pdo->prepare('INSERT INTO todos (created_by, title, description) VALUES (?, ?, ?)');
        $stmt->execute([$userid, $title, $description]);
    }

    public function update($id, $title, $description)
    {
        $stmt = $this->pdo->prepare('UPDATE todos SET title = ?, description = ? WHERE id = ?');
        $stmt->execute([$title, $description, $id]);
    }

    public function updateStatus($id, $isDone)
    {
        $stmt = $this->pdo->prepare('UPDATE todos SET isDone = ? WHERE id = ?');
        $stmt->execute([$isDone, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM todos WHERE id = ?');
        $stmt->execute([$id]);
    }
}
