<?php

namespace App\Http\Controllers\datacenter;

use App\Http\Controllers\Controller;
use App\Models\Ambiente;
use App\Models\App;
use App\Models\Base;
use App\Models\Cluster;
use App\Models\Orgao;
use App\Models\Projeto;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VirtualMachine;
use App\Models\Vlan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class VirtualMachineController extends Controller
{
    private $virtualmachine;
    private $vlan;
    private $base;    
    private $users;

    public function __construct(VirtualMachine $virtualmachine, Vlan $vlan, Base $base, User $users)
    {
        $this->virtualmachine = $virtualmachine;
        $this->vlan = $vlan;
        $this->base = $base;   
        $this->users = $users;     
    }

    /**
     * Método para listagem de registros com opção de pesquisa
     */
    public function index(Request $request,int $id)
    {      
        if(is_null($request->pesquisa)){                    
            $virtualmachines = $this->virtualmachine->query()->where('cluster_id','=',$id)->orderByDesc('id')->paginate(6);        
        }else{            
            if($request->pesquisa){
            $query = $this->virtualmachine->query()
                   ->where('nome_vm','LIKE','%'.strtoupper($request->pesquisa).'%')
                   ->where('cluster_id','=',$id);
            $virtualmachines = $query->orderByDesc('id')->paginate(6);
            }else{                
                $vlan = $this->vlan->whereId($request->vlanid)->first();                
                $virtualmachines = $vlan->virtual_machines()->paginate(5); 
            }
        }
        $projetos = Projeto::all(); //todos os projetos        
        $orgaos = Orgao::all(); //todos os orgãos
        $ambientes = Ambiente::all(); //todos os ambientes
        $vlans = Vlan::all();  //todas as vlans
        $cluster = Cluster::find($id);        
        $users = $this->users->query()
                             ->where('moderador','=','true')
                             ->where('inativo','=','false')
                             ->where('setor_idsetor','=',1)
                             ->orderBy('name')
                             ->get();
        return view('datacenter.virtual_machine.index',[            
            'cluster'         => $cluster,
            'id'              => $id,
            'virtualmachines' => $virtualmachines,
            'vlans'           => $vlans,
            'projetos'        => $projetos,            
            'orgaos'          => $orgaos,
            'ambientes'       => $ambientes,
            'users'           => $users,
        ]);
    }

    
    public function create()
    {
        //
    }

    /**
     * Método para a criação de um novo registro
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nome_vm'             => 'required|max:255',
            'cpu'                 => 'required',
            'memoria'             => 'required',
            'disco'               => 'required',
            'ip'                  => 'required|max:50',
            'resource_pool'       => 'required|max:150',            
            'sistema_operacional' => 'required|max:50',
            'gatway'              => 'required|max:20',            
            'ambiente_id'         => 'required',
            'orgao_id'            => 'required',
            'cluster_id'          => 'required',
            'projeto_id'          => 'required',
        ],[
            'nome_vm.required'             => 'O campo NOME é obrigatório!',
            'nome_vm.max'                  => 'O NOME deve ter no máximo :max caracteres!',
            'cpu.required'                 => 'O campo CPU é obrigatório!',
            'memoria.required'             => 'O campos MEMÓRIA é obrigatório!',
            'disco.required'               => 'O campo DISCO é obrigatório!',
            'ip.required'                  => 'O campo IP é obrigatório!',
            'ip.max'                       => 'O IP deve conter no máximo :max caracteres!',
            'resource_pool.required'       => 'O campo RESOURCE POOL é obrigatório!',
            'resource_pool.max'            => 'O RESOURCE POOL deve conter no máximo :max caracteres!',            
            'sistema_operacional.required' => 'O campo SISTEMA OPERACIONAL é obrigatório!',
            'sistema_operacional.max'      => 'O SISTEMA OPERACIONAL deve conter no máximo :max caracteres!',
            'gatway.required'              => 'O campo GATWAY é obrigatório!',
            'gatway.max'                   => 'O GATEWAY deve conter no máximo :max caracteres!',
            'ambiente_id.required'         => 'O AMBIENTE é obrigatório!',
            'orgao_id.required'            => 'O ORGÃO é obrigatório!',
            'cluster_id.required'          => 'O CLUSTER é obrigatório!',
            'projeto_id.required'          => 'O PROJETO é obrigatório!',

        ]);
        if($validator->fails()){
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->errors()->getMessages(),
            ]);
        }else{            
            $data = [
                'nome_vm' => strtoupper($request->input('nome_vm')),
                'cpu'     => $request->input('cpu'),
                'memoria' => $request->input('memoria'),
                'disco'   => $request->input('disco'),
                'ip'      => $request->input('ip'),
                'resource_pool' => strtoupper($request->input('resource_pool')),                
                'sistema_operacional' => strtoupper($request->input('sistema_operacional')),
                'gatway' => $request->input('gatway'),
                'ambiente_id' => $request->input('ambiente_id'),
                'orgao_id'    => $request->input('orgao_id'),
                'cluster_id'  => $request->input('cluster_id'),
                'projeto_id'  => $request->input('projeto_id'),
                'cluster'     => $request->input('cluster'),               
            ];
            $virtualmachine = $this->virtualmachine->create($data);                       
           
            $virtualmachine->vlans()->sync($request->input('vlans'));  //sincronização do relacionamento vlan n:n

            $vl = $virtualmachine->vlans;

            $users = $virtualmachine->users;
            $user = auth()->user();
            
            return response()->json([
                'virtualmachine' => $virtualmachine,
                'vlans' => $vl,
                'users' => $users,
                'user' => $user,
                'status' =>200,
                'message' => 'O registro foi criado com sucesso!',
            ]);
        }
    }

    
    public function show(VirtualMachine $virtualMachine)
    {
        //
    }

    /**
     * Método para a edição de registro
     */
    public function edit(int $id)
    {
        $virtualmachine = $this->virtualmachine->find($id);
        $vlans = $virtualmachine->vlans; //apenas vlans relacionadas
        $projeto = Projeto::find($virtualmachine->projeto_id);
        $orgao = Orgao::find($virtualmachine->orgao_id);
        $ambiente = Ambiente::find($virtualmachine->ambiente_id);    
        $users = $virtualmachine->users;
        $user = auth()->user();
        return response()->json([
            'virtualmachine' => $virtualmachine,
            'projeto' => $projeto,
            'orgao' => $orgao,
            'ambiente' => $ambiente,
            'vlans'  => $vlans,
            'users' => $users,
            'user' => $user,
            'status' => 200,            
        ]);
    }

    /**
     * Método para atualização de registro editado
     */
    public function update(Request $request, int $id)
    {          
        $validator = Validator::make($request->all(),[
            'nome_vm'             => 'required|max:255',
            'cpu'                 => 'required',
            'memoria'             => 'required',
            'disco'               => 'required',
            'ip'                  => 'required|max:50',
            'resource_pool'       => 'required|max:150',            
            'sistema_operacional' => 'required|max:50',
            'gatway'              => 'required|max:20',            
            'ambiente_id'         => 'required',
            'orgao_id'            => 'required',
            'cluster_id'          => 'required',
            'projeto_id'          => 'required',
        ],[
            'nome_vm.required'             => 'O campo NOME é obrigatório!',
            'nome_vm.max'                  => 'O NOME deve ter no máximo :max caracteres!',
            'cpu.required'                 => 'O campo CPU é obrigatório!',
            'memoria.required'             => 'O campos MEMÓRIA é obrigatório!',
            'disco.required'               => 'O campo DISCO é obrigatório!',
            'ip.required'                  => 'O campo IP é obrigatório!',
            'ip.max'                       => 'O IP deve conter no máximo :max caracteres!',
            'resource_pool.required'       => 'O campo RESOURCE POOL é obrigatório!',
            'resource_pool.max'            => 'O RESOURCE POOL deve conter no máximo :max caracteres!',            
            'sistema_operacional.required' => 'O campo SISTEMA OPERACIONAL é obrigatório!',
            'sistema_operacional.max'      => 'O SISTEMA OPERACIONAL deve conter no máximo :max caracteres!',
            'gatway.required'              => 'O campo GATEWAY é obrigatório!',
            'gatway.max'                   => 'O GATWAY deve conter no máximo :max caracteres!',
            'ambiente_id.required'         => 'O AMBIENTE é obrigatório!',
            'orgao_id.required'            => 'O ORGÃO é obrigatório!',
            'cluster_id.required'          => 'O CLUSTER é obrigatório!',
            'projeto_id.required'          => 'O PROJETO é obrigatório!',

        ]);
        if($validator->fails()){
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->errors()->getMessages(),
            ]);
        }else{           
            $virtualmachine = $this->virtualmachine->find($id);
            $v = $virtualmachine;
            if($virtualmachine){
            $data = [
                'nome_vm' => strtoupper($request->input('nome_vm')),
                'cpu'     => $request->input('cpu'),
                'memoria' => $request->input('memoria'),
                'disco'   => $request->input('disco'),
                'ip'      => $request->input('ip'),
                'resource_pool' => strtoupper($request->input('resource_pool')),                
                'sistema_operacional' => strtoupper($request->input('sistema_operacional')),
                'gatway' => $request->input('gatway'),
                'ambiente_id' => $request->input('ambiente_id'),
                'orgao_id'    => $request->input('orgao_id'),
                'cluster_id'  => $request->input('cluster_id'),
                'projeto_id'  => $request->input('projeto_id'),                
                'cluster' => $request->input('cluster'),                
            ];
            $virtualmachine->update($data);                       
            $v->vlans()->sync($request->input('vlans'));  //sincronização do relacionamento vlan n:n
            $vl = $v->vlans;
            $users = $v->users;
            $user = auth()->user();
            return response()->json([
                'virtualmachine' => $v,
                'vlans' => $vl,
                'users' => $users,
                'user' => $user,
                'status' =>200,
                'message' => 'O registro foi atualizado com sucesso!',
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Registro não localizado!',
            ]);
        }
        }
    }

    /**
     * Método para exclusão recursiva de registro para o adm
     */
    public function destroy(int $id)
    {
        $virtualmachine = $this->virtualmachine->find($id);
        $vl = $virtualmachine->vlans; //todos as vlans relacionadas
        $bases = $virtualmachine->bases;
        if(($virtualmachine->vlans()->count())||($virtualmachine->bases()->count())||($virtualmachine->users()->count())){
            if((auth()->user()->moderador)&&(!(auth()->user()->inativo))){
                if($virtualmachine->vlans()->count){
                    $virtualmachine->vlans()->detach($vl); //exclui o relacionamento n:n
                }
                if($virtualmachine->bases()->count()){
                    foreach ($bases as $base) {
                        $b = $this->base->find($base->id);
                        $apps = $b->apps;
                        if($b->apps()->count()){
                        foreach ($apps as $app) {
                            $a = App::find($app->id);
                            $a->delete();
                        }
                        }
                        $b->delete();
                    }                   
                }
                if($virtualmachine->users()->count()){
                    $usuarios = $virtualmachine->users;
                    $virtualmachine->users()->detach($usuarios);                   
                }
                $status = 200;
                $message = $virtualmachine->nome_vm.' foi excluído com sucesso!';
                $virtualmachine->delete();
            }else{
                $status = 400;
                $message = $virtualmachine->nome_vm.' não pôde ser excluído, pois há outros registros que dependem dele. Contacte um administrador.';
            }
        }else{
            $status = 200;
            $message = $virtualmachine->nome_vm.' foi excluído com sucesso!';
            $virtualmachine->delete();
        }       
   
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    } 
    
    /**
     * Método para mostrar as vlans relacionadas às vms
     */
    public function VlanXVm(int $id,int $vlid){                   
                $vlan = $this->vlan->whereId($vlid)->first();                
                $virtualmachines = $vlan->virtual_machines()->paginate(5);                
                $projetos = Projeto::all(); //todos os projetos        
                $orgaos = Orgao::all(); //todos os orgãos
                $ambientes = Ambiente::all(); //todos os ambientes
                $vlans = Vlan::all();  //todas as vlans
                $cluster = Cluster::find($id);                
                $users = $this->users->query()->where('moderador','=','true')->where('inativo','=','false')->orderBy('name')->get();
                $user = auth()->user();
                return view('datacenter.virtual_machine.index_vlanXvm',[
                    'cluster'         => $cluster,
                    'id'              => $id,
                    'virtualmachines' => $virtualmachines,
                    'vlans'           => $vlans,
                    'projetos'        => $projetos,            
                    'orgaos'          => $orgaos,
                    'ambientes'       => $ambientes,                    
                    'users'           => $users,
                    'user'            => $user,
                ]);        
    }

    /**
     * Método para criar uma nova base
     */
    public function storeBase(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'virtual_machine_id'  => 'required',
            'projeto_id'          => 'required',
            'nome_base'           => 'required',
            'ip'                  => 'required',
            'dono'                => 'required',  
        ],[
            'virtual_machine_id.required' => 'O campo VIRTUAL MACHINE é obrigatório!',
            'projeto_id.required'         => 'O campo PROJETO é obrigatório!',
            'nome_base.required'          => 'O campo NOME é obrigatório!',
            'ip.required'                 => 'O campo IP é obrigatório!',
            'dono.required'               => 'O campo DONO é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{           
            $data = [
                'virtual_machine_id' => $request->input('virtual_machine_id'),
                'projetos_id'         => $request->input('projeto_id'),
                'nome_base'          => strtoupper($request->input('nome_base')),
                'ip'                 => $request->input('ip'),
                'dono'               => strtoupper($request->input('dono')),
                'encoding'           => strtoupper($request->input('encoding')),               
            ];
            $base = $this->base->create($data);
            $user = auth()->user();
            return response()->json([
                'base'    => $base,
                'user' =>  $user,
                'status'  => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }


    public function storesenhavm(Request $request, int $id){
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
            $user = auth()->user();
            $virtualmachine = $this->virtualmachine->find($id);
            $data = [                
                'senha' => Crypt::encrypt($request->input('senha')),
                'validade' => $request->input('validade'),
                'val_indefinida' => intval($request->input('val_indefinida')),
                'criador_id' => $user->id,                
            ];
            $virtualmachine->update($data); //criação da senha
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
                'message' => 'Senha criada com sucesso!',
            ]);
        }        
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
            return response()->json([
                'user' => $user,                
                'virtualmachine' => $vm,
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

}
