<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sub_Area_Conhecimento;
use App\Models\Area_Conhecimento;
use Illuminate\Support\Facades\Validator;

class Sub_Area_ConhecimentoController extends Controller
{
    private $sub_area_conhecimento;

    public function __construct(Sub_Area_Conhecimento $sub_area_conhecimento)
    {
        $this->sub_area_conhecimento = $sub_area_conhecimento;        
    }
 
    public function index(Request $request)
    {
        if(is_null($request->nomepesquisa)){
            $sub_areas_conhecimento = $this->sub_area_conhecimento->orderByDesc('id')->paginate(6);
        }else{
            $query = Sub_Area_Conhecimento::with('area_conhecimento')
            ->where('descricao','LIKE','%'.strtoupper($request->nomepesquisa).'%');
            $sub_areas_conhecimento = $query->orderByDesc('id')->paginate(6);
        }
            $areas_conhecimento = Area_Conhecimento::all();
            
        return view('sub_area_conhecimento.index',compact('sub_areas_conhecimento','areas_conhecimento'));
    }

    
    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {       
        $validator = Validator::make($request->all(),[
            'area_conhecimento_id' => 'required',
            'descricao'            => 'required|max:191',
        ],[
            'area_conhecimento_id.required' => 'A ÁREA DE CONHECIMENTO é obrigatória!',
            'descricao.required'            => 'O campo DESCRIÇÃO é obrigatório!',
            'descricao.max'                 => 'A DESCRIÇÃO deve conter no máximo :max caracteres!',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{              
            $timestamps = $this->sub_area_conhecimento->timestamps;
            $this->sub_area_conhecimento->timestamps = false;
            $data = [
                'area_conhecimento_id' => $request->input('area_conhecimento_id'),
                'descricao' => strtoupper($request->input('descricao')),
                'created_at' => now(),
                'updated_at' => null,
            ];            
            $sub_area_conhecimento = $this->sub_area_conhecimento->create($data);                        
            $this->sub_area_conhecimento->timestamps = true;
            $s = Sub_Area_Conhecimento::find($sub_area_conhecimento->id);
            $area = Area_Conhecimento::find($sub_area_conhecimento->area_conhecimento_id);
            return response()->json([
                'sub_area_conhecimento' => $s,            
                'area_conhecimento' => $area,
                'status' => 200,
                'message' => 'Registro cadastrado com sucesso!',
            ]);
        }
    }
    
    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {        
        $sub = $this->sub_area_conhecimento->find($id);
        $area = Area_Conhecimento::find($sub->area_conhecimento_id);               

        return response()->json([            
            'sub_area_conhecimento' => $sub,
            'area_conhecimento' => $area,             
            'status' => 200,
        ]);
    }

    public function update(Request $request, $id)
    {       
        $validator = Validator::make($request->all(),[
            'area_conhecimento_id'  => 'required',
            'descricao'             => 'required|max:191',
        ],[
            'area_conhecimento_id.required' => 'A AREA DE CONHECIMENTO é obrigatória!',
            'descricao.required'            => 'A DESCRIÇÃO é obrigatória!',
            'descricao.max'                 => 'A DESCRIÇÃO deve conter no máximo :max caracteres!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $timestamps = $this->sub_area_conhecimento->timestamps;
            $this->sub_area_conhecimento->timestamps = false;
            $sub_area_conhecimento = $this->sub_area_conhecimento->find($id);            
            if($sub_area_conhecimento){
                $sub_area_conhecimento->area_conhecimento_id = $request->input('area_conhecimento_id');
                $sub_area_conhecimento->descricao = strtoupper($request->input('descricao'));
                $sub_area_conhecimento->updated_at = now();
                $sub_area_conhecimento->update();
                $this->sub_area_conhecimento->timestamps = true;
                $sub = Sub_Area_Conhecimento::find($id);
                $area = Area_Conhecimento::find($sub->area_conhecimento_id);
                return response()->json([
                    'sub_area_conhecimento' => $sub,
                    'area_conhecimento' => $area,
                    'status' => 200,
                    'message' => 'Registro atualizado com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Registro não localizado!',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $sub_area_conhecimento = $this->sub_area_conhecimento->find($id);
        $sub_area_conhecimento->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }
    
}
