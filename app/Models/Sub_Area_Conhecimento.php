<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_Area_Conhecimento extends Model
{    
    protected $table = 'sub_area_conhecimento';
    public $timestamps = FALSE;
    protected $fillable = [
        'area_conhecimento_id',
        'descricao',
        'created_at',
        'updated_at',
    ];

    public function area_conhecimento()
    {
        return $this->belongsTo(Area_Conhecimento::class,'area_conhecimento_id','id');
    }
}
