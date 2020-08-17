<?php

class EditController
{
    function httpGetMethod(Http $http, $queryField){

        $session = new Session();
        if(!$session->isLogged()){
            $flashBag = new FlashBag();
            $flashBag->add('Connection required');
            $http->redirectTo('/login');
        }

        $categoryModel = new CategoryModel();

        if(array_key_exists('action', $queryField)){

            $action = $queryField['action'];
            $id = intval($queryField['category_id']);

            $categoryModel = new CategoryModel();

            switch($action){

                case "remove":

                    $categoryModel->remove($id);
                    break;

                case "edit":
                    $http->redirectTo("/admin/categories/add?id=$id");
                    break;
            }

        }

        return[
            
            'categories' => $categoryModel->get_all(),

        ];
    }
}