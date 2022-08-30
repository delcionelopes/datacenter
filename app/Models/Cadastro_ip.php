<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadastro_ip extends Model
{    
    protected $table = 'cadastro_ip';   
    protected $fillable = [
        'rede_id',
        'ip',
        'status',   
    ];
    public function rede(){
        return $this->belongsTo(Rede::class,'rede_id','id');
    }
}
