<?php

class LogoutController{

    function httpGetMethod(Http $http){

        $session = new Session();
        $session->logout();

        // Logout confirmation
        $flashbag = new FlashBag();
        $flashbag->add('You were disconnected');

        $http->redirectTo('/index.php');
        
    }

}