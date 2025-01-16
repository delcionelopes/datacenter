<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Base;
use Illuminate\Http\Request;
use App\Models\Orgao;
use App\Models\User;
use App\Models\VirtualMachine;
use Illuminate\Support\Facades\Validator;

class OrgaoController extends Controller
{

    private $orgao;

    public function __construct(Orgao $orgao){
        $this->orgao = $orgao;
    }   

    /**
     * Método de listagem dos órgãos com opção de pesquisa
     */
    public function index(Request $request)
    {        
        if(is_null($request->pesquisanome)){
            $orgaos = $this->orgao->orderByDesc('id')->paginate(6);
        }else{            
            $query = $this->orgao->query()
            ->where('nome','LIKE','%'.strtoupper($request->pesquisanome).'%');            
            $orgaos = $query->orderByDesc('id')->paginate(6);
            
        }
        return view('orgao.index',compact('orgaos'));
    }

    
    public function create()
    {
        //
    }
    
    /**
     * Método para gravação de um novo registro
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nome' => 'required|max:191',           
        ],[
            'nome.required'   => 'O campo NOME é obrigatório!',
            'nome.max'        => 'O NOME deve conter no máximo :max caracteres!',            
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{             
            $data = [
                'nome' =>strtoupper($request->input('nome')),
                'telefone' =>$request->input('telefone'),                     
            ];            
            $orgao = $this->orgao->create($data);
            $user = auth()->user();
            return response()->json([
                'orgao'  => $orgao,
                'user' => $user,
                'status' => 200,
                'message' => 'Órgão cadastrado com sucesso!',
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
        $o = $this->orgao->find($id);
        $user = auth()->user();

        return response()->json([
            'orgao' => $o,
            'user' => $user,
            'status' => 200,
        ]);
    }

    /**
     * Método para atualização do registro editado
     */
    public function update(Request $request,int $id)
    {        
        $validator = Validator::make($request->all(),[
            'nome'     =>  'required|max:191',            
        ],[
            'nome.required'  => 'O campo NOME é obrigatório!',
            'nome.max'       => 'O NOME deve conter no máximo :max caracteres',            
        ]);

        if($validator->fails()){
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->errors()->getMessages(),
            ]);
        }else{          
            $orgao = $this->orgao->find($id);            
            if($orgao){
                $orgao->nome = strtoupper($request->input('nome'));
                $orgao->telefone = $request->input('telefone');
                
                $orgao->update();
               
                $o = Orgao::find($id);
                $user = auth()->user();

                return response()->json([
                    'orgao'   => $o,
                    'user' => $user,
                    'status'  => 200,
                    'message' => 'Órgão atualizado com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status'  => 404,
                    'message' => 'Órgão não localizado!',
                ]);
            }
        }
    }

    /**
     * Método para exclusão recursiva do registro para o adm
     */
    public function destroy(int $id)
    {
        $orgao = $this->orgao->find($id);

        $vms = $orgao->virtualmachine;
        $apps = $orgao->apps;
        $users = $orgao->users;
        if(($orgao->virtualmachine()->count())||($orgao->apps()->count())||($orgao->users()->count())){
            if((auth()->user()->moderador)&&(!(auth()->user()->inativo))){
                if($orgao->virtualmachine()->count()){
                    foreach ($vms as $vm) {
                        $v = VirtualMachine::find($vm->id);
                        $bases = $v->bases;
                        foreach ($bases as $base) {
                            $b = Base::find($base->id);
                            $apps = $b->apps;
                            foreach ($apps as $app) {
                                $a = App::find($app->id);
                                $a->delete();
                            }
                            $b->delete();
                        }
                        $vmXvlans = $v->vlans;
                        if($v->vlans()->count()){
                        $v->vlans()->detach($vmXvlans);
                        $v->delete();
                        }
                    }                    
                }
                if($orgao->apps()->count()){
                    foreach ($apps as $app) {
                        $a = App::find($app->id);
                        $a->delete();
                    }                    
                }
                if($orgao->users()->count()){
                    $users = $orgao->users;
                    foreach ($users as $user) {
                        $u = User::find($user->id);
                        $u->delete();
                    }                    
                }                
                $status = 200;
                $message = $orgao->nome.' excluído com sucesso!';
                $orgao->delete();
            }else{
                $status = 400;
                $message = $orgao->nome.' não pode ser excluído. Pois há outros registros que dependem dele! Procure um administrador!';
            }
        }else{
            $status = 200;
            $message = $orgao->nome.' excluído com sucesso!';
            $orgao->delete();
        }

        return response()->json([
            'status'  =>  $status,
            'message' => $message,
        ]);
    }
}
