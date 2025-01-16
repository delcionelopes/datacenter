<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Arquivo;
use App\Models\Artigo;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ArtigoController extends Controller
{
    private $artigo;                            
    private $arquivo;                            

    public function __construct(Artigo $artigo, Arquivo $arquivo)
    {
        $this->artigo = $artigo;                  
        $this->arquivo = $arquivo;
    }

    public function index(Request $request)
    {     
        if(is_null($request->pesquisa)){
            $artigos = $this->artigo->orderBy('id','DESC')->paginate(5);                           
        }else{
            $query = Artigo::with('User')
                         ->where('titulo','LIKE','%'.$request->pesquisa.'%');         
            $artigos = $query->orderBy('id','DESC')->paginate(5);
        }            
            $temas = Tema::all('id','titulo'); //Todos os temas
        return view('artigos.index',compact('artigos','temas'));
    }

    
    public function create()
    {
        //return view('artigos.create');
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'titulo'    => 'required|max:100',
            'descricao' => 'required|max:180',
            'conteudo'  => 'required',
        ],[
            'titulo.required'    => 'O campo TÍTULO é obrigatório!',
            'titulo.max'         => 'O TÍTULO deve conter no máximo :max caracteres!',
            'descricao.required' => 'O campo DESCRIÇÃO é obrigatório!',
            'descricao.max'      => 'A DESCRIÇÃO deve conter no máximo :max caracteres!',
            'conteudo.required'  => 'O campo CONTEÚDO é obrigatório',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $user = auth()->user();            
            $data = [
                'id' => $this->maxidartigos_inc(),
                'titulo'     => $request->input('titulo'),
                'descricao'  => $request->input('descricao'),
                'conteudo'   => $request->input('conteudo'),
                //'slug'       => $request->input('slug'),
                'user_id'    => $user->id,                
            ];
            $artigo = $this->artigo->create($data);      //criação do artigo                                                      
            $artigo->temas()->sync($request->input('temas'));  //sincronização
            $a = Artigo::find($artigo->id);            
            return response()->json([                
                'user'  => $user,
                'artigo' => $a,
                'status'  => 200,
                'message' => 'Artigo adicionado com sucesso!',
            ]);            
        }             

    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $artigo = $this->artigo->find($id);
        $temas = $artigo->temas; //Apenas os temas relacionados        
        return response()->json([
            'temas'  => $temas,  //Envio do objeto no response
            'artigo' => $artigo,
            'status' => 200,
        ]);
   
    }

    
    public function update(Request $request, $id)
    {        
        $validator = Validator::make($request->all(),[
            'titulo'    => 'required|max:100',
            'descricao' => 'required|max:180',
            'conteudo'  => 'required',
        ],[
            'titulo.required'    => 'O campo TÍTULO é obrigatório!',
            'titulo.max'         => 'O TÍTULO deve conter no máximo :max caracteres!',
            'descricao.required' => 'O campo DESCRIÇÃO é obrigatório!',
            'descricao.max'      => 'A DESCRIÇÃO deve conter no máximo :max caracteres!',
            'conteudo.required'  => 'O campo CONTEÚDO é obrigatório',
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
                $data = [
                    'titulo' => $request->input('titulo'),
                    'descricao' => $request->input('descricao'),
                    'conteudo' => $request->input('conteudo'),
                    //'slug' => $request->input('slug'),
                    'user_id' => $user->id,                                                
                    ];               
                $artigo->update($data);       //atualização retorna um booleano  
                $a = Artigo::find($id);   //localização do artigo atual pelo $id
                $a->temas()->sync($request->input('temas')); //sync()temas do artigo
                $arquivos = $a->arquivos;
                $totalarqs = $a->arquivos->count();
                return response()->json([
                    'arquivos'=>$arquivos,
                    'totalarqs'=>$totalarqs,
                    'user'    => $user,
                    'artigo'  => $a,                    
                    'status'  => 200,
                    'message' => 'Artigo atualizado com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status'  => 404,
                    'message' => 'Artigo não localizado!',
                ]);
            }
        }   

    }

    
    public function destroy($id)
    {
        $artigo = $this->artigo->find($id);
        $t = $artigo->temas; //os dados de temas são atribuídos a variável $t
        $artigo->temas()->detach($t); //exclui os dados de temas()
        if($artigo->imagem)
        {
            $this->deleteCapa($id); //exclui a capa e o arquivo
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

    public function editCapa($id){
        $artigo = $this->artigo->find($id);
        return response()->json([
            'artigo' => $artigo,
            'status' => 200,
        ]);
    }

    public function uploadCapa(Request $request, $id){
        //Salvar arquivo no diretório                 
        $file = $request->file('imagem');                           
        $fileName =  $id.'_'.$file->getClientOriginalName();
        $filePath = 'img/'.$fileName;
        $storagePath = public_path().'/storage/img/';
        $file->move($storagePath,$fileName);   

        //salvar informações no banco
        $artigo = $this->artigo->find($id);
        $data = [                          
            'imagem' => $filePath,             
        ];                        
        $artigo->update($data);
        $a = Artigo::find($id);
        return response()->json([
            'artigo' => $a,
            'status' => 200,
            'message' => 'A capa foi adicionada com sucesso!',
        ]);
   }

   public function deleteCapa($id){
    $artigo = $this->artigo->find($id);
    $capaPath = public_path('/storage/'.$artigo->imagem);        
    //deleta o arquivo na pasta   
    if(file_exists($capaPath)){
        unlink($capaPath);
    }    
    //limpa o campo imagem na tabela   
    $data = [                          
        'imagem' => null,             
    ];                        
    $artigo->update($data);  //atualização
    $a = Artigo::find($id); //registro atualizado
    return response()->json([
        'artigo' => $a,
        'status' => 200,
        'message' => 'A capa foi excluída com sucesso!',
    ]);
}

public function editArquivo($id){
    $artigo = $this->artigo->find($id);
    return response()->json([            
        'artigo' => $artigo,
        'status' => 200,
    ]);
}

public function uploadArquivo(Request $request, $id){     
    //seta o artigo e o usuário                     
    $artigo = $this->artigo->find($id);
    $user = auth()->user();
    //pega o array de arquivos          
    if ($request->TotalFiles>0) 
    {
           for($x = 0; $x < $request->TotalFiles; $x++) 
           {                                              
              if($request->hasFile('arquivo'.$x))
              {
                    $file = $request->file('arquivo'.$x);
                    $fileLabel = $file->getClientOriginalName();
                    $fileName = $artigo->id.'_'.$fileLabel;                        
                    $filePath = 'arq/'.$fileName;
                    $storagePath = public_path().'/storage/arq/';
                    $file->move($storagePath,$fileName);                                                 
                    
                    $data[$x]['id'] = $this->maxidarquivo_inc();
                    $data[$x]['artigos_id'] = $id;
                    $data[$x]['user_id'] = $user->id; 
                    $data[$x]['rotulo'] = $fileLabel;
                    $data[$x]['nome'] = $fileName;
                    $data[$x]['path'] = $filePath;                    
                } 
           }                  
             $arquivo = Arquivo::insert($data);                                                                  
   }    
             $artigoid = $artigo->id;
             $totalarqs = $artigo->arquivos->count();
             $arquivos = $artigo->arquivos;
             return response()->json([
                 'artigoid' => $artigoid,
                 'totalarqs' => $totalarqs,
                 'arquivos' => $arquivos,
                 'status' => 200,
                 'message' => 'O(s) arq(s) est(ão) adicionado(s) com sucesso!',
             ]);  

}

public function deleteArquivo($id){        
    $arquivo = Arquivo::find($id);
    $artigoid = $arquivo->artigos_id;  
    //deleção o arquivo na pasta /storage/arq/   
    $arquivoPath = public_path('/storage/'.$arquivo->path);                    
    if(file_exists($arquivoPath)){
        unlink($arquivoPath);
    }    
    //excluir na tabela                             
    $arquivo->delete();
    $artigo = $this->artigo->find($artigoid);
    $totalarqs = $artigo->arquivos->count();
    return response()->json([
        'artigoid' => $artigoid,
        'totalarqs' => $totalarqs,
        'status' => 200,
        'message' => 'O arquivo foi excluído com sucesso!',
    ]);        
}

protected function maxidartigos_inc(){
    $artigo = $this->artigo->orderByDesc('id')->first();
    if($artigo){
        $codigo = $artigo->id+1;
    }else{
        $codigo = 1;
    }
    return $codigo;
}

protected function maxidarquivo_inc(){
    $arquivo = $this->arquivo->orderByDesc('id')->first();
    if($arquivo){
        $codigo = $arquivo->id+1;
    }else{
        $codigo = 1;
    }
    return $codigo;
}

}
