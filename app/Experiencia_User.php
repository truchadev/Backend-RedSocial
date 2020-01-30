<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experiencia_User extends Model
{
    public function ciudades(){
        return $this->belongsTo('App\Ciudads');
    }

    public function users(){
        return $this->hasMany('App\Users');
    }
}
