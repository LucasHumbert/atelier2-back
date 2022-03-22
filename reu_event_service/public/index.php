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

$app->get('/events[/]', EventController::class . ':getEvents');
$app->get('/events/{id}[/]', EventController::class . ':getEvent');
$app->get('/events/{id}/messages[/]', EventController::class . ':getEventMessages');
$app->get('/events/{id}/users[/]', EventController::class . ':getEventUsers');

$app->run();
