<?php

namespace App\Http\Controllers\datacenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Host;
use Illuminate\Support\Facades\Validator;
use App\Models\Cluster;

class HostController extends Controller
{
    private $host;    
    
    public function __construct(Host $host)
    {
        $this->host = $host;
    }

    /**
     * Método para listagem de registros com a opção de pesquisa
     */
    public function index(Request $request,int $id)
    {             
        if(is_null($request->pesquisa)){            
            $hosts = $this->host->query()->where('cluster_id','=',$id)->orderByDesc('id')->paginate(6);
        }else{            
            $query = $this->host->query()
                     ->where('cluster_id','=',$id)
                     ->where('datacenter','LIKE','%'.strtoupper($request->pesquisa).'%');
            $hosts = $query->orderByDesc('id')->paginate(6);            
        }                    
        $cluster = Cluster::find($id);            

        return view('datacenter.host.index',[
            'hosts' => $hosts,
            'id'    => $id,
            'cluster' => $cluster,
        ]);
    }

    
    public function create()
    {
        //
    }

    /**
     * Método para criar um novo registro
     */
    public function store(Request $request)
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
            return response()->json([
                'host'    => $host,
                'status'  => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }
   
    public function show($id)
    {
        //
    }

    /**
     * Método para edição de registro
     */
    public function edit(int $id)
    {
        $host = $this->host->find($id);
        return response()->json([
            'host'   => $host,
            'status' => 200,
        ]);
    }

    /**
     * Método para atualizar registro editado
     */
    public function update(Request $request,int $id)
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
            $host = $this->host->find($id);            
            if($host){
                $data = [
                    'cluster_id' => $request->input('cluster_id'),
                    'obs_host'   => strtoupper($request->input('obs_host')),
                    'ip'         => $request->input('ip'),
                    'datacenter' => strtoupper($request->input('datacenter')),
                    'cluster'    => strtoupper($request->input('cluster')),                   
                ];
                $host->update($data);               
                $h = Host::find($id);                          
                return response()->json([
                    'host'    => $h,
                    'status'  => 200,
                    'message' => 'Registro atualizado com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Registro não encontrado!',
                ]);
            }
        }
    }

    /**
     * Método para exclusão de registro
     */
    public function destroy(int $id)
    {             
        $host = $this->host->find($id); 
        $host->delete();        
        return response()->json([
            'status'  => 200,
            'message' => 'Resgistro excluído com sucesso!',
        ]);
    }
}
