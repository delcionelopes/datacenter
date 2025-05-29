<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;
    protected $table = "perfil";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'nome',
        'created_at',
        'updated_at'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function autorizacoes(){
        return $this->hasMany(Autorizacao::class);
    }

  
}
