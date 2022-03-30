<?php

namespace reu\event\app\controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use reu\event\app\model\Event;
use reu\event\app\model\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\event\app\utils\Writer;
use Slim\Container;

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
    private $c;

    public function __construct(Container $c)
    {
        $this->c = $c;
    }

    /**
     * Fonction de récupération d'un utilisateur.
     *
     * Cette fonction permet de récupérer un utilisateur si et seulement si le token d'authorisation appartient à ce dernier.
     *
     * @param Request $request GET avec un header Authorization de type Bearer et en id l'id de l'utilisateur à récuperer.
     * @param Response $response
     * @param $args
     * @return Response Retourne une 200 avec les informations de l'utilisateurs.
     */
    public function getUser(Request $request, Response $response, $args): Response
    {
        try {
            $tokenstring = sscanf($request->getHeader('Authorization')[0], "Bearer %s")[0];
            $token = JWT::decode($tokenstring, new Key($this->c['secret'], 'HS512'));
            if($token->upr->id !== $args['id']){
                return Writer::jsonOutput($response, 401, ['error' => 'Unauthorized']);
            }
        }
        catch (\Exception $e){
            return Writer::jsonOutput($response, 403, ['message' => $e->getMessage()]);
        }
        try {
            $user = User::with('messages')->find($args['id'],['firstname', 'lastname']);
        }
        catch (ModelNotFoundException $e) {
            return Writer::jsonOutput($response, 404, ['message' => 'Utilisateur introuvable']);
        }
        return Writer::jsonOutput($response, 200, ['user' => $user]);
    }

    /**
     * Fonction de modification d'un utilisateur.
     *
     * Cette fonction permet de modifier les informations d'un utilisateur si et seulement si le token d'authorisation appartient à ce dernier.
     * Filtrage des paramètres passés dans le body de la requête.
     *
     * @param Request $request PUT avec dans le body le firstname et le lastname ainsi que le token envoyé en bearer.
     * @param Response $response
     * @param $args
     * @return Response Renvoie une 200 avec un message de confirmation de la modification de l'utilisateur.
     */
    public function putUser(Request $request, Response $response, $args): Response
    {
        try {
            $pars = $request->getParsedBody();
            $tokenstring = sscanf($request->getHeader('Authorization')[0], "Bearer %s")[0];
            $token = JWT::decode($tokenstring, new Key($this->c['secret'], 'HS512'));
            if($token->upr->id !== $args['id']){
                return Writer::jsonOutput($response, 401, ['error' => 'Unauthorized']);
            }
        }
        catch (\Exception $e){
            return Writer::jsonOutput($response, 403, ['message' => $e->getMessage()]);
        }
        try {
            $user = User::find($args['id']);
            $user->firstname = filter_var($pars['firstname'],FILTER_SANITIZE_STRING);
            $user->lastname = filter_var($pars['lastname'],FILTER_SANITIZE_STRING);
            $user->save();
        }
        catch (\Exception $e) {
            return Writer::jsonOutput($response, $e->getCode(), ['message' => $e->getMessage()]);
        }
        return Writer::jsonOutput($response, 200, ['message' => 'User updated']);
    }

    /**
     * Fonction de récupération des évènements et le choix où est l'utilisateur via son id passé en paramètre.
     *Cette fonction retourne les évènements si et seulement si le token d'authorisation appartient à l'utilisateur.
     *
     * @param Request $request On envoie un token dans un header authorization au format bearer avec dans l'url le id de l'utilisateur.
     * @param Response $response
     * @param $args
     * @return Response Retourne une 200 suivis d'un tableau d'event.
     */
    public function getUsersEvents(Request $request, Response $response, $args)
    {
        try {
            $tokenstring = sscanf($request->getHeader('Authorization')[0], "Bearer %s")[0];
            $token = JWT::decode($tokenstring, new Key($this->c['secret'], 'HS512'));
            if($token->upr->id !== $args['id']){
                return Writer::jsonOutput($response, 401, ['error' => 'Unauthorized']);
            }
        }
        catch (\Exception $e){
            return Writer::jsonOutput($response, 403, ['message' => $e->getMessage()]);
        }
        try {
            $user = User::with('events')
                ->where('id','=',$args['id'])
                ->first();
            $res = [];
            foreach($user->events as $event_utilisateur){
                $event = Event::find($event_utilisateur->pivot->event_id);
                $event['choice'] = $event_utilisateur->pivot->choice;
                $res[] = $event;
            }

        } catch (ModelNotFoundException $e) {

            return Writer::jsonOutput($response, 404, ['message' => 'Events introuvable']);
        }

        return Writer::jsonOutput($response, 200, ['events' => $res]);
    }
}
