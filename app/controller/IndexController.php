<?php

class IndexController
{
    function index()
    {
        $view=new View();
        $view->render('Public/index2',
            []);
    }
}