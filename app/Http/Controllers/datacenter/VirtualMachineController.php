<?php

namespace App\Http\Controllers\datacenter;

use App\Http\Controllers\Controller;
use App\Models\Ambiente;
use App\Models\Base;
use App\Models\Cluster;
use App\Models\Orgao;
use App\Models\Projeto;
use Illuminate\Http\Request;
use App\Models\VirtualMachine;
use App\Models\Vlan;
use Illuminate\Support\Facades\Validator;

class VirtualMachineController extends Controller
{
    private $virtualmachine;
    private $vlan;
    private $base;

    public function __construct(VirtualMachine $virtualmachine, Vlan $vlan, Base $base)
    {
        $this->virtualmachine = $virtualmachine;
        $this->vlan = $vlan;
        $this->base = $base;
    }

    public function index(Request $request,$id)
    {      
        if(is_null($request->pesquisa)){                    
            $virtualmachines = $this->virtualmachine->query()->where('cluster_id','=',$id)->orderByDesc('id')->paginate(5);        
        }else{            
            if($request->pesquisa){
            $query = $this->virtualmachine->query()
                   ->where('nome_vm','LIKE','%'.strtoupper($request->pesquisa).'%')
                   ->where('cluster_id','=',$id);
            $virtualmachines = $query->orderByDesc('id')->paginate(5);
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
        return view('datacenter.virtual_machine.index',[            
            'cluster'         => $cluster,
            'id'              => $id,
            'virtualmachines' => $virtualmachines,
            'vlans'           => $vlans,
            'projetos'        => $projetos,            
            'orgaos'          => $orgaos,
            'ambientes'       => $ambientes,
        ]);
    }

    
    public function create()
    {
        //
    }

    
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
            $timestamps = $this->virtualmachine->timestamps;
            $this->virtualmachine->timestamps = false;
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
                'created_at' => now(),
                'updated_at' => null,
            ];
            $virtualmachine = $this->virtualmachine->create($data);                        
            $this->virtualmachine->timestamps = true;
            $virtualmachine->vlans()->sync($request->input('vlans'));  //sincronização do relacionamento vlan n:n
            $vl = $virtualmachine->vlans;
            $v = VirtualMachine::find($virtualmachine->id);
            return response()->json([
                'virtualmachine' => $v,
                'vlans' => $vl,
                'status' =>200,
                'message' => 'O registro foi criado com sucesso!',
            ]);
        }
    }

    
    public function show(VirtualMachine $virtualMachine)
    {
        //
    }

    
    public function edit($id)
    {
        $virtualmachine = $this->virtualmachine->find($id);
        $vlans = $virtualmachine->vlans; //apenas vlans relacionadas
        $projeto = Projeto::find($virtualmachine->projeto_id);
        $orgao = Orgao::find($virtualmachine->orgao_id);
        $ambiente = Ambiente::find($virtualmachine->ambiente_id);        
        return response()->json([
            'virtualmachine' => $virtualmachine,
            'projeto' => $projeto,
            'orgao' => $orgao,
            'ambiente' => $ambiente,
            'vlans'  => $vlans,
            'status' => 200,            
        ]);
    }

    
    public function update(Request $request, $id)
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
            $timestamps = $this->virtualmachine->timestamps;
            $this->virtualmachine->timestamps = false;
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
                'updated_at' => now(),
            ];
            $virtualmachine->update($data);            
            $this->virtualmachine->timestamps = true;
            $v = VirtualMachine::find($id);
            $v->vlans()->sync($request->input('vlans'));  //sincronização do relacionamento vlan n:n
            $vl = $v->vlans;
            return response()->json([
                'virtualmachine' => $v,
                'vlans' => $vl,
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

    
    public function destroy($id)
    {
        $virtualmachine = $this->virtualmachine->find($id);
        $vl = $virtualmachine->vlans; //todos as vlans relacionadas
        $virtualmachine->vlans()->detach($vl); //exclui o relacionamento
        $virtualmachine->delete();
        return response()->json([
            'status' => 200,
            'message' => 'O registro foi excluído com sucesso!',
        ]);
    } 
    
    public function VlanXVm($id,$vlid){                   
                $vlan = $this->vlan->whereId($vlid)->first();                
                $virtualmachines = $vlan->virtual_machines()->paginate(5);                
                $projetos = Projeto::all(); //todos os projetos        
                $orgaos = Orgao::all(); //todos os orgãos
                $ambientes = Ambiente::all(); //todos os ambientes
                $vlans = Vlan::all();  //todas as vlans
                $cluster = Cluster::find($id);                
                return view('datacenter.virtual_machine.index_vlanXvm',[
                    'cluster'         => $cluster,
                    'id'              => $id,
                    'virtualmachines' => $virtualmachines,
                    'vlans'           => $vlans,
                    'projetos'        => $projetos,            
                    'orgaos'          => $orgaos,
                    'ambientes'       => $ambientes,                    
                ]);        
    }

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
            $timestamps = $this->base->timestamps;
            $this->base->timestamps = false;
            $data = [
                'virtual_machine_id' => $request->input('virtual_machine_id'),
                'projetos_id'         => $request->input('projeto_id'),
                'nome_base'          => strtoupper($request->input('nome_base')),
                'ip'                 => $request->input('ip'),
                'dono'               => strtoupper($request->input('dono')),
                'encoding'           => strtoupper($request->input('encoding')),
                'created_at'         => now(),
                'updated_at'         => null,
            ];
            $base = $this->base->create($data);            
            $this->base->timestamps = true;
            $b = Base::find($base->id);
            return response()->json([
                'base'    => $b,                
                'status'  => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }

}
