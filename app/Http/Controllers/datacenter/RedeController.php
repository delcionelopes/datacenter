<?php

namespace App\Http\Controllers\datacenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cadastro_ip;
use App\Models\Rede;
use App\Models\Vlan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class RedeController extends Controller
{
    private $rede;
    private $cadastroIp;

    public function __construct(Rede $rede, Cadastro_ip $cadastroIp)
    {
        $this->rede = $rede;
        $this->cadastroIp = $cadastroIp;
    }
    /**
     * Método para listagem de registros com opção de pesquisa
     */
    public function index(Request $request,int $id, $color)
    {        
        if(is_null($request->pesquisa)){
            $redes = $this->rede->query()->where('vlan_id','=',$id)->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->rede->query()
                   ->where('vlan_id','=',$id)
                   ->where('nome_rede','LIKE','%'.strtoupper($request->pesquisa).'%')
                   ->orderByDesc('id');            
            $redes = $query->paginate(6);                        
        }                    
        $vlan = Vlan::find($id);
        return view('datacenter.rede.index',[
            'redes' => $redes,
            'id'    => $id,     
            'vlan'  => $vlan,
            'color' => $color
        ]);
    }

    
    public function create()
    {
        //
    }

    /**
     * Método para criar novo registro
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nome_rede' => 'required|max:100',
            'mascara'   => 'required|max:15',
            'tipo_rede' => 'required|max:20',
            'vlan_id'   => 'required',
        ],[
            'nome_rede.required'  => 'O campo NOME é obrigatório!',
            'nome_rede.max'       => 'O NOME deve ter no máximo :max caracteres!',
            'mascara.required'    => 'O campo MÁSCARA é obrigatório!',
            'mascara.max'         => 'A MASCARA deve conter no máximo :max caracteres!',
            'tipo_rede.required'  => 'O campo TIPO é obrigatório!',
            'tipo_rede.max'       => 'O TIPO deve ter no máximo :max caracteres!',
            'vlan_id.required'    => 'O campo VLAN é obrigatório!',
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
            $vl = $rede->vlan;
            $user = auth()->user();
            return response()->json([
                'rede' => $rede,
                'vlan' => $vl,
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
     * Método para edição de registro
     */
    public function edit(int $id)
    {
        $rede = $this->rede->find($id);
        $user = auth()->user();
        return response()->json([
            'rede' => $rede,
            'user' => $user,
            'status' => 200,
        ]);
    }

    /**
     * Método para atualizar registro editado
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'nome_rede' => 'required|max:100',
            'mascara'   => 'required|max:15',
            'tipo_rede' => 'required|max:20',
            'vlan_id'   => 'required',
        ],[
            'nome_rede.required'  => 'O campo NOME é obrigatório!',
            'nome_rede.max'       => 'O NOME deve ter no máximo :max caracteres!',
            'mascara.required'    => 'O campo MÁSCARA é obrigatório!',
            'mascara.max'         => 'A MASCARA deve conter no máximo :max caracteres!',
            'tipo_rede.required'  => 'O campo TIPO é obrigatório!',
            'tipo_rede.max'       => 'O TIPO deve ter no máximo :max caracteres!',
            'vlan_id.required'    => 'O campo VLAN é obrigatório!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{           
            $rede = $this->rede->find($id);            
            $vl = $rede->vlan;
            if($rede){
                $data = [
                    'nome_rede' => strtoupper($request->input('nome_rede')),
                    'mascara'   => $request->input('mascara'),
                    'tipo_rede' => strtoupper($request->input('tipo_rede')),
                    'vlan_id'   => $request->input('vlan_id'),                   
                ];
                $rede->update($data);              
                $r = Rede::find($id);
                $user = auth()->user();
                return response()->json([
                    'rede' => $r,
                    'vlan' => $vl,
                    'user' => $user,
                    'status' => 200,
                    'message' => 'O registro foi atualizado com sucesso!',
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
     */
    public function destroy(int $id)
    {
        $rede = $this->rede->find($id);
        $ips = $rede->cadastro_ips;
        if($rede->cadastro_ips()->count()){
            if((auth()->user()->admin)&&(!(auth()->user()->inativo))){
                foreach ($ips as $ip) {
                    $i = Cadastro_ip::find($ip->id);
                    $i->delete();
                }                
                $status = 200;
                $message = $rede->nome_rede.' foi excluído com sucesso!';
                $rede->delete();
            }else{
                $status = 400;
                $message = $rede->nome_rede.' não pôde ser excluído. Pois há outros registros que dependem dele. Contacte um administrador!';
            }
        }else{
            $status = 200;
            $message = $rede->nome_rede.' foi excluído com sucesso!';
            $rede->delete();
        }
      
     
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function storeIp(Request $request){
        $validator = Validator::make($request->all(),[            
            'ip'          => 'required|max:15',
            'status'  => 'required|max:20',            
        ],[
            'ip.required'         => 'O campo IP é obrigatório!',
            'ip.max'              => 'O IP deve ter no máximo :max caracteres!',
            'status.required' => 'O campo STATUS é obrigatório!',
            'status.max'      => 'O STATUS deve ter no máximo :max caracteres!',            
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $data = [
                'rede_id' => $request->input('rede_id'),                
                'ip'         => $request->input('ip'),
                'status' => strtoupper($request->input('status')),                
            ];
            $cadastroIp = $this->cadastroIp->create($data);
            $rede = $cadastroIp->rede;
            $user = auth()->user();
            return response()->json([
                'cadastroIp' => $cadastroIp,
                'rede'    => $rede,
                'user' => $user,
                'status'  => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }

    //relatórios
  public function relatorioRedes(){
    $redes = $this->rede->all();
    $date = now();
    $setor = auth()->user()->setor->nome;
    return Pdf::loadView('relatorios.datacenter.redes',[
        'redes' => $redes,
        'date' => $date,
        'setor' => $setor,
    ])->setPaper('a4','landscape')->stream('redes.pdf');        
}

}
