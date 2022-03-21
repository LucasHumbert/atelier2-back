<?php

namespace reu\event\app\controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use reu\event\app\model\Event;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\event\app\utils\Writer;


class EventController
{
    public function getEvents(Request $request, Response $response, $args): Response
    {
        $events = Event::all()->makeHidden(['id', 'creator_id'])->toArray();
        return Writer::jsonOutput($response, 200, $events);
    }
}
