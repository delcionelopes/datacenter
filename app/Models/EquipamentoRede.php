<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EquipamentoRede extends Model
{
    use HasFactory;
    protected $table = 'equipamento_rede';
    protected $primaryKey = 'idequipamento_rede';
    protected $fillable = [
        'idequipamento_rede',
        'nome',
        'descricao',
        'pass_admin',
        'setor_idsetor',
        'created_at',
        'updated_at',
        'criador_id',
        'alterador_id',
        'orgao_vinc_id',
        'setor_vinc_id',
        'modelo',
        'ip',
        'mac',
        'localizacao',
        'serie',
        'patrimonio',
        'equipamento_grupo_id',
        'inativo',
    ];

    public function users():BelongsToMany{
        return $this->belongsToMany(User::class,'equipamento_rede_has_users','equipamento_rede_idequipamento_rede','users_id')
                    ->withPivot([
                        'pass_user_equipamento',
                        'created_at',
                        'updated_at',
                    ]);       
    }

    public function setor(){
        return $this->belongsTo(Setor::class,'setor_idsetor');
    }

    public function criador(){
        return $this->belongsTo(User::class,'criador_id');
    }

    public function alterador(){
        return $this->belongsTo(User::class,'alterador_id');
    }

    public function orgaovinc(){
        return $this->belongsTo(Orgao::class,'orgao_vinc_id');        
    }

    public function setorvinc(){
        return $this->belongsTo(Setor_Vinc::class,'setor_vinc_id');
    }

    public function grupo(){
        return $this->belongsTo(Equipamento_Grupo::class,'equipamento_grupo_id');
    }

}
