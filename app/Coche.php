<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coche extends Model
{
    protected $table = 'coches';

    public function usuario()
    {
      return $this->belongsTo('App\Usuario','user_id');
    }
}
