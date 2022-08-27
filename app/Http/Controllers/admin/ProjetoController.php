<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Projeto;
use Illuminate\Support\Facades\Validator;

class ProjetoController extends Controller
{
    private $projeto;

    public function __construct(Projeto $projeto)
    {
        $this->projeto = $projeto;        
    }


    
    public function index(Request $request)
    {
        if(is_null($request->pesquisanome)){
            $projetos = $this->projeto->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->projeto->query()
            ->where('nome_projeto','LIKE','%'.strtoupper($request->pesquisanome.'%'));
            $projetos = $query->orderByDesc('id')->paginate(6);
        }
        return view('projeto.index',compact('projetos'));
    }

    
    public function create()
    {
        //
    }

    
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
            $timestamps = $this->projeto->timestamps;
            $this->projeto->timestamps = false;
            $data = [
                'nome_projeto' => strtoupper($request->input('nome_projeto')),              
                'created_at' => now(),
                'updated_at' => null,
            ];            
            $projeto = $this->projeto->create($data);                        
            $this->projeto->timestamps = false;
            $p = Projeto::find($projeto->id);
            return response()->json([
                'projeto' => $p,
                'status' => 200,
                'message' => 'Projeto adicionado com sucesso!',
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {             
        $proj = $this->projeto->find($id);                

        return response()->json([
            'projeto' => $proj,
            'status' => 200,
        ]);
    }

    
    public function update(Request $request, $id)
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
            $timestamps = $this->projeto->timestamps;
            $this->projeto->timestamps = false;
            $projeto = Projeto::find($id);
            if($projeto){     
                $projeto->nome_projeto = strtoupper($request->input('nome_projeto'));
                $projeto->updated_at = now();
                $projeto->update();
                $this->projeto->timestamps = true;
                $proj = Projeto::find($id);
                return response()->json([
                    'projeto'  => $proj,
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

    public function destroy($id)
    {
        $projeto = $this->projeto->find($id);
        $projeto->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Projeto excluído com sucesso!',
        ]);
    }
}
