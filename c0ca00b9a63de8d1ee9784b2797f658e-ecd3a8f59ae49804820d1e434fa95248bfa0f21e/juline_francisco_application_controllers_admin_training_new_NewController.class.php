<?php

class NewController
{
    // Image properties
    const WIDTH_MAX = "2400";
    const HEIGHT_MAX = "2400";
    const MAX_SIZE = 1000000;
    const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png'];

    function httpGetMethod(Http $http, array $queryField){

        $session = new Session();
        if(!$session->isLogged()){
            $flashBag = new FlashBag();
            $flashBag->add('Connection required');
            $http->redirectTo('/user/Login');
        }

        $trainingModel = new TrainingModel();

        // To be used in select field
        $categoryModel = new CategoryModel();

        // If training article already exists, get it's id and display it's info
        if(array_key_exists('id', $queryField)) {

            $id = intval($queryField['id']);

            return [

                'error' => "",
                'training' => $trainingModel->get_one($id),
                'categories' => $categoryModel->get_all(),

            ];

        }

        // New training article, get fields from TrainingForm
        return[

            'error' => "",
            '_form' => new TrainingForm(),
            'categories' => $categoryModel->get_all()

        ];
    }

    function httpPostMethod(Http $http, array $formFields){

        // Get info from input on $_POST($formFields)
        $title = $formFields['title'];
        $content = $formFields['content'];
        $category = $formFields['category'];

        try {

            // If title, content or category is empty display error message
            if(empty($title) or empty($content) or empty($category)){
                throw new DomainException('Fields are required');
            }

            $trainingModel = new TrainingModel();

            // Editing article
            if(array_key_exists('btn_update_article', $formFields))
            {

                $id = intval($formFields['id']);
                $trainingModel->update($title, $content, $category, $id);

                $http->redirectTo('admin/training/edition');
            }

            if ($http->hasUploadedFile('image'))
            {

                // récupère les infos du fichier uploadé
                $file = $http->getUploadedFile('image');


                // faire les tests sur l'image (extention, taille, poids...)
                // Recuperation de l'extension du fichier
                $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));


                if (!(in_array(strtolower($extension), self::ALLOWED_EXTENSIONS)))
                {

                    throw new DomainException('Extension not allowed');
                }

                $imgProperties = getimagesize($file['tmp_name']);

                // Check image type
                if ($imgProperties[2] >= 1 && $imgProperties[2] <= 14)
                {
                    // Check dimensions and size
                    if (($imgProperties[0] <= self::WIDTH_MAX) && ($imgProperties[1] <= self::HEIGHT_MAX) && (filesize($file['tmp_name']) <= self::MAX_SIZE))
                    {

                        // Check errors
                        if ($file['error'] === UPLOAD_ERR_OK)
                        {

                            $imageName = md5(uniqid()) . '.' . $extension;

                            move_uploaded_file($file['tmp_name'], WWW_PATH . "/images/training/" . $imageName);

                            $image = $imageName;


                            // New article
                            $trainingModel->add($title, $content, $image, $category);

                            $http->redirectTo('/admin/training/edition');
                            
                        }

                        // In case there's an error while uploading error message
                        throw new DomainException('Internal error');

                    }
                    // Dimensions don't match error
                    throw new DomainException("Dimensions not allowed ");
                }
                // Type doesn't match error
                throw new DomainException('Image type not allowed');
            }
        } catch (DomainException $exception){

            $form = new TrainingForm();
            $form->bind($formFields);

            $categoryModel = new CategoryModel();

            return[
                'error' => $exception->getMessage(),
                'categories' => $categoryModel->get_all(),
                '_form' => $form

            ];
        }
    }

}