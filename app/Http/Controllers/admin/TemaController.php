<?php

namespace App\Http\Controllers\admin;

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

    public function index(Request $request)
    {
        if(is_null($request->pesquisa)){
            $temas = $this->tema->orderBy('id','DESC')->paginate(5);
        }else{
            $query = $this->tema->query()
                     ->where('titulo','LIKE','%'.$request->pesquisa.'%');
            $temas = $query->orderBy('id','DESC')->paginate(5);
        }
        return view('tema.index',compact('temas'));
    }
    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'titulo'     => 'required|max:100',
            'descricao'  => 'required|max:180', 
        ],[
            'titulo.required'  => 'O campo TÍTULO é obrigatório',
            'titulo.max'       => 'O TÍTULO não pode ter mais de :max caracteres!',
            'descricao.require'=> 'O campo DESCRIÇÃO é obrigatório',
            'descricao.max'    => 'A DESCRIÇÃO não pode ter mais de :max caracteres!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->getMessages(),
            ]);
        }else{            
            $data = [
                'id' => $this->maxidtema_inc(),
                'titulo'    => $request->input('titulo'),
                'descricao' => $request->input('descricao'),
                //'slug'      => $request->input('slug'),                
            ];
            $tema = $this->tema->create($data); //registro criado            
            $t = Tema::find($tema->id);
            return response()->json([
                'tema' => $t, //o objeto $t é atribuído ao json tema
                'status' => 200,
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
        $tema = $this->tema->find($id);
        return response()->json([
            'tema'   => $tema,
            'status' => 200,
        ]);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'titulo'     => 'required|max:100',
            'descricao'  => 'required|max:180', 
        ],[
            'titulo.required'  => 'O campo TÍTULO é obrigatório',
            'titulo.max'       => 'O TÍTULO não pode ter mais de :max caracteres!',
            'descricao.require'=> 'O campo DESCRIÇÃO é obrigatório',
            'descricao.max'    => 'A DESCRIÇÃO não pode ter mais de :max caracteres!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->getMessages(),
            ]);
        }else{
            $tema = $this->tema->find($id);            
            if($tema){
                $data = [
                    'titulo'    => $request->input('titulo'),
                    'descricao' => $request->input('descricao'),
                    //'slug'      => $request->input('slug'),
                ];
                $tema->update($data);
                $t = $this->tema->find($id);
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

    
    public function destroy($id)
    {
        $tema = $this->tema->find($id);
        $a = $tema->artigos;
        $tema->artigos()->detach($a);
        $tema->delete();
        return response()->json([
            'status'  => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    protected function maxidtema_inc(){
        $tema = $this->tema->orderByDesc('id')->first();
        if($tema){
            $codigo = $tema->id+1;
        }else{
            $codigo = 1;
        }
        return $codigo;
    }
}
