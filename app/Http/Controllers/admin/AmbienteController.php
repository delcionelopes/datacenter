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
            $timestamps = $this->ambiente->timestamps;
            $this->ambiente->timestamps=false;       
            $data = [
                'nome_ambiente' => strtoupper($request->input('nome_ambiente')),
                'created_at' => now(),
                'updated_at' => null,
            ];            
            $ambiente = $this->ambiente->create($data);
            $this->ambiente->timestamps=true;
            $a = Ambiente::find($ambiente->id);           
            return response()->json([                
                'ambiente' => $a,
                'status'  => 200,
                'message' => 'Ambiente adicionado com sucesso!',
            ]); 
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)    
    {              
        $a = $this->ambiente->find($id);                    
        
        return response()->json([
            'ambiente'=>$a,
            'status' => 200,]);        
    }

 
    public function update(Request $request, $id)
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
            $timestamps = $this->ambiente->timestamps;
            $this->ambiente->timestamps=false;       
            $ambiente = Ambiente::find($id);                                               
            if($ambiente){
                     $ambiente->nome_ambiente = strtoupper($request->input('nome_ambiente'));
                     $ambiente->updated_at = now();
                     $ambiente->update(); 
                     $this->ambiente->timestamps = true;
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

 
    public function destroy($id)
    {             
        $ambiente = Ambiente::find($id);
        $ambiente->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Ambiente excluído com sucesso!',
        ]);
    }
}
