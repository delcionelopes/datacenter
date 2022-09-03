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
            $data = [
                'descricao' => strtoupper($request->input('descricao')),                             
            ];            
            $area_conhecimento = $this->area_conhecimento->create($data);   
            
            return response()->json([
                'area_conhecimento' => $area_conhecimento,
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
            $area_conhecimento = $this->area_conhecimento->find($id);
            if($area_conhecimento){
                $area_conhecimento->descricao = strtoupper($request->input('descricao'));               
                $area_conhecimento->update();                
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
        $sub_area = $area_conhecimento->sub_area_conhecimento;
        $manuais = $area_conhecimento->manual;
        if(($area_conhecimento->sub_area_conhecimento()->count())||($area_conhecimento->manual()->count())){
            if((auth()->user()->moderador)&&(!(auth()->user()->inativo))){
                if($area_conhecimento->sub_area_conhecimento()->count()){
                    $area_conhecimento->sub_area_conhecimento()->detach($sub_area);
                }
                if($area_conhecimento->manual()->count()){
                    $area_conhecimento->manual()->detach($manuais);
                }
                $status = 200;
                $message = $area_conhecimento->descricao.' excluído com sucesso!';
                $area_conhecimento->delete();
            }else{
                $status = 400;
                $message = $area_conhecimento->descricao.' não pode ser excluído. Pois há outros registros que dependem dele! Procure um administrador!';
            }
        }else{            
            $status = 200;
            $message = $area_conhecimento->descricao.' excluído com sucesso!';
            $area_conhecimento->delete();
        }
        
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
