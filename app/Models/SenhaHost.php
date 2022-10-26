<?php

namespace App\Models;

use App\models\Host;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenhaHost extends Model
{
    use HasFactory;
    protected $table = 'senhahost';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'host_id',
        'senha',
        'validade',
        'val_indefinida',
        'criador_id',
        'alterador_id',
    ];

    public function host(){
        return $this->belongsTo(Host::class,'host_id');
    }

    public function criador(){
        return $this->belongsTo(User::class,'criador_id');
    }

    public function alterador(){
        return $this->belongsTo(User::class,'alterador_id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'senhahost_users','senhahost_id','user_id');
    }
}
