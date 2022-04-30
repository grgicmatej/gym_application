<?php
define("BP",__DIR__ . DIRECTORY_SEPARATOR );
error_reporting(E_ALL);
ini_set("display_errors",1);

$t = implode(PATH_SEPARATOR,[
    BP . "app" . DIRECTORY_SEPARATOR . "model",
    BP . "app" . DIRECTORY_SEPARATOR . "controller"
]
);

set_include_path($t);
spl_autoload_register(function($klasa)
{
    $putanja = strtr($klasa,"\\",DIRECTORY_SEPARATOR) . ".php";
    return include $putanja;
});
App::start();




