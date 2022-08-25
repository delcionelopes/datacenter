<?php

namespace App\models;

use App\Models\Cluster;
use Illuminate\Database\Eloquent\Model;

class Host extends Model
{    
    protected $table = 'hosts';
    public $timestamps = FALSE;
    protected $fillable = [
        'cluster_id',
        'obs_host',
        'ip',
        'datacenter',
        'cluster',
        'created_at',
        'updated_at',
    ];

    public function cluster(){
        return $this->belongsTo(Cluster::class,'cluster_id','id');
    }
}
