<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    //add fo activation and notifications
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'puesto', 'ciudad_id', 'salario_min', 'salario_max', 'descripcion', 'experiencia_min', 'empresa_id', 'estudios_min_id', 'tipo_contrato_id', 'tipo_jornada_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function users(){
        return $this->belongsToMany('App\Users');
    }

    public function tecnologias(){
        return $this->belongsToMany('App\Tecnologias', 'ofertas__tecnologias', 'tecnologia_id', 'oferta_id');
    }

    public function ciudades(){
        return $this->belongsTo('App\Ciudads');
    }

    public function contratos(){
        return $this->belongsTo('App\Contratos');
    }

    public function estudios(){
        return $this->belongsTo('App\Estudios');
    }

    public function j_laborales(){
        return $this->belongsTo('App\J_Laborals');
    }

    public function empresas(){
        return $this->belongsTo('App\Emprsas');
    }


}
