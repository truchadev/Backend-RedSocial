<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
//add fo activation and notifications
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    //add fo activation and notifications
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'activation_token', 'ciudad_id','ciudad_id'
                ,'tecnologia_id'
                ,'estudios_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'remember_token', 'activation_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ofertas(){
        return $this->belongsToMany('App\Ofertas');
    }

    public function tecnologias(){
        return $this->belongsToMany('App\Tecnologias');
    }

    public function ciudades(){
        return $this->belongsTo('App\Ciudads');
    }

    public function estudios(){
        return $this->belongsToMany('App\Estudios');
    }

    public function experiencias(){
        return $this->belongsTo('App\Experiencia_Users');
    }
}
