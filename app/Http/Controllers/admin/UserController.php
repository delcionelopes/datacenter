<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Orgao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Método para listagem de registros com opção de pesquisa
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        if(is_null($request->pesquisa)){
            $users = $this->user->orderByDesc('id')->paginate(5);
        }else{
            $query = $this->user->query()
                     ->where('name','LIKE','%'.$request->pesquisa.'%');
            $users = $query->orderByDesc('id')->paginate(5);
        }
        $orgaos = Orgao::all();
        return view('user.index',[
            'users' => $users,
            'orgaos' => $orgaos,
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
     * Método para criação de novo registro
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:8|max:100',        
            'cpf' => 'required|cpf|unique:users',   
            'orgao_id' => 'required',
        ],[
            'name.required'  => 'O campo NOME é obrigatório!',
            'name.max'       => 'O NOME deve ter no máximo :max caracteres!',
            'email.required' => 'O campo EMAIL é obrigatório!',
            'email.email'    => 'O EMAIL é inválido!',
            'email.max'      => 'O EMAIL deve conter no máximo :max caracteres!',
            'email.unique'   => 'O EMAIL já existe!',
            'password.required' => 'A SENHA é obrigatória!',
            'password.min' => 'A SENHA deve ter no mínimo :min caracteres!',
            'password.max' => 'A SENHA deve ter no máximo :max caracteres!',
            'cpf.required' => 'O CPF é obrigatório!',
            'cpf.cpf'      => 'O CPF é inválido!',
            'cpf.unique'   => 'O CPF já existe!',
            'orgao_id.required' => 'O ÓRGÃO é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
        $filePath="";
        if($request->hasFile('imagem')){
        $file = $request->file('imagem');                           
        $fileName =  $file->getClientOriginalName();
        $filePath = 'avatar/'.$fileName;
        $storagePath = public_path('/storage/avatar/');
        $file->move($storagePath,$fileName);
        }
        $data = [
            'name' => strtoupper($request->input('name')),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
            'moderador' => $request->input('moderador'),
            'inativo' => false,
            'avatar'  => $filePath,
            'orgao_id' => $request->input('orgao_id'),
            'matricula' => $request->input('matricula'),
            'cpf' => $request->input('cpf'),            
        ];
        $user = $this->user->create($data);
        return response()->json([
            'user' => $user,
            'status' => 200,
            'message'=> 'Registro incluído com sucesso!',
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
     * Método para edição de registro
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $user = $this->user->find($id);
        return response()->json([
            'user' => $user,
            'status' => 200,
        ]);
    }

    /**
     * Método para atualizar registro editado
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,int $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|min:8|max:100',  
            'cpf' => 'required|cpf',     
            'orgao_id' => 'required',
        ],[
            'name.required'  => 'O campo NOME é obrigatório!',
            'name.max'       => 'O NOME deve ter no máximo :max caracteres!',
            'email.required' => 'O campo EMAIL é obrigatório!',
            'email.email'    => 'O EMAIL é inválido!',
            'email.max'      => 'O EMAIL deve conter no máximo :max caracteres!',     
            'password.required' => 'A SENHA é obrigatória!',
            'password.min' => 'A SENHA deve ter no mínimo :min caracteres!',
            'password.max' => 'A SENHA deve ter no máximo :max caracteres!',      
            'cpf.required' => 'O CPF é obrigatório!',
            'cpf.cpf'      => 'O CPF é inválido!',  
            'orgao_id.required' => 'O ÓRGÃO é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{        
        $user = $this->user->find($id);
        if($user){
        $filePath="";
        if($request->hasFile('imagem')){
        //exclui o arquivo de avatar anterior se houver
          if($user->avatar){
            $antigoPath = public_path('/storage/'.$user->avatar);
            if(file_exists($antigoPath)){
            unlink($antigoPath);
            }
          }
        //upload do novo arquivo
        $file = $request->file('imagem');                           
        $fileName =  $user->id.'_'.$file->getClientOriginalName();
        $filePath = 'avatar/'.$fileName;
        $storagePath = public_path('/storage/avatar/');
        $file->move($storagePath,$fileName);
        }        
        $data['name'] = strtoupper($request->input('name'));
        $data['email'] = strtolower($request->input('email'));
        $data['password'] = bcrypt($request->input('password'));
        $data['moderador'] = $request->input('moderador');
        $data['inativo'] = $request->input('inativo');
        if($filePath!=""){
        $data['avatar']  = $filePath;
        }
        $data['matricula'] = $request->input('matricula');
        $data['cpf'] = $request->input('cpf');
        $data['orgao_id'] = $request->input('orgao_id');        
        $user->update($data);
        $u = User::find($id);
        return response()->json([
            'user' => $u,
            'status' => 200,
            'message'=> 'Registro atualizado com sucesso!',
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
     * Método para exclusão de registro
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = $this->user->find($id);
        //exclusão do arquivo do avatar se houver
        if($user->avatar){
            $avatarPath = public_path('storage/'.$user->avatar);
            if(file_exists($avatarPath)){
                unlink($avatarPath);
            }
        }      
        //Exclusão do usuário
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    /**
     * Método para mudar o perfil do usuário 
     */
    public function moderadorUsuario(Request $request,int $id){
        $moderador = $request->input('moderador');
        $data = ['moderador' => $moderador];
        $user = $this->user->find($id);
        $user->update($data);
        $u = User::find($id);
        return response()->json([
            'user' => $u,
            'status'=> 200,
        ]);
    }

    /**
     * Método para desativar o usuário
     */
    public function inativoUsuario(Request $request,int $id){
        $inativo = $request->input('inativo');
        $data = ['inativo' => $inativo];
        $user = $this->user->find($id);
        $user->update($data);
        $u = User::find($id);
        return response()->json([
            'user' => $u,
            'status'=> 200,
        ]);
    }

}
