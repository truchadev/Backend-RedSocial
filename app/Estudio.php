<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    public function users(){
        return $this->belongsToMany('App\Users');
    }

    public function ofertas(){
        return $this->hasMany('App\Ofertas');
    }
}
