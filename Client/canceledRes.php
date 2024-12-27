<?php
require_once '../classes/Client.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_reservation'])) {
    if (isset($_POST['id_res']) && is_numeric($_POST['id_res'])) {
        $id_res = $_POST['id_res'];
        $client = new Client($_SESSION['user_id'], null, null, null);
        $client->cancelReservation($id_res);
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            Swal.fire({
                icon: "warning",
                title: "ID invalide",
                text: "ID de réservation invalide.",
                confirmButtonText: "OK"
            });
        </script>';
        exit(); 
    }
}
?>
