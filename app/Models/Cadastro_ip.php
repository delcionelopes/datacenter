<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadastro_ip extends Model
{    
    protected $table = 'cadastro_ip';   
    protected $fillable = [
        'rede_id',
        'ip',
        'status',
        'created_at',
        'updated_at',
        'orgao_vinc_id',
        'setor_vinc_id',
        'mac',
        'descricao',
    ];
    public function rede(){
        return $this->belongsTo(Rede::class,'rede_id','id');
    }

    public function setor(){
        return $this->belongsTo(Setor_Vinc::class,'setor_vinc_id');
    }

    public function orgaovinc(){
        return $this->belongsTo(Orgao::class,'orgao_vinc_id');
    }

}
