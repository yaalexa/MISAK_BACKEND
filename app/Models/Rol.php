<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table="rols";
    protected $fillable = [
        'name',
        
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ]; 

    //Relacion de muchos a uno 
    public function user(){
        return $this->hasMany('App\User','user_id','id');
    }
}
