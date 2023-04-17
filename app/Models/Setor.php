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
        return $this->hasMany(User::class);
    }
}
