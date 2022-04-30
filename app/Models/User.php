<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'full_name',
        'document_type',
        'document_number',
        'certificate_misak',
        'email',
        'password',
        'rol_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'remember_token'
    ];


    // relacion de muchos a uno
    public function rol(){
        return $this->hasMany('App\Rol','user_id','id');
    }
    //relacion de muchos a muchos
    public function material(){
        return $this->hasMany('App\Models\Material_User','material_id','id');
    }
}


   


   

