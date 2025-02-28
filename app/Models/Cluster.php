<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cluster extends Model
{    
    protected $table = 'cluster';   
    protected $fillable = [        
        'nome_cluster',
        'total_memoria',
        'total_processador',      
    ];

    public function hosts():HasMany{
        return $this->hasMany(Host::class);
    }
    public function virtual_machines():HasMany{
        return $this->hasMany(VirtualMachine::class,'id','cluster_id');
    }
}
