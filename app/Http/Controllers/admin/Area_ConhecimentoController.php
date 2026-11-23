<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area_Conhecimento;
use App\Models\Area_conhecimento_has_setor;
use App\Models\Arqs;
use App\Models\Setor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class Area_ConhecimentoController extends Controller
{
    private $area_conhecimento;
    private $setor;
    private $areas_setor;
    private $arqs;

    public function __construct(Area_Conhecimento $area_conhecimento, Setor $setor, Area_conhecimento_has_setor $areas_setor,
                                Arqs $arqs)
    {
        $this->area_conhecimento = $area_conhecimento;
        $this->setor = $setor;
        $this->areas_setor = $areas_setor;
        $this->arqs = $arqs;
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

    public function indexAreaPSetor($id){
        $areas = $this->area_conhecimento->orderBy('id','DESC')->get();
        $setor = $this->setor->find($id);
        $areassrelacionadas = $this->areas_setor->query()
                                  ->select('area_conhecimento_id')
                                  ->where('setor_idsetor','=',$setor->id)
                                  ->get();
        $array = [];
        foreach ($areassrelacionadas as $area) {
            $array[] = $area->area_conhecimento_id;
        }
        $areasrelacionadas = $array;

        return response()->json([
            'status' => 200,
            'areas' => $areas,
            'areasrelacionadas' => $areasrelacionadas,
            'setor' => $setor,
        ]);
    }

    public function indexSetores(Request $request,$color){
        if(is_null($request->pesquisa)){
            $setores = $this->setor->orderBy('id','DESC')->paginate(10);
        }else{
            $query = $this->setor->query()
                                 ->where('nome','LIKE','%'.strtoupper($request->pesquisa).'%');
            $setores = $query->orderBy('id','DESC')->paginate(10);
        }
        return view('area_conhecimento.indexsetores',[
            'setores' => $setores,
            'color' => $color,
        ]);
    }

    public function indexAreasRelacionadas($id,$color)
    {       
        $areas = $this->area_conhecimento->orderBy('id','DESC')->get();        
        $setor = $this->setor->find($id);        
        $areasrelacionadas = $this->areas_setor->query()
                                           ->where('setor_idsetor','=',$setor->id)
                                           ->get();  
        
        return view('area_conhecimento.indexsetor',[
            'setor' => $setor,
            'areas' => $areas,
            'areasrelacionadas' => $areasrelacionadas,
            'color' => $color,
        ]);
    }

    public function indexArquivosRelacionados($setorid,$areaid,$color){
        $query = $this->arqs->query()
                     ->where([
                        ['setor_idsetor',$setorid],
                        ['area_conhecimento_id',$areaid],
                     ]);
        $arqs = $query->orderBy('id','DESC')->paginate(10);

        return view('area_conhecimento.indexarquivos',[
            'arqs' => $arqs,
            'color' => $color,
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
                'created_at' => now(),
                'updated_at' => null,
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
                $area_conhecimento->updated_at = now();
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
        if(($area_conhecimento->setores()->count())){
            if((auth()->user()->admin)&&(!(auth()->user()->inativo))){                                
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
