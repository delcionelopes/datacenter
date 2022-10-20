<?php

namespace App\Models;

use App\models\Host;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{    
    protected $table = 'cluster';   
    protected $fillable = [
        'nome_cluster',
        'total_memoria',
        'total_processador',      
    ];

    public function hosts(){
        return $this->hasMany(Host::class);
    }
    public function virtual_machines(){
        return $this->hasMany(VirtualMachine::class);
    }
}
