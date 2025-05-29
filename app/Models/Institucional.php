<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucional extends Model
{
    use HasFactory;
    protected $table = "institucional";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'logo',
        'sigla',
        'nome',
        'url_site',
        'created_at',
        'updated_at',
    ];

    public function entidades(){
        return $this->belongsToMany(Entidade::class,'entidade_has_institucional','institucional_id','entidade_id');
    }

    public function artigos(){
        return $this->belongsToMany(Artigo::class,'institucional_has_artigo','institucional_id','artigos_id');
    }
}
