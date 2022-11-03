<?php

namespace App\Http\Controllers\datacenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Host;
use Illuminate\Support\Facades\Validator;
use App\Models\Cluster;
use App\Models\User;

class HostController extends Controller
{
    private $host;    
    private $users;
    
    public function __construct(Host $host, User $users)
    {
        $this->host = $host;        
        $this->users = $users;
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
        $users = $this->users->query()->where('moderador','=','true')->where('inativo','=','false')->orderBy('name')->get();
        return view('datacenter.host.index',[
            'hosts' => $hosts,
            'id'    => $id,
            'cluster' => $cluster,
            'users'  => $users,
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
            $users = $host->users;     
            return response()->json([
                'host'    => $host,
                'users' => $users,
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
                $users = $h->users;                       
                return response()->json([
                    'host'    => $h,
                    'users' => $users,
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
            if($host->users()->count()){
                $usuarios = $host->users;
                $host->users()->detach($usuarios);
            }
                
        $host->delete();        
        return response()->json([
            'status'  => 200,
            'message' => 'Resgistro excluído com sucesso!',
        ]);
    }

    public function storesenhahost(Request $request, int $id){
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
            $host = $this->host->find($id);
            $data = [                
                'senha' => $request->input('senha'),
                'validade' => $request->input('validade'),
                'val_indefinida' => intval($request->input('val_indefinida')),
                'criador_id' => $user->id,                
            ];
            $host->update($data); //criação da senha
            $h = Host::find($id);            
            $h->users()->sync($request->input('users')); //sincronização            
            $u = $h->users;
            return response()->json([
                'user' => $user,              
                'host' => $h,
                'users' => $u,
                'status' => 200,
                'message' => 'Senha criada com sucesso!',
            ]);
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
                'senha' => $request->input('senha'),
                'validade' => $request->input('validade'),
                'val_indefinida' => intval($request->input('val_indefinida')),
                'alterador_id' => $user->id,                
            ];
            $host->update($data); //atualização da senha
            $h = Host::find($id);            
            $h->users()->sync($request->input('users')); //sincronização            
            $u = $h->users;
            return response()->json([
                'user' => $user,              
                'host' => $h,
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
        return response()->json([
            'status' => 200,            
            'host' => $host,
            'criador' => $criador,
            'alterador' => $alterador,
            'users' => $users,
        ]);
    }

}
