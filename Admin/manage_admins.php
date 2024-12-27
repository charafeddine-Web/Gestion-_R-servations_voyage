<?php
require_once("../db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admin'])) {
    $name = $_POST['admin_name'];
    $email = $_POST['admin_email'];
    $password = password_hash($_POST['admin_password'], PASSWORD_BCRYPT);
    $idRole = 2;
    $pdo = DatabaseConnection::getInstance()->getConnection();
    $sql = "INSERT INTO users (name, email, password, idRole) VALUES (:name, :email, :password, :idRole)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':idRole', $idRole, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: Dashboard.php");
    } else {
        header("Location: Dashboard.php");
    }
    exit;
}
?>
