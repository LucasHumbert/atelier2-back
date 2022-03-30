<?php

namespace reu\backoffice\app\controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\backoffice\app\model\Event;
use reu\backoffice\app\model\User;
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

class HomeController
{
    /**
     * Fonction permettant de poster un message sur un événement
     *
     * Cette fonction permet de renseigner dans la base de donnée un message envoyé par un utilisateur dans un
     * événement donné. Un message pouvant être envoyé seulement par un utilisateur connecté, on regarde dans le token envoyé
     * pour connaitre l'id de l'auteur du message.
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function getInfos(Request $request, Response $response): Response
    {
        $users = User::all();
        $usersCount = count($users);

        $events = Event::all();
        $eventsCount = count($events);

        $messagesCount = 0;
        foreach ($users as $user) {
            $messagesCount += count($user->messages);
        }

        return Writer::jsonOutput($response, 200, ['nbUsers' => $usersCount, 'nbEvents' => $eventsCount, 'nbMessages' => $messagesCount]);
    }
}
