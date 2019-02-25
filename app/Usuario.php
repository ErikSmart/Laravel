<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
  protected $table = 'usuarios';


  protected $fillable = [
      'id','nombre', 'email', 'password', 'role', 'apellido', 'remeber_token', 'created_at', 'updated_at'
  ];
}
