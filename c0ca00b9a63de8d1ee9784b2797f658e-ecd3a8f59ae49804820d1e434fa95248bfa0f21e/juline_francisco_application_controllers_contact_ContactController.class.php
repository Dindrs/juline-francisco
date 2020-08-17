<?php

class ContactController
{
    function httpGetMethod(){

        return[

            'error' => "",
            '_form' => new ContactForm()

        ];
    }

    function httpPostMethod(Http $http, array $formFields){

        // Retrieve info to be sent
        $name = htmlentities($formFields['name']);
        $email = htmlentities(trim($formFields['email']));
        $subject = htmlentities($formFields['subject']);
        $question = htmlentities($formFields['question'] . "\n");

        // Receiver
        $to = 'ingridi_ethos@hotmail.com';
        $boundary = md5(uniqid(mt_rand(), true));

        $headers = "From:".$name. '<'.$email.">" . "\n";
        $headers .= 'Reply-To:' . $email . "\n";
        $headers .= "S/MIME-Version: 1.0" . "\n";
        $headers .= 'Content-Type: multipart/mixed;boundary='.$boundary . "\n";
        $headers .= "\n";

        $message = '--' .$boundary. "\n";
        $message .= "\n";
        $message .= $question."\n";
        $message .= "\n";

        try{

            if(empty($name) || empty($email) || empty($subject) || empty($question)){

                throw new DomainException("All fields are required");

            }

            // mail to => my email,  from => $name , $message => $question, $headers

            if(mail($to, $subject, $message, $headers)) {

                $flashBag = new FlashBag();
                $flashBag->add('Email was sent successfully');

                $http->redirectTo('/index.php');

            }

        } catch(DomainException $exception){

            $form = new ContactForm();
            $form->bind($formFields);

            return[

                'error' => $exception->getMessage(),
                '_form' => $form

            ];
        }
    }
}