<?php

namespace reu\backoffice\app\middlewares;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use reu\backoffice\app\model\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use reu\backoffice\app\utils\Writer;
use Slim\Container;

class checkToken
{
    private $c;
    public function __construct(Container $c)
    {
        $this->c = $c;
    }

    public function checkLevel(Request $request, Response $response, callable $next) {

        if(!isset($request->getHeader('Authorization')[0])){
            return Writer::jsonOutput($response, 401, ['message' => 'no authorization header']);
        }

        $tokenstring = sscanf($request->getHeader('Authorization')[0], "Bearer %s")[0];
        $token = JWT::decode($tokenstring, new Key($this->c['secret'], 'HS512'));

        if($token->upr->level < 10) {
            return Writer::jsonOutput($response, 401, ['message' => 'Unauthorized']);
        } else {
            return $next($request, $response);
        }
    }
}
