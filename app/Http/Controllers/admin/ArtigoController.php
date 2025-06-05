<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arquivo;
use App\Models\Artigo;
use App\Models\Institucional;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArtigoController extends Controller
{
    private $artigo;
    private $tema;
    private $arquivo;
    private $institucional;

    public function __construct(Artigo $artigo, Tema $tema, Arquivo $arquivo, Institucional $institucional)
    {
        $this->artigo = $artigo;
        $this->tema = $tema;
        $this->arquivo = $arquivo;
        $this->institucional = $institucional;
    }

    public function index(Request $request,$color)
    {     
        if(is_null($request->pesquisa)){
            $artigos = $this->artigo->orderBy('id','DESC')->paginate(5);                           
        }else{
            $query = Artigo::with('User')
                         ->where('titulo','LIKE','%'.$request->pesquisa.'%');         
            $artigos = $query->orderBy('id','DESC')->paginate(5);
        }        
        return view('artigos.index',[
            'artigos' => $artigos,
            'color' => $color,
        ]);
    }

    
    public function create($color)
    {       
        $temas = $this->tema->all('id','titulo');
        $institucionais = $this->institucional->all('id','nome');
        return view('artigos.create',[
            'temas' => $temas,
            'color' => $color,
            'institucionais' => $institucionais,
        ]);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'titulo'    => ['required','max:100'],
            'descricao' => ['required','max:180'],
            'conteudo'  => ['required'],
            'temas' => ['required','array','min:1'],
            'institucionais' => ['required','array','min:1'],
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $filePath = "";
            if($request->hasFile('imagem')){
                $file = $request->file('imagem');
                $fileName = $file->getClientOriginalName();
                $filePath = 'img/'.$fileName;
                $storagePath = public_path().'/storage/img/';
                $file->move($storagePath,$fileName);

                //excluir imagem temporária
                $tempPath = public_path().'/storage/temp/'.$fileName;
                if(file_exists($tempPath)){
                    unlink($tempPath);
                }
            }
            $user = auth()->user();
            $id = $this->maxId();
            $data['id'] = $id;
            $data['titulo'] = $request->input('titulo');
            $data['descricao'] = $request->input('descricao');
            $data['conteudo'] = $request->input('conteudo');
            $data['slug'] = $id;
            if($filePath){
                $data['imagem'] = $filePath;
            }
            $data['user_id'] = $user->id;
            $data['created_at'] = now();
            $data['updated_at'] = null;
            
            $artigo = $this->artigo->create($data);      //criação do artigo                                          
            
            $artigo->temas()->sync(json_decode($request->input('temas')));  //sincronização
            $artigo->institucionais()->sync(json_decode($request->input('institucionais')));  //sincronização
            
            return response()->json([                
                'status'  => 200,            
            ]);            
        }             

    }

    
    public function show($id)
    {
        //
    }

    
    public function edit(int $id, $color)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $artigo = $this->artigo->find($id);
        $temas = $this->tema->all('id','titulo');
        $institucionais = $this->institucional->all('id','nome');
        return view('artigos.edit',[
            'temas'  => $temas,
            'artigo' => $artigo,
            'color' => $color,
            'institucionais' => $institucionais,
        ]);
   
    }

    
    public function update(Request $request, int $id)
    {        
        $validator = Validator::make($request->all(),[
            'titulo'    => ['required','max:100'],
            'descricao' => ['required','max:180'],
            'conteudo'  => ['required'],        
            'temas' => ['required','min:1'],
            'institucionais' => ['required','min:1'],
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $artigo = $this->artigo->find($id);            
            $user = auth()->user();
            if($artigo){
                $filePath = "";
                if($request->hasFile('imagem')){
                    //exclui a imagem antiga do diretório se houver
                    if($artigo->imagem){
                        $antigoPath = public_path().'/storage/'.$artigo->imagem;
                        if(file_exists($antigoPath)){
                            unlink($antigoPath);
                        }
                    }

                    //armazena a nova imagem
                    $file = $request->file('imagem');
                    $fileName = $file->getClientOriginalName();
                    $filePath = 'img/'.$fileName;
                    $storagePath = public_path().'/storage/img/';
                    $file->move($storagePath,$fileName);

                    //exclui imagem da pasta temporária
                    $tempPath = public_path().'/storage/temp/'.$fileName;
                    if(file_exists($tempPath)){
                        unlink($tempPath);
                    }

                }

                $data['titulo'] = $request->input('titulo');
                $data['descricao'] = $request->input('descricao');
                $data['conteudo'] = $request->input('conteudo');
                if($filePath){
                    $data['imagem'] = $filePath;
                }
                $data['user_id'] = $user->id;
                $data['updated_at'] = now();
                
                $artigo->update($data);       //atualização retorna um booleano  
                $a = Artigo::find($id);   //localização do artigo atualizado pelo $id
                $a->temas()->sync(json_decode($request->input('temas'))); //sync()temas do artigo
                $a->institucionais()->sync(json_decode($request->input('institucionais'))); 
                
                return response()->json([
                    'status'  => 200,                
                ]);
            }else{
                return response()->json([
                    'status'  => 404,
                    'message' => 'Artigo não localizado!',
                ]);
            }
        }   

    }

    
    public function destroy(int $id)
    {
        $artigo = $this->artigo->find($id);
        $t = $artigo->temas; //os dados de temas são atribuídos a variável $t
        $i = $artigo->institucionais;
        $artigo->temas()->detach($t); //exclui os dados de temas()
        $artigo->institucionais()->detach($i);
        if($artigo->imagem)
        {
            //deleção do arquivo de imagem do diretório
            $arquivoPath = public_path().'/storage/'.$artigo->imagem;
            if(file_exists($arquivoPath)){
                unlink($arquivoPath);
            }
        }
        if($artigo->arquivos->count()>0) //se houver arquivo cadastrado
        {
            foreach($artigo->arquivos as $arqs) //arquivos relacionados
            {
                $this->deleteArquivo($arqs->id); //exclui o registro e o arquivo
            }
        } 
        if($artigo->comentarios->count()>0) //Se houver comentário
        {
                $comentarios = $artigo->comentarios;         
                $artigo->comentarios()->delete($comentarios);            
        }      
        $artigo->delete(); //deleta o artigo
        return response()->json([
            'status'  => 200,
            'message' => 'Artigo excluído com sucesso!',
        ]);
    }

    public function armazenarImagemTemporaria(Request $request){
            if($request->hasFile('imagem')){
            $file = $request->file('imagem');                           
            $fileName =  $file->getClientOriginalName();        
            $storagePath = public_path().'/storage/temp/';
            $filePath = 'storage/temp/'.$fileName;
            $file->move($storagePath,$fileName);            
            }
            return response()->json([
                'status' => 200,
                'filepath' => $filePath,
            ]);        
    }

    
     public function excluirImagemTemporaria(Request $request){
         //exclui a imagem temporária no diretório se houver
                if($request->hasFile('imagem')){
                    $file = $request->file('imagem');
                    $filename = $file->getClientOriginalName();
                    $antigoPath = public_path().'/storage/temp/'.$filename;
                    if(file_exists($antigoPath)){
                        unlink($antigoPath);
                    }
                }     
        return response()->json([
            'status' => 200,            
        ]);
    }

    public function uploadDocs(Request $request, int $id){             
         if ($request->TotalFiles>0) 
         {
           $user = auth()->user();
           $arquivo = $this->arquivo->orderByDesc('id')->first();
           if($arquivo){
            $maxid = $arquivo->id;
           }else{
            $maxid = 0;
           }

           for($x = 0; $x < $request->TotalFiles; $x++) 
           {                                              
              if($request->hasFile('arquivo'.$x))
              {
                    $file = $request->file('arquivo'.$x);
                    $fileLabel = $file->getClientOriginalName();
                    $fileName = $id.'_'.$fileLabel;                        
                    $filePath = 'arquivos/'.$fileName;
                    $storagePath = public_path().'/storage/arquivos/';
                    $file->move($storagePath,$fileName);                                                 

                    $maxid++;
                    
                    $data[$x]['id'] = $maxid;
                    $data[$x]['user_id'] = $user->id;
                    $data[$x]['artigos_id'] = $id;                    
                    $data[$x]['rotulo'] = $fileLabel;
                    $data[$x]['nome'] = $fileName;
                    $data[$x]['path'] = $filePath;                    
                    $data[$x]['created_at'] = now();
                    $data[$x]['updated_at'] = null;
                } 
           }                      
             Arquivo::insert($data);                                                                  
         }    
             $artigo = $this->artigo->find($id);             
             $arquivos = $artigo->arquivos;
             return response()->json([
                 'artigo' => $artigo,                 
                 'arquivos' => $arquivos,
                 'status' => 200,                 
             ]);  

    }

    public function deleteDocs(int $id){        
            $arquivo = $this->arquivo->find($id);    
            $artigoid = $arquivo->artigos_id;
            //deleção do arquivo na pasta /storage/arquivos/   
            $arquivoPath = public_path('/storage/'.$arquivo->path);
            if(file_exists($arquivoPath)){
                unlink($arquivoPath);
            }    
            //excluir na tabela                             
            $arquivo->delete();
            $artigo = $this->artigo->find($artigoid);    
            return response()->json([
                'artigo' => $artigo,
                'status' => 200,                
            ]);        
    }

    public function abrirDoc(int $id){
        $arquivo = $this->arquivo->find($id);
        return response()->json([
            'status' => 200,
            'arquivo' => $arquivo,
        ]);
    }  

    public function deleteArquivo(int $id){        
        $arquivo = Arquivo::find($id);
        $artigoid = $arquivo->artigos_id;  
        //deleção o arquivo na pasta /storage/arquivos/   
        $arquivoPath = public_path('/storage/'.$arquivo->path);                    
        if(file_exists($arquivoPath)){
            unlink($arquivoPath);
        }    
        //excluir na tabela                             
        $arquivo->delete();        
        return true;        
    }

    protected function maxId(){
        $artigo = $this->artigo->orderByDesc('id')->first();
        if($artigo){
            $codigo = $artigo->id;
        }else{
            $codigo = 0;
        }
        return $codigo+1;
    }

}
