<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material_Educational_level extends Model
{
    use HasFactory;
    protected $fillable = [
        'material_id',
        'educational_level_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function material(){
        return $this->belongsTo('App\Material','material_id','id');
    }
    public function educational_level(){
        return $this->belongsTo('App\Educational_Level','educational_level_id','id');
    }
}

