<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orgao;
use Illuminate\Support\Facades\Validator;

class OrgaoController extends Controller
{

    private $orgao;

    public function __construct(Orgao $orgao){
        $this->orgao = $orgao;
    }   

    
    public function index(Request $request)
    {        
        if(is_null($request->pesquisanome)){
            $orgaos = $this->orgao->orderByDesc('id')->paginate(10);
        }else{            
            $query = $this->orgao->query()
            ->where('nome','LIKE','%'.strtoupper($request->pesquisanome).'%');            
            $orgaos = $query->orderByDesc('id')->paginate(10);
            
        }
        return view('orgao.index',compact('orgaos'));
    }

    
    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {      
        

        $validator = Validator::make($request->all(),[
            'nome' => 'required|max:191',
            'telefone' => 'required',
        ],[
            'nome.required'   => 'O campo NOME é obrigatório!',
            'nome.max'        => 'O NOME deve conter no máximo :max caracteres!',
            'telefone.required' => 'O campo TELEFONE é obrigatório!',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{  
            $timestamps = $this->orgao->timestamps;
            $this->orgao->timestamps = false;
            $data = [
                'nome' =>strtoupper($request->input('nome')),
                'telefone' =>$request->input('telefone'), 
                'created_at' => now(),
                'updated_at' => null,          
            ];            
            $orgao = $this->orgao->create($data);                        
            $this->orgao->timestamps = true;
            $o = Orgao::find($orgao->id);
            return response()->json([
                'orgao'  => $o,
                'status' => 200,
                'message' => 'Órgão cadastrado com sucesso!',
            ]);
        }
    }
    
    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        $o = $this->orgao->find($id);

        return response()->json([
            'orgao' => $o,
            'status' => 200,
        ]);
    }

    
    public function update(Request $request, $id)
    {        
        $validator = Validator::make($request->all(),[
            'nome'     =>  'required|max:191',
            'telefone' =>  'required',
        ],[
            'nome.required'  => 'O campo NOME é obrigatório!',
            'nome.max'       => 'O NOME deve conter no máximo :max caracteres',
            'telefone.required'  => 'O campo TELEFONE é obrigatório!',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->errors()->getMessages(),
            ]);
        }else{
            $timestamps = $this->orgao->timestamps;
            $this->orgao->timestamps = false;
            $orgao = $this->orgao->find($id);            
            if($orgao){
                $orgao->nome = strtoupper($request->input('nome'));
                $orgao->telefone = $request->input('telefone');
                $orgao->updated_at = now();
                $orgao->update();
                $this->orgao->timestamps = true;
                $o = Orgao::find($id);

                return response()->json([
                    'orgao'   => $o,
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

    public function destroy($id)
    {
        $orgao = Orgao::find($id);
        $orgao->delete();

        return response()->json([
            'status'  =>  200,
            'message' => 'Órgão excluído com sucesso!',
        ]);
    }
}
