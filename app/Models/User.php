<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'moderador',
        'inativo',
        'avatar',        
        'orgao_id',  
        'cpf',
        'matricula',
        'link_instagram',
        'link_facebook',
        'link_site',
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
