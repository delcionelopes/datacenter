<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area_conhecimento_has_setor extends Model
{
    use HasFactory;
    protected $table = 'area_conhecimento_has_setor';
    protected $fillable = [
        'setor_idsetor',
        'area_conhecimento_id',
        'created_at',
        'updated_at',
    ];

    public function setores(){
        return $this->belongsTo(Setor::class,'setor_idsetor');
    }

    public function areaconhecimento(){
        return $this->belongsTo(Area_Conhecimento::class,'area_conhecimento_id');
    }

}
