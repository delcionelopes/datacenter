<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{    
    protected $table = 'manuais';    
    protected $fillable =
    [        
        'data_criacao',
        'data_atualizacao',
        'descricao',
        'objetivo',
        'manual',
        'area_conhecimento_id',
        'usuario',   
    ];

    public function area_conhecimento()
    {
        return $this->belongsTo(Area_Conhecimento::class,'area_conhecimento_id','id');
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }
}
