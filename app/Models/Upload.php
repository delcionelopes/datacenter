<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{   
    protected $table = 'upload';
    protected $fillable =
    [
        'nome_arquivo',
        'manual_id',        
        'data_atual',
        'path_arquivo',                
    ];

    public function manual()
    {
        return $this->belongsTo(Manual::class,'manual_id');
    }    
}
