<?php

namespace reu\backoffice\app\controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use reu\backoffice\app\model\Event;
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

class UserController
{
    /**
     * Fonction de récupération des utilisateurs
     *
     * Cette fonction permet de récuperer les utilisateurs du site.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getUsers(Request $request, Response $response): Response
    {
        $users = User::all();
        foreach ($users as $user) {
            if(strtotime(date("Y-m-d H:i:s")) - (strtotime($user->updated_at)) > (86400*365)){
                $user->inactive = 1;
            }
            else{
                $user->inactive = 0;
            }
        }

        return Writer::jsonOutput($response, 200, ['users' => $users]);
    }

    public function getUser(Request $request, Response $response, $args): Response
    {
        $user = User::find($args['id']);
        if(strtotime(date("Y-m-d H:i:s")) - (strtotime($user->updated_at)) > (86400*365)){
            $user->inactive = 1;
        }
        else{
            $user->inactive = 0;
        }

        $events = Event::where('creator_id', '=', $args['id'])->get();

        foreach ($events as $event) {
            $event->inactive = 0;

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

        return Writer::jsonOutput($response, 200, ['user' => $user, 'events' => $events]);
    }

    public function deleteUser(Request $request, Response $response, $args): Response {
        $user = User::find($args['id']);
        $events = Event::where('creator_id', '=', $args['id'])->get();
        $user->events()->wherePivot('user_id', '=', $args['id'])->detach();
        $user->messages()->wherePivot('user_id', '=', $args['id'])->detach();
        foreach ($events as $event) {
            $event->delete();
        }
        $user->delete();

        $response = $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        $response->getBody()->write(json_encode(['response' => 'User deleted']));
        return $response;
    }
}
