<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plataforma extends Model
{
    //use HasFactory;    
    public $timestamps = FALSE;
    protected $table = 'plataformas';

    protected $fillable = [
      'nome_plataforma',  
      'created_at',
      'updated_at',
    ];
}
