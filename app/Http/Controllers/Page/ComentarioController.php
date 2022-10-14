<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use App\Models\Artigo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComentarioController extends Controller
{
    private $comentario;

    public function __construct(Comentario $comentario)
    {
        $this->comentario = $comentario;
    }

    public function salvarComentario(Request $request){
        $validator = Validator::make($request->all(),[
            'comentario' => 'required',
        ],[
            'comentario.required' => auth()->user()->name.', comente algo.',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
        $artigo = Artigo::find($request->input('artigoid'));
        $user = auth()->user();        
        $texto = $request->input('comentario');        
        $data = [
            'id' => $this->maxidcomentario_inc(),
            'artigos_id' => $artigo->id,
            'user_id' => $user->id,
            'texto' => $texto,            
        ];        
        $c = $this->comentario->create($data);
        $this->comentario->timestamps=true;
        $c = Comentario::find($c->id);        
        return response()->json([
            'status' => 200,
            'comentario' => $c,            
            'user_c' => $user,
        ]);
        }
    }

    public function deleteComentario($id){
        $comentario = $this->comentario->find($id);
        $comentario->delete();
        return response()->json([
            'status' => 200,
        ]);
    }

    protected function maxidcomentario_inc(){
        $comentario = $this->comentario->orderByDesc('id')->first();
        if($comentario){
            $codigo = $comentario->id+1;
        }else{
            $codigo = 1;
        }
        return $codigo;
    }
}
