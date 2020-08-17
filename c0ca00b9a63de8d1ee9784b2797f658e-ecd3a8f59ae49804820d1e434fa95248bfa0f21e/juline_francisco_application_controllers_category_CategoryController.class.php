<?php

class CategoryController
{
    function httpGetMethod(){

        $get_category = new CategoryModel();
        $category = $get_category->get_all();

        return[

            'categories' => $category

        ];

    }

}