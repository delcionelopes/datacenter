<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    //use HasFactory;    
    public $timestamps = FALSE;
    protected $table = 'ambientes';
    protected $fillable = [
        'nome_ambiente',
        'created_at',
        'updated_at',
    ];    
    
    
    public function virtual_machine(){
        return $this->hasMany(VirtualMachine::class);
    } 

}