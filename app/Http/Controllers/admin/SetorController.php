<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SetorController extends Controller
{
    private $setor;

    public function __construct(Setor $setor)
    {
        $this->setor = $setor;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(is_null($request->pesquisa)){
            $setores = $this->setor->orderByDesc('idsetor')->paginate(10);
        }else{
            $query = $this->setor->query()
                          ->where('nome','LIKE','%'.strtoupper($request->pesquisa).'%');
            $setores = $query->orderByDesc('idsetor')->paginate(10);
        }

        return view('setor.index',[
            'setores' => $setores,
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
            'sigla' => ['required','max:10'],
            'nome' => ['required','max:50'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $data['idsetor'] = $this->maxid();
            $data['sigla'] = strtoupper($request->input('sigla'));
            $data['nome'] = strtoupper($request->input('nome'));
            $data['created_at'] = now();
            $setor = $this->setor->create($data);
            $user = auth()->user();
            return response()->json([
                'status' => 200,
                'setor' => $setor,
                'user' => $user,
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
        $setor = $this->setor->find($id);
        $user = auth()->user();
        return response()->json([
            'status' => 200,
            'setor' => $setor,
            'user' => $user,
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
            'sigla' => ['required','max:10'],
            'nome' => ['required','max:50'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $setor = $this->setor->find($id);
            if($setor){            
            $data['sigla'] = strtoupper($request->input('sigla'));
            $data['nome'] = strtoupper($request->input('nome'));
            $data['updated_at'] = now();
            $setor->update($data);
            $user = auth()->user();
            return response()->json([
                'status' => 200,
                'setor' => $setor,
                'user' => $user,
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
    public function destroy(int $id)
    {
        $setor = $this->setor->find($id);
        $usuarios = $setor->users;
        $equipamentos = $setor->equipamentos;
        if($usuarios){
            return response()->json([
                'status' => 400,
                'message' => 'Registro não pode ser excluído. Pois há usuários que dependem dele.',
            ]);
        }else
        if($equipamentos){
            return response()->json([
                'status' => 400,
                'message' => 'Registro não pode ser excluído. Pois há equipamentos que dependem dele.',
            ]);
        }else{
            $setor->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Registro excluído com sucesso!',
            ]);
        }
        
    }

    protected function maxid(){
        $setor = $this->setor->orderByDesc('idsetor')->first();
        if($setor){
            $ultimo = $setor->idsetor;
        }else{
            $ultimo = 0;
        }
        return $ultimo+1;
    }
}
