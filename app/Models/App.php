<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'senha',
        'validade',
        'val_indefinida',
        'criador_id',
        'alterador_id',      
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

    public function users():BelongsToMany{
        return $this->belongsToMany(User::class,'app_has_users','app_id','user_id')->withPivot(['users.name']);
    }     

}
