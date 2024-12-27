<?php 
require_once("User.php");
require_once __DIR__.'/../db.php';


class Client extends User {
    public function __construct($name, $email, $password) {
        parent::__construct(null, $name, $email, $password, 3);
    }

    public function register() {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            if ($pdo === null) {
                echo "Error: Could not establish database connection.";
                return false;
            }

            $sql = "INSERT INTO users (name, email, password, idRole) VALUES (:name, :email, :password, :idRole)";
            $stmt = $pdo->prepare($sql);

            // Debug values
            if (!$this->name || !$this->email || !$this->password) {
                throw new Exception("Missing required fields: name, email, or password.");
            }

            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':idRole', $this->idRole, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $this->idUser = $pdo->lastInsertId(); 
                return true;
            }

            $errorInfo = $stmt->errorInfo();
            throw new Exception("SQL Execution Failed: " . $errorInfo[2]);

        } catch (PDOException $e) {
            echo "Registration Error: " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function addReservation($id_activity, $date_reservation, $status,$nbr_places) {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            if (!$pdo) {
                echo 'Database connection failed.';
                return false;
            }
    
            $sql = "INSERT INTO reservations (id_client, id_activite, date_reservation, status,nbr_places) 
                    VALUES (:id_client, :id_activity, :date_reservation, :status,:nbr_places)";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(':id_client', $this->idUser, PDO::PARAM_INT); 
            $stmt->bindParam(':id_activity', $id_activity, PDO::PARAM_INT);
            $stmt->bindParam(':date_reservation', $date_reservation);
            $stmt->bindParam(':nbr_places', $nbr_places);
            $stmt->bindParam(':status', $status);
    
            if ($stmt->execute()) {
                return true;
            } else {
                echo 'Failed to execute query.';
                return false;
            }
        } catch (PDOException $e) {
            echo "Add Reservation Error: " . $e->getMessage();
            return false;
        }
    }
    
    
    public function cancelReservation($id_res) {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "DELETE FROM reservations WHERE id_reservation = :id_res AND id_client = :id_client";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_res', $id_res, PDO::PARAM_INT);
            $stmt->bindParam(':id_client', $this->idUser, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                header(header: "location: ../Client/clientAuth.php");
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Cancel Reservation Error: " . $e->getMessage();
            return false;
        }
    }
    
    
    
    public function viewOffers() {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT * FROM activites"; 
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "View Offers Error: " . $e->getMessage();
            return [];  
        }
    }
    
}

//pour test

// $client = new Client();
// $client->setName("charafeddinttbibzat") ;
// $client->setEmail("charafeddinetbibzat@gmail.com");
// $client->setPassword(password_hash("12341234", PASSWORD_BCRYPT)); 

// if ($client->register()) {
//     echo "Client registered successfully with role ID 3!";
// } else {
//     echo "Client registration failed.";
//     echo "<br>";
//     echo "<br>";
//     echo "<br>";

// }
