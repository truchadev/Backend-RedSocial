<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    public function users(){
        return $this->belongsToMany('App\Users');
    }

    public function tecnologias(){
        return $this->belongsToMany('App\Tecnologias', 'ofertas__tecnologias', 'tecnologia_id', 'oferta_id');
    }

}
