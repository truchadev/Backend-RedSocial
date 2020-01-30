<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oferta_User extends Model
{
    public function estados(){
        return $this->belongsTo('App\Estados');
    }
}
