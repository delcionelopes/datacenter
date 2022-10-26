<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenhaVM extends Model
{
    use HasFactory;
    protected $table = 'senhavm';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'virtual_machine_id',
        'senha',
        'validade',
        'val_indefinida',
        'criador_id',
        'alterador_id',
    ];

    public function virtual_machine(){
        return $this->belongsTo(VirtualMachine::class,'virtual_machine_id');
    }

    public function criador(){
        return $this->belongsTo(User::class,'criador_id');
    }

    public function alterador(){
        return $this->belongsTo(User::class,'alterador_id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'senhavm_users','senhavm_id','user_id');
    }
}
