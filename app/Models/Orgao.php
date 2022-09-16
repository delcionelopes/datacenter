<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orgao extends Model
{      
    protected $table = 'orgao';   
    protected $fillable = [
        'nome',
        'telefone',     
    ];

    public function virtualmachine()
    {
        return $this->hasMany(VirtualMachine::class,'orgao_id');
    }


    public function apps()
    {
        return $this->hasMany(App::class,'orgao_id');
    }   

    public function users()
    {
        return $this->hasMany(User::class,'orgao_id');
    }


}
