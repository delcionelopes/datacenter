<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area_Conhecimento;
use App\Models\Manual;
use App\Models\Upload;
use Illuminate\Support\Facades\Validator;

class ManualController extends Controller
{

    private $manual;        

    public function __construct(Manual $manual)
    {
        $this->manual = $manual;
    }   
    
    /**
     * Método para listagem de manuais com opção de pesquisa
     */
    public function index(Request $request, $color)
    {        
        if(is_null($request->pesquisa)){
            $manuais = $this->manual->orderByDesc('id')->paginate(6);
        }else{
            $query = Manual::with('area_conhecimento')
            ->where('descricao','LIKE','%'.strtoupper($request->pesquisa.'%'));            

            $manuais = $query->orderByDesc('id')->paginate(6);            
        }       

        $areas_conhecimento = Area_Conhecimento::all();
        

        return view('manuais.index', [
            'manuais' => $manuais,
            'areas_conhecimento' => $areas_conhecimento,
            'color' => $color
        ]);
        
    }

    
    public function create()
    {
        //
    }
    /**
     * Método para gravação de novo manual
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'area_conhecimento_id' => 'required',
            'descricao' => 'required|max:100',
            'objetivo' => 'required',
            'manual'  => 'required',            
        ],[
            'area_conhecimento_id.required' => 'A ÁREA DE CONHECIMENTO é obrigatória!',
            'descricao.required' => 'O campo DESCRIÇÃO é obrigatório!',
            'descricao.max' => 'A DESCRIÇÃO deve conter no máximo :max caracteres!',
            'objetivo.required' => 'O OBJETIVO é obrigatório!',
            'manual.required' => 'O MANUAL é obrigatório!',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{       
            $user = auth()->user();
            $data = [
                'area_conhecimento_id' => $request->input('area_conhecimento_id'),                
                'descricao' => strtoupper($request->input('descricao')),
                'objetivo' => strtoupper($request->input('objetivo')),
                'manual' => strtoupper($request->input('manual')),
                'setor_idsetor' => $user->setor_idsetor,
                'created_at' => now(),
            ];
            $manual = $this->manual->create($data);            
                                                       
            $area = Area_Conhecimento::find($manual->area_conhecimento_id);                    
            return response()->json([
                'manual' => $manual,
                'area_conhecimento' => $area,
                'user' => $user,
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
     * Método para edição de registro do manual
     */
    public function edit(int $id)
    {
        $manual = $this->manual->find($id);
        $area = Area_Conhecimento::find($manual->area_conhecimento_id);
        $user = auth()->user();
        $setor = $manual->setor;
        return response()->json([
            'manual' => $manual,
            'user' => $user,
            'setor' => $setor,
            'area_conhecimento' => $area,
            'status' => 200,
        ]);
    }
    
