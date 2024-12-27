<?php

require("./classes/User.php");
require("./classes/Client.php");

require_once __DIR__ . '/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit']) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $user = new Client($name, $email);

    if ($user->register()) {
        session_start();
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['role_id'] = $user['id_role'];
        $_SESSION['user_name'] = $user['name'];

        if ($user['id_role'] == 1) {
            header("Location: ./Admin/Dashboard.php");
            exit();
        } 
        elseif ($user['id_role'] == 3) {
            header("Location: ./Client/clientAuth.php");
            exit();
        } else {
            header("Location: clientAuth.php");
            exit();
        }
        
    }      
   else {
        echo "Échec de l'enregistrement du client.";
    }
 }
?>