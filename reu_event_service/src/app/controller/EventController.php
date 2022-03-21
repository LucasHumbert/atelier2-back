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

    public function getEvent(Request $request, Response $response, $args): Response
    {
        try {
            $event = Event::findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode([
                "error" => 404,
                "message" => 'Model innexistant',
            ]));
            return $response;
        }

        $queryparam = $request->getQueryParams();
        $data = ["type" => "ressource",
            "event" => $event,
            "links" => [
                'self' => ['href' => $request->getUri() . '']
            ]];
        $response = $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        $response->getBody()->write(json_encode($data));
        return $response;
    }
}
