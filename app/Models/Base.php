<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $table = "bases";
    public $timestamps = FALSE;
    protected $fillable = [
        'nome_base',
        'ip',
        'dono',
        'encoding',
        'virtual_machine_id',
        'projetos_id',
        'created_at',
        'updated_at',
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
}
