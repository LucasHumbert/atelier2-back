<?php
/**
 * File:  index.php
 *
 */

require_once __DIR__ . '/../src/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager;
use reu\event\app\controller\EventController;
use reu\event\app\controller\GuestController;
use reu\event\app\controller\UserController;
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

//Events routes
//add user_id to return all events created by specific user
$app->get('/events[/]', EventController::class . ':getEvents');
$app->get('/events/{id}[/]', EventController::class . ':getEvent');
$app->get('/events/{id}/users[/]', EventController::class . ':getEventUsers');
$app->post('/events[/]', EventController::class . ':postEvent')
    ->add(new Validation($postEventValidators));
$app->post('/events/{event_id}/users[/]', EventController::class . ':postEventUser');
$app->put('/events/{event_id}/users/{user_id}[/]', EventController::class . ':putChoice');
$app->delete('/events/{id}[/]', EventController::class . ':deleteEvent');
$app->get('/events/{id}/messages[/]', EventController::class . ':getEventMessages');
$app->post('/events/{eventId}/message[/]', EventController::class . ':postMessage');

//Users routes
$app->get('/users/{id}[/]', UserController::class . ':getUser');
$app->get('/users/{id}/events[/]', UserController::class . ':getUsersEvents');
$app->put('/users/{id}[/]', UserController::class . ':putUser');

//Guests routes
$app->get('/guests/{idEvent}[/]', GuestController::class . ':getGuests');
$app->post('/guests/{idEvent}[/]', GuestController::class . ':postGuest');

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});

$app->run();
