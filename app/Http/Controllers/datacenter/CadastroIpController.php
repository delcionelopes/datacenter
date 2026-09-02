<?php

namespace App\Http\Controllers\Datacenter;

use App\Models\Cadastro_ip;
use App\Http\Controllers\Controller;
use App\Models\Orgao;
use App\Models\Rede;
use App\Models\Setor_Vinc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CadastroIpController extends Controller
{    
    private $cadastroIp;
    private $orgao;
    private $setorvinc;
    public function __construct(Cadastro_ip $cadastroIp, Orgao $orgao, Setor_Vinc $setorvinc){  
        $this->cadastroIp = $cadastroIp;
        $this->orgao = $orgao;
        $this->setorvinc = $setorvinc;
    }

    /**
     * Método para listagem de registros com a opção de pesquisa
     */
    public function index(Request $request, int $id, $color)
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
        $orgaos = $this->orgao->orderBy('id')->get();
        return view('datacenter.ip.index',[
            'cadastroIps' => $cadastroIps,
            'id' => $id,
            'vlan_id' => $vlan_id,
            'color' => $color,
            'orgaos' => $orgaos,
        ]);
    }

    public function carregaSetores(int $id){
        $setores = $this->setorvinc->whereOrgao_id($id)->orderBy('id')->get();
        return response()->json([
            'status' => 200,
            'setores' => $setores,
        ]);
    }
 
    public function create(int $id, $color)
    {        
        $orgaos = $this->orgao->orderBy('id')->get();
        return view('datacenter.ip.create',[
            'orgaos' => $orgaos,
            'id' => $id,
            'color' => $color,
        ]);
    }
    
    /**
     * Método para a criação de um novo registro
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[           
           'ip'      => ['required','max:15'],
           'orgao'   => ['required'],
           'rede'    => ['required'],
           'setor'   => ['required'],
           'descricao' => ['max:255'],
           'mac' => ['max:30'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{

            $data['rede_id'] = $request->input('rede');
            $data['ip'] = $request->input('ip');
            $data['status'] = strtoupper($request->input('status'));
            $data['orgao_vinc_id'] = $request->input('orgao');
            $data['setor_vinc_id'] = $request->input('setor');
            $data['mac'] = $request->input('mac');
            $data['descricao'] = $request->input('descricao');
            $data['created_at'] = now();                
            
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
    public function edit(int $id, int $redeid, $color)
    {
        $cadastroIp = $this->cadastroIp->find($id);        
        $orgaos = $this->orgao->orderBy('id')->get();
        return view('datacenter.ip.edit',[            
            'ip' => $cadastroIp,
            'id' => $redeid,
            'orgaos' => $orgaos,            
            'color' => $color,
        ]);
    }

    /**
     * Método para a atualização de registro editado
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[            
           'ip'      => ['required','max:15'],
           'rede'    => ['required'],
           'orgao'   => ['required'],
           'setor'   => ['required'],
           'descricao' => ['max:255'],
           'mac' => ['max:30'],
           ]);
         if($validator->fails()){
             return response()->json([
                 'status' => 400,
                 'errors' => $validator->errors()->getMessages(),
             ]);
         }else{                     
             $cadastroIp = $this->cadastroIp->find($id);
             if($cadastroIp){
                $data['rede_id'] = $request->input('rede');
                $data['ip'] = $request->input('ip');
                $data['status'] = strtoupper($request->input('status'));
                $data['orgao_vinc_id'] = $request->input('orgao');
                $data['setor_vinc_id'] = $request->input('setor');
                $data['mac'] = $request->input('mac');
                $data['descricao'] = $request->input('descricao');
                $data['updated_at'] = now();
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
        $data = ['status' => $vstatus,'updated_at'=>now()];
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
