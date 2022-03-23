<?php

namespace reu\backoffice\app\controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use reu\backoffice\app\model\Event;
use reu\backoffice\app\model\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use reu\backoffice\app\utils\Writer;

class UserController
{
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
}
