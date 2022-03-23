<?php

namespace reu\event\app\controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use reu\event\app\model\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\event\app\utils\Writer;

class UserController
{
    public function getUsers(Request $request, Response $response)
    {
        $users = User::all();
        return Writer::jsonOutput($response, 200, [$users]);
    }
}
