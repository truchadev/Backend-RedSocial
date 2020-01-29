<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ofertas_Tecnologia extends Model
{
//add fo activation and notifications
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'oferta_id', 'tecnologia_id'
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
}
