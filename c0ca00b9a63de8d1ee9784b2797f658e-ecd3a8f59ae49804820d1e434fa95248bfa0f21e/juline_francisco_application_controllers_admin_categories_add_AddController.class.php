<?php

class AddController
{
    function httpGetMethod(Http $http, array $queryField){

        $session = new Session();
        if(!$session->isLogged()){
            $flashBag = new FlashBag();
            $flashBag->add('Connection required');
            $http->redirectTo('/user/Login');
        }

        // if the category already exists get it's id and display it's info
        if(array_key_exists('id', $queryField)) {

            $category_id = intval($queryField['id']);

            $categoryModel = new CategoryModel();
            $category = $categoryModel->get_one($category_id);


            return [
                'error' => "",
                'category' => $category,
            ];

        }

        return[
            'error' => "",
            '_form' => new AddCategoryForm()
        ];
    }

    function httpPostMethod(Http $http, array $formFields){

        // Get title and all first letters must be capitals
        $title = ucfirst($formFields['title']);

        try {

            if(empty($title)){
                throw new DomainException('Field is required');
            }

            $categoryModel = new CategoryModel();

            if($categoryModel->title_exists($title)){
                
                throw new DomainException("$title category already exists");
            }

            // Editing mode
            if(array_key_exists('btn_update_category', $formFields))
            {

                $id = intval($formFields['id']);
                $categoryModel->update($title, $id);

                $http->redirectTo('admin/categories/edit');

            }

            // New category
            $categoryModel->add($title);
            $http->redirectTo('admin/categories/edit');

        } catch (DomainException $exception){

            // In case there's an error keep the info, instead of making user retype it all over again
            $form = new AddCategoryForm();
            $form->bind($formFields);
            
            return[
                'error' => $exception->getMessage(),
                '_form' => $form
            ];
        }
    }
}