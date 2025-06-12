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
            if ($this->emailExists($email)) {
                return "The email address is already in use.";
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password, role, profile_picture) 
                    VALUES (:name, :email, :password, :role, :profile_picture)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            $filename = basename($imagePath); // get "default.jpg"
            $stmt->bindParam(':profile_picture', $filename);


            try {
                if ($stmt->execute()) {
                    return true;
                }
            } catch (PDOException $e) {
                return "Error: " . $e->getMessage();
            }

            return "Registration failed.";
        }

    public function emailExists($email) {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
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
