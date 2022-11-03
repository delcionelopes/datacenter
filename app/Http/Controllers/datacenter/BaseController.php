<?php

namespace App\Http\Controllers\datacenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Base;
use App\Models\Orgao;
use App\Models\Projeto;
use App\Models\User;
use App\Models\VirtualMachine;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    private $base;
    private $app;   
    private $users;

    public function __construct(Base $base, App $app, User $users)
    {
        $this->base = $base;
        $this->app = $app;       
        $this->users = $users;
    }
    
    /**
     * Método para listagem dos registros com opção de pesquisa
     */
    public function index(Request $request,int $id)
    {
        if(is_null($request->pesquisa)){
            $bases = $this->base->query()->where('virtual_machine_id','=',$id)->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->base->query()
                          ->where('virtual_machine_id','=',$id)
                          ->where('nome_base','LIKE','%'.strtoupper($request->pesquisa).'%');
            $bases = $query->orderByDesc('id')->paginate(6);              
        }        
        $vm = VirtualMachine::find($id);
        $projetos = Projeto::all();
        $orgaos = Orgao::all();
        $bds = $this->base->query()->where('virtual_machine_id','=',$id)->orderByDesc('id')->get();
        $virtual_machines = VirtualMachine::all();
        $users = $this->users->query()->where('moderador','=','true')->where('inativo','=','false')->orderBy('name')->get();
        return view('datacenter.base.index',[
            'bases' => $bases,
            'id' => $id,
            'vm' => $vm,
            'projetos' => $projetos,
            'orgaos' => $orgaos,
            'bds' => $bds,
            'virtual_machines' => $virtual_machines,
            'users' => $users,
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
            $users = $base->users;     
            return response()->json([
                'base'    => $base,
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
     * Método para a edição de registro
     */
    public function edit(int $id)
    {
        $base = $this->base->find($id);
        $projeto = Projeto::find($base->projetos_id);
        $vm = VirtualMachine::find($base->virtual_machine_id);  
        $users = $base->users;      
        return response()->json([
            'base'   => $base,
            'users' => $users,
            'vm' => $vm,
            'projeto' => $projeto,
            'status' => 200,
        ]);
    }

    /**
     * Método para a atualização de registro editado
     */
    public function update(Request $request,int $id)
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
            $base = $this->base->find($id);            
            if($base){            
            $data = [
                'virtual_machine_id' => $request->input('virtual_machine_id'),
                'projetos_id'         => $request->input('projeto_id'),
                'nome_base'          => strtoupper($request->input('nome_base')),
                'ip'                 => $request->input('ip'),
                'dono'               => strtoupper($request->input('dono')),
                'encoding'           => strtoupper($request->input('encoding')),               
            ];
            $base->update($data);          
            $b = Base::find($id);
            $users = $b->users;
            return response()->json([
                'base'    => $b,
                'users' => $users,
                'status'  => 200,
                'message' => 'Registro atualizado com sucesso!',
            ]);
        }else{
            return response()->json([
                'status'  => 404,
                'message' => 'Registro não encontrado!',
            ]);
        }
    }
    }    

    /**
     * Método para a exclusão recursiva do registro para o adm
     */
    public function destroy(int $id)
    {
        $base = $this->base->find($id);        
        $apps = $base->apps;
        if(($base->apps()->count())||($base->users()->count())){
            if((auth()->user()->moderador)&&(!(auth()->user()->inativo))){             
                if($base->apps()->count()){
                    foreach ($apps as $app) {
                        $a = App::find($app->id);
                        $u = $a->users;
                        $a->users()->detach($u);
                        $a->delete();
                    }                                      
                }
                if($base->users()->count()){                   
                    $usuarios = $base->users;
                    $base->users()->detach($usuarios);                    
                }
                $status = 200;
                $message = $base->nome_base.' excluído com sucesso!'; 
                $base->delete();
            }else{
                $status = 400;
                $message = $base->nome_base.' não pode ser excluído. Pois há outros registros que dependem dele! Procure um administrador!';
            }
        }else{
            $status = 200;
            $message = $base->nome_base.' excluído com sucesso!'; 
            $base->delete();
        }
        
        return response()->json([
            'status'  => $status,
            'message' => $message,
        ]);
    }

    /**
     * Método para a criação de um novo registro de app
     */
    public function storeApp(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bases_id'    => 'required',
            'projetos_id' => 'required',
            'orgao_id'    => 'required',
            'nome_app'    => 'required',
            'dominio'     => 'required',
        ],[
            'bases_id.required'     => 'O campo BASE é obrigatório!',
            'projetos_id.required'  => 'O campo PROJETO é obrigatório!',
            'orgao_id.required'     => 'O campo ORGÃO é obrigatório!',
            'nome_app.required'     => 'O campo NOME é obrigatório!',
            'dominio.required'      => 'O campo DOMÍNIO é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{          
            $data = [
                'base_id'    => $request->input('bases_id'),
                'projeto_id' => $request->input('projetos_id'),
                'orgao_id'    => $request->input('orgao_id'),
                'nome_app'    => strtoupper($request->input('nome_app')),
                'dominio'     => strtolower($request->input('dominio')),
                'https'       => $request->input('https'),              
            ];
            $app = $this->app->create($data);    
            $users = $app->users;        
            return response()->json([
                'app'     => $app,
                'users' => $users,
                'status'  => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }

    public function storesenhabase(Request $request, int $id){
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
            $base = $this->base->find($id);
            $data = [                
                'senha' => $request->input('senha'),
                'validade' => $request->input('validade'),
                'val_indefinida' => intval($request->input('val_indefinida')),
                'criador_id' => $user->id,
            ];
            $base->update($data); //criação da senha
            $b = Base::find($id);            
            $b->users()->sync($request->input('users')); //sincronização
            $u = $b->users;
            return response()->json([
                'user' => $user,                
                'base' => $b,
                'users' => $u,
                'status' => 200,
                'message' => 'Senha foi criada com sucesso!',
            ]);
        }        
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
                'senha' => $request->input('senha'),
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
        return response()->json([
            'status' => 200,            
            'base' => $base,
            'criador' => $criador,
            'alterador' => $alterador,
            'users' => $users,
        ]);
    }

}
