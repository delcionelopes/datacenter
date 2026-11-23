<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    use HasFactory;
    protected $table = 'setor';
    protected $primaryKey = 'idsetor';
    protected $fillable = [
        'idsetor',
        'sigla',
        'nome',
        'created_at',
        'updated_at',
        ];

    public function equipamentos(){
        return $this->hasMany(EquipamentoRede::class);
    }

    public function users(){
        return $this->hasMany(User::class,'setor_id','idsetor');
    }

    public function areas(){
        return $this->belongsToMany(Area_Conhecimento::class,'area_conhecimento_has_setor','setor_idsetor','area_conhecimento_id')
                    ->withPivot('setor_idsetor','area_conhecimento_id')
                    ->orderBy('area_conhecimento_id');
    }
}
