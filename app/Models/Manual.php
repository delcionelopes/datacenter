<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{    
    protected $table = 'manuais';    
    protected $fillable =
    [        
        'descricao',
        'objetivo',
        'manual',
        'area_conhecimento_id',
        'setor_id',
        'usuario',
        'created_at',
        'updated_at',
    ];

    public function area_conhecimento()
    {
        return $this->belongsTo(Area_Conhecimento::class,'area_conhecimento_id');
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class,'manual_id');
    }

    public function setor(){
        return $this->belongsTo(Setor::class,'setor_id');
    }
}
