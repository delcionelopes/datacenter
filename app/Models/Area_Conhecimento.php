<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area_Conhecimento extends Model
{    
    protected $table = 'area_conhecimento'; 
    protected $fillable = 
    [
        'id',
        'descricao',
        'created_at',
        'updated_at',
    ];

    public function Arquivos(){
        return $this->hasMany(Arqs::class);
    }

    public function Setores(){
        return $this->belongsToMany(Setor::class,'area_conhecimento_has_setor','area_conhecimento_id','setor_idsetor')
                    ->withPivot('area_conhecimento_id','setor_idsetor')
                    ->orderBy('area_conhecimento_id');
    }
        
}
