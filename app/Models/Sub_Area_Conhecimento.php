<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_Area_Conhecimento extends Model
{    
    protected $table = 'sub_area_conhecimento';  
    protected $fillable = [
        'area_conhecimento_id',
        'descricao',      
    ];

    public function area_conhecimento()
    {
        return $this->belongsTo(Area_Conhecimento::class,'area_conhecimento_id','id');
    }
}
