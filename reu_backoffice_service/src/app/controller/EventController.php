<?php

namespace reu\backoffice\app\controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use reu\backoffice\app\model\Event;
use reu\backoffice\app\model\Guest;
use reu\backoffice\app\model\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\backoffice\app\utils\Writer;

/**
 * Class UserController
 *
 * @author HUMBERT Lucas
 * @author BUDZIK Valentin
 * @author HOUQUES Baptiste
 * @author LAMBERT Calvin
 * @package reu\event\app\controller
 *
 */

class EventController
{
    /**
     * Fonction de récupération des événements
     *
     * Cette fonction retourne tous les événements.
     * On retourne l'inactivité de l'évènement en calculant si la date de l'évènement est passé depuis 1 an ou plus.
     *
     * @param Request $request GET
     * @param Response $response
     * @return Response Retourne au format JSON la liste des évènements
     */
    public function getEvents(Request $request, Response $response): Response
    {
        $events = Event::with('messages')->get();

        foreach ($events as $event) {
            $event->inactive = 0;

            $creatorUser = User::find($event->creator_id, ['firstname', 'lastname']);
            $event->creatorUser = $creatorUser;

            if(count($event->messages) == 0) {
                if(strtotime(date("Y-m-d H:i:s")) - (strtotime($event->date)) > (86400*365)){
                    $event->inactive = 1;
                }
            }
            else {
                $lastMessage = $event->messages[0]->pivot->date;
                foreach ($event->messages as $message) {
                    if(strtotime($message->pivot->date) > strtotime($lastMessage)){
                        $lastMessage = $message->pivot->date;
                    }
                }
                if(strtotime(date("Y-m-d H:i:s")) - (strtotime($lastMessage)) > (86400*365)){
                    $event->inactive = 1;
                    $event->lastMessage = $lastMessage;
                }
            }
        }

        return Writer::jsonOutput($response, 200, ['events' => $events->makeHidden(['messages'])]);
    }

    /**
     * Fonction de récupération d'un événement
     *
     * Cette fonction retourne un événement en fonction de l'id dans le paramètre de la route.
     *
     * - Si la requête contient le paramêtre embed (de type array), la réponse retourne des informations supplémentaires sur
     * les messages et/ou les utilisateurs liés à l'évènement.
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
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

    public function deleteEvent(Request $request, Response $response, $args): Response
    {
        $event = Event::find($args['id']);
        $event->messages()->wherePivot('event_id', '=', $args['id'])->detach();
        $event->users()->wherePivot('event_id', '=', $args['id'])->detach();
        $guests = Guest::where('event_id', '=', $args['id'])->get();
        foreach ($guests as $guest) {
            $guest->delete();
        }
        $event->delete();

        $response = $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        $response->getBody()->write(json_encode(['response' => 'Event deleted']));
        return $response;
    }
}
