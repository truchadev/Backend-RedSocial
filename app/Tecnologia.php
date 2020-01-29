<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tecnologia extends Model
{
    public function users(){
        return $this->belongsToMany('App\Users');
    }

    public function ofertas(){
        return $this->belongsToMany('App\Ofertas', 'ofertas__tecnologias', 'oferta_id', 'tecnologia_id');
    }

}
