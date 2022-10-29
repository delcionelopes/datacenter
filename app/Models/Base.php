<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $table = 'bases';
    protected $fillable = [
        'nome_base',
        'ip',
        'dono',
        'encoding',
        'virtual_machine_id',
        'projetos_id',
        'senha',
        'validade',
        'val_indefinida',
        'criador_id',
        'alterador_id',
    ];

    public function virtualmachine(){
        return $this->belongsTo(VirtualMachine::class);
    }

    public function projeto(){
        return $this->belongsTo(Projeto::class);
    }

    public function apps()
    {
        return $this->hasMany(App::class);
    }
    
    public function users(){
        return $this->belongsToMany(User::class,'bases_has_users','base_id','user_id');
    }
}
