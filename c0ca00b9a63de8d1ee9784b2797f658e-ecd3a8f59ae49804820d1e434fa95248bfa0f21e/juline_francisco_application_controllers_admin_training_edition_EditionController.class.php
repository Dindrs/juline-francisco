<?php

class EditionController
{
    function httpGetMethod(Http $http, $queryField){

        $session = new Session();
        if(!$session->isLogged()){
            $flashBag = new FlashBag();
            $flashBag->add('Connection Required');
            $http->redirectTo('user/login');

        }

        $trainingModel= new TrainingModel();

        if(array_key_exists('action', $queryField)){

            $action = $queryField['action'];
            $id = intval($queryField['training_id']);

            $trainingModel = new TrainingModel();

            switch($action){

                case "remove":
                    $data = $trainingModel->get_one($id);
                    $imageName = $data['image'];

                    $trainingModel->remove($id);

                    // On deletion remove image from folder
                    unlink(WWW_PATH . "/images/training/" . $imageName);

                    $http->redirectTo('/admin/training/edition');

                    break;

                case "edit":
                    $http->redirectTo("/admin/training/new?id=$id");
                    break;

            }
        }

        return[

            'training' => $trainingModel->get_all(),

        ];
    }
}