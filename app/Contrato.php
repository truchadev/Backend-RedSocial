<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    public function ofertas(){
        return $this->hasMany('App\Oferta');
    }
}