    /**
     * Método para atualizar o registro editado
     */
    public function update(Request $request,int $id)
    {                   
        $validator = Validator::make($request->all(),[
            'area_conhecimento_id' => 'required',
            'descricao' => 'required|max:100',
            'objetivo' => 'required',
            'manual'  => 'required',            
        ],[
            'area_conhecimento_id.required' => 'A ÁREA DE CONHECIMENTO é obrigatória!',
            'descricao.required' => 'O campo DESCRIÇÃO é obrigatório!',
            'descricao.max' => 'A DESCRIÇÃO deve conter no máximo :max caracteres!',
            'objetivo.required' => 'O campo OBJETIVO é obrigatório!',
            'manual.required' => 'O campo MANUAL é obrigatório!',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{        
            $manual = $this->manual->find($id);                        
            $user = auth()->user();
            if($manual){
                $manual->area_conhecimento_id = $request->input('area_conhecimento_id');
                $manual->descricao = strtoupper($request->input('descricao'));               
                $manual->objetivo = strtoupper($request->input('objetivo'));
                $manual->manual = strtoupper($request->input('manual'));
                $manual->setor_idsetor = $user->setor_idsetor;
                $manual->updated_at = now();
                $manual->update();                
                $ma = Manual::find($id);                
                $area = Area_Conhecimento::find($ma->area_conhecimento_id);
                $uploads = Upload::query('upload')
                           ->where('manual_id', $id)
                           ->get();
                $setor = $ma->setor;
                

                return response()->json([
                    'manual' => $ma,
                    'uploads' => $uploads,
                    'area_conhecimento' => $area,
                    'user' => $user,
                    'setor' => $setor,
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
     * Método para exclusão de registro recursivamente para o administrador
     */
    public function destroy(int $id)
    {
        $manual = $this->manual->find($id);  
        $descricao = $this->manual->descricao;              
        if($manual->uploads()->count()){            
            $message = 'Este registro não pode ser excluído. Pois existem arquivos que dependem dele!'; 
            $status = 400;                           
        }else{                
        $message = $descricao.' excluído com sucesso!';
        $status = 200;
        $manual->delete();
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    /**
     * lista os arquivos anexados do manual
     */
    public function indexFile(int $id)
    {
        $uploadsManual = Upload::query('upload')
                         ->where('manual_id',$id)
                         ->get();
        return response()->json([
            'status' => 200,
            'uploads' => $uploadsManual,
        ]);
    }

    //edita manual
    public function editFileUpload(int $id){   
        $manual = $this->manual->find($id);        
        return response()->json([
            'status' => 200,
            'manual' => $manual,
        ]);
    }

    //upload de arquivos anexados do manual
    public function upload(Request $request,int $id)
    {                           
         $manual = $this->manual->find($id);
         $setor = $manual->setor;
         $user = auth()->user();              
         $TotalFiles = $request->input('TotalFiles');         
         if($TotalFiles>0){
         for($x = 0; $x < $TotalFiles;$x++){
            if($request->hasFile('arquivo'.$x))
            {
                $file = $request->file('arquivo'.$x);                           
                $fileName =  $id.'_'.$file->getClientOriginalName();
                $filePath = 'downloads/'.$fileName;
                $storagePath = public_path('/storage/downloads/');
                $file->move($storagePath,$fileName);    
                
                $data[$x]['manual_id'] = $id;
                $data[$x]['nome_arquivo'] = $fileName;
                $data[$x]['path_arquivo'] = $filePath;
                $data[$x]['data_atual'] = now();                                     
            }    
        }        
         $arquivo = Upload::insert($data);            
        }
         $manualid = $manual->id;
         $arquivos = $manual->uploads;
         $totalfiles = $manual->uploads->count();         
         return response()->json([       
             'manualid' => $manualid,
             'manual' => $manual,
             'user' => $user,
             'setor' => $setor,
             'totalfiles' => $totalfiles,
             'arquivos' => $arquivos,
             'status' => 200,
             'message' => 'Arquivo(s) enviado(s) com sucesso!',
         ]);                   
    }

    /**
     * método para baixar o arquivo
     */
    public function downloadFile(int $id){        
       
        $uploadmanual = Upload::find($id);                
        $downloadPath = public_path('storage/'.$uploadmanual->path_arquivo);       
        $headers = [
            'HTTP/1.1 200 OK',
            'Pragma' => 'public',
            'Content-Type' => 'application/pdf'         
        ];  
                   
        return response()->download($downloadPath,$uploadmanual->nome_arquivo,$headers);    
    }

    /**
     * Método para exclusão de arquivos anexados ao manual
     */
    public function destroyFile(int $id)
    {
        $uploadmanual = Upload::find($id);        
        $manualid = $uploadmanual->manual_id;
        $uploadPath = public_path('storage/'.$uploadmanual->path_arquivo);
        $uploadmanual->delete();
        //deleta o arquivo na pasta   
        if(file_exists($uploadPath)){
            unlink($uploadPath);
        }        
        $manual = $this->manual->find($manualid);
        $totalfiles = $manual->uploads->count();        
        return response()->json([        
            'status' => 200,
            'manualid' => $manualid,
            'totalfiles' => $totalfiles,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }


}
