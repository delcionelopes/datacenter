<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
        'moderador',
        'inativo',
        'sistema',
        'avatar',        
        'orgao_id',  
        'setor_id',
        'cpf',
        'matricula',
        'link_instagram',
        'link_facebook',
        'link_site',
        'funcao_id',
        'perfil_id',
    ];

    public function orgao()
    {
        return $this->belongsTo(Orgao::class);
    }

    public function artigos(){
        return $this->hasMany(Artigo::class);
    }

    public function comentarios(){
        return $this->hasMany(Comentario::class);
    }

    public function arquivos(){
        return $this->hasMany(Arquivo::class);
    }

    public function app():BelongsToMany{
        return $this->belongsToMany(App::class,'app_has_users','user_id','app_id');
    }

    public function host():BelongsToMany{
        return $this->belongsToMany(Host::class,'hosts_has_users','user_id','host_id');
    }

    public function virtual_machine():BelongsToMany{
        return $this->belongsToMany(VirtualMachine::class,'virtual_machine_has_users','user_id','virtual_machine_id');        
    }   
    
    public function vlan():BelongsToMany{
        return $this->belongsToMany(Vlan::class,'vlan_has_users','user_id','vlan_id');        
    }  

    public function base():BelongsToMany{
        return $this->belongsToMany(Base::class,'bases_has_users','user_id','base_id');
    }

     public function equipamento():BelongsToMany{
        return $this->belongsToMany(EquipamentoRede::class,'equipamento_rede_has_users','users_id','equipamento_rede_idequipamento_rede')
                    ->withPivot([
                        'pass_user_equipamento',
                        'created_at',
                        'updated_at',
                    ]);
    }

    public function setor(){
        return $this->belongsTo(Setor::class,'setor_id','idsetor');
    }

    public function perfil(){
        return $this->belongsTo(Perfil::class,'perfil_id','id');
    }

    public function funcao(){
        return $this->belongsTo(Funcao::class,'id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];   

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
