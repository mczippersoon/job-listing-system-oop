<?php
class Dbconnection {
    private $host = "localhost";
    private $db_name = "job-listing-system";
    private $username = "root";
    private $password = "09110261041";
    protected $conn;

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>


