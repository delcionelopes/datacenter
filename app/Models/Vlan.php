<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vlan extends Model
{    
    protected $table = 'vlan';
    public $timestamps = FALSE;
    protected $fillable = [
        'nome_vlan',
        'created_at',
        'updated_at',
    ];

    public function virtual_machines(){
        return $this->belongsToMany(VirtualMachine::class,'vm_vlan','vlan_id','virtual_machine_id');
    }    
    public function redes(){
        return $this->hasMany(Rede::class);
    }
}
