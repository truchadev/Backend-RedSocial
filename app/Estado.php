<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public function oferta(){
        return $this->hasMany('App\Estados');
    }
}
