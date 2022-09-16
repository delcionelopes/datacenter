<?php

namespace App\Http\Controllers\datacenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cadastro_ip;
use App\Models\Vlan;
use Illuminate\Support\Facades\Validator;
use App\Models\Rede;

class vlanController extends Controller
{
    private $vlan;
    private $rede;
    
    public function __construct(Vlan $vlan,Rede $rede)
    {
        $this->vlan = $vlan;        
        $this->rede = $rede;
    }

    public function index(Request $request)
    {
        if(is_null($request->pesquisa)){
            $vlans = $this->vlan->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->vlan->query()
                   ->where('nome_vlan','LIKE','%'.strtoupper($request->pesquisa).'%');
            $vlans = $query->orderByDesc('id')->paginate(6);
        }
        return view('datacenter.vlan.index',[
            'vlans' => $vlans,
        ]);
    }

    public function create()
    {
        //
    }

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
            return response()->json([
                'vlan' => $vlan,
                'status' => 200, 
                'message' => 'Registro criado com sucesso!',
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(int $id)
    {
        $vlan = $this->vlan->find($id);
        return response()->json([
            'vlan' => $vlan,
            'status' => 200,
        ]);
    }

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
                        return response()->json([
                            'vlan' => $v,
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

    public function destroy(int $id)
    {
        $vlan = $this->vlan->find($id);
        $vms = $vlan->virtual_machines;
        $redes = $vlan->redes;
        if(($vlan->virtual_machines()->count())||($vlan->redes()->count())){
            if((auth()->user()->moderador)&&(!(auth()->user()->inativo))){
                if($vlan->virtual_machines()->count()){
                    $vlan->virtual_machines()->detach($vms);
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
            return response()->json([
                'vlan'  => $vlan,
                'rede'  => $rede,
                'status' => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }
}
