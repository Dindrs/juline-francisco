<?php

class LoginController{

    function httpGetMethod(){

        return[
            
            'error'=> "",
            '_form' => new LoginForm(),
            
        ];
    }

    function httpPostMethod(Http $http, array $formFields)
    {
        try{

            //Form reception
            $email = trim($formFields['email']);
            $password = $formFields['password'];

            //Check if fields are empty
            if(empty($email) or empty($password)){

                throw new DomainException('All fields are required');

            }

            $userModel = new UserModel();
            $user_id = $userModel->login($email, $password);

            //Session info
            $user = $userModel->get($user_id);

            //Create session
            $session = new Session();
            $session->login($user['firstname'], $user['lastname'], $user_id, $email);

            //Login confirmation
            $flashbag = new FlashBag();
            $flashbag->add('You are connected');

            $http->redirectTo('/Admin');

        } catch (DomainException $exception){

            $form = new LoginForm();
            $form->bind($formFields);

            return[

                'error' => $exception->getMessage(),
                '_form' => $form

            ];

        }

    }

}