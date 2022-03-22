<?php

namespace reu\auth\app\middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\auth\app\utils\Writer;

class CORS
{
    public function corsHeaders(Request $rq,
                                Response $rs,
                                callable $next ): Response {
        if (! $rq->hasHeader('Origin'))
            return Writer::jsonOutput($rs, 401, ["missing Origin Header (cors)"]);
        $response = $next($rq,$rs);
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', 'http://myapp.net')
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET' )
            ->withHeader('Access-Control-Allow-Headers','Authorization' )
            ->withHeader('Access-Control-Max-Age', 3600)
            ->withHeader('Access-Control-Allow-Credentials', 'true');
        return $response;
    }
}