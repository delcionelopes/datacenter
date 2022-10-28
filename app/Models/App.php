<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $table = 'app';     
    protected $fillable = [        
        'base_id',
        'projeto_id',
        'orgao_id',
        'nome_app',
        'dominio',
        'https',   
    ];

    public function bases()
    {
        return $this->belongsTo(Base::class);
    }

    public function projetos()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function orgao()
    {
        return $this->belongsTo(Orgao::class);
    }

    public function senhaapp()
    {
        return $this->hasMany(SenhaApp::class,'app_id');
    }
    

}
