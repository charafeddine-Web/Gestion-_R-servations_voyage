<?php
session_start();
include("../classes/reservation.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reservation_id'], $_POST['action'])) {
        $reservation_id = intval($_POST['reservation_id']);
        $action = $_POST['action'];
        $pdo = DatabaseConnection::getInstance()->getConnection();

        $res = new Reservation(null, null, null, null, $pdo);
        if ($action === 'accept') {
            $res->acceptRes($reservation_id);
        } elseif ($action === 'refuse') {
            $res->refuseRes($reservation_id);
        }

    }
}

header("Location: ./Dashboard.php");
exit;
