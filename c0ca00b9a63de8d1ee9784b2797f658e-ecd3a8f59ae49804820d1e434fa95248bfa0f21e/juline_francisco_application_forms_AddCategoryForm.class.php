<?php

class AddCategoryForm extends Form
{

    public function build()
    {

        $this->addFormField('title');
        $this->addFormField('creation_date');

    }
}