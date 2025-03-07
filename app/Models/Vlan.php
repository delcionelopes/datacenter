<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function virtual_machines():BelongsToMany{
        return $this->belongsToMany(VirtualMachine::class,'vm_vlan','vlan_id','virtual_machine_id');
    }    
    public function redes(){
        return $this->hasMany(Rede::class,'id','vlan_id');
    }

    public function users():BelongsToMany{
        return $this->belongsToMany(User::class,'vlan_has_users','vlan_id','user_id')->withPivot(['users.name']);
    }
}
