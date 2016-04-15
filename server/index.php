<?php

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

/**
 * index.php
 * Start the app and provide the backend
 */

require "bootstrap.php";

use Slim\Http\Request;
use Slim\Http\Response;

// Show all the errors
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$container = new \Slim\Container($configuration);

// Create a new slim instance and show the errors
$app = new \Slim\App($container);

//Create a new video game
$app->post(
    '/videogame/register',
   function ($request, $response) {
        $videoGameController = new App\Controllers\VideoGameController();
        $result = $videoGameController->register($request);
        return $response->withJson($result);
    }
);

//Get all video games
$app->get(
    '/videogames',
    function ($request, $response) {
        $videoGameController = new App\Controllers\VideoGameController();
        $result = $videoGameController->getAll($request);
        return $response->withJson($result);
    }
);

//Delete video game
$app->delete(
    '/videogame/{id}',
    function ($request, $response, $args) {
        $videoGameController = new App\Controllers\VideoGameController();
        $result = $videoGameController->delete($request, $args);
        return $response->withJson($result);
    }
);

//Update video game
$app->post(
    '/videogame/{id}',
    function ($request, $response, $args) {
        $videoGameController = new App\Controllers\VideoGameController();
        $result = $videoGameController->update($request, $args);
        return $response->withJson($result);
    }
);


$app->run();