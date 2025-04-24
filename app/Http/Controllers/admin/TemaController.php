<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TemaController extends Controller
{
    private $tema;

    public function __construct(Tema $tema)
    {
        $this->tema = $tema;
    }

    public function index(Request $request,$color)
    {
        if(is_null($request->pesquisa)){
            $temas = $this->tema->orderBy('id','DESC')->paginate(5);
        }else{
            $query = $this->tema->query()
                     ->where('titulo','LIKE','%'.$request->pesquisa.'%');
            $temas = $query->orderBy('id','DESC')->paginate(5);
        }
        return view('tema.index',[
            'temas' => $temas,
            'color' => $color,
        ]);
    }
    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'titulo'     => ['required','max:100'],
            'descricao'  => ['required','max:180'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->getMessages(),
            ]);
        }else{        
            $data['id'] = $this->maxId();
            $data['titulo'] = $request->input('titulo');
            $data['descricao'] = $request->input('descricao');            
            $data['created_at'] = now();
            $data['updated_at'] = null;

            $tema = $this->tema->create($data);
            
            return response()->json([
                'tema' => $tema,
                'status' => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }

    }

    public function show($id)
    {
        //
    }

    
    public function edit(int $id)
    {
        $tema = $this->tema->find($id);
        return response()->json([
            'tema'   => $tema,
            'status' => 200,
        ]);
    }

    
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'titulo'     => ['required','max:100'],
            'descricao'  => ['required','max:180'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->getMessages(),
            ]);
        }else{
            $tema = $this->tema->find($id);            
            if($tema){
                $data['titulo'] = $request->input('titulo');
                $data['descricao'] = $request->input('descricao');                
                $data['updated_at'] = now();
                $tema->update($data); //retorna um valor booleano
                $t = Tema::find($id); //registro atualizado
                return response()->json([
                    'tema'    => $t,
                    'status'  => 200,
                    'message' => 'Registro atualizado com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status'  => 404,
                    'message' => 'Tema não localizado!',
                ]);
            }
        }

    }

    
    public function destroy(int $id)
    {
        $tema = $this->tema->find($id);
        $artigos = $tema->artigos;
        if($tema->artigos->count()){
        //$tema->artigos()->detach($artigos);
            return response()->json([
                'status' => 400,
                'errors' => 'Este registro não pode ser excluído! Pois há outros que dependem dele.',
            ]);
        }
        $tema->delete();
        return response()->json([
            'status'  => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    protected function maxId(){
        $tema = $this->tema->orderByDesc('id')->first();
        if($tema){
            $codigo = $tema->id;
        }else{
            $codigo = 0;
        }
        return $codigo+1;
    }


}
