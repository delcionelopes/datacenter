<?php

namespace App\Http\Controllers\datacenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cadastro_ip;
use App\Models\Vlan;
use Illuminate\Support\Facades\Validator;
use App\Models\Rede;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class vlanController extends Controller
{
    private $vlan;
    private $rede;
    private $users;
    
    public function __construct(Vlan $vlan,Rede $rede,User $users)
    {
        $this->vlan = $vlan;        
        $this->rede = $rede;       
        $this->users = $users;
    }

    /**
     * Método para listagem com opção de pesquisa
     */
    public function index(Request $request, $color)
    {
        if(is_null($request->pesquisa)){
            $vlans = $this->vlan->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->vlan->query()
                   ->where('nome_vlan','LIKE','%'.strtoupper($request->pesquisa).'%');
            $vlans = $query->orderByDesc('id')->paginate(6);
        }
        $users = $this->users->query()
                             ->where('admin','=','true')
                             ->where('inativo','=','false')
                             ->where('setor_id','=',1)
                             ->orderBy('name')
                             ->get();
        return view('datacenter.vlan.index',[
            'vlans' => $vlans,
            'users' => $users,
            'color' => $color
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Método para a criação de um novo registro
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nome_vlan' => 'required|max:100',
        ],[
            'nome_vlan.required' => 'O campo NOME é obrigatório!',
            'nome_vlan.max'      => 'O NOME deve conter no máximo :max caracteres!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{           
            $data = [
                'nome_vlan' => strtoupper($request->input('nome_vlan')),                
            ];
            $vlan = $this->vlan->create($data); 
            $u = $vlan->users;  
            $user = auth()->user();
            return response()->json([
                'vlan' => $vlan,
                'users' => $u,
                'user' => $user,
                'status' => 200, 
                'message' => 'Registro criado com sucesso!',
            ]);
        }
    }

    public function show($id)
    {
        //
    }
    
    /**
     * Método para a edição de registro
     */
    public function edit(int $id)
    {
        $vlan = $this->vlan->find($id);
        $u = $vlan->users;
        return response()->json([
            'vlan' => $vlan,
            'users' => $u,
            'status' => 200,
        ]);
    }

    /**
     * Método para atualizar um registro editado
     */
    public function update(Request $request,int $id)
    {
        $validator = Validator::make($request->all(),[
            'nome_vlan' => 'required|max:100',
        ],[
            'nome_vlan.required' => 'O campo NOME é obrigatório!',
            'nome_vlan.max'      => 'O NOME deve conter no máximo :max caracteres!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{           
            $vlan = $this->vlan->find($id);            
            if($vlan){
                        $data = [
                            'nome_vlan' => strtoupper($request->input('nome_vlan')),                            
                        ];
                        $vlan->update($data);                      
                        $v = Vlan::find($id);
                        $u = $v->users;
                        $user = auth()->user();
                        return response()->json([
                            'vlan' => $v,
                            'users' => $u,
                            'user' => $user,
                            'status' => 200, 
                            'message' => 'Registro alterado com sucesso!',
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
     * Método para exclusão recursiva pelo adm
     */
    public function destroy(int $id)
    {
        $vlan = $this->vlan->find($id);
        $vms = $vlan->virtual_machines;
        $redes = $vlan->redes;
        if(($vlan->virtual_machines()->count())||($vlan->redes()->count())||($vlan->users()->count())){
            if((auth()->user()->admin)&&(!(auth()->user()->inativo))){
                if($vlan->virtual_machines()->count()){
                    $vlan->virtual_machines()->detach($vms); //exclusão da relação n:n
                }
                if($vlan->redes()->count()){
                    foreach ($redes as $rede) {
                        $r = $this->rede->find($rede->id);
                        $ips = $r->cadastro_ips;
                        if($r->cadastro_ips()->count()){
                            foreach ($ips as $ip) {
                                $i = Cadastro_ip::find($ip->id);
                                $i->delete();
                            }
                        }
                        $r->delete();
                    }                    
                }
                if($vlan->users()->count()){                    
                    $usuarios = $vlan->users;
                    $vlan->users()->detach($usuarios);                    
                }
                $status = 200;
                $message = $vlan->nome_vlan.' foi excluído com sucesso!';
                $vlan->delete();
            }else{
                $status = 400;
                $message = $vlan->nome_vlan.' não pôde ser escluído, pois há outros registros que dependem dele. Contacte um administrador.';
            }
        }else{
            $status = 200;
            $message = $vlan->nome_vlan.' foi excluído com sucesso!';
            $vlan->delete();
        }
        
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    /**
     * Método para a criação de uma nova rede vinculada à vlan
     */
    public function storerede(Request $request){        
        $validator = Validator::make($request->all(),[            
            'nome_rede' => 'required|max:100',
            'mascara'   => 'required|max:15',
            'tipo_rede' => 'required|max:20',         
            'vlan_id'   => 'required',   
        ],[            
            'nome_rede.required' => 'O campo NOME DA REDE é obrigatório!',
            'nome_rede.max'      => 'O NOME DA REDE pode ter no máximo :max caracteres!',
            'mascara.required'   => 'O campo MÁSCARA é obrigatório!',
            'mascara.max'        => 'A MASCARA poder ter no máximo :max caracteres!',
            'tipo_rede.required' => 'O campo TIPO é obigatório!',
            'tipo_rede.max'      => 'O TIPO deve ter no máximo :max caracteres!',
            'vlan_id.required'   => 'O VLAN é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{           
            $data = [                
                'nome_rede' => strtoupper($request->input('nome_rede')),
                'mascara'   => $request->input('mascara'),
                'tipo_rede' => strtoupper($request->input('tipo_rede')),
                'vlan_id'   => $request->input('vlan_id'),               
            ];            
            $rede = $this->rede->create($data);          
            $vlan = $rede->vlan;
            $user = auth()->user();
            return response()->json([
                'vlan'  => $vlan,
                'rede'  => $rede,
                'user' => $user,
                'status' => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }

public function storesenhavlan(Request $request, int $id){
        $validator = Validator::make($request->all(),[
            'senha' => 'required',
            'validade' => ['required','date'],
            'users' => ['required','array','min:2'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $user = auth()->user();
            $vlan = $this->vlan->find($id);
            $data = [          
                'senha' => Crypt::encrypt($request->input('senha')),
                'validade' => $request->input('validade'),
                'val_indefinida' => intval($request->input('val_indefinida')),
                'criador_id' => $user->id,                
            ];
            $vlan->update($data); //criação da senha
            $v = Vlan::find($id);            
            $v->users()->sync($request->input('users')); //sincronização    
            $u = $v->users;        
            return response()->json([
                'user' => $user,              
                'vlan' => $v,
                'users' => $u, 
                'user' => $user,
                'status' => 200,
                'message' => 'Senha foi criada com sucesso!',
            ]);
        }        
    } 

    public function updatesenhavlan(Request $request, int $id){
        $validator = Validator::make($request->all(),[
            'senha' => 'required',
            'validade' => ['required','date'],
            'users' => ['required','array','min:2'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $vlan = $this->vlan->find($id);
            if($vlan){
            $user = auth()->user();            
            $data = [                
                'senha' => Crypt::encrypt($request->input('senha')),
                'validade' => $request->input('validade'),
                'val_indefinida' => intval($request->input('val_indefinida')),
                'alterador_id' => $user->id,                
            ];
            $vlan->update($data); //atualização da senha
            $v = Vlan::find($id);            
            $v->users()->sync($request->input('users')); //sincronização
            $u = $v->users;
            return response()->json([
                'user' => $user,                
                'vlan' => $v,
                'users' => $u,
                'user' => $user,
                'status' => 200,
                'message' => 'Senha atualizada com sucesso!',
            ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Senha não localizada!',
                ]);
            }
        }        
    }

public function editsenhavlan(int $id){        
        $vlan = $this->vlan->find($id);
        $criador = "";
        $alterador ="";
        if ($vlan->criador_id) {
           $criador = User::find($vlan->criador_id)->name;
        }       
        if ($vlan->alterador_id) {
            $alterador = User::find($vlan->alterador_id)->name;
        }                
        $u = $vlan->users; 
        $s = Crypt::decrypt($vlan->senha);
        $user = auth()->user();
        return response()->json([
            'status' => 200,   
            'senha' => $s,
            'user' => $user,
            'vlan' => $vlan,
            'criador' => $criador,
            'alterador' => $alterador,
            'users' => $u,
        ]);
    }


}
