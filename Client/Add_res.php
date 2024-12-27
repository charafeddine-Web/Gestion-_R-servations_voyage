<?php
require_once '../classes/Client.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_reservation'])) {
    if (isset($_POST['id_activite'], $_POST['nbr_places'], $_POST['date_reservation']) && is_numeric($_POST['id_activite']) && is_numeric($_POST['nbr_places'])) {
        $id_activite = $_POST['id_activite'];
        $nbr_places = $_POST['nbr_places'];
        $date_reservation = $_POST['date_reservation'];  
        $status = 'En_attente';  

        $client = new Client($_SESSION['user_id'], null, null);
        if($client->addReservation($id_activite, $date_reservation, $status, $nbr_places)){
            header("location: clientAuth.php");
            exit();
        }    
    }
}
?>
