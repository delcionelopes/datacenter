<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{    
    protected $table = 'manuais';
    public $timestamps = FALSE;
    protected $fillable =
    [        
        'data_criacao',
        'data_atualizacao',
        'descricao',
        'objetivo',
        'manual',
        'area_conhecimento_id',
        'usuario',        
        'created_at',
        'updated_at',
    ];

    public function area_conhecimento()
    {
        return $this->belongsTo(Area_Conhecimento::class,'area_conhecimento_id','id');
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class,'manual_id');
    }
}
