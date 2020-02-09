<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Ciudad extends Model
{

    public function users(){
        return $this->hasMany('App\User');
    }

    public function empresas(){
        return $this->hasMany('App\Empresa');
    }

    public function ofertas(){
        return $this->hasMany('App\Oferta');
    }

    public function estudios_users(){
        return $this->hasMany('App\Estudio_User');
    }

    public function experiencias_users(){
        return $this->hasMany('App\Experiencia_User');
    }
}
