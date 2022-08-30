<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rede extends Model
{    
    protected $table = 'rede';    
    protected $fillable = [
        'nome_rede',
        'mascara',
        'tipo_rede',
        'vlan_id',     
    ];

    public function vlan(){
        return $this->belongsTo(Vlan::class,'vlan_id','id');
    }
    public function cadastro_ips(){
        return $this->hasMany(Cadastro_ip::class);
    }
}
