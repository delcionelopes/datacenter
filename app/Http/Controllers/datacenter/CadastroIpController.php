<?php

namespace App\Http\Controllers\datacenter;

use App\Models\Cadastro_ip;
use App\Http\Controllers\Controller;
use App\Models\Rede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CadastroIpController extends Controller
{    
    private $cadastroIp;

    public function __construct(Cadastro_ip $cadastroIp){  
        $this->cadastroIp = $cadastroIp;
    }

    /**
     * Método para listagem de registros com a opção de pesquisa
     */
    public function index(Request $request, int $id)
    {
        if(is_null($request->pesquisa)){
            $cadastroIps = $this->cadastroIp->query()
                                             ->where('rede_id','=',$id)
                                             ->orderByDesc('id')
                                             ->paginate(6);
        }else{
            $query = $this->cadastroIp->query()
                                      ->where('rede_id','=',$id) 
                                      ->where('ip','LIKE',$request->pesquisa);
            $cadastroIps = $query->orderByDesc('id')
                                 ->paginate(6);
        }      
        $vlan_id = Rede::find($id)->vlan_id;    
        return view('datacenter.ip.index',[
            'cadastroIps' => $cadastroIps,
            'id' => $id,
            'vlan_id' => $vlan_id,
        ]);
    }
 
    public function create()
    {        
    }
    
    /**
     * Método para a criação de um novo registro
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[           
           'ip'      => 'required|max:15',           
        ],[            
            'ip.required'       => 'O campo IP é obrigatório!',
            'ip.max'            => 'O IP deve conter no máximo :max caracteres!',                       
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{                
            $data = [
                'rede_id' => $request->input('rede_id'),
                'ip' => $request->input('ip'),
                'status' => strtoupper($request->input('status')),               
            ];
            $cadastroIp = $this->cadastroIp->create($data);                      
            $rede = $cadastroIp->rede;
            $user = auth()->user();
            return response()->json([
                'rede' => $rede,
                'cadastroIp' => $cadastroIp,
                'user' => $user,
                'status' => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }
    
    public function show(Cadastro_ip $cadastro_ip)
    {
        //        
    }
    
    /**
     * Método para a edição de registro
     */
    public function edit(int $id)
    {
        $cadastroIp = $this->cadastroIp->find($id);        
        $user = auth()->user();
        return response()->json([            
            'cadastroIp' => $cadastroIp,
            'user' => $user,
            'status' => 200,
        ]);
    }

    /**
     * Método para a atualização de registro editado
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[            
            'ip'      => 'required|max:15',            
         ],[             
             'ip.required'       => 'O campo IP é obrigatório!',
             'ip.max'            => 'O IP deve conter no máximo :max caracteres!',             
         ]);
         if($validator->fails()){
             return response()->json([
                 'status' => 400,
                 'errors' => $validator->errors()->getMessages(),
             ]);
         }else{                     
             $cadastroIp = $this->cadastroIp->find($id);
             if($cadastroIp){
                $data = [
                    'rede_id' => $request->input('rede_id'),
                    'ip' => $request->input('ip'),                                          
                ];
                $cadastroIp->update($data);               
                $c = Cadastro_ip::find($id);
                $rede = $c->rede;
                $user = auth()->user();
                return response()->json([
                    'cadastroIp' => $c,
                    'rede' => $rede,
                    'user' => $user,
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
     * Método para a exclusão de registro
     */
    public function destroy(int $id)    {
        $cadastroIp = $this->cadastroIp->find($id);
        $cadastroIp->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    /**
     * Método para a mudança de status do ip
     */
    public function status(Request $request, int $id){
        $vstatus = $request->input('pstatus');        
        $data = ['status' => $vstatus];
        $cadastroIp = $this->cadastroIp->find($id);
        $cadastroIp->update($data);
        $ip = Cadastro_ip::find($id);
        $user = auth()->user();
        return response()->json([
            'ip' => $ip,
            'user' => $user,
            'status' => 200,
        ]);
    }
}
