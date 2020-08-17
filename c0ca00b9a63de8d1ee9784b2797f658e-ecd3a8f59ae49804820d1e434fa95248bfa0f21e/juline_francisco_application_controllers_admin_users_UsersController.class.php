<?php

class UsersController
{
    function httpGetMethod(Http $http, $queryField)
    {
        $session = new Session();
        if(!$session->isLogged()){
            $http->redirectTo('/user/login');
        }

        $userModel = new UserModel();

        if(array_key_exists('remove', $queryField)) {

            $id = intval($queryField['user_id']);

            $userModel = new UserModel();
            $userModel->remove($id);

        }

        return[

            'users' => $userModel->get_all(),
            'error' => ''

        ];
    }
}