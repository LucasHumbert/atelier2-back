<?php
/**
 * File:  index.php
 *
 */

require_once __DIR__ . '/../src/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager;
use reu\event\app\controller\EventController;
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
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->get('/events[/]', EventController::class . ':getEvents');
$app->get('/events/{id}[/]', EventController::class . ':getEvent');
$app->get('/events/{id}/messages[/]', EventController::class . ':getEventMessages');
$app->get('/events/{id}/users[/]', EventController::class . ':getEventUsers');

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});

$app->run();
