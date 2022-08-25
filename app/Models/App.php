<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $table = 'app';
    public $timestamps = FALSE;
    protected $fillable = [
        'base_id',
        'projeto_id',
        'orgao_id',
        'nome_app',
        'dominio',
        'https',
        'created_at',
        'updated_at'
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

}
