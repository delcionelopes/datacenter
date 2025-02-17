<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Base;
use Illuminate\Http\Request;
use App\Models\Projeto;
use App\Models\VirtualMachine;
use Illuminate\Support\Facades\Validator;

class ProjetoController extends Controller
{
    private $projeto;

    public function __construct(Projeto $projeto)
    {
        $this->projeto = $projeto;        
    }


    /**
     * Método para listagem de registros com opção de pesquisa
     */
    public function index(Request $request, $color)
    {
        if(is_null($request->pesquisanome)){
            $projetos = $this->projeto->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->projeto->query()
            ->where('nome_projeto','LIKE','%'.strtoupper($request->pesquisanome.'%'));
            $projetos = $query->orderByDesc('id')->paginate(6);
        }
        return view('projeto.index',[
            'projetos' => $projetos,
            'color' => $color
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
            'nome_projeto'  => 'required|max:100',
        ],[
            'nome_projeto.required' => 'O campo NOME é obrigatório!',
            'nome_projeto.max'  => 'O NOME deve conter no máximo :max caracteres!',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{              
            $data = [
                'nome_projeto' => strtoupper($request->input('nome_projeto')),             
            ];            
            $projeto = $this->projeto->create($data);          
            $user = auth()->user();
            return response()->json([
                'projeto' => $projeto,
                'user' => $user,
                'status' => 200,
                'message' => 'Projeto adicionado com sucesso!',
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    /**
     * Método para a edição do registro
     */
    public function edit(int $id)
    {             
        $proj = $this->projeto->find($id);   
        $user = auth()->user();

        return response()->json([
            'projeto' => $proj,
            'user' => $user,
            'status' => 200            
        ]);
    }

    /**
     * Método para atualizar o registro editado
     */
    public function update(Request $request,int $id)
    {        
        $validator = Validator::make($request->all(),[
            'nome_projeto' => 'required|max:100',
        ],[
            'nome_projeto.required' => 'O campo Nome é obrigatório!',
            'nome_projeto.max'  => 'O NOME deve conter no máximo :max caracteres!',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{           
            $projeto = Projeto::find($id);
            if($projeto){     
                $projeto->nome_projeto = strtoupper($request->input('nome_projeto'));            
                $projeto->update();    
                $proj = Projeto::find($id);
                $user = auth()->user();
                return response()->json([
                    'projeto'  => $proj,
                    'user' => $user,
                    'status' => 200,
                    'message' => 'Projeto atualizado com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Projeto não localizado!',
                ]);
            }
        }
    }

    /**
     * Método para exclusão de registro recursivamente para o adm
     */
    public function destroy(int $id)
    {
        $projeto = $this->projeto->find($id);
        $bases = $projeto->bases;
        $vms = $projeto->virtual_machines;
        $apps = $projeto->apps;
        if(($projeto->bases()->count())||($projeto->virtual_machines()->count())||($projeto->apps()->count())){
            if((auth()->user()->moderador)&&(!(auth()->user()->inativo))){
                if($projeto->bases()->count()){
                    foreach ($bases as $base) {
                        $b = Base::find($base->id);
                        $aps = $b->apps;                        
                        foreach ($aps as $ap) {
                            $a = App::find($ap->id);
                            $a->delete();
                        }
                        $b->delete();
                    }
                  
                }
                if($projeto->virtual_machines()->count()){
                    foreach ($vms as $vm) {
                        $v = VirtualMachine::find($vm->id);
                        $dbs = $v->bases;
                        foreach ($dbs as $db) {
                            $b = Base::find($db->id);
                            $aps = $b->apps;
                            foreach ($aps as $ap) {
                                $a = App::find($ap->id);
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
                if($projeto->apps()->count()){
                    foreach ($apps as $app) {
                        $a = App::find($app->id);
                        $a->delete();
                    }                 
                }
                $status = 200;
                $message = $projeto->nome_projeto.' excluído com sucesso!';
                $projeto->delete();
            }else{
                $status = 400;
                $message = $projeto->nome_projeto.' não pode ser excluído. Pois há outros registros que dependem dele! Procure um administrador!';
            }
        }else{
            $status = 200;
            $message = $projeto->nome_projeto.' excluído com sucesso!';
            $projeto->delete();
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
