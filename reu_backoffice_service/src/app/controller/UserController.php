<?php

namespace reu\backoffice\app\controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use reu\backoffice\app\model\Event;
use reu\backoffice\app\model\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\backoffice\app\utils\Writer;

class UserController
{
    public function getUsers(Request $request, Response $response): Response
    {
        $users = Event::all()->toArray();
        return Writer::jsonOutput($response, 200, $users);
    }
}
