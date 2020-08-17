<?php

class TrainingController
{
    function httpGetMethod(Http $http, array $queryField){

        $get_training = new TrainingModel();

        // Retrieve one article
        if(array_key_exists('training_id', $queryField)){

            $training_id = $queryField['training_id'];
            $get_one = $get_training->get_one($training_id);

            return[
                
                'training_id'  => $training_id,
                'training'     => $get_one

            ];
        }

        // Retrieve all articles from category's id
        $category_id = intval($queryField['id']);

        $get_category = new CategoryModel;

        $category = $get_category->get_one($category_id);
        $category_name = $category['title'];

        $training = $get_training->get_all_from_category($category_name);

        return[

            'category_name' => $category_name,
            'trainings' => $training

        ];

    }
    
}