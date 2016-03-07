<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/~~~~~~.php";

    // session_start();

    $app = new Silex\Application();

    // $server = 'mysql:host=localhost;dbname=~~~~~';
    // $username = 'root';
    // $password = 'root';
    // $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));



    return $app;
 ?>
