<?php

namespace reu\event\app\controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use reu\event\app\model\Event;
use reu\event\app\model\Guest;
use reu\event\app\model\Message;
use reu\event\app\model\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\event\app\utils\Writer;
use Ramsey\Uuid\Uuid;
use Slim\Container;

/**
 * Class EventController
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
    private $c;

    public function __construct(Container $c)
    {
        $this->c = $c;
    }

    /**
     * Fonction de récupération des événements
     *
     * Cette fonction récupère dans la base de données tous les événements à partir d'une requête.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */

    public function getEvents(Request $request, Response $response): Response
    {
        $queryparam = $request->getQueryParams();
        if (!empty($queryparam) && in_array('creator_id', $queryparam['filter'])) {
            $tokenstring = $queryparam['creator_token'];
            try {
                $token = JWT::decode($tokenstring, new Key($this->c['secret'], 'HS512'));
            }
            catch (\Exception $e){
                return Writer::jsonOutput($response, 403, ['message' => $e]);
            }

            $events = Event::all()->where('creator_id', '=', $token->upr->id)->makeHidden(['id', 'creator_id'])->toArray();;
            return Writer::jsonOutput($response, 200, ['events' => $events]);
        }
        $events = Event::all()->where('public', '=', true)->makeHidden(['creator_id'])->toArray();
        return Writer::jsonOutput($response, 200, ['events' => $events]);
    }

    /**
     * Fonction de récupération d'un événement
     *
     * Cette fonction permet de récuperer un événement afin de fournir les informations lié à cet événement.
     * Si la requête contient un paramêtre embed, on peut obtenir des informations supplémentaires concernant
     * les messages, les utilisateurs lié à l'événement, ...
     *
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
            $creatorUser = User::find($event->creator_id, ['firstname', 'lastname', 'mail']);
            $event->creatorUser = $creatorUser;

        } catch (ModelNotFoundException $e) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode([
                "error" => 404,
                "message" => 'Model innexistant',
            ]));
            return Writer::jsonOutput($response, 404, ['message' => 'Model innexistant']);
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
                        'choice' => $event_user->pivot->choice
                    ];
                }
            }

            //get user connected of the event
            if (isset($queryparam['filter']) && in_array('userConnected', $queryparam['filter'])) {
                $tokenstring = sscanf($request->getHeader('Authorization')[0], "Bearer %s")[0];
                $token = JWT::decode($tokenstring, new Key($this->c['secret'], 'HS512'));
                try {
                    $event = Event::with('users')->find($args['id']);
                    foreach ($event->users as $userEvent) {
                        if($userEvent->pivot->user_id === $token->upr->id){
                            return Writer::jsonOutput($response, 200, ['event' => $event,'userConnected' => ['firstname' => $token->upr->firstname,'lastname' => $token->upr->lastname],'inEvent' => true,'choice' => $userEvent->pivot->choice]);
                        }
                    }
                    return Writer::jsonOutput($response, 200, ['event' => $event,'userConnected' => ['firstname' => $token->upr->firstname,'lastname' => $token->upr->lastname],'inEvent' => false]);
                }
                catch (\Exception $e){
                    return Writer::jsonOutput($response, $e->getCode(), ['message => $e']);
                }
            }

            if (isset($queryparam['embed']) && in_array('guests', $queryparam['embed'])) {
                $guests = Guest::all()->where('event_id', '=', $args['id']);
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

            //add guests to the response
            if(isset($guests)){
                $data['guests'] = $guests;
            }

            $data["links"] = ['self' => ['href' => $request->getUri() . '']];

            //add link to get event users
            if(isset($users)){
                $data['links']['users'] = ['href' => 'http://api.event.local:62560/events/' . $event->id .'/users'];
            }
            //add link to get event messages
            if(isset($messages)){
                $data['links']['messages'] = ['href' => 'http://api.event.local:62560/events/' . $event->id . '/messages'];
            }
            //add link to get event messages
            if(isset($guests)){
                $data['links']['guests'] = ['href' => 'http://api.event.local:62560/events/' . $event->id . '/guests'];
            }

            return Writer::jsonOutput($response, 200, $data);
        }

        //response without parameters
        $data = ["type" => "ressource",
            "event" => $event->makeHidden(['messages', 'users']),
            "links" => [
                'self' => ['href' => $request->getUri() . '']
            ]];

        return Writer::jsonOutput($response, 200, $data);
    }

    /**
     * Fonction de récupération des messages lié à un événement
     *
     * La fonction permet, en transmettant l'identifiant de l'événement, de récupérer tous les messages qui lui
     * sont associés. La réponse contient l'id de l'événement, le contenu, la date du message et l'id, le prénom
     * et le nom de l'utilisateur ayant posté le message.
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */

    public function getEventMessages(Request $request, Response $response, $args): Response
    {
        $event = Event::with('messages')
            ->where('id', '=', $args['id'])->first();

        $messages = [];
        foreach($event->messages as $message) {
            $messages[] = ['user_id' => $message->pivot->user_id,
                'event_id' => $message->pivot->event_id,
                'content' => $message->pivot->content,
                'date' => $message->pivot->date,
                'user' => [
                    'firstname' => $message->firstname,
                    'lastname' => $message->lastname,
                ]
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

    /**
     * Fonction de récupération des messages lié à un utilisateur
     *
     * A renseigner
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */

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

    /**
     * Fonction de création d'un événement
     *
     * Cette fonction permet de créer un événement en s'assurant au préalable que tous les champs sont bien
     * renseigner et en appliquant des filtres sur ces derniers.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */

    public function postEvent (Request $request, Response $response): Response
    {
        $pars = $request->getParsedBody();
        $tokenstring = sscanf($request->getHeader('Authorization')[0], "Bearer %s")[0];

        $token = JWT::decode($tokenstring, new Key($this->c['secret'], 'HS512'));

        if (!isset($pars['title'], $pars['description'],$pars['date'],$pars['address'],$pars['lat'],$pars['lon'],$pars['public'])) {
            return Writer::jsonOutput($response, 422, ["message" => 'Attribut nom non existant']);
        }

        try{
            $event =  new Event;
            $event->id =  Uuid::uuid4();
            $event->creator_id = $token->upr->id;
            $event->title = filter_var($pars['title'],FILTER_SANITIZE_STRING);
            $event->description = filter_var($pars['description'],FILTER_SANITIZE_STRING);
            $date = strtotime(filter_var($pars['date'], FILTER_SANITIZE_STRING));
            $event->date = date('y-m-d H:i:s', $date);
            $event->address = filter_var($pars['address'],FILTER_SANITIZE_STRING);
            $event->lat = $pars['lat'];
            $event->lon = $pars['lon'];
            if($pars['public'] == "true"){
                $event->public = 1;
            } else {
                $event->public = 0;
            }
            $event->save();

        } catch (\Exception $e) {
            return Writer::jsonOutput($response, 200, ['message' => $e]);
        }
        return Writer::jsonOutput($response, 200, ['event' => $event]);
    }
    /**
     * Fonction d'envoi du choix d'un utilisateur à un événement
     *
     * Cette fonction permet de renseigner dans la base de donnée le choix de l'utilisateur à un événement,
     * si il participera ou non à l'événement. Cette fonction est utilisable uniquement si c'est la première fois
     * que l'utilisateur souhaite faire son choix
     *
     *
     * A renseigner
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function postChoice (Request $request, Response $response, $args): Response
    {
        $pars = $request->getParsedBody();

        $tokenstring = sscanf($request->getHeader('Authorization')[0], "Bearer %s")[0];
        $token = JWT::decode($tokenstring, new Key($this->c['secret'], 'HS512'));

        $user = User::with('events')->find($token->upr->id);
        $user->events()->attach($args['event_id'],['choice'=> $pars['choice']]);

        return Writer::jsonOutput($response, 200, ['message' => 'created']);
    }

    /**
     * Fonction d'envoi du changement de choix déjà renseigné d'un utilisateur à un événement
     *
     * Cette fonction permet de renseigner dans la base de donnée le choix de l'utilisateur à un événement,
     * si il participera ou non à l'événement. Cette fonction modifie le choix de l'utilisateur
     *
     * A renseigner
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function putChoice (Request $request, Response $response, $args): Response
    {
        $pars = $request->getParsedBody();

        $tokenstring = sscanf($request->getHeader('Authorization')[0], "Bearer %s")[0];
        $token = JWT::decode($tokenstring, new Key($this->c['secret'], 'HS512'));

        $user = User::with('events')->find($token->upr->id);
        $user->events()->updateExistingPivot($args['event_id'],array('choice' => $pars['choice']),false);

        return Writer::jsonOutput($response, 200, ['message' => 'created']);
    }

    /**
     * Fonction permettant de poster un message sur un événement
     *
     * Cette fonction permet de renseigner dans la base de donnée un message envoyé par un utilisateur dans un
     * événement donné. Un message pouvant être envoyé seulement par un utilisateur connecté, on regarde dans le token envoyé
     * pour connaitre l'id de l'auteur du message.
     *
     * A renseigner
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function postMessage (Request $request, Response $response, $args): Response
    {
        $pars = $request->getParsedBody();

        $tokenstring = sscanf($request->getHeader('Authorization')[0], "Bearer %s")[0];
        $token = JWT::decode($tokenstring, new Key($this->c['secret'], 'HS512'));

        $user = User::with('messages')->find($token->upr->id);
        $user->messages()->attach($args['eventId'],['content'=> $pars['content'], 'date' => date('y-m-d H:i:s')]);

        return Writer::jsonOutput($response, 200, ['message' => 'created']);
    }
}
