<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento_Grupo extends Model
{
    use HasFactory;
    protected $table = 'equipamento_grupo';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'sigla',
        'descricao',
        'ico',
        'created_at',
        'updated_at',
    ];

    public function equipamento(){
        return $this->hasMany(EquipamentoRede::class);
    }
}
