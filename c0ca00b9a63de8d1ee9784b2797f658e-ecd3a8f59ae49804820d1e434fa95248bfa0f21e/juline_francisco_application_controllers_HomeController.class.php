<?php

class HomeController
{
    public function httpGetMethod()
    {
        
    	return[

    	    'flashbag' => new FlashBag()
            
        ];
    	
    }

}