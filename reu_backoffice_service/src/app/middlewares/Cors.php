<?php

namespace reu\backoffice\app\middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\backoffice\app\utils\Writer;

class Cors
{
    public function corsHeaders(Request $rq,
                                Response $rs,
                                callable $next ): Response {
        if (! $rq->hasHeader('Origin'))
            return Writer::jsonOutput($rs, 401, ["missing Origin Header (cors)"]);
        $response = $next($rq,$rs);
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET' )
            ->withHeader('Access-Control-Allow-Headers','Authorization' )
            ->withHeader('Access-Control-Max-Age', 3600)
            ->withHeader('Access-Control-Allow-Credentials', 'true');
        return $response;
    }
}
