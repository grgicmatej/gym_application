<?php

class ContactController extends SecurityController
{
    public function contact()
    {
        if (Contact::contacts()){
            header( 'Location:'.App::config('url').'?m=1');
        }else{
            header( 'Location:'.App::config('url').'?m=0');
        }

    }
}