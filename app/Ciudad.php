<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Ciudad extends Model
{

    public function users(){
        return $this->hasMany('App\Users');
    }

    public function empresas(){
        return $this->hasMany('App\Empresa');
    }

    public function ofertas(){
        return $this->hasMany('App\Empresa');
    }

    public function estudios_users(){
        return $this->hasMany('App\Empresa');
    }

    public function experiencias_users(){
        return $this->hasMany('App\Empresa');
    }
}
