<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use Illuminate\Support\Facades\DB;
use App\Helpers\JwtAuth;

class UsuariosController extends Controller
{
    public function registro(Request $request)
    {
      $json = $request->input('json',null);
      $params = json_decode($json);

      $email =  $params->email ;
      $nombre =  $params->nombre ;
      $apellido =  $params->apellido ;
      $role = 'ROLE_USER';
      $password =  $params->password ;
      if (!is_null($email) && !is_null($password) && !is_null($nombre)) {
        $user = new Usuario();
        $user->email = $email;
        $user->nombre = $nombre;
        $user->apellido=$apellido;
        $user->role = $role;

        $pwd = hash('sha256',$password);
        $user->password = $pwd;

        $isset_user= Usuario::where('email', $email)->first();
        if (count($isset_user)==0) {
          $user->save();
          $data = array('status' => 'ok','code' => 200, 'message' => 'Usuario registrado correctamente');
        }else {
          $data = array('status' => 'error','code' => 400, 'message' => 'Usuario duplicado', 'dato' => count($isset_user));
        }

      }else {
        $data = array('status' => 'error','code' => 400, 'message' => 'Usuario no creado');
      }
      return response()->json($data,200);
    }
    public function login(Request $request)
    {
      $jwtAuth = new JwtAuth();
      $json = $request->input('json',null);
      $params = json_decode($json);

      $email = (!is_null($json) && isset($params->email)) ? $params->email: null;
      $password =  (!is_null($json) && isset($params->password)) ? $params->password: null;
      $getToken = (!is_null($json) && isset($params->gettoken)) ? $params->gettoken: null;
      $pwd = hash('sha256',$password);
      if (!is_null($email) && !is_null($password)) {
        $signup = $jwtAuth->signup($email,$pwd);
        return response()->json($signup,200);
      }
    }
}
