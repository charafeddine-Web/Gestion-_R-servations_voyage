<?php 
require_once("User.php");
require('../db.php');

class Client extends User {
public function __construct($id = null, $name = null, $email = null, $pdo = null, $idRole = null){
    Parent::__construct($id = null, $name = null, $email = null, $pdo = null, $idRole = null);
}
    public function register() {
        try {

            if (!isset($this->idRole)) {
                $this->idRole = 3; 
            }
            $sql = "INSERT INTO users (name, email, password, id_role) VALUES (:name, :email, :password, :id_role)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':id_role', $this->idRole, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Registration Error: " . $e->getMessage();
            return false;
        }
    }

    public function addReservation($id_activity, $date_reservation, $status) {
        try {
            $pdo = DatabaseConnection::getInstance();
            $sql = "INSERT INTO reservations (id_client, id_activite, date_reservation, status) 
                    VALUES (:id_client, :id_activity, :date_reservation, :status)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id_client', $this->idUser, PDO::PARAM_INT); 
            $stmt->bindParam(':id_activity', $id_activity, PDO::PARAM_INT);
            $stmt->bindParam(':date_reservation', $date_reservation);
            $stmt->bindParam(':status', $status);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Add Reservation Error: " . $e->getMessage();
            return false;
        }
    }

    public function cancelReservation($id_res) {
        try {
            $pdo = DatabaseConnection::getInstance();
            $sql = "DELETE FROM reservations WHERE id_reservation = :id_res AND id_client = :id_client";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id_res', $id_res, PDO::PARAM_INT);
            $stmt->bindParam(':id_client', $this->id, PDO::PARAM_INT); 

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Cancel Reservation Error: " . $e->getMessage();
            return false;
        }
    }

    public function viewOffers() {
        try {
            $pdo = DatabaseConnection::getInstance(); 
            $sql = "SELECT * FROM offers"; 
            $stmt = $this->pdo->query($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "View Offers Error: " . $e->getMessage();
            return [];
        }
    }
}


$client = new Client();
$client->name = "John Doe";
$client->email = "john@example.com";
$client->password = password_hash("password123", PASSWORD_BCRYPT);

if ($client->register()) {
    echo "Client registered successfully with role ID 3!";
} else {
    echo "Client registration failed.";
}
