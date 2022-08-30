<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plataforma;
use Illuminate\Support\Facades\Validator;

class PlataformaController extends Controller
{
    
    private $plataforma;

    public function __construct(Plataforma $plataforma)
    {
        $this->plataforma = $plataforma;
    }

    public function index(Request $request)
    {
        if(is_null($request->pesquisanome)){
            $plataformas = $this->plataforma->orderByDesc('id')->paginate(6);            
        }else{
            $query = $this->plataforma->query()
            ->where('nome_plataforma','LIKE','%'.strtoupper($request->pesquisanome.'%'));
            $plataformas = $query->orderByDesc('id')->paginate(6);
        }
        return view('plataforma.index',compact('plataformas'));
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {       

        $validator = Validator::make($request->all(),[
            'nome_plataforma'  => 'required|max:100',
        ],[
            'nome_plataforma.required' => 'O campo NOME é obrigatório!',
            'nome_plataforma.max'   => 'O NOME deve conter no máximo :max caracteres!',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{                    
            $data = [
                'nome_plataforma' => strtoupper($request->input('nome_plataforma')),                           
            ];            
            $plataforma = $this->plataforma->create($data);
            return response()->json([
                'plataforma' => $plataforma,
                'status'  => 200,
                'message' => 'Plataforma cadastrada com sucesso!',
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $p = $this->plataforma->find($id);

        return response()->json([
            'plataforma' => $p,
            'status' => 200,
        ]);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nome_plataforma'  => 'required|max:100',            
        ],[
            'nome_plataforma.required' => 'O campo NOME é obrigatório',
            'nome_plataforma.max'  => 'O NOME deve conter no máximo :max caracteres!',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{            
            $plataforma = $this->plataforma->find($id);
            if($plataforma){
                $plataforma->nome_plataforma = strtoupper($request->input('nome_plataforma'));             
                $plataforma->update();
                
                $p = Plataforma::find($id);

                return response()->json([
                    'plataforma' => $p,
                    'status'  => 200,
                    'message' => 'Plataforma atualizada com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status'  => 404,
                    'message' => 'Plataforma não localizada!',
                ]);
            }
        }
    }

    
    public function destroy($id)
    {
        $plataforma = $this->plataforma->find($id);
        $plataforma->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Plataforma excluída com sucesso!',
        ]);
    }
}
