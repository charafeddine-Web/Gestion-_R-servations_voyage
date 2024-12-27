<?php

require_once("./classes/User.php");
require_once __DIR__ .'/db.php';

$error_message = [];
$success_message = ""; 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
<<<<<<< HEAD
        $user = User::login($email, $password);
        if ($user) {
            $success_message = "Connexion réussie !";
        } else {
            header("location: index.php");
            $error_message[] = "Email ou mot de passe incorrect.";
            exit();
        }
    } else {
        header("location: index.php");
        $error_message[] = "Veuillez remplir tous les champs.";
=======
        User::login($email, $password);
       
    } else {
        echo "Veuillez remplir tous les champs.";
        header("Location: index.php");
>>>>>>> main
    }
    
}


