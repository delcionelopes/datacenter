<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setor_Vinc extends Model
{
    use HasFactory;
    protected $table = 'setor_vinc';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'orgao_id',
        'sigla',
        'descricao',
        'created_at',
        'updated_at',
    ];

    public function orgao_vinc(){
        return $this->belongsTo(Orgao::class,'orgao_id');
    }

    public function ips(){
        return $this->hasMany(Cadastro_ip::class,'id','setor_vinc_id');
    }

    public function equipamentos(){
        return $this->hasMany(EquipamentoRede::class,'id','setor_vinc_id');
    }


}
