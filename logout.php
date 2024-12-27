<?php
include_once('../classes/User.php');
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    error_log("Logout triggered");
    User::logout();
}

?>