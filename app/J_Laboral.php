<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class J_Laboral extends Model
{
    public function oferta(){
        return $this->hasMany('App\Ofertas');
    }
}
