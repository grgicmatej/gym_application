<?php

class ContactController extends SecurityController
{
    public function contact()
    {
        echo json_encode(contact::contact());
    }
}