<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orgao extends Model
{      
    protected $table = 'orgao';
    public $timestamps = FALSE;
    protected $fillable = [
        'nome',
        'telefone',
        'created_at',
        'updated_at',
    ];

    public function virtualmachine()
    {
        return $this->hasMany(VirtualMachine::class);
    }


    public function apps()
    {
        return $this->hasMany(App::class);
    }


}
