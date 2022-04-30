<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    // relacion de uno a muchos 
    public function material(){
        return $this->BelongsTo('App\Material','editorial_id','id');
    }
}

