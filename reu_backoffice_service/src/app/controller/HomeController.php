<?php

namespace reu\backoffice\app\controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\backoffice\app\model\Event;
use reu\backoffice\app\model\User;
use reu\backoffice\app\utils\Writer;

class HomeController
{
    public function getInfos(Request $request, Response $response): Response
    {
        $users = User::all();
        $usersCount = count($users);

        $events = Event::all();
        $eventsCount = count($events);

        $messagesCount = 0;
        foreach ($users as $user) {
            $messagesCount += count($user->messages);
        }

        return Writer::jsonOutput($response, 200, ['nbUsers' => $usersCount, 'nbEvents' => $eventsCount, 'nbMessages' => $messagesCount]);
    }
}