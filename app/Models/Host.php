<?php

namespace App\models;

use App\Models\Cluster;
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
    ];

    public function cluster(){
        return $this->belongsTo(Cluster::class,'cluster_id','id');
    }
}
