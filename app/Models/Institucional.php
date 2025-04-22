<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function entidades():BelongsToMany{
        return $this->belongsToMany(Entidade::class,'entidade_has_institucional','institucional_id','entidade_id');
    }

    public function artigos():BelongsToMany{
        return $this->belongsToMany(Artigo::class,'institucional_has_artigo','institucional_id','artigos_id');
    }
}
