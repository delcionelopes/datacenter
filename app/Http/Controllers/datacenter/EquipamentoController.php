<?php

namespace App\Http\Controllers\datacenter;

use App\Http\Controllers\Controller;
use App\Models\EquipamentoRede;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EquipamentoController extends Controller
{
    private $equipamento;
    private $user;

    public function __construct(EquipamentoRede $equipamento, User $user)
    {
        $this->equipamento = $equipamento;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $color)
    {
        $useradmin = auth()->user();
        if(is_null($request->pesquisa)){
            $equipamentos = $this->equipamento->query()->where('setor_idsetor','=',$useradmin->setor_id)->orderByDesc('idequipamento_rede')->paginate(10);
        }else{
            $query = $this->equipamento->query()
                          ->where('setor_idsetor','=',$useradmin->setor_id)
                          ->where('nome','LIKE','%'.strtoupper($request->pesquisa).'%');
            $equipamentos = $query->orderByDesc('idequipamento_rede')->paginate(10);
        }        
        $users = $this->user->where('setor_id','=',$useradmin->setor_id)->get();
        return view('datacenter.equipamento.index',[
            'equipamentos' => $equipamentos,
            'users' => $users,
            'color' => $color
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
            'nome' => ['required','max:200'],
            'descricao' => 'required',            
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $user = auth()->user();
            $setorid = $user->setor_id;
            $data = [
                'idequipamento_rede' => $this->maxid(),
                'nome' => strtoupper($request->input('nome')),
                'descricao' => strtoupper($request->input('descricao')),               
                'setor_idsetor' => $setorid,
                'criador_id' => $user->id,
                'created_at' => now(),
            ];
            $equipamento = $this->equipamento->create($data);     
            $user = auth()->user();
            $users = $equipamento->users;
            $setor = $equipamento->setor;
            return response()->json([
                'status' => 200,
                'equipamento' => $equipamento,
                'setor' => $setor,
                'user' => $user,
                'users' => $users,
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
        $equipamento = $this->equipamento->find($id);
        $user = auth()->user();
        if($equipamento->pass_admin){
            $senhaadmin = Crypt::decrypt($equipamento->pass_admin);
        }else{
            $senhaadmin = "";
        }       
        $setor = $equipamento->setor;
        return response()->json([
            'status' => 200,
            'equipamento' => $equipamento,
            'setor' => $setor,
            'user' => $user,
            'senhaadmin' => $senhaadmin,
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
            'nome' => ['required','max:200'],
            'descricao' => 'required',
            'senhaadmin' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $equipamento = $this->equipamento->find($id);
            if($equipamento){
            $user = auth()->user();
            $setorid = $user->setor_id;
            $data = [                
                'nome' => strtoupper($request->input('nome')),
                'descricao' => strtoupper($request->input('descricao')),                
                'setor_idsetor' => $setorid,
                'pass_admin' => Crypt::encrypt($request->input('senhaadmin')),
                'alterador_id' => $user->id,
                'updated_at' => now(),
            ];
            $equipamento->update($data);  
            $eq = EquipamentoRede::find($id);
            $user = auth()->user();
            $users = $eq->users;
            $setor = $eq->setor;
            return response()->json([
                'status' => 200,
                'equipamento' => $eq,
                'setor' => $setor,
                'user' => $user,
                'users' => $users,
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
        $equipamento = $this->equipamento->find($id);
        $usuarios = $equipamento->users;
        if($usuarios){
            $equipamento->users()->detach($usuarios);
        }
        $equipamento->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    protected function maxid(){
        $equipamento = $this->equipamento->orderByDesc('idequipamento_rede')->first();
        if($equipamento){
            $codigo = $equipamento->idequipamento_rede;
        }else{
            $codigo = 0;
        }
        return $codigo+1;
    }

    public function editsenhaEquipamento(int $id){
        $equipamento = $this->equipamento->find($id);
        $criador = $equipamento->criador->name;
        $alterador = $equipamento->alterador->name;
        $senhaadmin = Crypt::decrypt($equipamento->pass_admin);
        $user = auth()->user();
        if($equipamento->users()->count()){
            $senha = $equipamento->users()->find($user->id)->pivot->pass_user_equipamento;
            if($senha){
            $senhaindividual = Crypt::decrypt($senha);
            }else{
                $senhaindividual = "";
            }
        }else{
            $senhaindividual = "";
        }
        $users = $equipamento->users;

        return response()->json([
            'status' => 200,
            'equipamento' => $equipamento,
            'criador' => $criador,
            'alterador' => $alterador,
            'users' => $users,
            'senhaadmin' => $senhaadmin,
            'senhaindividual' => $senhaindividual,
            'user' => $user,
        ]);
    }

    public function editsenhaIndividual(int $id){
        $equipamento = $this->equipamento->find($id);        
        $user = auth()->user();
        if($equipamento->users()->count()){
            $senha = $equipamento->users()->find($user->id)->pivot->pass_user_equipamento;
            if($senha){
            $senhaindividual = Crypt::decrypt($senha);
            }else{
                $senhaindividual = "";
            }
        }else{
            $senhaindividual = "";
        }

        return response()->json([
            'status' => 200,
            'equipamento' => $equipamento,        
            'senhaindividual' => $senhaindividual,
            'user' => $user,
        ]);
    }

    public function updatesenhaequipamento(Request $request, int $id){
        $validator = Validator::make($request->all(),[
            'senha' => 'required',
            'users' => ['required','array','min:1'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
                $equipamento = $this->equipamento->find($id);            
                $user = auth()->user();
                $equipamento->users()->sync($request->input('users'));
                $data['pass_user_equipamento'] = Crypt::encrypt($request->input('senha'));
                $data['created_at'] = $equipamento->created_at;
                $data['updated_at'] = now();
                DB::table('equipamento_rede_has_users')->where([
                    'equipamento_rede_idequipamento_rede' => $id,
                    'users_id' => $user->id,
                ])->update($data);
                return response()->json([
                    'status' => 200,
                    'message' => 'Permissões atualizadas',
                ]);
            }
        
    }

     public function updatesenhaIndividual(Request $request, int $id){
        $validator = Validator::make($request->all(),[
            'senha' => 'required',            
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
                $equipamento = $this->equipamento->find($id);            
                $user = auth()->user();                
                $data['pass_user_equipamento'] = Crypt::encrypt($request->input('senha'));                
                $data['updated_at'] = now();
                DB::table('equipamento_rede_has_users')->where([
                    'equipamento_rede_idequipamento_rede' => $id,
                    'users_id' => $user->id,
                ])->update($data);
                return response()->json([
                    'status' => 200,
                    'message' => 'Permissão atualizada',
                ]);            
        }
    }

}
