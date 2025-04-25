<?php

namespace App\Http\Controllers\datacenter;

use App\Http\Controllers\Controller;
use App\Models\Institucional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class institucionalController extends Controller
{
    private $institucional;

    public function __construct(Institucional $institucional)
    {
        $this->institucional = $institucional;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $color)
    {
        if(isNull($request->pesquisa)){
            $institucionais = $this->institucional->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->institucional->query()
                          ->where('nome','LIKE','%'.strtoupper($request->pesquisa).'%');
            $institucionais = $query->orderByDesc('id')->paginate(6);
        }
        return view('datacenter.institucional.index',[
            'institucionais' => $institucionais,
            'color' => $color,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($color)
    {
        return view('datacenter.institucional.create',[
            'color' => $color,
        ]);
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
            'nome' => ['required','max:100'],
            'url_site' => ['required'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $filePath = "";
            if($request->hasFile('imagem')){
                $file = $request->file('imagem');
                $fileName = $file->getClientOriginalName();
                $filePath = 'institucional/'.$fileName;
                $storagePath = public_path().'/storage/institucional/';
                $file->move($storagePath,$fileName);

                //excluir imagem temporária
                $tempPath = public_path().'/storage/temp/'.$fileName;
                if(file_exists($tempPath)){
                    unlink($tempPath);
                }
            }
            $data['id'] = $this->maxId();
            $data['sigla'] = $request->input('sigla');
            $data['nome'] = $request->input('nome');
            $data['url_site'] = $request->input('url_site');
            if($filePath){
                $data['logo'] = $filePath;
            }
            $institucional = $this->institucional->create($data);

            return response()->json([
                'status' => 200,
                'institucional' => $institucional,
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
    public function edit($id,$color)
    {
        $institucional = $this->institucional->find($id);
        return view('datacenter.institucional.edit',[
            'status' => 200,
            'institucional' => $institucional,
            'color' => $color,
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
            'sigla' => ['required','max:10'],
            'nome' => ['required','max:100'],
            'url_site' => ['required'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $institucional = $this->institucional->find($id);
            if($institucional){
                $filePath = "";
                if($request->hasFile('imagem')){
                    //excluir a imagem antiga se houver
                    if($institucional->logo){
                        $antigoPath = public_path().'/storage/'.$institucional->logo;
                        if(file_exists($antigoPath)){
                            unlink($antigoPath);
                        }
                    }
                    $file = $request->file('imagem');
                    $fileName = $file->getClientOriginalName();
                    $filePath = 'institucional/'.$fileName;
                    $storagePath = public_path().'/storage/institucional/';
                    $file->move($storagePath,$fileName);

                    //excluir imagem temporária
                    $tempPath = public_path().'/storage/temp/'.$fileName;
                    if(file_exists($tempPath)){
                        unlink($tempPath);
                    }
                }
                $data['sigla'] = $request->input('sigla');
                $data['nome'] = $request->input('nome');
                $data['url_site'] = $request->input('url_site');
                if($filePath){
                    $data['logo'] = $filePath;
                }
                $institucional->update($data);
                $i = Institucional::find($id);
    
                return response()->json([
                    'status' => 200,
                    'institucional' => $i,
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
        $institucional = $this->institucional->find($id);
        $entidades = $institucional->entidades;
        $artigos = $institucional->artigos;
        if($entidades->count()){
            return response()->json([
                'status' => 400,
                'message' => 'Não pode ser excluído. Pois, há entidades vinculadas!',
            ]);
        }
        if($artigos->count()){
            return response()->json([
                'status' => 400,
                'message' => 'Não pode ser excluído. Pois, há artigos vinculados',
            ]);
        }
        $institucional->delete;
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    public function armazenarImagemTemporaria(Request $request){
        $validator = Validator::make($request->all(),[
            'imagem' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $filePath = "";
            if($request->hasFile('imagem')){
                $file = $request->file('imagem');
                $fileName = $file->getClientOriginalName();
                $storagePath = public_path().'/storage/temp/';
                $filePath = 'storage/temp/'.$fileName;
                $file->move($storagePath,$fileName);
            }
            return response()->json([
                'status' => 200,
                'filepath' => $filePath,
            ]);
        }
    }

    public function excluirImagemTemporaria(Request $request){
        //exclui o arquivo temporário se houver
        if($request->hasFile('imagem')){
            $file = $request->file('imagem');
            $fileName = $file->getClientOriginalName();
            $antigoPath = public_path().'/storage/temp/'.$fileName;
            if(file_exists($antigoPath)){
                unlink($antigoPath);
            }
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    protected function maxId(){
        $institucional = $this->institucional->orderByDesc('id')->first();
        if($institucional){
            $codigo = $institucional->id;
        }else{
            $codigo = 0;
        }
        return $codigo+1;
    }


}
