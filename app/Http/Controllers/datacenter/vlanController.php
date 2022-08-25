<?php

namespace App\Http\Controllers\datacenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            $vlans = $this->vlan->orderByDesc('id')->paginate(5);
        }else{
            $query = $this->vlan->query()
                   ->where('nome_vlan','LIKE','%'.strtoupper($request->pesquisa).'%');
            $vlans = $query->orderByDesc('id')->paginate(5);
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
            $timestamps = $this->vlan->timestamps;
            $this->vlan->timestamps=false;
            $data = [
                'nome_vlan' => strtoupper($request->input('nome_vlan')),
                'created_at' =>now(),
                'updated_at' => null,
            ];
            $vlan = $this->vlan->create($data);
            $this->vlan->timestamps=true;
            $v = Vlan::find($vlan->id);
            return response()->json([
                'vlan' => $v,
                'status' => 200, 
                'message' => 'Registro criado com sucesso!',
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $vlan = $this->vlan->find($id);
        return response()->json([
            'vlan' => $vlan,
            'status' => 200,
        ]);
    }

    public function update(Request $request, $id)
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
            $timestamps = $this->vlan->timestamps;
            $this->vlan->timestamps = false;
            $vlan = $this->vlan->find($id);            
            if($vlan){
                        $data = [
                            'nome_vlan' => strtoupper($request->input('nome_vlan')),
                            'updated_at' => now(),
                        ];
                        $vlan->update($data);
                        $this->vlan->timestamps = true;
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

    public function destroy($id)
    {
        $vlan = $this->vlan->find($id);
        $vlan->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
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
            $timestamps = $this->rede->timestamps;
            $this->rede->timestamps = false;
            $data = [                
                'nome_rede' => strtoupper($request->input('nome_rede')),
                'mascara'   => $request->input('mascara'),
                'tipo_rede' => strtoupper($request->input('tipo_rede')),
                'vlan_id'   => $request->input('vlan_id'),
                'created_at' => now(),
                'updated_at' => null,
            ];            
            $rede = $this->rede->create($data);            
            $this->rede->timestamps = true;
            $r = Rede::find($rede->id);
            $vlan = $rede->vlan;
            return response()->json([
                'vlan'  => $vlan,
                'rede'  => $r,
                'status' => 200,
                'message' => 'Registro gravado com sucesso!',
            ]);
        }
    }
}
