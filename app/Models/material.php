<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table="materials";
    protected $fillable =[
        'name',
        'isbn',
        'year',
        'num_pages',
        'priority',
        'pdf',
        'img',
        'type_material_id',
        'editorial_id',
        'area_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function scopeFiltroPorTituloYAutor($query, $filtro)
    {
        if( !empty( $filtro) ) {
            $query->where('name', 'LIKE', '%'.$filtro.'%');  
        }
    }
    //relacion de muchos a muchos
    public function author(){
        return $this->hasMany('App\Models\Author_Material','author_id','id');
    }

    //relacion de muchos a muchos
    public function educational_level(){
        return $this->hasMany('App\Models\Material_Educational_level','educational_level_id','id');
    }
     //relacion de muchos a muchos
     public function user(){
        return $this->hasMany('App\Models\Material_User','user_id','id');
    }

    //Relacion de muchos a uno 
    public function Type_materila(){
        return $this->hasMany('App\Type_Material','type_material_id','id');
    }
    //Relacion de muchos a uno 
    public function editorial(){
        return $this->hasMany('App\Editorial','editorial_id','id');
    }
    //Relacion de muchos a uno 
    public function area(){
        return $this->hasMany('App\Area','area_id','id');
    }
}

