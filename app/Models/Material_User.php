<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material_User extends Model
{
    use HasFactory;
    protected $fillable = [
        'manejo_users',
        'detalle_material',
        'date_download',
        'material_id',
        'users_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function material(){
        return $this->belongsTo('App\Material','material_id','id');
    }

}
