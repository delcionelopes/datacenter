<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenhaVLAN extends Model
{
    use HasFactory;
    protected $table = 'senhavlan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'vlan_id',
        'senha',
        'validade',
        'val_indefinida',
        'criador_id',
        'alterador_id',        
    ];

    public function vlan(){
        return $this->belongsTo(Vlan::class,'vlan_id');
    }

    public function criador(){
        return $this->belongsTo(User::class,'criador_id');        
    }

    public function alterador(){
        return $this->belongsTo(User::class,'alterador_id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'senhavlan_users','senhavlan_id','user_id');
    }
}
