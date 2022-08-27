<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area_Conhecimento;
use Illuminate\Support\Facades\Validator;

class Area_ConhecimentoController extends Controller
{
    private $area_conhecimento;

    public function __construct(Area_Conhecimento $area_conhecimento)
    {
        $this->area_conhecimento = $area_conhecimento;
    }

    public function index(Request $request)
    {
        if(is_null($request->nomepesquisa)){
            $areas_conhecimento = $this->area_conhecimento->orderByDesc('id')->paginate(6);
        }else{            
            $query = $this->area_conhecimento->query()
            ->where('descricao','LIKE','%'.strtoupper($request->nomepesquisa).'%');
            $areas_conhecimento = $query->orderByDesc('id')->paginate(6);
        }
        return view('area_conhecimento.index',compact('areas_conhecimento'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {             

        $validator = Validator::make($request->all(),[
            'descricao'  => 'required|max:80',
        ],[
            'descricao.required' => 'O campo DESCRIÇÃO é obrigatório!',
            'descricao.max'   => 'A DESCRIÇÃO deve conter no máximno :max caracteres!',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{    
            $timestamps = $this->area_conhecimento->timestamps;        
            $this->area_conhecimento->timestamps = false;
            $data = [
                'descricao' => strtoupper($request->input('descricao')),              
                'created_at' => now(),
                'updated_at' => null,
            ];            
            $area_conhecimento = $this->area_conhecimento->create($data);
            $this->area_conhecimento->timestamps = true;
            $area_C = Area_Conhecimento::find($area_conhecimento->id);
            return response()->json([
                'area_conhecimento' => $area_C,
                'status' => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }

    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $area_C = $this->area_conhecimento->find($id);

        return response()->json([
            'area_conhecimento' => $area_C,
            'status' => 200,            
        ]);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'descricao' => 'required|max:80',
        ],[
            'descricao.required' => 'O campo DESCRIÇÃO é obrigatório!',
            'descricao.max'  => 'A DESCRIÇÃO deve conter no máximo :max caracteres!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $timestamps = $this->area_conhecimento->timestamps;        
            $this->area_conhecimento->timestamps = false;
            $area_conhecimento = $this->area_conhecimento->find($id);
            if($area_conhecimento){
                $area_conhecimento->descricao = strtoupper($request->input('descricao'));
                $area_conhecimento->updated_at = now();
                $area_conhecimento->update();
                $this->area_conhecimento->timestamps = true;
                $area_C = Area_Conhecimento::find($id);
                return response()->json([
                    'area_conhecimento' => $area_C,
                    'status' => 200,
                    'message' => 'Registro atualizado com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Registro não encontrado!',
                ]);
            }
        }

    }

    public function destroy($id)
    {
        $area_conhecimento = $this->area_conhecimento->find($id);
        $area_conhecimento->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }
}
