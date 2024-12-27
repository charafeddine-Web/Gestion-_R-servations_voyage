<?php 
require_once __DIR__ . '/../db.php';

    abstract class User {
        protected $idUser;
        protected $name;
        protected $email;
        protected $password;
        protected $idRole;

        public function __construct($name, $email, $idRole){
            $this->name = $name; 
            $this->email = $email;
            $this->idRole = $idRole ;
            
        }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
    // public function getRole() {
    //     return $this->idRole;
    // }
    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }
    public static function login($email, $password) {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        if (!$pdo) {
            echo "Erreur de connexion.";
            return null;
        }
        
        $query = "SELECT u.id_client, u.name, u.password, r.idRole 
                  FROM users u 
                  INNER JOIN roles r ON u.idRole = r.idRole 
                  WHERE u.email = :email";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        print_r($user);

            if (password_verify($password,$user['password'],)) {

                session_start();
                $_SESSION['user_id'] = $user['id_client'];
                $_SESSION['role_id'] = $user['idRole'];
                $_SESSION['user_name'] = $user['name'];
                if($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2){
                    header("Location: ../Admin/Dashboard.php");
                }
                else {
                    header("Location: ./Client/clientAuth.php");
                }
            } else {
                echo "Mot de passe incorrect. ";
            }
        } else {
            echo "Email non trouvé dans la base de données.";
            return null;
        }
    }
        public static function logout(){
            session_start();

            if(isset($_SESSION['user_id'])){
                session_unset();
                session_destroy();
                header("Location: ../index.php");  
                exit;  
            } 
            // else {
            //     header("Location: ../index.php");
            //     exit;
            // }
        }
    }
    ?>
