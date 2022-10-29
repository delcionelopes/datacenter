<?php

namespace App\models;

use App\Models\Cluster;
use App\Models\SenhaHost;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function cluster(){
        return $this->belongsTo(Cluster::class,'cluster_id','id');
    }

    public function senhahost(){
        return $this->hasMany(SenhaHost::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'hosts_has_users','host_id','user_id');
    }
}
