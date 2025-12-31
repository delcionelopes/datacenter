<?php

namespace App\Http\Controllers\Datacenter;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Base;
use App\Models\Host;
use App\Models\User;
use App\Models\VirtualMachine;
use App\Models\Vlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class SenhaController extends Controller
{
    private $app;
    private $host;
    private $virtualmachine;
    private $base;
    private $vlan;
    private $user;

    public function __construct(App $app, Host $host, VirtualMachine $virtualmachine, Base $base, Vlan $vlan, User $user)
    {
        $this->app = $app;
        $this->host = $host;
        $this->virtualmachine = $virtualmachine;
        $this->base = $base;
        $this->vlan = $vlan;
        $this->user = $user;
    }

    public function index($color){        
        $date = date("Y-m-d");       
        
        $user = auth()->user(); //usuário logado

        $users = $this->user->query()
                            ->where('admin','=','true')
                            ->where('setor_id','=',1)
                            ->where('inativo','=','false')
                            ->orderBy('name')
                            ->get(); //usuários com perfil setor infra
        $usersdiversos = $this->user->query()
                            ->where('admin','=','true')
                            ->where('setor_id','=',$user->setor_idsetor)
                            ->where('inativo','=','false')
                            ->orderBy('name')
                            ->get(); //usuários com perfil outros setores

        $apps = $this->app->where('senha','<>',null)->where('validade','<=',$date)->where('val_indefinida','=',0)->paginate(6);
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

        $usersistema = $this->user->find($user->id);

        $totaluserapps = $usersistema->app()->count();
        $userapps = $usersistema->app;

        $totaluserhosts = $usersistema->host()->count();
        $userhosts = $usersistema->host;

        $totaluserbases = $usersistema->base()->count();
        $userbases = $usersistema->base;

        $totaluservms = $usersistema->virtual_machine()->count();
        $uservms = $usersistema->virtual_machine;

        $totaluservlans = $usersistema->vlan()->count();
        $uservlans = $usersistema->vlan;

        $totaluserequipamentos = $usersistema->equipamento()->count();
        $userequipamentos = $usersistema->equipamento;


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
            'users' => $users,
            'usersdiversos' => $usersdiversos,
            'totaluserapps' => $totaluserapps,
            'userapps' => $userapps,
            'totaluserhosts' => $totaluserhosts,
            'userhosts' => $userhosts,
            'totaluserbases' => $totaluserbases,
            'userbases' => $userbases,
            'totaluservms' => $totaluservms,
            'uservms' => $uservms,
            'totaluservlans' => $totaluservlans,
            'uservlans' => $uservlans,
            'totaluserequipamentos' => $totaluserequipamentos,
            'userequipamentos' => $userequipamentos,
            'color' => $color
        ]);
    }

    public function editsenhaapp(int $id){        
        $app = $this->app->find($id);
        $criador = "";
        $alterador ="";
        if ($app->criador_id) {
           $criador = User::find($app->criador_id)->name;
        }       
        if ($app->alterador_id) {
            $alterador = User::find($app->alterador_id)->name;
        }                
        $users = $app->users; 
        $user = auth()->user();
        $s = Crypt::decrypt($app->senha);
        return response()->json([
            'status' => 200,            
            'app' => $app,
            'senha' => $s,
            'criador' => $criador,
            'alterador' => $alterador,
            'users' => $users,
            'user' => $user,
        ]);
    }

     public function updatesenhaapp(Request $request, int $id){
        $validator = Validator::make($request->all(),[
            'senha' => 'required',
            'validade' => ['required','date'],
            'users' => ['required','array','min:2'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $app = $this->app->find($id);
            if($app){
            $user = auth()->user();            
            $data = [                
                'senha' => Crypt::encrypt($request->input('senha')),
                'validade' => $request->input('validade'),
                'val_indefinida' => intval($request->input('val_indefinida')),
                'alterador_id' => $user->id,                
            ];       
            $app->update($data); //atualização da senha
            $a = App::find($id);           
            $a->users()->sync($request->input('users')); //sincronização   
            $u = $app->users;         
            $user = auth()->user();
            return response()->json([
                'user' => $user,
                'app' => $a,
                'users' => $u,
                'user' => $user,
                'status' => 200,
                'message' => 'Senha atualizada com sucesso!',
            ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Senha não localizada!',
                ]);
            }
        }        
    } 

public function updatesenhahost(Request $request, int $id){
        $validator = Validator::make($request->all(),[
            'senha' => 'required',
            'validade' => ['required','date'],
            'users' => ['required','array','min:2'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $host = $this->host->find($id);
            if($host){
            $user = auth()->user();            
            $data = [                
                'senha' => Crypt::encrypt($request->input('senha')),
                'validade' => $request->input('validade'),
                'val_indefinida' => intval($request->input('val_indefinida')),
                'alterador_id' => $user->id,                
            ];
            $host->update($data); //atualização da senha
            $h = Host::find($id);            
            $h->users()->sync($request->input('users')); //sincronização            
            $u = $h->users;
            $user = auth()->user();
            return response()->json([
                'user' => $user,              
                'host' => $h,
                'users' => $u,
                'user' => $user,
                'status' => 200,
                'message' => 'Senha atualizada com sucesso!',
            ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Senha não localizada!',
                ]);
            }
        }        
    }

    public function editsenhahost(int $id){        
        $host = $this->host->find($id);
        $criador = "";
        $alterador ="";
        if ($host->criador_id) {
           $criador = User::find($host->criador_id)->name;
        }       
        if ($host->alterador_id) {
            $alterador = User::find($host->alterador_id)->name;
        }                
        $users = $host->users;   
        $s = Crypt::decrypt($host->senha);    
        $user = auth()->user();
        return response()->json([
            'status' => 200,            
            'host' => $host,
            'senha' => $s,
            'criador' => $criador,
            'alterador' => $alterador,
            'users' => $users,
            'user' => $user,
        ]);
    }    


public function updatesenhavm(Request $request, int $id){
        $validator = Validator::make($request->all(),[
            'senha' => 'required',
            'validade' => ['required','date'],
            'users' => ['required','array','min:2'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $virtualmachine = $this->virtualmachine->find($id);
            if($virtualmachine){
            $user = auth()->user();            
            $data = [                
                'senha' => Crypt::encrypt($request->input('senha')),
                'validade' => $request->input('validade'),
                'val_indefinida' => intval($request->input('val_indefinida')),
                'alterador_id' => $user->id,                
            ];
            $virtualmachine->update($data); //atualização da senha
            $vm = VirtualMachine::find($id);            
            $vm->users()->sync($request->input('users')); //sincronização            
            $u = $vm->users;
            $user = auth()->user();
            return response()->json([
                'user' => $user,                
                'virtualmachine' => $vm,
                'users' => $u,
                'user' => $user,
                'status' => 200,
                'message' => 'Senha atualizada com sucesso!',
            ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Senha não localizada!',
                ]);
            }
        }        
    }

 public function editsenhavm(int $id){        
        $virtualmachine = $this->virtualmachine->find($id);
        $criador = "";
        $alterador ="";
        if ($virtualmachine->criador_id) {
           $criador = User::find($virtualmachine->criador_id)->name;
        }       
        if ($virtualmachine->alterador_id) {
            $alterador = User::find($virtualmachine->alterador_id)->name;
        }                
        $u = $virtualmachine->users;    
        $s = Crypt::decrypt($virtualmachine->senha);
        $user = auth()->user();
        return response()->json([
            'status' => 200,            
            'virtualmachine' => $virtualmachine,
            'senha' => $s,
            'users' => $u,
            'user' => $user,
            'criador' => $criador,
            'alterador' => $alterador,            
        ]);
    }
    
  public function updatesenhabase(Request $request, int $id){
        $validator = Validator::make($request->all(),[
            'senha' => 'required',
            'validade' => ['required','date'],
            'users' => ['required','array','min:2'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $base = $this->base->find($id);
            if($base){
            $user = auth()->user();            
            $data = [                
                'senha' => Crypt::encrypt($request->input('senha')),
                'validade' => $request->input('validade'),
                'val_indefinida' => intval($request->input('val_indefinida')),
                'alterador_id' => $user->id,                
            ];
            $base->update($data); //atualização da senha
            $b = Base::find($id);            
            $b->users()->sync($request->input('users')); //sincronização            
            $u = $b->users;
            
            return response()->json([
                'user' => $user,                
                'base' => $b,
                'users' => $u,
                'status' => 200,
                'message' => 'Senha atualizada com sucesso!',
            ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Senha não localizada!',
                ]);
            }
        }        
    }

     public function editsenhabase(int $id){        
        $base = $this->base->find($id);
        $criador = "";
        $alterador ="";
        if ($base->criador_id) {
           $criador = User::find($base->criador_id)->name;
        }       
        if ($base->alterador_id) {
            $alterador = User::find($base->alterador_id)->name;
        }                
        $users = $base->users;   
        $s = Crypt::decrypt($base->senha);     
        $user = auth()->user();
        return response()->json([
            'status' => 200,            
            'base' => $base,
            'senha' => $s,
            'criador' => $criador,
            'alterador' => $alterador,
            'users' => $users,
            'user' => $user,
        ]);
    }

    public function updatesenhavlan(Request $request, int $id){
        $validator = Validator::make($request->all(),[
            'senha' => 'required',
            'validade' => ['required','date'],
            'users' => ['required','array','min:2'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $vlan = $this->vlan->find($id);
            if($vlan){
            $user = auth()->user();            
            $data = [                
                'senha' => Crypt::encrypt($request->input('senha')),
                'validade' => $request->input('validade'),
                'val_indefinida' => intval($request->input('val_indefinida')),
                'alterador_id' => $user->id,                
            ];
            $vlan->update($data); //atualização da senha
            $v = Vlan::find($id);            
            $v->users()->sync($request->input('users')); //sincronização
            $u = $v->users;
            return response()->json([
                'user' => $user,                
                'vlan' => $v,
                'users' => $u,
                'status' => 200,
                'message' => 'Senha atualizada com sucesso!',
            ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Senha não localizada!',
                ]);
            }
        }        
    }

public function editsenhavlan(int $id){        
        $vlan = $this->vlan->find($id);
        $criador = "";
        $alterador ="";
        if ($vlan->criador_id) {
           $criador = User::find($vlan->criador_id)->name;
        }       
        if ($vlan->alterador_id) {
            $alterador = User::find($vlan->alterador_id)->name;
        }                
        $u = $vlan->users; 
        $s = Crypt::decrypt($vlan->senha);
        $user = auth()->user();
        return response()->json([
            'status' => 200,   
            'senha' => $s,
            'vlan' => $vlan,
            'criador' => $criador,
            'alterador' => $alterador,
            'users' => $u,
            'user' => $user,
        ]);
    }

}
