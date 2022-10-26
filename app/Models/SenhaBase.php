<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenhaBase extends Model
{
    use HasFactory;
    protected $table = 'senhabase';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'base_id',
        'senha',
        'validade',
        'val_indefinida',
        'criador_id',
        'alterador_id',
    ];

    public function base(){
        return $this->belongsTo(Base::class,'base_id');
    }

    public function criador(){
        return $this->belongsTo(User::class,'criador_id');
    }

    public function alterador(){
        return $this->belongsTo(User::class,'alterador_id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'senhabase_users','senhabase_id','user_id');
    }
}
