<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area_Conhecimento;
use App\Models\Manual;
use App\Models\Sub_Area_Conhecimento;
use App\Models\Upload;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class Area_ConhecimentoController extends Controller
{
    private $area_conhecimento;

    public function __construct(Area_Conhecimento $area_conhecimento)
    {
        $this->area_conhecimento = $area_conhecimento;
    }
    
    /**
     * Método de listagem das áreas de conhecimento com opção de pesquisa
     */
    public function index(Request $request, $color)
    {        
        if(is_null($request->nomepesquisa)){
            $areas_conhecimento = $this->area_conhecimento->orderByDesc('id')->paginate(6);
        }else{                 
            $query = $this->area_conhecimento->query()
            ->where('descricao','LIKE','%'.strtoupper($request->nomepesquisa).'%');
            $areas_conhecimento = $query->orderByDesc('id')->paginate(6);
        }
        return view('area_conhecimento.index',[
            'areas_conhecimento' => $areas_conhecimento,
            'color' => $color
        ]);
    }

    
    public function create()
    {
        //
    }

    /**
     * grava o novo registro da área de conhecimento
     */
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
            $user = auth()->user();
            return response()->json([
                'area_conhecimento' => $area_conhecimento,
                'user' => $user,
                'status' => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }

    }

    
    public function show($id)
    {
        //
    }

    /**
     * Método para edição do registro
     */
    public function edit(int $id)
    {     
        $area_C = $this->area_conhecimento->find($id);
        $user = auth()->user();

        return response()->json([
            'area_conhecimento' => $area_C,
            'user' => $user,
            'status' => 200,            
        ]);
    }

    /**
     * Método para atualização do registro editado
     */
    public function update(Request $request, int $id)
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
                $user = auth()->user();
                return response()->json([
                    'area_conhecimento' => $area_C,
                    'user' => $user,
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

    /**
     * Método para exclusão de registro
     */
    public function destroy(int $id)
    {        
        $area_conhecimento = $this->area_conhecimento->find($id);
        $sub_areas = $area_conhecimento->sub_area_conhecimento;
        $manuais = $area_conhecimento->manual;
        if(($area_conhecimento->sub_area_conhecimento()->count())||($area_conhecimento->manual()->count())){
            if((auth()->user()->admin)&&(!(auth()->user()->inativo))){                
                if($area_conhecimento->sub_area_conhecimento()->count()){                                        
                    foreach ($sub_areas as $sub_area) {
                        $s = Sub_Area_Conhecimento::find($sub_area->id);
                        $s->delete();
                    }
                }
                if($area_conhecimento->manual()->count()){
                    foreach ($manuais as $manual) {
                        $m = Manual::find($manual->id);
                        $uploads = $m->uploads;
                        if($m->uploads()->count()){
                            foreach ($uploads as $upload) {
                                $up = Upload::find($upload->id);
                                $upPath = public_path('storage/'.$up->path_arquivo);
                                $up->delete();
                                //deleta o arquivo na pasta do servidor  
                                if(file_exists($upPath)){
                                    unlink($upPath);
                                }                                        
                            }
                        }
                        $m->delete();
                    }                    
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

    //relatórios
    public function relatorioAreas(){
        $areas = $this->area_conhecimento->all();
        $date = now();
        $setor = auth()->user()->setor->nome;
        return Pdf::loadView('relatorios.datacenter.area_subarea',[
            'areas' => $areas,
            'date' => $date,
            'setor' => $setor,
        ])->stream('area_subarea.pdf');        
    }

}
