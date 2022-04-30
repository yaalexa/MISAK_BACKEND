<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author_Material extends Model
{
    use HasFactory;

    protected $fillable =[
        'author_id',
        'material_id'

    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function author(){
        return $this->belongsTo('App\Author','author_id','id');
    }
    public function material(){
        return $this->belongsTo('App\Material','material_id','id');
    }
    
}


