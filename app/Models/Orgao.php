<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orgao extends Model
{      
    protected $table = 'orgao';   
    protected $fillable = [
        'id',
        'nome',
        'telefone',
        'created_at',
        'updated_at',
    ];

    public function virtualmachine()
    {
        return $this->hasMany(VirtualMachine::class);
    }


    public function apps()
    {
        return $this->hasMany(App::class);
    }   

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function setorvinc(){
        return $this->hasMany(Setor_Vinc::class);
    }

    public function equipamento(){
        return $this->hasMany(EquipamentoRede::class);
    }

    public function ip(){
        return $this->hasMany(Cadastro_ip::class);
    }


}
