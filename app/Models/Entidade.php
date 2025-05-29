<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidade extends Model
{
    use HasFactory;
    protected $table = "entidade";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'logo',
        'sigla',
        'nome',
        'created_at',
        'updated_at',
    ];

    public function institucionais(){
        return $this->belongsToMany(Institucional::class,'entidade_has_institucional','entidade_id','institucional_id');
    }
         
}
