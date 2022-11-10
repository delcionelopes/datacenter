<?php

namespace App\Http\Controllers\datacenter;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Base;
use App\Models\Host;
use App\Models\VirtualMachine;
use App\Models\Vlan;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;

class SenhaController extends Controller
{
    private $app;
    private $host;
    private $virtualmachine;
    private $base;
    private $vlan;

    public function __construct(App $app, Host $host, VirtualMachine $virtualmachine, Base $base, Vlan $vlan)
    {
        $this->app = $app;
        $this->host = $host;
        $this->virtualmachine = $virtualmachine;
        $this->base = $base;
        $this->vlan = $vlan;
    }

    public function index(){        
        $date = date("Y-m-d");//Carbon::now(new DateTimeZone('America/Sao_Paulo'))->toDateTimeString();                
        $user = auth()->user();
        $apps = $this->app->where('senha','<>',null)->where('validade','<=',$date)->where('val_indefinida','=',0)->get();
        $totalapps = $apps->count();
        $hosts = $this->host->where('senha','<>',null)->where('validade','<=',$date)->where('val_indefinida','=',0)->get();
        $totalhosts = $hosts->count();
        $virtualmachines = $this->virtualmachine->where('senha','<>',null)->where('validade','<=',$date)->where('val_indefinida','=',0)->get();
        $totalvirtualmachines = $virtualmachines->count();
        $bases = $this->base->where('senha','<>',null)->where('validade','<=',$date)->where('val_indefinida','=',0)->get();
        $totalbases = $bases->count();
        $vlans = $this->vlan->where('senha','<>',null)->where('validade','<=',$date)->where('val_indefinida','=',0)->get();        
        $totalvlans = $vlans->count();
        $totalgeral = $totalapps+$totalhosts+$totalvirtualmachines+$totalbases+$totalvlans;
        return view('datacenter.senha.index',[
            'apps' => $apps,
            'hosts' => $hosts,
            'virtualmachines' => $virtualmachines,
            'bases' => $bases,
            'vlans' => $vlans,
            'totalapps' => $totalapps,
            'totalhosts' => $totalhosts,
            'totalvirtualmachines' => $totalvirtualmachines,
            'totalbases' => $totalbases,
            'totalvlans' => $totalvlans,
            'totalgeral' => $totalgeral,
            'user' => $user,
        ]);
    }

    
}
