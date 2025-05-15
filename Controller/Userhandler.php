<?php
require_once 'Database/Dbconnection.php';

class Userhandler {
    private $conn;

    public function __construct() {
        $db = new DbConnection();
        $this->conn = $db->getConnection(); // ✅ PDO object
    }

    public function searchByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($username, $email, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, role) 
                                      VALUES (:username, :email, :password, :role)");
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':role' => $role
        ]);
    }

    public function updateUser($id, $username, $email, $role) {
        $stmt = $this->conn->prepare("UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id");
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':role' => $role,
            ':id' => $id
        ]);
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}


