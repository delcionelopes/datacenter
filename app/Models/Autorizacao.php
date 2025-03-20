<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorizacao extends Model
{
    use HasFactory;
    protected $table = "autorizacao";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'perfil_id',
        'modulo_has_operacao_operacao_id',
        'modulo_has_operacao_modulo_id',
        'modulo_has_operacao_id',
        'created_at',
        'updated_at',
        'user_creater',
        'user_updater',
    ];

    protected function perfil(){
        return $this->belongsTo(Perfil::class,'perfil_id','id');
    }

    public function modulo(){
        return $this->belongsTo(Modulo::class,'modulo_has_operacao_modulo_id','id');
    }

    public function operacao(){
        return $this->belongsTo(Operacao::class,'modulo_has_operacao_operacao_id','id');
    }    

    public function usercreater(){
        return $this->belongsTo(User::class,'user_creater','id');
    }

    
}
