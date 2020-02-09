<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tecnologia extends Model
{
    public function users(){
        return $this->hasMany('App\User');
    }

    public function ofertas(){
        return $this->hasMany('App\Oferta');
    }

}
