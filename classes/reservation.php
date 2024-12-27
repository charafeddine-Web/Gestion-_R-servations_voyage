<?php 

    require_once("../db.php");
    class Reservation {
        private $id_res;
        private $userId;
        private $activityId;
        private $date;
        private $status;
        private $connexion;

        public function __construct($userId, $activityId, $date, $status){
            $this->connexion = DatabaseConnection::getInstance()->getConnection();
            $this->userId = $userId;
            $this->activityId = $activityId; 
            $this->date = $date;
            $this->status = $status;
        }
        public function acceptRes($id_res){
            $sql = "UPDATE reservations 
            set `status` = :status 
            WHERE id_reservation = :id_res";
            $stmt = $this->connexion->prepare($sql);
            $c = 'Confirmée';
            $stmt->bindParam(':status', $c);
            $stmt->bindParam(':id_res', $id_res);
            return $stmt->execute();
        }
        public function refuseRes($id_res){
            $sql = "UPDATE reservations 
            set `status` = :status 
            WHERE id_reservation = :id_res";
            $stmt = $this->connexion->prepare($sql);
            $a ='Annulée';
            $stmt->bindParam(':status', $a);
            $stmt->bindParam(':id_res', $id_res);
            return $stmt->execute();
        }
        public function showRes() {
            $sql = "SELECT r.id_reservation , u.name as name_client, a.name as name_activite, r.date_reservation, r.nbr_places, r.status  
            FROM reservations as r inner join users as u on r.id_client=u.id_client 
            inner join activites as a on r.id_activite = a.id_activite";
            $stmt = $this->connexion->prepare($sql);
            $stmt->execute();
            
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $reservations;
        }
    }

?>