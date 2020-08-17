<?php

class AdminController
{

    function httpGetMethod(Http $http, array $queryFields){

        $session = new Session();
        if(!$session->isLogged()){

            $http->redirectTo('/user/Login');

        }

        $admin = new UserModel();

        return[

            'user' => $admin->get($session->getId()),
            'flashbag' => new Flashbag()

        ];

    }

}