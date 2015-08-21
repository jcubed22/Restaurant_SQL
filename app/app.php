<?php

    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Venue.php';
    require_once __DIR__.'/../src/Cuisine.php';

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=restaurant';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));


    //Home
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'form_check' => false, 'venue_check' => false));
    });

    //Cuisine form view
    $app->get("/form_cuisines", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'form_check' => true));
    });

    //Venue form view
    $app->get("/form_venue", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'form_check' => false));
    });

    //Submit cuisine
    $app->post('/add_cuisine', function() use ($app) {

        $cuisine = new Cuisine($_POST['type']);
        $cuisine->save();

        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'form_check' => false));
    });

    //Delete all cuisines
    $app->post('/delete_cuisines', function() use($app) {
        Cuisine::deleteAll();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll(), 'form_check' => false));
    });

    //Navigate to cuisine page
    $app->get('/cuisines/{id}', function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'venues' => $cuisine->getVenues(), 'form_check' => false));
    });

    //Create a new venue
    $app->post('/add_venue', function() use($app) {
        $name = $_POST['name'];
        $cuisine_id = $_POST['cuisine_id'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        $rating = $_POST['rating'];
        $venue = new Venue($name, $cuisine_id, $id = null, $rating, $address, $description);
        $venue->save();
        $cuisine = Cuisine::find($cuisine_id);

        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'venues' => $cuisine->getVenues(), 'form_check' => false));
    });



    $app->get('/form_restaurant', function() use ($app) {
        $cuisine = Cuisine::find($_GET['cuisine_id']);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'venues' => $cuisine->getVenues(), 'form_check' => true));
    });

    return $app;
?>
