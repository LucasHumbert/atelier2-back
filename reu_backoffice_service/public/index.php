<?php
/**
 * File:  index.php
 *
 */

require_once __DIR__ . '/../src/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager;
use reu\backoffice\app\controller\EventController;
use reu\backoffice\app\controller\UserController;
use reu\backoffice\app\middlewares\Cors;
use Slim\App;

$settings = require_once __DIR__ . '/../src/app/conf/settings.php';
$errors = require_once __DIR__ . '/../src/app/conf/errors.php';


$c = new \Slim\Container(array_merge($settings,$errors));
$app = new App($c);


$capsule = new Manager();
$capsule->addConnection(parse_ini_file($c['settings']['dbconf']));
$capsule->setAsGlobal();
$capsule->bootEloquent();

//Middlewares
$app->add(Cors::class . ':corsHeaders');
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

//Event routes
$app->get('/events[/]', EventController::class . ':getEvents');
$app->get('/events/{id}[/]', EventController::class . ':getEvent');

//User routes
$app->get('/users[/]', UserController::class . ':getUsers');

$app->run();
