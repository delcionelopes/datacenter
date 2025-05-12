<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Host extends Model
{    
    protected $table = 'hosts';   
    protected $fillable = [
        'cluster_id',
        'obs_host',
        'ip',
        'datacenter',
        'cluster',
        'senha',
        'validade',
        'val_indefinida',
        'criador_id',
        'alterador_id',
        'created_at',
        'updated_at',
    ];

    public function clusterref(){
        return $this->belongsTo(Cluster::class);
    }

    public function users():BelongsToMany{
        return $this->belongsToMany(User::class,'hosts_has_users','host_id','user_id');
    }
}
