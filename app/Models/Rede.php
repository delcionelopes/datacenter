<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rede extends Model
{    
    protected $table = 'rede';
    public $timestamps = FALSE;
    protected $fillable = [
        'nome_rede',
        'mascara',
        'tipo_rede',
        'vlan_id',        
        'created_at',
        'updated_at',
    ];

    public function vlan(){
        return $this->belongsTo(Vlan::class,'vlan_id','id');
    }
    public function cadastro_ips(){
        return $this->hasMany(Cadastro_ip::class);
    }
}
