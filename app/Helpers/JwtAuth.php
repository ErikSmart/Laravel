<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\Usuario;

/**
 *
 */
class JwtAuth
{
    public $key;
    public function __construct()
    {
        $this->key = 'esta-es-la-clave';
    }

    public function signup($email, $password, $getToken=null)
    {
        $user = Usuario::where(array(
      'email' => $email,
      'password' => $password
    ))->first();


        $signup = false;
        if (is_object($user)) {
            $signup = true;
        }

        if ($signup) {
            $token = array(
      'sub' => $user->id,
      'email' => $user->email,
      'nombre' => $user->nombre,
      'apellido' => $user->apellido,
      'iat' => time(),
      'exp' => time()+(7*24*60*60)
      );
            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key, array('HS256'));
            if (is_null($getToken)) {
                return $jwt;
            } else {
                return $decoded;
            }
        } else {
            return array('status' => 'error', 'message' => 'Login a fallado');
        }
    }

    public function checkToken($jwt, $getIdentity = false)
    {
        $auth = false;

        try {
            $decoded = JWT::decode($jwt, $this->key, array('HS256'));
        } catch (\UnexpectedValueException $e) {
            $auth = false;
        } catch (\DomainException $e) {
            $auth=false;
        }

        if (isset($decoded) && is_object($decoded) && isset($decoded->sub)) {
            $auth = true;
        } else {
            $auth = false;
        }
        if ($getIdentity) {
            return $decoded;
        }
        return $auth;
    }
}
