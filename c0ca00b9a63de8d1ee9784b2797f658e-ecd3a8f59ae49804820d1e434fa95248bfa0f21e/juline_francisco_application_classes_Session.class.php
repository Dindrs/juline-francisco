<?php

class Session {

    public function __construct() {
        
        if(session_status() == PHP_SESSION_NONE){

            session_start();
            
        }
    }

    public function login(string $firstname, string $lastname, int $id, string $email){

        $_SESSION = [
            'user' => [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'id' => $id,
                'email' => $email
            ],
            'isLogged' => true
        ];
    }

    public function logout(){
        $_SESSION = [];
        session_destroy();
    }

    public function isLogged(){
        // If is logged exists user is connected
        return array_key_exists('isLogged', $_SESSION) && $_SESSION['isLogged'] == true;
    }

    public function getFullName(){
        $firstname = ucfirst(strtolower($_SESSION['user']['firstname']));
        $lastname = strtoupper($_SESSION['user']['lastname']);
        return "$firstname $lastname";
    }

    public function getId(){
        return $_SESSION['user']['id'];
    }

    public function getEmail(){
        return $_SESSION['user']['email'];
    }

}