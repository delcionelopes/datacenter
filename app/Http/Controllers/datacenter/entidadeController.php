<?php

namespace App\Http\Controllers\datacenter;

use App\Http\Controllers\Controller;
use App\Models\Entidade;
use App\Models\Institucional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class entidadeController extends Controller
{
    private $entidade;
    private $institucional;

    public function __construct(Entidade $entidade, Institucional $institucional)
    {
        $this->entidade = $entidade;
        $this->institucional = $institucional;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $color)
    {
        if(is_null($request->pesquisa)){
            $entidades = $this->entidade->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->entidade->query()
                          ->where('nome','LIKE','%'.strtoupper($request->pesquisa).'%');
            $entidades = $query->orderByDesc('id')->paginate(6);
        }
        
        return view('datacenter.entidade.index',[
            'entidades' => $entidades,
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
        $institucionais = $this->institucional->all();
        return view('datacenter.entidade.create',[
            'institucionais' => $institucionais,
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
            'nome' => ['required','max:100'],
            'sigla' => ['required','max:10'],            
            'institucionais' => ['required','min:1'],
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
                $filePath = 'entidade/'.$fileName;
                $storagePath = public_path().'/storage/entidade/';
                $file->move($storagePath,$fileName);

                //excluir imagem temporária
                $tempPath = public_path().'/storage/temp/'.$fileName;
                if(file_exists($tempPath)){
                    unlink($tempPath);
                }
            }
            $data['id'] = $this->maxId();
            $data['nome'] = $request->input('nome');
            $data['sigla'] = $request->input('sigla');
            if($filePath){
                $data['logo'] = $filePath;
            }
            $data['created_at'] = now();
            $data['updated_at'] = null;

            $entidade = $this->entidade->create($data);
            $entidade->institucionais()->sync(json_decode($request->input('institucionais')));

            return response()->json([
                'status' => 200,
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
    public function edit($id, $color)
    {
        $entidade = $this->entidade->find($id);
        $institucionais = $this->institucional->all();
        return view('datacenter.entidade.edit',[
            'entidade' => $entidade,
            'institucionais' => $institucionais,
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
            'nome' => ['required','max:100'],
            'sigla' => ['required','max:10'],            
            'institucionais' => ['required','array','min:1'],
        ]);
        if($validator->fails()){
            return response()->json([
              'status' => 400,
              'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $entidade = $this->entidade->find($id);
            if($entidade){
                $filePath = "";
                if($request->hasFile('imagem')){
                    //excluir a imagem antiga se houver
                    if($entidade->logo){
                        $antigoPath = public_path().'/storage/'.$entidade->logo;
                        if(file_exists($antigoPath)){
                            unlink($antigoPath);
                        }
                    }
                    $file = $request->file('imagem');
                    $fileName = $file->getClientOriginalName();
                    $filePath = 'entidade/'.$fileName;
                    $storagePath = public_path().'/storage/entidade/';
                    $file->move($storagePath,$fileName);

                    //excluir imagem temporária
                    $tempPath = public_path().'/storage/temp/'.$fileName;
                    if(file_exists($tempPath)){
                        unlink($tempPath);
                    }
                }
                $data['nome'] = $request->input('nome');
                $data['sigla'] = $request->input('sigla');
                if($filePath){
                    $data['logo'] = $filePath;
                }
                $data['updated_at'] = now();
    
                $entidade->update($data);

                $e = Entidade::find($id);
                $e->institucionais()->sync(json_decode($request->input('institucionais')));
    
                return response()->json([
                    'status' => 200,
                    'entidade' => $e,
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
        $entidade = $this->entidade->find($id);
        $institucionais = $entidade->institucionais;
        if($institucionais->count()){
            $entidade->institucionais()->detach($institucionais);
        }        
        //excluir imagem do diretório
        $filePath = public_path().'/storage/'.$entidade->logo;
        if(file_exists($filePath)){
            unlink($filePath);
        }
        $entidade->delete;
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
        $entidade = $this->entidade->orderByDesc('id')->first();
        if($entidade){
            $codigo = $entidade->id;
        }else{
            $codigo = 0;
        }
        return $codigo+1;
    }
    


}
