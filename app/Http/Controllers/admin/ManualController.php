<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area_Conhecimento;
use App\Models\Manual;
use App\Models\Upload;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Facades\Storage;
//use Facade\FlareClient\Stacktrace\File;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
//use PDF;
//use PharIo\Manifest\Url;

class ManualController extends Controller
{

    private $manual;        

    public function __construct(Manual $manual)
    {
        $this->manual = $manual;
    }   
    
    public function index(Request $request)
    {        
        if(is_null($request->pesquisa)){
            $manuais = $this->manual->orderByDesc('id')->paginate(6);
        }else{
            $query = Manual::with('area_conhecimento')
            ->where('descricao','LIKE','%'.strtoupper($request->pesquisa.'%'));            

            $manuais = $query->orderByDesc('id')->paginate(6);            
        }       

        $areas_conhecimento = Area_Conhecimento::all();
        

        return view('manuais.index', compact('manuais','areas_conhecimento'));
        
    }

    
    public function create()
    {
        //
    }
   
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
            $timestamps = $this->manual->timestamps;
            $this->manual->timestamps = false;              
            $data = [
                'area_conhecimento_id' => $request->input('area_conhecimento_id'),
                'data_criacao' => now(),
                'descricao' => strtoupper($request->input('descricao')),
                'objetivo' => strtoupper($request->input('objetivo')),
                'manual' => strtoupper($request->input('manual')),                
                //'usuario' => auth()->user->name,                
                'created_at' => now(),
                'updated_at' => null,
            ];
            $manual = $this->manual->create($data);  
            $this->manual->timestamps = true;
            $m = Manual::find($manual->id);                                                  
            $area = Area_Conhecimento::find($m->area_conhecimento_id);                    
            return response()->json([
                'manual' => $m,
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
        $manual = $this->manual->find($id);
        $area = Area_Conhecimento::find($manual->area_conhecimento_id);

        return response()->json([
            'manual' => $manual,
            'area_conhecimento' => $area,
            'status' => 200,
        ]);
    }
    
    public function update(Request $request, $id)
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
            $timestamp = $this->manual->timestamps;
            $this->manual->timestamps = false;
            $manual = $this->manual->find($id);                        
            if($manual){
                $manual->area_conhecimento_id = $request->input('area_conhecimento_id');
                $manual->descricao = strtoupper($request->input('descricao'));
                $manual->data_atualizacao = now();
                $manual->objetivo = strtoupper($request->input('objetivo'));
                $manual->manual = strtoupper($request->input('manual'));
                //$manual->usuario = auth()->user->name;                
                $manual->updated_at = now();
                $manual->update();                
                $ma = Manual::find($id);                
                $area = Area_Conhecimento::find($ma->area_conhecimento_id);
                $uploads = Upload::query('upload')
                           ->where('manual_id', $id)
                           ->get();

                return response()->json([
                    'manual' => $ma,
                    'uploads' => $uploads,
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
        $manual = $this->manual->find($id);
        $manual->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    public function indexFile($id)
    {
        $uploadsManual = Upload::query('upload')
                         ->where('manual_id',$id)
                         ->get();
        return response()->json([
            'status' => 200,
            'uploads' => $uploadsManual,
        ]);
    }

    public function editFileUpload($id){   
        $manual = $this->manual->find($id);        
        return response()->json([
            'status' => 200,
            'manual' => $manual,
        ]);
    }

    public function upload(Request $request,$id)
    {                           
         $manual = $this->manual->find($id);         
         //Salvar informações no banco através                  
         $TotalFiles = $request->input('TotalFiles');         
         if($TotalFiles>0){
         for($x = 0; $x < $TotalFiles;$x++){
            if($request->hasFile('arquivo'.$x))
            {
                $file = $request->file('arquivo'.$x);                           
                $fileName =  $file->getClientOriginalName();
                $filePath = 'downloads/'.$fileName;
                $storagePath = public_path().'/storage/downloads/';
                $file->move($storagePath,$fileName);    
                
                $data[$x]['manual_id'] = $id;
                $data[$x]['nome_arquivo'] = $fileName;
                $data[$x]['path_arquivo'] = $filePath;
                $data[$x]['data_atual'] = now();
                $data[$x]['created_at'] = now();
                $data[$x]['updated_at'] = null;                          
            }    
        }        
         $arquivo = Upload::insert($data);            
        }
         $manualid = $manual->id;
         $arquivos = $manual->uploads;
         $totalfiles = $manual->uploads->count();         
         return response()->json([       
             'manualid' => $manualid,
             'totalfiles' => $totalfiles,
             'arquivos' => $arquivos,
             'status' => 200,
             'message' => 'Arquivo(s) enviado(s) com sucesso!',
         ]);                   
    }

    public function downloadFile($id){                      
        
        dd('cheguei aqui!');
        $uploadmanual = Upload::find($id);                
        $downloadPath = public_path('/storage/'.$uploadmanual->path_arquivo);  
        
        $headers = [
            'HTTP/1.1 200 OK',
            'Pragma: public',
            'Content-Type: application/pdf'
        ];                  
        return response()->download($downloadPath,$uploadmanual->nome_arquivo,$headers);    
    }

    public function destroyFile($id)
    {
        $uploadmanual = Upload::find($id);        
        $manualid = $uploadmanual->manual_id;
        $uploadPath = public_path('/storage/'.$uploadmanual->path_arquivo);
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
