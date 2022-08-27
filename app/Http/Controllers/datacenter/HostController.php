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

    public function index(Request $request,$id)
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
            $timestamps = $this->host->timestamps;
            $this->host->timestamps = false;         
            $data = [
                'cluster_id' => $request->input('cluster_id'),
                'obs_host'   => strtoupper($request->input('obs_host')),
                'ip'         => $request->input('ip'),
                'datacenter' => strtoupper($request->input('datacenter')),
                'cluster'    => strtoupper($request->input('cluster')),              
                'created_at' => now(),
                'updated_at' => null,
            ];
            $host = $this->host->create($data);                        
            $this->host->timestamps = true;
            $h = Host::find($host->id);
            return response()->json([
                'host'    => $h,
                'status'  => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }
   
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $host = $this->host->find($id);
        return response()->json([
            'host'   => $host,
            'status' => 200,
        ]);
    }

    public function update(Request $request, $id)
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
            $timestamps = $this->host->timestamps;
            $this->host->timestamps = false;
            $host = $this->host->find($id);            
            if($host){
                $data = [
                    'cluster_id' => $request->input('cluster_id'),
                    'obs_host'   => strtoupper($request->input('obs_host')),
                    'ip'         => $request->input('ip'),
                    'datacenter' => strtoupper($request->input('datacenter')),
                    'cluster'    => strtoupper($request->input('cluster')),
                    'updated_at' => now(),
                ];
                $host->update($data);
                $this->host->timestamps = true;      
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

    public function destroy($id)
    {             
        $host = $this->host->find($id);                
        $host->delete();        
        return response()->json([
            'status'  => 200,
            'message' => 'Resgistro excluído com sucesso!',
        ]);
    }
}
