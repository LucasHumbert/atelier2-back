<?php

namespace reu\auth\app\utils;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * Class Writer
 *
 * @author HUMBERT Lucas
 * @author BUDZIK Valentin
 * @author HOUQUES Baptiste
 * @author LAMBERT Calvin
 * @package reu\auth\app\utils
 *
 */
class Writer {

    /**
     * Fonction décriture de réponse
     *
     * La fonction permet d'écrire la réponse plus facilement. On peut lui passes les différents paramètre et elle se charge de tranformer la fonction en JSON.
     *
     * @param Response $resp
     * @param int $code
     * @param array $data
     * @param array $headers
     * @return Response
     */
    public static function jsonOutput(Response $resp, int $code, array $data = [], array $headers = []) : Response {

        $data_json = json_encode($data);

        $resp = $resp->withStatus($code);
        $resp = $resp->withHeader('Content-Type', 'application/json;charset=utf-8');

        if(!empty($headers)) {
            foreach($headers as $header) {
                $resp = $resp->withHeader($header[0], $header[1]);
            }
        }

        $resp->getBody()->write($data_json);

        return $resp;
    }
}
