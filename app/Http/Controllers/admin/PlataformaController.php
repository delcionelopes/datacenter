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

    /**
     * Método para listar plataformas parametrizada pela pesquisa
     */
    public function index(Request $request, $color)
    {
        if(is_null($request->pesquisanome)){
            $plataformas = $this->plataforma->orderByDesc('id')->paginate(6);            
        }else{
            $query = $this->plataforma->query()
            ->where('nome_plataforma','LIKE','%'.strtoupper($request->pesquisanome.'%'));
            $plataformas = $query->orderByDesc('id')->paginate(6);
        }
        return view('plataforma.index',[
            'plataformas' => $plataformas,
            'color' => $color 
        ]);
    }

    
    public function create()
    {
        //
    }

    /**
     * Método para gravar um novo registro
     */
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
            $user = auth()->user();
            return response()->json([
                'plataforma' => $plataforma,
                'user' => $user,
                'status'  => 200,
                'message' => 'Plataforma cadastrada com sucesso!',
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
        $p = $this->plataforma->find($id);
        $user = auth()->user();

        return response()->json([
            'plataforma' => $p,
            'user' => $user,
            'status' => 200,            
        ]);
    }

    /**
     * Método para atualização de registro editado
     */
    public function update(Request $request,int $id)
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
                $user = auth()->user();

                return response()->json([
                    'plataforma' => $p,
                    'user' => $user,
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

    /**
     * Método para exclusão de registro
     */
    public function destroy(int $id)
    {
        $plataforma = $this->plataforma->find($id);
        $plataforma->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Plataforma excluída com sucesso!',
        ]);
    }
}
