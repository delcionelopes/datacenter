<?php

namespace App\Http\Controllers\datacenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Base;
use App\Models\Orgao;
use App\Models\Projeto;
use App\Models\VirtualMachine;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{
    private $app;
    private $base;

    public function __construct(App $app, Base $base)
    {
        $this->app = $app;
        $this->base = $base;
    }
    /**
     * método index: Faz a listagem, pesquisa e chama a view index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $id)
    {
        if(is_null($request->pesquisa)){
            $apps = $this->app->query()->where('base_id','=',$id)->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->app->query()
                          ->where('base_id','=',$id)
                          ->where('nome_app','LIKE','%'.strtoupper($request->pesquisa).'%');
            $apps = $query->orderByDesc('id')->paginate(6);
        }
        
        $bd = $this->base->find($id);
        $vm = VirtualMachine::find($bd->virtual_machine_id);
        $orgaos = Orgao::all();
        $projetos = Projeto::all();
        $bases = $this->base->query()->where('virtual_machine_id','=',$bd->virtual_machine_id)->orderByDesc('id')->get();

        return view('datacenter.app.index',[
            'id' => $id,
            'apps' => $apps,
            'bd'   => $bd,
            'orgaos' => $orgaos,
            'projetos' => $projetos,
            'bases' => $bases,
            'vm' => $vm,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * método store: Valida e grava um novo registro
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bases_id'    => 'required',
            'projetos_id' => 'required',
            'orgao_id'    => 'required',
            'nome_app'    => 'required',
            'dominio'     => 'required',
        ],[
            'bases_id.required'     => 'O campo BASE é obrigatório!',
            'projetos_id.required'  => 'O campo PROJETO é obrigatório!',
            'orgao_id.required'     => 'O campo ORGÃO é obrigatório!',
            'nome_app.required'     => 'O campo NOME é obrigatório!',
            'dominio.required'      => 'O campo DOMÍNIO é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{          
            $data = [
                'base_id'    => $request->input('bases_id'),
                'projeto_id' => $request->input('projetos_id'),
                'orgao_id'    => $request->input('orgao_id'),
                'nome_app'    => strtoupper($request->input('nome_app')),
                'dominio'     => strtolower($request->input('dominio')),
                'https'       => $request->input('https'),              
            ];
            $app = $this->app->create($data);          
            return response()->json([
                'app'     => $app,
                'status'  => 200,
                'message' => 'Registro gravado com sucesso!',
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
     * método edit: Localiza um registro e envia para alteração
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $app = $this->app->find($id);
        $projeto = Projeto::find($app->projeto_id);
        $base = Base::find($app->base_id);
        $orgao = Orgao::find($app->orgao_id);
        $vm = VirtualMachine::find($base->virtual_machine_id);
        return response()->json([
            'app'     => $app,
            'projeto' => $projeto,
            'base'    => $base,
            'orgao'   => $orgao,
            'vm'      => $vm,
            'status'  => 200,
        ]);
    }

    /**
     * método update: Valida e efetiva a atualização de registro editado
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,int $id)
    {
        $validator = Validator::make($request->all(),[
            'bases_id'    => 'required',
            'projetos_id' => 'required',
            'orgao_id'    => 'required',
            'nome_app'    => 'required',
            'dominio'     => 'required',
        ],[
            'bases_id.required'     => 'O campo BASE é obrigatório!',
            'projetos_id.required'  => 'O campo PROJETO é obrigatório!',
            'orgao_id.required'     => 'O campo ORGÃO é obrigatório!',
            'nome_app.required'     => 'O campo NOME é obrigatório!',
            'dominio.required'      => 'O campo DOMÍNIO é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{           
            $app = $this->app->find($id);
            if($app){
                $data = [
                    'base_id'    => $request->input('bases_id'),
                    'projeto_id' => $request->input('projetos_id'),
                    'orgao_id'    => $request->input('orgao_id'),
                    'nome_app'    => strtoupper($request->input('nome_app')),
                    'dominio'     => strtolower($request->input('dominio')),
                    'https'       => $request->input('https'),                                    
                ];
                $app->update($data);          
                $a = App::find($id);
                return response()->json([
                    'app'     => $a,
                    'status'  => 200,
                    'message' => 'Registro atualizado com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status'  => 404,
                    'message' => 'Registro não encontrado!',
                ]);
            }
        }
    }

    /**
     * método destroy: Localiza um registro e o exclui
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $app = $this->app->find($id);        
        $app->delete();
        return response()->json([
            'status'  => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }
    
    /**
     * Atribui a opção do HTTPS ao app
     */
    public function httpsApp(Request $request,int $id)
    {           
        $app = $this->app->find($id);  
        $data = ['https' => $request->input('https')];        
        $app->update($data);
        $a = App::find($id);
        return response()->json([
            'app' => $a,
            'status' => 200,
        ]);
    }


}
