<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table="rols";
    protected $fillable = [
        'name'
        // 'user_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ]; 

    //Relacion de uno a muchos
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
