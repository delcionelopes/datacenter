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
            $data = [
                'nome' =>strtoupper($request->input('nome')),
                'telefone' =>$request->input('telefone'),                     
            ];            
            $orgao = $this->orgao->create($data);                      
            return response()->json([
                'orgao'  => $orgao,
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
            $orgao = $this->orgao->find($id);            
            if($orgao){
                $orgao->nome = strtoupper($request->input('nome'));
                $orgao->telefone = $request->input('telefone');
                
                $orgao->update();
               
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
        $orgao = $this->orgao->find($id);

        $vms = $orgao->virtualmachine;
        $apps = $orgao->apps;
        $users = $orgao->users;
        if(($vms)||($apps)||($users)){
            if((auth()->user()->moderador)&&(!(auth()->user()->inativo))){
                if($vms){
                    $orgao->virtualmachine()->detach($vms);
                }
                if($apps){
                    $orgao->apps()->detach($apps);
                }
                if($users){
                    $orgao->users()->detach($users);
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
