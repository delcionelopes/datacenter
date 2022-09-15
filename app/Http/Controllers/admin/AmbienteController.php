<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ambiente;
use Illuminate\Support\Facades\Validator;

class AmbienteController extends Controller
{    

    private $ambiente;
    
    public function __construct(Ambiente $ambiente){
        $this->ambiente = $ambiente;
    }

    public function index(Request $request)    
    {                         
        if(is_null($request->nome)){
            $ambientes = $this->ambiente->orderByDesc('id')->paginate(6);
        }else{                                                
            $query = $this->ambiente->query()
                     ->where('nome_ambiente','LIKE','%'.strtoupper($request->nome).'%');                     
            
            $ambientes = $query->orderByDesc('id')->paginate(6);            
            
        }                           
        return view('ambientes.index',[
            'ambientes' => $ambientes,
        ]);                
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {       

        $validator = Validator::make($request->all(),[
            'nome_ambiente' => 'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->errors()->getMessages(),
            ]);
        } else {                 
            $data = [
                'nome_ambiente' => strtoupper($request->input('nome_ambiente')),              
            ];            
            $ambiente = $this->ambiente->create($data);                     
            return response()->json([                
                'ambiente' => $ambiente,
                'status'  => 200,
                'message' => 'Ambiente adicionado com sucesso!',
            ]); 
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(int $id)    
    {              
        $a = $this->ambiente->find($id);                    
        
        return response()->json([
            'ambiente'=>$a,
            'status' => 200,]);        
    }

 
    public function update(Request $request,int $id)
    {     
        
        $validator = Validator::make($request->all(),[
            'nome_ambiente' => 'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'   => 400,
                'errors'   => $validator->errors()->getMessages(), 
            ]);
        }else{           
           
            $ambiente = $this->ambiente->find($id);                                               
            if($ambiente){
                     $ambiente->nome_ambiente = strtoupper($request->input('nome_ambiente'));                     
                     $ambiente->update(); 
                   
                     $a = Ambiente::find($id);                      
                     
                     return response()->json([             
                         'ambiente' => $a,                     
                         'status'    => 200,
                         'message'   => 'Ambiente atualizado com sucesso!',
                     ]);
                } else {
                      return response()->json([
                         'status'   => 404,
                         'message'  => 'Ambiente não localizado!',
            ]);
        }
    }

    }

 
    public function destroy(int $id)
    {        
        $ambiente = $this->ambiente->find($id);
        $vm = $ambiente->virtual_machine;  
        if($ambiente->virtual_machine()->count()){          
            if((auth()->user()->moderador)&&(!(auth()->user()->inativo))){                
                $ambiente->virtual_machine()->detach($vm);                
                $status = 200;
                $message = $ambiente->nome_ambiente.' excluído com sucesso!';                
                $ambiente->delete();
            }else{
                $status = 400;
                $message = $ambiente->nome_ambiente.' não pode ser excluído. Pois há outros registros que dependem dele! Procure um administrador!';
            }
        }else{
            $status = 200;
            $message = $ambiente->nome_ambiente.' excluído com sucesso!';            
            $ambiente->delete();        
        }

        return response()->json([
            'status'  => $status,
            'message' => $message,
        ]);
    }
}
