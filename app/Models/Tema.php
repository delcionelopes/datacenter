<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;
    protected $table = 'temas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'titulo',
        'descricao',
        'slug',
        'created_at',
        'updated_at',
    ];

    public function artigos(){
    return $this->belongsToMany(Artigo::class, 'temas_artigos', 'temas_id','artigos_id');
    }

 
}
