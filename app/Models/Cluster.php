<?php

namespace App\Models;

use App\models\Host;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{    
    protected $table = "cluster";
    public $timestamps = FALSE;
    protected $fillable = [
        'nome_cluster',
        'total_memoria',
        'total_processador',
        'created_at',
        'updated_at',
    ];

    public function hosts(){
        return $this->hasMany(Host::class);
    }
    public function virtual_machines(){
        return $this->hasMany(VirtualMachine::class);
    }
}
