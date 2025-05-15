<?php
require_once 'Database/Dbconnection.php';

class User {
    public $conn;
    public $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $email, $password, $role, $imagePath)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, role, profile_picture) VALUES (:name, :email, :password, :role, :profile_picture)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':profile_picture', $imagePath);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Error: " . implode(", ", $stmt->errorInfo());
        }
    }


    public function login($email, $password) {
        $sql = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user'] = [
                'name' => $user['name'],
                'profile_picture' => $user['profile_picture']
            ];
            return true;
        }

        return false;
    }

    public function logout() {
        session_start();
        session_destroy();
    }
}
?>
