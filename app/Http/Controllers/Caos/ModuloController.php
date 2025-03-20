<?php

namespace App\Http\Controllers\Caos;

use App\Http\Controllers\Controller;
use App\Models\Autorizacao;
use App\Models\Modulo;
use App\Models\Operacao;
use App\Models\Perfil;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModuloController extends Controller
{
    private $modulo;
    private $operacao;
    private $autorizacao;
    private $user;
    private $perfil;

    public function __construct(Modulo $modulo, Operacao $operacao, Autorizacao $autorizacao, User $user, Perfil $perfil)
    {
        $this->modulo = $modulo;
        $this->operacao = $operacao;
        $this->autorizacao = $autorizacao;
        $this->user = $user;
        $this->perfil = $perfil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(is_null($request->pesquisa)){
            $modulos = $this->modulo->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->modulo->query()
                          ->where('nome','LIKE','$'.strtoupper($request->pesquisa).'%');
            $modulos = $query->orderByDesc('id')->paginate(6);
        }
        return view('caos.modulo.index',[
            'modulos' => $modulos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $operacoes = $this->operacao->orderBy('id')->get();

        return view('caos.modulo.create',[
            'operacoes' => $operacoes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nome' => ['required','max:50'],
            'descricao' => ['required','max:200'],            
            'color' => ['required','max:15'],            
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
                $filePath = 'ico_modulo/'.$fileName;
                $storagePath = public_path().'/storage/ico_modulo/';
                $file->move($storagePath,$fileName);

                //excluir imagem temporária
                $tempPath = public_path().'/storage/temp/'.$fileName;
                if(file_exists($tempPath)){
                    unlink($tempPath);
                }
            }
           
            $data['id'] = $this->maxIdModulo();
            $data['nome'] = $request->input('nome');
            $data['descricao'] = $request->input('descricao');
            $data['color'] = $request->input('color');
            if($filePath){
                $data['ico'] = $filePath;
            }
            $data['created_at'] = now();
            $modulo = $this->modulo->create($data);
            $modulo->operacoes()->sync(json_decode($request->input('operacoes')));
            return response()->json([
                'modulo' => $modulo,
                'status' => 200,
                'message' => 'Registro criado com sucesso!',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $modulo = $this->modulo->find($id);
        $operacoes = $this->operacao->orderBy('id')->get();        
        
        return view('caos.modulo.edit',[
            'modulo' => $modulo,
            'operacoes' => $operacoes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'nome' => ['required','max:50'],
            'descricao' => ['required','max:200'],            
            'color' => ['required','max:15'],            
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $modulo = $this->modulo->find($id);
            if($modulo){
                $filePath = "";
                if($request->hasFile('imagem')){
                    //excluir a imagem antiga se houver
                    if($modulo->ico){
                        $antigoPath = public_path().'/storage/'.$modulo->ico;
                        if(file_exists($antigoPath)){
                            unlink($antigoPath);
                        }
                    }
                    $file = $request->file('imagem');
                    $fileName = $file->getClientOriginalName();
                    $filePath = 'ico_modulo/'.$fileName;
                    $storagePath = public_path().'/storage/ico_modulo/';
                    $file->move($storagePath,$fileName);

                    //excluir imagem temporária
                    $tempPath = public_path().'/storage/temp/'.$fileName;
                    if(file_exists($tempPath)){
                        unlink($tempPath);
                    }
                }

            $data['nome'] = $request->input('nome');
            $data['descricao'] = $request->input('descricao');
            $data['color'] = $request->input('color');
            if($filePath){
                $data['ico'] = $filePath;
            }
            $data['updated_at'] = now();

            $modulo->update($data);

            $m = Modulo::find($id);
            $m->operacoes()->sync(json_decode($request->input('operacoes')));

            return response()->json([
                'status' => 200,
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {        
        $modulo = $this->modulo->find($id);
        $operacoes = $modulo->operacoes;
        $autorizacoes = $modulo->autorizacao;

        if($autorizacoes){
            return response()->json([
                'status' => 400,
                'errors' => 'Este módulo não pode ser excluído. Pois há autorizações que dependem dele.',
            ]);
        }

        if($modulo->operacoes()->count()){
            $modulo->operacoes()->detach($operacoes);
        }        

        //excluir imagem do diretório ico_modulo
        $filePath = public_path().'/storage/'.$modulo->ico;
        if(file_exists($filePath)){
            unlink($filePath);
        }

        $modulo->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);

    }

    public function armazenarImagemTemporaria(Request $request){
        $validator = Validator::make($request->all(),[
            'imagem' => 'required',
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
                $storagePath = public_path().'/storage/temp/';
                $filePath = 'storage/temp/'.$fileName;
                $file->move($storagePath,$fileName);
            }
            return response()->json([
                'status' => 200,
                'filepath' => $filePath,
            ]);
        }
    }

    public function excluirImagemTemporaria(Request $request){
        //exclui o arquivo temporário se houver
        if($request->hasFile('imagem')){
            $file = $request->file('imagem');
            $fileName = $file->getClientOriginalName();
            $antigoPath = public_path().'/storage/temp/'.$fileName;
            if(file_exists($antigoPath)){
                unlink($antigoPath);
            }
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    protected function maxIdModulo(){
        $modulo = $this->modulo->orderByDesc('id')->first();
        if($modulo){
            $codigo = $modulo->id;
        }else{
            $codigo = 0;
        }
        return $codigo+1;
    }

    public function modulosXoperacoes(int $operacao_id){
        $operacao = $this->operacao->find($operacao_id);
        $modulos = $operacao->modulos()->paginate(6);
        return view('caos.modulo.index_moduloXoperacoes',[
            'modulos' => $modulos,
        ]);
    }

  //relatórios
  public function relatorioModope(){
    $modulos = $this->modulo->all();
    $date = now();
    $setor = auth()->user()->setor->nome;
    return Pdf::loadView('relatorios.datacenter.modope',[
        'modulos' => $modulos,
        'date' => $date,
        'setor' => $setor,
    ])->stream('modulosXoperacoes.pdf');        
}

//relatório de permissões
public function relatorioPermissoes(int $id){
    $user = $this->user->whereId($id)->first();
    $autorizacoes = $this->autorizacao->query()->wherePerfil_id($user->perfil->id)->get();
    $aut2 = $this->autorizacao->query()->wherePerfil_id($user->perfil->id)->get();
    $modulos = $this->modulo->all();
    $operacoes = $this->operacao->all();
    $date = now();
    $setor = auth()->user()->setor->nome;
    return Pdf::loadView('relatorios.datacenter.autorizacao',[
        'user' => $user,
        'autorizacoes' => $autorizacoes,
        'aut2' => $aut2,
        'modulos' => $modulos,
        'operacoes' => $operacoes,
        'date' => $date,
        'setor' => $setor,
    ])->stream('permissões_de_'.$user->name.'.pdf');        
}

public function retornaOperacao(int $perfil_id, int $modulo_id){
    dd("Chegou aqui, controller!");
    $autope = $this->autorizacao->query()
                                ->wherePerfil_id($perfil_id)
                                ->whereModulo_has_operacao_modulo_id($modulo_id)
                                ->get();
    $operacoes = $this->operacao->all();
    return response()->json([
        'autope' => $autope,
        'operacoes' => $operacoes,
        'status' => 200,
    ]);
}


}
