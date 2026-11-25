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

    public function indexAlfa($id)
    {   
        $grupos = $this->area_conhecimento
                       ->whereDoesntHave('Setores',function($query) use($id){
                        $query->where('setor_idsetor','=',$id);
                       })->get();
        $setor = $this->setor->find($id);        
        
        return response()->json([
            'status' => 200,
            'setor' => $setor,
            'grupos' => $grupos,
        ]);
     
  
    }

    public function indexSetores($color){
        $user = auth()->user();        
            $query = $this->setor->query()
                                 ->where('idsetor','=',$user->setor_id);
            $setores = $query->orderBy('idsetor','DESC')->paginate(2);
        
        return view('area_conhecimento.indexsetores',[
            'setores' => $setores,
            'color' => $color,
        ]);
    }

    public function indexAreasRelacionadas($id,$color)
    {   
        $setor = $this->setor->find($id);        
        $areasrelacionadas = $this->areas_setor->query()
                                           ->where('setor_idsetor','=',$setor->idsetor)
                                           ->get();
        
        return view('area_conhecimento.indexgrupo',[
            'setor' => $setor,
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
        $arqs = $query->orderBy('id','DESC')->get();

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

    public function storearea(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'descricao' => ['required','max:80'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{            
            $data['descricao'] = $request->input('descricao');
            $data['created_at'] = now();
            $data['updated_at'] = null;            
            $grupo = $this->area_conhecimento->create($data);

            return response()->json([
                'status' => 200,
                'grupo' => $grupo,
                'message' => 'registro criado com sucesso!',
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

    public function editarea($id){
        $area_conhecimento = $this->area_conhecimento->find($id);

        return response()->json([
            'status' => 200,
            'grupo' => $area_conhecimento,
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

    public function updatearea(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'descricao' => ['required','max:80'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $grupoarquivo = $this->area_conhecimento->find($id);
            if($grupoarquivo){
            $data['descricao'] = strtoupper($request->input('descricao'));            
            $data['updated_at'] = now();
            $grupoarquivo = $this->area_conhecimento->update($data);
            $g = Area_Conhecimento::find($id);

            return response()->json([
                'status' => 200,
                'grupo' => $g,
                'message' => 'registro atualizado com sucesso!',
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

    public function destroyarea($id)
    {
        $area_conhecimento = $this->area_conhecimento->find($id);
        $arquivos = $this->arqs->query()
                                 ->where([                                    
                                    ['area_conhecimento_id',$area_conhecimento->id],
                                 ])->get();
        
        if($arquivos->count()>0){
            return response()->json([
                'status' => 400,
                'message' => 'Este registro não pode ser excluído. Pois, existem outros que dependem dele!',
            ]);
        }else{
                 $this->areas_setor->query()
                                     ->where([
                                        ['area_conhecimento_id',$area_conhecimento->id],
                                     ])->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
        }
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

    public function vincularGruposArquivosXSetores(Request $request, $id){        
        $grupos = json_decode($request->grupos,true);
        if($grupos){
            $setor = $this->setor->find($id);            
            $x = 0;
            foreach ($grupos as $grupo) {  //checa o relacionamento de acordo com o array                
                $qrysetor_grupos = $this->areas_setor->query()
                                   ->where([
                                           ['setor_idsetor',$setor->idsetor],
                                           ['area_conhecimento_id',$grupo],
                                           ]);
                $setor_grupos = $qrysetor_grupos->get();
                if($setor_grupos->count()>0){
                foreach ($setor_grupos as $grupo1) { //verifica os arquivos
                    $arqs = $this->arqs->query()
                                 ->where([
                                    ['setor_idsetor',$setor->idsetor],
                                    ['area_conhecimento_id',$grupo1->area_conhecimento_id],
                                 ]);
                    if($arqs->count()==0){ //se não existirem arquivos, excluir o relacionamento
                        $this->areas_setor->query()
                                 ->where([
                                    ['setor_idsetor',$setor->idsetor],
                                    ['area_conhecimento_id',$grupo1->area_conhecimento_id],
                                 ])->delete();
                    }else{ //se existirem arquivos, exclua-os e depois exclua o relacionamento
                       foreach ($arqs as $arq) {
                            $path = public_path().'/storage/'.$arq->path;
                            if(file_exists($path)){
                                unlink($path);
                            }
                            $a = $this->arqs->find($arq->id);
                            $a->delete;
                       }
                       $this->areas_setor->query()
                                 ->where([
                                    ['setor_idsetor',$setor->idsetor],
                                    ['area_conhecimento_id',$grupo1->area_conhecimento_id],
                                 ])->delete();                        
                    }

                }
            }
                $data[$x]['setor_idsetor'] = $setor->idsetor;
                $data[$x]['area_conhecimento_id'] = $grupo;
                $data[$x]['created_at'] = now();
                $data[$x]['updated_at'] = now();                                   
                $x++;
            }
                Area_conhecimento_has_setor::insert($data);

            return response()->json([
                'status' => 200,
                'message' => 'Regitro atualizado com sucesso!',
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Marque pelo menos uma opção!',
            ]);
        }
    }

    public function mostraarquivos($setorid,$grupoid){
        $qrysetor_grupos = $this->areas_setor->query()
                                   ->with('areaconhecimento')
                                   ->where([
                                           ['setor_idsetor','=',$setorid],
                                           ['area_conhecimento_id','<>',$grupoid],
                                           ]);
        $setor_grupos = $qrysetor_grupos->get();                
        $arquivos = $this->arqs->query()
                              ->where([
                                ['setor_idsetor',$setorid],
                                ['area_conhecimento_id',$grupoid],
                              ])->get();
        return response()->json([
            'status' => 200,
            'arquivos' => $arquivos,
            'setorgrupos' => $setor_grupos,
        ]);
        
    }

    public function uploadDocs(Request $request, $setorid, $grupoid){
         if ($request->TotalFiles>0) 
         {
           $user = auth()->user();    

           for($x = 0; $x < $request->TotalFiles; $x++) 
           {                                              
              if($request->hasFile('arquivo'.$x))
              {
                    $file = $request->file('arquivo'.$x);
                    $fileLabel = $file->getClientOriginalName();
                    $fileName = $setorid.'_'.$grupoid.'_'.$fileLabel;                        
                    $filePath = 'arquivos_setor/'.$fileName;
                    $storagePath = public_path().'/storage/arquivos_setor/';
                    $file->move($storagePath,$fileName);                                                 
                       
                    $data[$x]['setor_idsetor'] = $setorid;
                    $data[$x]['area_conhecimento_id'] = $grupoid;                    
                    $data[$x]['rotulo'] = $fileLabel;
                    $data[$x]['nomereal'] = $fileName;
                    $data[$x]['caminho'] = $filePath;                    
                    $data[$x]['created_at'] = now();
                    $data[$x]['updated_at'] = now();
                    $data[$x]['created_by'] = $user->id;
                    $data[$x]['updated_by'] = $user->id;
                } 
           }                      
             Arqs::insert($data);                                                                  
         } 
         $qrysetor_grupos = $this->areas_setor->query()
                                   ->with('areaconhecimento')
                                   ->where([
                                           ['setor_idsetor','=',$setorid],
                                           ['area_conhecimento_id','<>',$grupoid],
                                           ]);
        $setor_grupos = $qrysetor_grupos->get();
        
             $arquivos = $this->arqs->query()
                              ->where([
                                ['setor_idsetor',$setorid],
                                ['area_conhecimento_id',$grupoid],
                              ])->get();
             return response()->json([
                 'status' => 200,
                 'arquivos' => $arquivos,
                 'setorgrupos' => $setor_grupos,
             ]);  

    }

    public function abrirDoc(int $id){
        $arq = $this->arqs->find($id);
        return response()->json([
            'status' => 200,
            'arquivo' => $arq,
        ]);
    }
    
    public function excluirArquivo($id){
        $arq = $this->arqs->find($id);

        //excluir arquivo do diretório
        if($arq->caminho){
        $path = public_path().'/storage/'.$arq->caminho;
                            if(file_exists($path)){
                                unlink($path);
                            }
        }

        $arq->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    public function moverArquivo(Request $request, $id,$grupoid){
        $arq = $this->arqs->find($id);
        $user = auth()->user();
        $origem = $arq->caminho;
        $file = $arq->setor_idsetor.'_'.$grupoid.'_'.$arq->rotulo;
        $destino = 'arquivos_setor/'.$file;
        $path = public_path().'/storage/';
        //verifica se o arquivo de origem existe
        if(file_exists($path.$origem)){
            if(rename($path.$origem,$path.$destino)){
                $data['area_conhecimento_id'] = $grupoid;
                $data['nomereal'] = $file;
                $data['caminho'] = $destino;
                $data['updated_at'] = now();
                $data['updated_by'] = $user->id;
                $arq->update($data);
                return response()->json([
                    'status' => 200,
                    'message' => 'Arquivo movido com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Erro ao mover arquivo!',
                ]);
            }
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Arquivo não encontrado!',
            ]);
        }
    }

    public function copiarArquivo(Request $request, $id,$grupoid){
        $arq = $this->arqs->find($id);
        $user = auth()->user();
        $origem = $arq->caminho;
        $file = $arq->setor_idsetor.'_'.$grupoid.'_'.$arq->rotulo;
        $destino = 'arquivos_setor/'.$file;
        $path = public_path().'/storage/';
        //verifica se o arquivo de origem existe
        if(file_exists($path.$origem)){
            if(copy($path.$origem,$path.$destino)){
                $data['setor_idsetor'] = $arq->setor_idsetor;
                $data['area_conhecimento_id'] = $grupoid;
                $data['nomereal'] = $file;
                $data['rotulo'] = $arq->rotulo;
                $data['caminho'] = $destino;
                $data['created_at'] = now();
                $data['created_by'] = $user->id;
                $this->arqs->create($data);
                return response()->json([
                    'status' => 200,
                    'message' => 'Arquivo copiado com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Erro ao mover arquivo!',
                ]);
            }
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Arquivo não encontrado!',
            ]);
        }
    }

}
