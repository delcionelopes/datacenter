<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    //use HasFactory;    
    protected $table = 'projetos'; 
    protected $fillable =
    [
        'nome_projeto',     
    ];

    public function bases()
    {
        return $this->hasMany(Base::class);
    }

    public function virtual_machines()
    {
        return $this->hasMany(VirtualMachine::class);
    }

    public function apps()
    {
        return $this->hasMany(App::class);
    }   

}
