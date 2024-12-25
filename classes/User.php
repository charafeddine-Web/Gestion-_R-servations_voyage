<?php 

    abstract class User {
        protected $idUser;
        protected $name;
        protected $email;
        protected $password;
        protected $idRole;


        public function __construct($id, $name, $email){
            $this->idUser = $id;
            $this->name = $name; 
            $this->email = $email;
            $this->idRole = $idRole ;
        }
        public function login($email, $password){
            
        }

    }
?>