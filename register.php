<?php

require("./classes/User.php");
require("./classes/Client.php");

require_once __DIR__ . '/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $user = new Client($name, $email, $password);

    if ($user->register()) {
        session_start();
        $_SESSION['user_id'] = $user->getIdUser();  
        $_SESSION['role_id'] = $user->getIdRole();  
        $_SESSION['user_name'] = $user->getName(); 

        if ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2) {
            header("Location: ./Admin/Dashboard.php");
            exit();
        } else {
            header("Location: ./Client/clientAuth.php");
            exit();
        }
    } else {
        echo "Échec de l'enregistrement du client.";
    }
}
