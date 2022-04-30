<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Educational_level extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    //relacion de muchos a muchos
    public function material(){
        return $this->hasMany('App\Models\Material_Educational_Level','educational_level_id','id');
    }
}

