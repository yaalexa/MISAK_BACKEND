<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_Material extends Model
{
    use HasFactory;
    protected $table="type__materials";
    
    protected $fillable =[
        'name'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
     // relacion de uno a muchos 
     public function material(){
        return $this->BelongsTo('App\Material','type_material_id','id');
    }
}

