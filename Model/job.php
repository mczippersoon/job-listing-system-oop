<?php

class Job
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add($title, $description, $userId)
    {
        $stmt = $this->conn->prepare("INSERT INTO jobs (title, description, user_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $userId]);
    }

    public function getAll()
    {
        $stmt = $this->conn->query("SELECT * FROM jobs");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUserId($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM jobs WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM jobs WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description)
    {
        $stmt = $this->conn->prepare("UPDATE jobs SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM jobs WHERE id = ?");
        $stmt->execute([$id]);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../../Controller/JobController.php?action=add" method="POST">
    <input type="text" name="title" placeholder="Job Title" required>
    <textarea name="description" placeholder="Job Description" required></textarea>
    <input type="hidden" name="user_id" value="1"> <!-- Replace with session ID -->
    <button type="submit">Post Job</button>
    </form>

</body>
</html>