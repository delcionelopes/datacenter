<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    use HasFactory;
    protected $table = "funcao";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'nome',
        'descricao',
        'created_at',
        'updated_at'
    ];

    public function users(){
        return $this->hasMany(User::class,'funcao_id');
    }
}
