<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudio_User extends Model
{
    public function ciudades(){
        return $this->belongsTo('App\Ciudads');
    }
}
