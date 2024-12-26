<?php 
    require_once("db.php");

    abstract class User {
        protected $idUser;
        protected $name;
        protected $email;
        protected $password;
        protected $idRole;

        public function __construct($id, $name, $email, $idRole){
            $this->idUser = $id;
            $this->name = $name; 
            $this->email = $email;
            $this->idRole = $idRole ;
            
        }
        public static function login($email, $password) {
            $pdo = DatabaseConnection::getInstance()->getConnection();

            $query = "SELECT u.id_user, u.name, u.password, r.id_role 
                      FROM users u 
                      INNER JOIN roles r ON u.role_id = r.id_role 
                      WHERE u.email = :email";
    
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
    
            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if (password_verify($password, $user['password'])) {
    
                    session_start();
                    $_SESSION['user_id'] = $user['id_user'];
                    $_SESSION['role_id'] = $user['id_role'];
                    $_SESSION['user_name'] = $user['name'];
                    if($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2){
                        header("Location: dashboard.php");
                    }else {
                        header("Location: clientAuth.PHP");
                    }
                } else {
                    echo "alert invalide ";
                }
            } else {
                echo "alert invalid ";
            }
        }
        public function logout(){
            session_start();
            if(isset($_SESSION['user_id'])){
                session_unset();
                session_destroy();
                header("Location: index.php");  
                exit;  
            } else {
                header("Location: index.php");
                exit;
            }
        }
    }
    ?>
