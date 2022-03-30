<?php

namespace reu\auth\app\controller;


use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;
use reu\auth\app\model\User;
use reu\auth\app\utils\Writer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

/**
 * Class AuthCOntroller
 *
 * @author HUMBERT Lucas
 * @author BUDZIK Valentin
 * @author HOUQUES Baptiste
 * @author LAMBERT Calvin
 * @package reu\auth\app\controller
 *
 */

class AuthController
{

    private $c;

    /**
     * Constructeur de l'auth controller
     *
     * @param Container $c
     */
    public function __construct(Container $c)
    {
        $this->c = $c;
    }

    /**
     * Fonction de connexion
     *
     * Fonction d'inscription de l'utilisateur à la plateform.
     *
     * @param Request $rq Requête POST avec firstname, lastname, mail, password, confirmpassword
     * @param Response $rs
     * @return Response Retourne L'utilisateur crée
     */
    public function signup(Request $rq, Response $rs): Response
    {
        $bodyParam = $rq->getParsedBody();
        if(empty($bodyParam)){
            return Writer::jsonOutput($rs, 204);
        } else {
            if(isset($bodyParam['firstname'], $bodyParam['lastname'], $bodyParam['mail'], $bodyParam['password'], $bodyParam['confirmpassword'])){
                if($bodyParam['password'] === $bodyParam['confirmpassword']) {
                    $user = new User();
                    $user->id = Uuid::uuid4();
                    $password = password_hash($bodyParam['password'], PASSWORD_DEFAULT);
                    $firstname = filter_var($bodyParam['firstname'], FILTER_SANITIZE_STRING);
                    $lastname = filter_var($bodyParam['lastname'], FILTER_SANITIZE_STRING);
                    $mail = filter_var($bodyParam['mail'], FILTER_SANITIZE_EMAIL);
                    $user->firstname = $firstname;
                    $user->lastname = $lastname;
                    $user->mail = $mail;
                    $user->password = $password;
                    $user->level = 0;
                    $user->save();
                } else {
                    return Writer::jsonOutput($rs, 404, ['error' => 'Incorrect password']);
                }
            } else {
                return Writer::jsonOutput($rs, 404, ['error' => 'Some fiels are missing']);
            }
        }
        return Writer::jsonOutput($rs, 201, ['user' => $user]);
    }

    /**
     * Fonction de vérification du token
     *
     * Permet de récuperer le token afin de regarder ça validité et obtenir des informations sur le compte auquel il est relié
     *
     * @param Request $rq GET Request avec Authorization header où se trouve le token
     * @param Response $rs
     * @param $args
     * @return Response Retourne les informations lié au compte stocké dans le token
     */
    public function checkToken(Request $rq, Response $rs, $args): Response
    {
        if (!$rq->hasHeader('Authorization')) {
            $rs = $rs->withStatus(401)->withHeader('Content-type', 'application/json');
            $rs->getBody()->write(json_encode(
                ['status' => 401, 'message' => 'No autorization header.']
            ));
        } else {
            try {
                $tokenstring = sscanf($rq->getHeader('Authorization')[0], "Bearer %s")[0];
                $token = JWT::decode($tokenstring, new Key($this->c['secret'], 'HS512'));
                $rs->getBody()->write(json_encode(['profile' => $token->upr]));
                $rs = $rs->withStatus(200)->withHeader('Content-type', 'application/json');
            } catch (ExpiredException | SignatureInvalidException | BeforeValidException | \UnexpectedValueException $e) {
                $rs->getBody()->write(json_encode(["error" => $e->getMessage(), 'token' => $tokenstring, 'secret' => $this->c['secret']]));
                $rs = $rs->withStatus(500)->withHeader('Content-type', 'application/json');
            }
        }
        return $rs;
    }

    /**
     * Fonction d'authentification des utilisateurs.
     *
     * Dans cette fonction on envoie les données utilisateurs afin de récupérer le token généré.
     *
     * @param Request $rq GET avec un Authorization header de type BasicAuth
     * @param Response $rs
     * @return Response Retourne le token d'accès, le refresh token ainsi que UUID de l'utilisateur
     * @throws \Exception
     */
    public function authenticate(Request $rq, Response $rs): Response
    {

        if (!$rq->hasHeader('Authorization')) {

            $rs = $rs->withHeader('WWW-authenticate', 'Basic realm="reu_api api" ');
            return Writer::jsonOutput($rs, 401, ['No Authorization header present']);
        };

        $authstring = base64_decode(explode(" ", $rq->getHeader('Authorization')[0])[1]);
        list($email, $pass) = explode(':', $authstring);

        try {

            $user = User::select('id', 'mail', 'firstname', 'lastname', 'password', 'refresh_token', 'level')
                ->where('mail', '=', $email)
                ->firstOrFail();

            if (!password_verify($pass, $user->password))
                throw new \Exception("password check failed");

            unset ($user->password);

        } catch (ModelNotFoundException $e) {
            $rs = $rs->withHeader('WWW-authenticate', 'Basic realm="reu auth" ');
            return Writer::jsonOutput($rs, 401, ['Erreur authentification']);
        } catch (\Exception $e) {
            $rs = $rs->withHeader('WWW-authenticate', 'Basic realm="reu auth" ');
            return Writer::jsonOutput($rs, 401, ['Erreur de mdp']);
        }


        $secret = $this->c['secret'];
        $token = JWT::encode(['iss' => 'http://api.auth.local/auth',
            'aud' => 'http://api.auth.local',
            'iat' => time(),
            'exp' => time() + (12 * 30 * 24 * 3600),
            'upr' => [
                'id' => $user->id,
                'email' => $user->mail,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'level' => $user->level
            ]],
            $secret, 'HS512');

        $user->refresh_token = bin2hex(random_bytes(32));
        $user->save();
        $data = [
            'accessToken' => $token,
            'refreshToken' => $user->refresh_token,
            'user_id' => $user->id
        ];

        return Writer::jsonOutput($rs, 200, $data);


    }

}
