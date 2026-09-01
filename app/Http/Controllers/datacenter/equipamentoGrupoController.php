<?php

namespace App\Http\Controllers\Datacenter;

use App\Http\Controllers\Controller;
use App\Models\Equipamento_Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class equipamentoGrupoController extends Controller
{
    private $grupo;

    public function __construct(Equipamento_Grupo $grupo)
    {
        $this->grupo = $grupo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $color)
    {
        if(is_null($request->pesquisa)){
            $grupos = $this->grupo->orderBy('id','DESC')->get();
        }else{
            $query = $this->grupo->query()
                                 ->where('descricao','LIKE','%'.$request->pesquisa.'%');
            $grupos = $query->orderBy('id','DESC')->get();
        }
        return view('datacenter.equipamentogrupo.index',[
            'grupos' => $grupos,
            'color' => $color,
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(),[
            'descricao' => ['required','max:50'],         
            'sigla' => ['required','max:20'],
            'ico' => ['required','max:200'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{            
            $data['descricao'] = strtoupper($request->input('descricao'));            
            $data['sigla'] = strtoupper($request->input('sigla'));
            $data['ico'] = $request->input('ico');
            $data['created_at'] = now();
            $data['updated_at'] = null;            
            $grupo = $this->grupo->create($data);
            return response()->json([
                'status' => 200,
                'grupo' => $grupo,
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
    public function edit($id)
    {
        $grupo = $this->grupo->find($id);
        return response()->json([
            'status' => 200,
            'grupo' => $grupo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $validator = Validator::make($request->all(),[
            'descricao' => ['required','max:50'],            
            'sigla' => ['required','max:20'],
            'ico' => ['required','max:200'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $grupo = $this->grupo->find($id);
            if($grupo){
            $data['descricao'] = strtoupper($request->input('descricao'));            
            $data['sigla'] = strtoupper($request->input('sigla'));
            $data['ico'] = $request->input('ico');
            $data['updated_at'] = now();            
            $grupo = $this->grupo->create($data);
            $g = Equipamento_Grupo::find($id);
            return response()->json([
                'status' => 200,
                'grupo' => $g,
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupo = $this->grupo->find($id);        
        $equipamentos = $grupo->equipamento;        
        if($equipamentos->count()){
            return response()->json([
                'status' => 400,
                'message' => 'Este registro não pode ser excluído! Pois, há equipamentos que dependem dele.',
            ]);
        }
        $grupo->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }
}
