<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenhaApp extends Model
{
    use HasFactory;
    protected $table = 'senhaapp';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'senha',
        'validade',
        'val_indefinida',
        'criador_id',
        'alterador_id',
        'app_id',
    ];

    public function app(){
        return $this->belongsTo(App::class,'app_id');
    }

    public function criador(){
        return $this->belongsTo(User::class,'criador_id');
    }

    public function alterador(){
        return $this->belongsTo(User::class,'alterador_id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'senhaapp_users','senhaapp_id','user_id');
    }

}
