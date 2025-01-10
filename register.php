<?php

require("./classes/User.php");
require("./classes/Client.php");
require_once __DIR__ . '/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($name) || empty($email) || empty($password)) {
            echo "Error: Missing required fields: name, email, or password.";
            return;
        }

        $hashpassword = password_hash($password, PASSWORD_BCRYPT);

        if (!$hashpassword) {
            echo "Password hashing failed.";
            return;
        }

        $client = new Client(null,$name, $email, $hashpassword);

        if ($client->register()) {
            session_start();
            $_SESSION['user_id'] = $client->getIdUser();  
            $_SESSION['role_id'] = $client->getIdRole();  
            $_SESSION['user_name'] = $client->getName(); 

            if ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2) {
                header("Location: ./Admin/Dashboard.php");
                exit();
            } else {
                header("Location: ./Client/clientAuth.php");
            }
        } else {
            echo "Échec de l'enregistrement du client.";
        }
    } else {
        echo "Error: Missing required fields.";
    }
}

