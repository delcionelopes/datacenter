<?php

namespace App\Http\Controllers\Datacenter;

use App\Http\Controllers\Controller;
use App\Models\Setor_Vinc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class setorVincController extends Controller
{
    private $setorVinc;

    public function __construct(Setor_Vinc $setorVinc)
    {
        $this->setorVinc = $setorVinc;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'orgao' => ['required'],
            'sigla' => ['required','max:10'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{            
            $data['descricao'] = strtoupper($request->input('descricao'));
            $data['orgao_id'] = $request->input('orgao');
            $data['sigla'] = strtoupper($request->input('sigla'));
            $data['created_at'] = now();
            $data['updated_at'] = null;
            $setor = $this->setorVinc->create($data);
            return response()->json([
                'status' => 200,
                'setor' => $setor,
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
        $setor = $this->setorVinc->find($id);
        return response()->json([
            'status' => 200,
            'setor' => $setor,
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
            'orgao' => ['required'],
            'sigla' => ['required','max:10'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $setor = $this->setorVinc->find($id);
            if($setor){
            $data['descricao'] = strtoupper($request->input('descricao'));
            $data['orgao_id'] = $request->input('orgao');
            $data['sigla'] = strtoupper($request->input('sigla'));            
            $data['updated_at'] = now();            
            $setor->update($data);
            $s = Setor_Vinc::find($id);
            return response()->json([
                'status' => 200,
                'setor' => $s,
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
        $setor = $this->setorVinc->find($id);
        $ips = $setor->ips;
        $equipamentos = $setor->equipamentos;
        if($ips->count()){
            return response()->json([
                'status' => 400,
                'message' => 'Este registro não pode ser excluído! Pois, há ips que dependem dele.',
            ]);
        }
        if($equipamentos->count()){
            return response()->json([
                'status' => 400,
                'message' => 'Este registro não pode ser excluído! Pois, há equipamentos que dependem dele.',
            ]);
        }
        $setor->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }
}
