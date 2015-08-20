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


    //Home
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'cuisine_check' => false, 'venue_check' => false));
    });

    //Cuisine form view
    $app->get("/form-cuisines", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'cuisine_check' => true, 'venue_check' => false));
    });

    //Venue form view
    $app->get("/form-venue", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'cuisine_check' => false, 'venue_check' => true));
    });

    //Submit cuisine
    $app->post('/add_cuisine', function() use ($app) {

        $cuisine = new Cuisine($_POST['type']);
        $cuisine->save();

        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'cuisine_check' => false, 'venue_check' => false));
    });

    //Delete all cuisines
    $app->post('/delete_cuisines', function() use($app) {
        Cuisine::deleteAll();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'cuisine_check' => false, 'venue_check' => false));
    });

    //Navigate to cuisine page
    $app->get('/cuisines/{id}', function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'venues' => $cuisine->getVenues()));
    });




    return $app;
?>
