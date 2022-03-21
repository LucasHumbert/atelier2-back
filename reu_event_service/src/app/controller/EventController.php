<?php

namespace reu\event\app\controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class EventController
{
    public function getEvents(Request $request, Response $response, $args): Response
    {
        $response->getBody()->write(json_encode('test'));
        return $response;
    }
}
