<?php 
    class Reservation {
        private $id_res;
        private $userId;
        private $activityId;
        private $date;
        private $status;
        private $connexion;

        public function __construct($id_res, $userId, $activityId, $date, $status, $connexion){
            $this->connexion = $connexion;
            $this->id_res = $id_res;
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

            $stmt->bindParam(':status', 'Confirmée');
            $stmt->bindParam(':id_res', $id_res);
            return $stmt->execute();
        }
        public function refuseRes($id_res){
            $sql = "UPDATE reservations 
            set `status` = :status 
            WHERE id_reservation = :id_res";
            $stmt = $this->connexion->prepare($sql);

            $stmt->bindParam(':status', 'Annulée');
            $stmt->bindParam(':id_res', $id_res);
            return $stmt->execute();
        }
    }

?>