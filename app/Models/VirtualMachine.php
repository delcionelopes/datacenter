<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VirtualMachine extends Model
{
    protected $table = 'virtual_machine';    
    protected $fillable = [
        'nome_vm',
        'cpu',
        'memoria',
        'disco',
        'ip',
        'resource_pool',        
        'sistema_operacional',
        'gatway',
        'ambiente_id',
        'orgao_id',
        'cluster_id',
        'projeto_id',
        'cluster',
        'senha',
        'validade',
        'val_indefinida',
        'criador_id',
        'alterador_id',
    ];
    public function clusterref():BelongsTo{
        return $this->belongsTo(Cluster::class,'cluster_id','id');
    }    
    public function ambiente():BelongsTo{
        return $this->belongsTo(Ambiente::class,'ambiente_id','id');
    }
    public function orgao():BelongsTo{
        return $this->belongsTo(Orgao::class,'orgao_id','id');
    }
    public function projeto():BelongsTo{
        return $this->belongsTo(Projeto::class,'projeto_id','id');
    }
    public function vlans():BelongsToMany{
        return $this->belongsToMany(Vlan::class,'vm_vlan','virtual_machine_id','vlan_id');
    }
    public function bases(){
        return $this->hasMany(Base::class);
    }

    public function users():BelongsToMany{
        return $this->belongsToMany(User::class,'virtual_machine_has_users','virtual_machine_id','user_id')->withPivot(['users.name']);
    }
    
}
