<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    //use HasFactory;    
    protected $table = 'ambientes';
    protected $fillable = [
        'nome_ambiente',      
    ];    
    
    
    public function virtual_machine(){
        return $this->hasMany(VirtualMachine::class);
    } 

}