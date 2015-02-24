<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
//$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

// Cuenta API de Twitter. (dev.twitter.com)
$app['endroid_twitter.consumer_key']        = '';
$app['endroid_twitter.consumer_secret']     = '';
$app['endroid_twitter.access_token']        = '';
$app['endroid_twitter.access_token_secret'] = '';
$app['endroid_twitter.api_url']             = 'https://api.twitter.com/1.1/';

// Definición de la API de Twitter como servicio.
$app['twitter'] = $app->share(function () use ($app) {
    return new Endroid\Twitter\Twitter(
                                       $app['endroid_twitter.consumer_key'],
                                       $app['endroid_twitter.consumer_secret'],
                                       $app['endroid_twitter.access_token'],
                                       $app['endroid_twitter.access_token_secret'],
                                       $app['endroid_twitter.api_url']
                                       );
});


/*
 * Llamada tipo REST
 * GET favorites
 */
$app->get('/api/favorites', function () use ($app) {
    $twitter = $app['twitter'];
    $buzz = $twitter->query('favorites/list', 'GET', 'json', array('include_entities' => false));
    $favorites = json_decode($buzz->getContent());
    
    $resp = array();
    if (!isset($favorites->errors)) {
        // Si no hubo errores entonces itero entre los tweets favoritos.
        foreach ($favorites as $tweet) {
            $obj            = new \stdClass();
            $obj->timestamp = strtotime($tweet->created_at);
            $obj->user      = $tweet->user->screen_name;
            $obj->avatar    = $tweet->user->profile_image_url;
            $obj->content   = $tweet->text;
            
            $resp[] = $obj;
        }
    }
    
    return new Response(json_encode($resp));
});


$app->get('/', function () use ($app) {
    $favorites = json_decode(file_get_contents('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . '/api/favorites'));
    return new Response($app['twig']->render('favoritos.html.twig', array(
        'favorites' => $favorites,
    )));
});

$app->run();
