<?php

namespace App\Http\Controllers\datacenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Host;
use Illuminate\Support\Facades\Validator;
use App\Models\Cluster;
use App\Models\SenhaHost;

class HostController extends Controller
{
    private $host;    
    private $senhahost;
    
    public function __construct(Host $host, SenhaHost $senhahost)
    {
        $this->host = $host;
        $this->senhahost = $senhahost;
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
        $senhahost = $this->senhahost->whereHost_id($id)->first();
        if($senhahost){            
            if($senhahost->users()->count()){
                $usuarios = $senhahost->users;
                $senhahost->users()->detach($usuarios);
            }
            $senhahost->delete();
        }
        $host->delete();        
        return response()->json([
            'status'  => 200,
            'message' => 'Resgistro excluído com sucesso!',
        ]);
    }

    public function storesenhahost(Request $request){
        $validator = Validator::make($request->all(),[
            'senha' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $user = auth()->user();
            $senhahost_id = $this->maxsenhahost_inc();
            $data = [
                'id' => $senhahost_id,
                'senha' => $request->input('senha'),
                'validade' => $request->input('validade'),
                'val_indefinida' => $request->input('val_indefinida'),
                'host_id' => $request->input('host_id'),
                'criador_id' => $user->id,                
            ];
            $senhahost = $this->senhahost->create($data); //criação da senha
            $s = SenhaHost::find($senhahost->id);
            $h = $s->host;
            $senhahost->users()->sync($request->input('users')); //sincronização            
            return response()->json([
                'user' => $user,
                'senhahost' => $h,
                'host' => $h,
                'status' => 200,
                'message' => 'Senha de'+$h->datacenter+' foi criada com sucesso!',
            ]);
        }        
    }

    protected function maxsenhahost_inc(){
        $senhahost = $this->senhahost->orderByDesc('id')->first();
        if($senhahost){
            $codigo = $senhahost->id+1;
        }else{
            $codigo = 1;
        }
        return $codigo;
    }

    public function updatesenhahost(Request $request, int $id){
        $validator = Validator::make($request->all(),[
            'senha' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $senhahost = $this->senhahost->find($id);
            if($senhahost){
            $user = auth()->user();            
            $data = [                
                'senha' => $request->input('senha'),
                'validade' => $request->input('validade'),
                'val_indefinida' => $request->input('val_indefinida'),
                'host_id' => $request->input('host_id'),
                'alterador_id' => $user->id,                
            ];
            $senhahost->update($data); //atualização da senha
            $s = SenhaHost::find($id);
            $h = $s->host;
            $s->users()->sync($request->input('users')); //sincronização            
            return response()->json([
                'user' => $user,
                'senhahost' => $s,
                'host' => $h,
                'status' => 200,
                'message' => 'Senha de '+$h->datacenter+' atualizada com sucesso!',
            ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Senha não localizada!',
                ]);
            }
        }        
    }


}
