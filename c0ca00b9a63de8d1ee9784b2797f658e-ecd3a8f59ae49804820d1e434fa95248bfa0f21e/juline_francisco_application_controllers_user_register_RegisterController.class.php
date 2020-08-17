<?php

class RegisterController
{
    function httpGetMethod(Http $http, array $queryField){

        $session = new Session();
        if(!$session->isLogged()){

            $flashBag = new FlashBag();
            $flashBag->add('Connection required');
            $http->redirectTo('/user/Login');

        }

        return[

            'error' => "",
            '_form' => new RegisterForm()

        ];
    }

    function httpPostMethod(Http $http, array $formFields){

        $firstname = $formFields['firstname'];
        $lastname = $formFields['lastname'];
        $email = trim($formFields['email']);
        $password = $formFields['password'];


        try{

            if(empty ($lastname) || empty ($firstname) || empty($email) || empty ($password)){

                throw new DomainException('All fields are required');
            }

            if(strlen($password) < 8){

                throw new DomainException('Password must be min 8 characters.');
            }

            $userModel = new UserModel();

            // Create new user
            $userModel->create($firstname, $lastname, $email, $password);

            $http->redirectTo('/admin/users');

        } catch (DomainException $exception) {

            $form = new RegisterForm();
            $form->bind($formFields);

            return[

                'error' => $exception->getMessage(),
                '_form' => $form
                
            ];

        }

    }
}