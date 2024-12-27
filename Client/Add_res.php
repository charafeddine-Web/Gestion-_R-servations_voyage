<?php
require_once '../classes/Client.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_reservation'])) {
    if (isset($_POST['id_activite'], $_POST['nbr_places'], $_POST['date_reservation']) && is_numeric($_POST['id_activite']) && is_numeric($_POST['nbr_places'])) {
        $id_activite = $_POST['id_activite'];
        $nbr_places = $_POST['nbr_places'];
        $date_reservation = $_POST['date_reservation'];  
        $status = 'En_attente';  

<<<<<<< HEAD
        $client = new Client($_SESSION['user_id'], null, null);
        if($client->addReservation($id_activite, $date_reservation, $status, $nbr_places)){
            header("location: clientAuth.php");
            exit();
        }    
=======
        $client = new Client($_SESSION['user_id'], null, null, null);
        if ($client->addReservation($id_activite, $date_reservation, $status, $nbr_places)) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Succès",
                    text: "Réservation ajoutée avec succès.",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "./clientAuth.php";  
                });
            </script>';
            exit();
        } else {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Erreur",
                    text: "Échec de l\'ajout de la réservation.",
                    confirmButtonText: "Réessayer"
                }).then(() => {
                    window.location.href = "./clientAuth.php";  // Redirect after failure
                });
            </script>';
            exit();
        }
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            Swal.fire({
                icon: "warning",
                title: "Paramètres manquants",
                text: "Veuillez vérifier les champs obligatoires.",
                confirmButtonText: "OK"
            });
        </script>';
        exit();
>>>>>>> main
    }
}
?>
