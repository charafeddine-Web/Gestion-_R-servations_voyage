<?php
class DatabaseConnection {
    private static $instance = null;
    private $connection;

    private function construct() {
        try {
            $dsn = "mysql:host=localhost;dbname=agence_de_voyage_OOP;charset=utf8mb4";
            $username = "root";
            $password = "Charaf2024";

            $this->connection = new PDO($dsn, $username, $password);

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    private function clone() {}
}

$db1 = DatabaseConnection::getInstance();
$conn1 = $db1->getConnection();

// echo $conn1;