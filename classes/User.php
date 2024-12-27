<?php 
require_once __DIR__ . '/../db.php';   

    abstract class User {
        protected $idUser;
        protected $name;
        protected $email;
        protected $password;
        protected $idRole;


        public function __construct($idUser,$name, $email, $password,$idRole){
            $this->idUser = $idUser ;
            $this->name = $name; 
            $this->email = $email;
            $this->password = $password;
            $this->idRole = $idRole ;
            
        }
       
    
        public function getIdUser() {
            return $this->idUser;
        }
        public function getIdRole() {
            return $this->idRole;
        }
    
    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

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
<<<<<<< HEAD
            echo "<script>Swal.fire('Erreur!', 'Erreur de connexion à la base de données.', 'error');</script>";
=======
            echo "Erreur de connexion à la base de données.";
>>>>>>> main
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
    
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id_client'];
                $_SESSION['role_id'] = $user['idRole'];
                $_SESSION['user_name'] = $user['name'];
<<<<<<< HEAD
                if ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2) {
                    header("Location: ./Admin/Dashboard.php");
                    exit();
                } elseif ($_SESSION['role_id'] == 3) {
                    header("Location: ./Client/clientAuth.php");
                    exit();
                } else {
                    header("Location: ./index.php");
                    exit();
                }
            } else {
                echo "  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "
                 <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                        Swal.fire('Erreur!', 'Mot de passe incorrect.', 'error');
                      </script>";
            }
        } else {
            echo "  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

            echo "
             <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                    Swal.fire('Erreur!', 'Utilisateur introuvable avec cet email.', 'error');
                  </script>";
=======
    
                if ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2) {
                    header("Location: ./Admin/Dashboard.php");
                } else {
                    header("Location: ./Client/clientAuth.php");
                }
            } else {
                echo "<script>alert('Mot de passe incorrect. Veuillez réessayer.');</script>";
                header("Refresh: 0; URL=login.php");
            }
        } else {
            echo "<script>alert('Adresse e-mail introuvable. Veuillez vérifier vos informations.');</script>";
            header("Refresh: 0; URL=login.php");
>>>>>>> main
        }
    }
    
    
    public static function logout() {
        session_start();
    
        if (isset($_SESSION['user_id'])) {
            session_unset();
            session_destroy();
            header("Location: ./index.php");  
            exit();
        }
    }
    
    }
