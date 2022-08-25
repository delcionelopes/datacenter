<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area_Conhecimento extends Model
{    
    protected $table = 'area_conhecimento';
    public $timestamps = FALSE;
    protected $fillable = 
    [
        'descricao',
        'created_at',
        'updated_at',
    ];

    public function sub_area_conhecimento()
    {
        return $this->hasMany(Sub_Area_Conhecimento::class,'id','area_conhecimento_id');
    }

    public function manual()
    {
        return $this->hasMany(Manual::class,'id','area_conhecimento_id');
    }    
}
