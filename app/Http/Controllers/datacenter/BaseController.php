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

class BaseController extends Controller
{
    private $base;
    private $app;

    public function __construct(Base $base, App $app)
    {
        $this->base = $base;
        $this->app = $app;
    }
    
    public function index(Request $request,$id)
    {
        if(is_null($request->pesquisa)){
            $bases = $this->base->query()->where('virtual_machine_id','=',$id)->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->base->query()
                          ->where('virtual_machine_id','=',$id)
                          ->where('nome_base','LIKE','%'.strtoupper($request->pesquisa).'%');
            $bases = $query->orderByDesc('id')->paginate(6);              
        }        
        $vm = VirtualMachine::find($id);
        $projetos = Projeto::all();
        $orgaos = Orgao::all();
        $bds = $this->base->query()->where('virtual_machine_id','=',$id)->orderByDesc('id')->get();
        $virtual_machines = VirtualMachine::all();
        return view('datacenter.base.index',[
            'bases' => $bases,
            'id' => $id,
            'vm' => $vm,
            'projetos' => $projetos,
            'orgaos' => $orgaos,
            'bds' => $bds,
            'virtual_machines' => $virtual_machines,
        ]);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'virtual_machine_id'  => 'required',
            'projeto_id'          => 'required',
            'nome_base'           => 'required',
            'ip'                  => 'required',
            'dono'                => 'required',  
        ],[
            'virtual_machine_id.required' => 'O campo VIRTUAL MACHINE é obrigatório!',
            'projeto_id.required'         => 'O campo PROJETO é obrigatório!',
            'nome_base.required'          => 'O campo NOME é obrigatório!',
            'ip.required'                 => 'O campo IP é obrigatório!',
            'dono.required'               => 'O campo DONO é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{           
            $timestamps = $this->base->timestamps;
            $this->base->timestamps = false;            
            $data = [
                'virtual_machine_id' => $request->input('virtual_machine_id'),
                'projetos_id'         => $request->input('projeto_id'),
                'nome_base'          => strtoupper($request->input('nome_base')),
                'ip'                 => $request->input('ip'),
                'dono'               => strtoupper($request->input('dono')),
                'encoding'           => strtoupper($request->input('encoding')),
                'created_at' => now(),
                'updated_at' => null,
            ];
            $base = $this->base->create($data);
            $this->base->timestamps = true;
            $b = Base::find($base->id);
            return response()->json([
                'base'    => $b,
                'status'  => 200,
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
        $base = $this->base->find($id);
        $projeto = Projeto::find($base->projetos_id);
        $vm = VirtualMachine::find($base->virtual_machine_id);        
        return response()->json([
            'base'   => $base,
            'vm' => $vm,
            'projeto' => $projeto,
            'status' => 200,
        ]);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'virtual_machine_id'  => 'required',
            'projeto_id'          => 'required',
            'nome_base'           => 'required',
            'ip'                  => 'required',
            'dono'                => 'required',  
        ],[
            'virtual_machine_id.required' => 'O campo VIRTUAL MACHINE é obrigatório!',
            'projeto_id.required'         => 'O campo PROJETO é obrigatório!',
            'nome_base.required'          => 'O campo NOME é obrigatório!',
            'ip.required'                 => 'O campo IP é obrigatório!',
            'dono.required'               => 'O campo DONO é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $timestamps = $this->base->timestamps;
            $this->base->timestamps = false;    
            $base = $this->base->find($id);            
            if($base){            
            $data = [
                'virtual_machine_id' => $request->input('virtual_machine_id'),
                'projetos_id'         => $request->input('projeto_id'),
                'nome_base'          => strtoupper($request->input('nome_base')),
                'ip'                 => $request->input('ip'),
                'dono'               => strtoupper($request->input('dono')),
                'encoding'           => strtoupper($request->input('encoding')),
                'updated_at'         => now(),
            ];
            $base->update($data);
            $this->base->timestamps = true;
            $b = Base::find($id);
            return response()->json([
                'base'    => $b,
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

    public function destroy($id)
    {
        $base = $this->base->find($id);
        $base->delete();
        return response()->json([
            'status'  => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    public function storeApp(Request $request)
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
            $timestamps = $this->app->timestamps;
            $this->app->timestamps = false;
            $data = [
                'base_id'    => $request->input('bases_id'),
                'projeto_id' => $request->input('projetos_id'),
                'orgao_id'    => $request->input('orgao_id'),
                'nome_app'    => strtoupper($request->input('nome_app')),
                'dominio'     => strtolower($request->input('dominio')),
                'https'       => $request->input('https'),
                'created_at'  => now(),
                'updated_at'  => null,
            ];
            $app = $this->app->create($data);
            $this->app->timestamps = true;
            $a = App::find($app->id);
            return response()->json([
                'app'     => $a,
                'status'  => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }

}
