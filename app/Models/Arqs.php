<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arqs extends Model
{
    use HasFactory;
    protected $table = "arqs";
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'setor_idsetor',
        'area_conhecimento_id',
        'nomereal',
        'rotulo',
        'caminho',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function setores(){
         return $this->belongsTo(Setor::class,'setor_idsetor');
    }

    public function areaconhecimento(){
        return $this->belongsTo(Area_Conhecimento::class,'area_conhecimento_id');
    }


}
