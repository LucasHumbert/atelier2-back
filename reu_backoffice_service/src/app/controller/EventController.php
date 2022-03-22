<?php

namespace reu\backoffice\app\controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use reu\backoffice\app\model\Event;
use reu\backoffice\app\model\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\backoffice\app\utils\Writer;


class EventController
{
    public function getEvents(Request $request, Response $response, $args): Response
    {
        $events = Event::all()->makeHidden(['id', 'creator_id'])->toArray();
        return Writer::jsonOutput($response, 200, $events);
    }

    public function getEvent(Request $request, Response $response, $args): Response
    {
        //Try to find event
        try {
            $event = Event::with('messages', 'users')
                ->where('id', '=', $args['id'])->first();

        } catch (ModelNotFoundException $e) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode([
                "error" => 404,
                "message" => 'Model innexistant',
            ]));
            return $response;
        }

        //if the request contains 'embed' parameter
        $queryparam = $request->getQueryParams();
        if (!empty($queryparam)) {

            //get messages of the event
            if (isset($queryparam['embed']) && in_array('messages', $queryparam['embed'])) {
                $messages = [];
                foreach($event->messages as $message) {
                    $messages[] = ['user_id' => $message->pivot->user_id,
                        'content' => $message->pivot->content,
                        'date' => $message->pivot->date
                    ];
                }
            }

            //get users of the event
            if (isset($queryparam['embed']) && in_array('users', $queryparam['embed'])) {
                $users = [];
                foreach($event->users as $event_user) {
                    $user = User::find($event_user->pivot->user_id);
                    $users[] = ['user_id' => $user->id,
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                    ];
                }
            }

            $data = ["type" => "ressource",
                "event" => $event->makeHidden(['messages', 'users'])];

            //add users to the response
            if(isset($users)){
                $data['users'] = $users;
            }

            //add messages to the response
            if(isset($messages)){
                $data['messages'] = $messages;
            }

            $data["links"] = ['self' => ['href' => $request->getUri() . '']];

            //add link to get event users
            if(isset($users)){
                $data['links']['users'] = ['href' => 'http://api.backoffice.local:62560/events/' . $event->id .'/users'];
            }
            //add link to get event messages
            if(isset($messages)){
                $data['links']['messages'] = ['href' => 'http://api.backoffice.local:62560/events/' . $event->id . '/messages'];
            }

            $response = $response->withHeader('Content-Type', 'application/json;charset=utf-8');
            $response->getBody()->write(json_encode($data));
            return $response;
        }

        //response without parameters
        $data = ["type" => "ressource",
            "event" => $event->makeHidden(['messages', 'users']),
            "links" => [
                'self' => ['href' => $request->getUri() . '']
            ]];

        $response = $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        $response->getBody()->write(json_encode($data));
        return $response;
    }

    public function getEventMessages(Request $request, Response $response, $args): Response
    {
        $event = Event::with('messages')
            ->where('id', '=', $args['id'])->first();

        $messages = [];
        foreach($event->messages as $message) {
            $messages[] = ['user_id' => $message->pivot->user_id,
                'event_id' => $message->pivot->event_id,
                'content' => $message->pivot->content,
                'date' => $message->pivot->date
            ];
        }

        $data = ["type" => "ressource",
            "messages" => $messages,
            "links" => [
                'self' => ['href' => $request->getUri() . '']
            ]];

        $response = $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        $response->getBody()->write(json_encode($data));
        return $response;
    }

    public function getEventUsers(Request $request, Response $response, $args): Response
    {
        $event = Event::with('users')
            ->where('id', '=', $args['id'])->first();

        $users = [];
        foreach($event->users as $event_user) {
            $user = User::find($event_user->pivot->user_id);
            $users[] = ['user_id' => $user->id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
            ];
        }

        $data = ["type" => "ressource",
            "users" => $users,
            "links" => [
                'self' => ['href' => $request->getUri() . '']
            ]];

        $response = $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        $response->getBody()->write(json_encode($data));
        return $response;
    }
}
