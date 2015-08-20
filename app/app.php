<?php

    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Venue.php';
    require_once __DIR__.'/../src/Cuisine.php';

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=restaurant';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));


    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'cuisine_check' => false, 'venue_check' => false));
    });

    $app->get("/form-cuisines", function() use ($app){
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'cuisine_check' => true, 'venue_check' => false));
    });

    $app->get("/form-venue", function() use ($app){
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'cuisine_check' => false, 'venue_check' => true));
    });


    return $app;
?>
