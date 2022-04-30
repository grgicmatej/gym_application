<?php

class IndexController
{
    function index()
    {
        header( 'Location:'.App::config('url').'Dashboard/Dashboard');
    }
}