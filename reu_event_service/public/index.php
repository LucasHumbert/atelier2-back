<?php
/**
 * File:  index.php
 *
 */

require_once __DIR__ . '/../src/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager;
use reu\event\app\controller\EventController;
use Slim\App;
use DavidePastore\Slim\Validation\Validation as Validation;
use Respect\Validation\Validator as v;

$settings = require_once __DIR__ . '/../src/app/conf/settings.php';
$errors = require_once __DIR__ . '/../src/app/conf/errors.php';


$c = new \Slim\Container(array_merge($settings,$errors));
$app = new App($c);


$capsule = new Manager();
$capsule->addConnection(parse_ini_file($c['settings']['dbconf']));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$postEventValidators = [
    'title' => v::alnum() ,
    'description' => v::alnum(),
    'date' => v::date('Y-m-d h:i:s')->min('now'),
    'adress' => v::stringType()->alnum(),
    'lat' => v::floatType(),
    'lon' => v::floatType(),
    ];

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

$app->post('/events[/]', EventController::class . ':postEvent')
    ->add(new Validation($postEventValidators));

$app->run();
