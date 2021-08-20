<?php

class IndexController
{
    function index()
    {
        $view=new View();
        var_dump($_SESSION['Staff_Id']);
        die();
        $view->render('index',
            []);
    }
}