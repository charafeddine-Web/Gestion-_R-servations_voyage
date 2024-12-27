<?php
require_once("../classes/activity.php");
require_once("../db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $db = DatabaseConnection::getInstance()->getConnection();

    if (isset($_POST['add_activity'])) {
        $name = $_POST['activite_name'];
        $description = $_POST['activite_description'];
        $destination = $_POST['activite_destination'];
        $price = $_POST['activite_price'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $activity = new Activity($name, $description, $price, $destination, $start_date, $end_date);
        if ($activity->createActivity()) {
            header("Location: ./Dashboard.php");
        } else {
            header("Location: ./Dashboard.php");
        }
    }

    if (isset($_POST['edit_activity'])) {
        $id_act = $_POST['id_act'];
        $name = $_POST['menu_name'];
        $description = $_POST['activite_description'];
        $destination = $_POST['activite_destination'];
        $price = $_POST['activite_price'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
    
        $activity = new Activity(null, null, null, null, null, null);
        if ($activity->editActivity($id_act, $name, $description, $price, $destination, $start_date, $end_date)) {
            header("Location: ./Dashboard.php");
        } else {
            header("Location: ./Dashboard.php");
        }
    }
    

    if (isset($_POST['delete_activity'])) {
        $id_act = $_POST['delete_activity'];

        $activity = new Activity();
        if ($activity->deleteActivity($id_act)) {
            header("Location: ./Dashboard.php");
        } else {
            header("Location: ./Dashboard.php");
        }
    }
}


?>