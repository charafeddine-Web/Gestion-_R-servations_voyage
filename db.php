<?php
class DatabaseConnection {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new mysqli("localhost", "root", "Charaf2024", "agence_de_voyage");
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

    private function __clone() {}
}

$db1 = DatabaseConnection::getInstance();
$conn1 = $db1->getConnection();

