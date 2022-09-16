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

    /**
     * Método para listagem de registro com opção de pesquisa
     *  */ 
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
    
    /**
     * Método para criação de registro novo
     */
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
            $data = [
                'area_conhecimento_id' => $request->input('area_conhecimento_id'),
                'descricao' => strtoupper($request->input('descricao')),             
            ];            
            $sub_area_conhecimento = $this->sub_area_conhecimento->create($data);           
            $area = Area_Conhecimento::find($sub_area_conhecimento->area_conhecimento_id);
            return response()->json([
                'sub_area_conhecimento' => $sub_area_conhecimento,            
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
    
    /**
     * Método para edição de registro
     */
    public function edit(int $id)
    {        
        $sub = $this->sub_area_conhecimento->find($id);
        $area = Area_Conhecimento::find($sub->area_conhecimento_id);               

        return response()->json([            
            'sub_area_conhecimento' => $sub,
            'area_conhecimento' => $area,             
            'status' => 200,
        ]);
    }

    /**
     * Método para atualização de registro editado
     */
    public function update(Request $request,int $id)
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
            $sub_area_conhecimento = $this->sub_area_conhecimento->find($id);            
            if($sub_area_conhecimento){
                $sub_area_conhecimento->area_conhecimento_id = $request->input('area_conhecimento_id');
                $sub_area_conhecimento->descricao = strtoupper($request->input('descricao'));
                $sub_area_conhecimento->updated_at = now();
                $sub_area_conhecimento->update();               
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

    /**
     * Método para exclusão de registro
     */
    public function destroy(int $id)
    {
        $sub_area_conhecimento = $this->sub_area_conhecimento->find($id);
        $sub_area_conhecimento->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }
    
}
