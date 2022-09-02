<?php

namespace App\Http\Controllers\datacenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ambiente;
use App\Models\Cluster;
use Illuminate\Support\Facades\Validator;
use App\models\Host;
use App\Models\Orgao;
use App\Models\Projeto;
use App\Models\Vlan;

class ClusterController extends Controller
{
    private $cluster;
    private $host;

    public function __construct(Cluster $cluster, Host $host)
    {
        $this->cluster = $cluster;
        $this->host = $host;
    }

    
    public function index(Request $request)
    {
        if(is_null($request->pesquisa)){
            $clusters = $this->cluster->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->cluster->query()
            ->where('nome_cluster','LIKE','%'.strtoupper($request->pesquisa).'%');
            $clusters = $query->orderByDesc('id')->paginate(6);
        }    
        $projetos = Projeto::all(); //todos os projetos        
        $orgaos = Orgao::all(); //todos os orgãos
        $ambientes = Ambiente::all(); //todos os ambientes
        $vlans = Vlan::all();  //todas as vlans    
        return view('datacenter.cluster.index',[
            'clusters' => $clusters,
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
            'nome_cluster'      => 'required|max:100',
            'total_memoria'     => 'required',
            'total_processador' => 'required',
        ],[
            'nome_cluster.required'      => 'O campo NOME DO CLUSTER é obrigatório!',
            'nome_cluster.max'           => 'O NOME DO CLUSTER deve ter no máximo :max caracteres!',
            'total_memoria.required'     => 'O campo TOTAL DE MEMÓRIA é obrigatório!',
            'total_processador.required' => 'O campo TOTAL DE PROCESSADOR é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{                 
            $data = [
                'nome_cluster'      => strtoupper($request->input('nome_cluster')),
                'total_memoria'     => $request->input('total_memoria'),
                'total_processador' => $request->input('total_processador'),              
            ];            
            $cluster = $this->cluster->create($data);            
            return response()->json([
                'cluster' => $cluster,
                'status' => 200,
                'message' => 'Resgistro gravado com sucesso!',
            ]);
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $cluster = $this->cluster->find($id);
        return response()->json([
            'cluster' => $cluster,
            'status'  => 200,            
        ]);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nome_cluster'      => 'required|max:100',
            'total_memoria'     => 'required',
            'total_processador' => 'required',
        ],[
            'nome_cluster.required'      => 'O campo NOME CLUSTER é obrigatório!',
            'nome_cluster.max'           => 'O NOME CLUSTER deve ter no máximo :max caracteres!',
            'total_memoria.required'     => 'O campo TOTAL MEMÓRIA é obrigatório!',
            'total_processador.required' => 'O campo TOTAL PROCESSADOR é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{           
            $cluster = $this->cluster->find($id);
            if($cluster){
                        $data = [
                            'nome_cluster'      => strtoupper($request->input('nome_cluster')),
                            'total_memoria'     => $request->input('total_memoria'),
                            'total_processador' => $request->input('total_processador'),                         
                        ];
            $cluster = $this->cluster->update($data);           
            $c = Cluster::find($id);
            return response()->json([
                'cluster' => $c,
                'status'  => 200,
                'message' => 'Resgistro atualizado com sucesso!',
            ]);
        }else{
            return response()->json([
                'status'  => 404,
                'message' => 'Registro não localizado!',
            ]);
        }
        }   
    }

    
    public function destroy($id)
    {
        $cluster = $this->cluster->find($id);
        $cluster->delete();
        return response()->json([
            'status'  => 200,
            'mensage' => 'Registro excluído com sucesso!',
        ]);
    }

    public function storehost(Request $request)
    {        
        $validator = Validator::make($request->all(),[            
            'ip'          => 'required|max:15',
            'datacenter'  => 'required|max:50',
            'cluster'     => 'required|max:50',
        ],[
            'ip.required'         => 'O campo IP é obrigatório!',
            'ip.max'              => 'O IP deve ter no máximo :max caracteres!',
            'datacenter.required' => 'O campo DATACENTER é obrigatório!',
            'datacenter.max'      => 'O DATACENTER deve ter no máximo :max caracteres!',
            'cluster.required'    => 'O campo CLUSTER é obrigatório!',
            'cluster.max'         => 'O CLUSTER deve ter no máximo :max caracteres!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $data = [
                'cluster_id' => $request->input('cluster_id'),
                'obs_host'   => strtoupper($request->input('obs_host')),
                'ip'         => $request->input('ip'),
                'datacenter' => strtoupper($request->input('datacenter')),
                'cluster'    => strtoupper($request->input('cluster')),
            ];
            $host = $this->host->create($data);
            $cluster = $this->cluster->find($host->cluster_id);
            return response()->json([
                'cluster' => $cluster,
                'host'    => $host,
                'status'  => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }


}
