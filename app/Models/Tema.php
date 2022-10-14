<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Tema extends Model
{
    use HasFactory;    
    use Sluggable;    
    protected $table = 'temas';
    protected $fillable = [
        'id',
        'titulo',
        'descricao',
        'slug',
    ];

    public function artigos(){
    return $this->belongsToMany(Artigo::class, 'temas_artigos', 'temas_id','artigos_id');
    }

    public function Sluggable():array{
        return [
                'slug' => [
                    'source' => 'titulo',
                ],
        ];
    }


}
