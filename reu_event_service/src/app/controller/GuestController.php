<?php

namespace reu\event\app\controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\event\app\model\Event;
use reu\event\app\model\Guest;
use reu\event\app\utils\Writer;
use Slim\Container;

class GuestController
{
    private $c;

    public function __construct(Container $c)
    {
        $this->c = $c;
    }

    public function getGuests(Request $request, Response $response, $args): Response
    {
        $guests = Guest::where('event_id', '=', $args['idEvent'])->get();
        return Writer::jsonOutput($response, 200, ['guests' => $guests]);
    }

    public function postGuest(Request $request, Response $response, $args): Response
    {
        $pars = $request->getParsedBody();

        try{
            $guest =  new Guest();
            $guest->event_id = $args['idEvent'];
            $guest->name = filter_var($pars['name'],FILTER_SANITIZE_STRING);
            $guest->save();

        } catch (\Exception $e) {
            return Writer::jsonOutput($response, 200, ['message' => $e]);
        }
        return Writer::jsonOutput($response, 200, ['guest' => $guest]);
    }
}