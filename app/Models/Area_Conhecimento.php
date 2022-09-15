<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area_Conhecimento extends Model
{    
    protected $table = 'area_conhecimento'; 
    protected $fillable = 
    [
        'descricao',   
    ];

    public function sub_area_conhecimento()
    {
        return $this->hasMany(Sub_Area_Conhecimento::class,'area_conhecimento_id','id');
    }

    public function manual()
    {
        return $this->hasMany(Manual::class,'area_conhecimento_id','id');
    }    
}
