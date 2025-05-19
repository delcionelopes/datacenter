<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artigo extends Model
{
    use HasFactory;
    protected $table = 'artigos';
    protected $primaryKey = 'id';
    protected $fillable = 
    [
        'id',
        'titulo',
        'descricao',
        'conteudo',
        'slug',
        'user_id',
        'imagem',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }    

    public function comentarios(){
        return $this->hasMany(Comentario::class,'artigos_id');
    }

    public function temas(){
        return $this->belongsToMany(Tema::class,'temas_artigos','artigos_id','temas_id');
    }

    public function arquivos(){
        return $this->hasMany(Arquivo::class,'artigos_id');
    }
    
    public function institucionais(){
        return $this->belongsToMany(Institucional::class,'institucional_has_artigo','artigos_id','institucional_id');
    }  
    
}