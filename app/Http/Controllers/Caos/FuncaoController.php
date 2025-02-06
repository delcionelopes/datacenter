<?php

namespace App\Http\Controllers\Caos;

use App\Http\Controllers\Controller;
use App\Models\Funcao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FuncaoController extends Controller
{
    private $funcao;

    public function __construct(Funcao $funcao)
    {
        $this->funcao = $funcao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(is_null($request->pesquisa)){
            $funcoes = $this->funcao->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->funcao->query()
                          ->where('nome','LIKE','%'.strtoupper($request->pesquisa).'%');
            $funcoes = $query->orderByDesc('id')->paginate(6);
        }
        return view('caos.funcao.index',[
            'funcoes' => $funcoes,
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
            'nome' => ['required','max:30'],
            'descricao' => ['required','max:50'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $data['id'] = $this->maxId();
            $data['nome'] = strtoupper($request->input('nome'));
            $data['descricao'] = strtoupper($request->input('descricao'));
            $data['created_at'] = now();
            $funcao = $this->funcao->create($data);
            return response()->json([
                'funcao' => $funcao,
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
        $funcao = $this->funcao->find($id);
        return response()->json([
            'funcao' => $funcao,
            'status' => 200,
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
            'nome' => ['required','max:30'],
            'descricao' => ['required','max:50'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $funcao = $this->funcao->find($id);
            if($funcao){
                $data['nome'] = strtoupper($request->input('nome'));
                $data['descricao'] = strtoupper($request->input('descricao'));
                $data['updated_at'] = now();
                $funcao->update($data);
                $f = Funcao::find($id);

                return response()->json([
                    'funcao' => $f,
                    'status' => 200,
                    'message' => 'Registro atualizado com sucesso!'
                ]);
            }else{
                response()->json([
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
        $funcao = $this->funcao->find($id);
        $users = $funcao->users;
        if($funcao->users->count()){
            return response()->json([
                'status' => 400,
                'errors' => 'Este registro não pode ser excluído! Pois há outros que dependem dele.'
            ]);
        }else{
            $funcao->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Registro excluído com sucesso!',
            ]);
        }        
    }

    protected function maxId(){
        $funcao = $this->funcao->orderByDesc('id')->first();
        if($funcao){
            $codigo = $funcao->id;
        }else{
            $codigo = 0;
        }
        return $codigo+1;
    }
}
