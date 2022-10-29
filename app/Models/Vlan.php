<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vlan extends Model
{    
    protected $table = 'vlan';   
    protected $fillable = [
        'nome_vlan',
        'senha',
        'validade',
        'val_indefinida',
        'criador_id',
        'alterador_id',       
    ];

    public function virtual_machines(){
        return $this->belongsToMany(VirtualMachine::class,'vm_vlan','vlan_id','virtual_machine_id');
    }    
    public function redes(){
        return $this->hasMany(Rede::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'vlan_has_users','vlan_id','user_id');
    }
}
