<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rede extends Model
{    
    protected $table = 'rede';    
    protected $fillable = [
        'nome_rede',
        'mascara',
        'tipo_rede',
        'vlan_id',     
    ];

    public function vlan():BelongsTo{
        return $this->belongsTo(Vlan::class,'vlan_id','id');
    }
    public function cadastro_ips(){
        return $this->hasMany(Cadastro_ip::class);
    }
}
