<?php

namespace App\Http\Controllers\Caos;

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
            $setores = $this->setor->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->setor->query()
                          ->where('sigla','LIKE','%'.strtoupper($request->pesquisa).'%');
            $setores = $query->orderByDesc('id')->paginate(6);
        }
        return view('caos.setor.index',[
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
            'nome' => ['required','max:50'],
            'sigla' => ['required','max:10'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $data['id'] = $this->maxId();
            $data['nome'] = strtoupper($request->input('nome'));
            $data['sigla'] = strtoupper($request->input('sigla'));
            $data['created_at'] = now();
            $data['updated_at'] = null;
            $setor = $this->setor->create($data);
            return response()->json([
                'setor' => $setor,
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
        $setor = $this->setor->find($id);
        return response()->json([
            'setor' => $setor,
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
            'nome' => ['required','max:50'],
            'sigla' => ['required','max:10'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $setor = $this->setor->find($id);
            if($setor){
                $data['nome'] = strtoupper($request->input('nome'));
                $data['sigla'] = strtoupper($request->input('sigla'));
                $data['updated_at'] = now();
                $setor->update($data);
                $s = Setor::find($id);
                return response()->json([
                    'setor' => $s,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $setor = $this->setor->find($id);
        $users = $setor->users;
        if($setor->users->count()){
            return response()->json([
                'status' => 400,
                'errors' => 'Este registro não pode ser excluído! Pois há outros que dependem dele!',
            ]);
        }else{
            $setor->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Registro excluído com sucesso!',
            ]);
        }
    }

    protected function maxId(){
        $setor = $this->setor->orderByDesc('id')->first();
        if($setor){
            $codigo = $setor->id;
        }else{
            $codigo = 0;
        }
        return $codigo+1;
    }
}
