<?php
include_once __DIR__ .'./classes/User.php';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    error_log("Logout triggered");
    User::logout();
}

?>