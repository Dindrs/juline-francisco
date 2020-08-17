<?php

class TrainingForm extends Form
{

    public function build()
    {
        $this->addFormField('title');
        $this->addFormField('content');
        $this->addFormField('image');
        $this->addFormField('creation_date');
        $this->addFormField('category');
    }
}