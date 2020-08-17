<?php

class RegisterForm extends form
{

    public function build()
    {
        $this->addFormField('firstname');
        $this->addFormField('lastname');
        $this->addFormField('email');
        $this->addFormField('password');
    }
}