<?php 
    class Activity {
        private $id_act;
        private $name;
        private $description;
        private $price;
        private $destination;
        private $start_date;
        private $end_date;
        private $nbr_places;
    
        private $connexion;
    
        public function __construct($connexion, $name = null, $description = null, $price = null, $destination = null, $start_date = null, $end_date = null, $nbr_places = null) {
            $this->connexion = $connexion;
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->destination = $destination;
            $this->start_date = $start_date;
            $this->end_date = $end_date;
            $this->nbr_places = $nbr_places;
        }
    
        public function createActivity() {
            $sql = "INSERT INTO  activites (`name`, `description`, `destination`, `price`, `start_date`, `end_date`, `nbr_places`) 
                    VALUES(:name, :description, :destination, :price, :start_date, :end_date, :nbr_places)";
            $stmt = $this->connexion->prepare($sql);
    
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':destination', $this->destination);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':start_date', $this->start_date);
            $stmt->bindParam(':end_date', $this->end_date);
            $stmt->bindParam(':nbr_places', $this->nbr_places);
    
            return $stmt->execute();
        }
    

    public function editActivity($id_act, $name, $description, $price, $destination, $start_date, $end_date, $nbr_places) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->destination = $destination;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->nbr_places = $nbr_places;
        
        $sql = "UPDATE activites 
                SET `name` = :name, `description` = :description, `destination` = :destination, 
                    `price` = :price, `start_date` = :start_date, `end_date` = :end_date, `nbr_places` = :nbr_places
                WHERE id_activite = :id_act";
        $stmt = $this->connexion->prepare($sql);


        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':destination', $this->destination);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);
        $stmt->bindParam(':nbr_places', $this->nbr_places);
        $stmt->bindParam(':id_act', $id_act);

        return $stmt->execute();
    }

    public function deleteActivity($id_act) {
        $sql = "DELETE FROM activites WHERE id_activite = :id_act";
        $stmt = $this->connexion->prepare($sql);

        $stmt->bindParam(':id_act', $id_act);

        return $stmt->execute();
    }
}
?>