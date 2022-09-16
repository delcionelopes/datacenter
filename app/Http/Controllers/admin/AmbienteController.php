<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ambiente;
use App\Models\App;
use App\Models\Base;
use App\Models\VirtualMachine;
use Illuminate\Support\Facades\Validator;

class AmbienteController extends Controller
{    

    private $ambiente;
    
    public function __construct(Ambiente $ambiente){
        $this->ambiente = $ambiente;
    }

    /**
     * Lista ambientes com opção de pesquisa por nome do ambiente
     */
    public function index(Request $request)    
    {   
        //se não houver parâmetros na pesquisa $request->nome, deve listar todos os ambientes                     
        if(is_null($request->nome)){
            $ambientes = $this->ambiente->orderByDesc('id')->paginate(6);
        }else{                                 
            //retorna lista de ambientes pesquisados               
            $query = $this->ambiente->query()
                     ->where('nome_ambiente','LIKE','%'.strtoupper($request->nome).'%');                     
            
            $ambientes = $query->orderByDesc('id')->paginate(6);            
            
        }                           
        return view('ambientes.index',[
            'ambientes' => $ambientes,
        ]);                
    }


    public function create()
    {
        //
    }

    /**
     * Método de gravação do novo ambiente na base
     */
    public function store(Request $request)
    {           
        //aplica regras de validação nos dados do ambiente
        $validator = Validator::make($request->all(),[
            'nome_ambiente' => 'required|max:191',
        ],[
            'nome_ambiente.required' => 'O campo NOME é obrigatório',
            'nome_ambiente.max' => 'O NOME deve ter no máximo :max caracteres!',
        ]);
        //Relata erros do usuários nos dados
        if($validator->fails()){
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->errors()->getMessages(),
            ]);
        } else {     
            //atribui a request valida            
            $data = [
                'nome_ambiente' => strtoupper($request->input('nome_ambiente')),              
            ];            
            //cria o ambiente
            $ambiente = $this->ambiente->create($data);                     
            return response()->json([                
                'ambiente' => $ambiente,
                'status'  => 200,
                'message' => 'Ambiente adicionado com sucesso!',
            ]); 
        }
    }


    public function show($id)
    {
        //
    }

    /**
     * Método de envio do ambiente para alteração
     */
    public function edit(int $id)    
    {      
        //localiza o registro        
        $a = $this->ambiente->find($id);                    
        //retorna
        return response()->json([
            'ambiente'=>$a,
            'status' => 200,]);        
    }

    /**
     * Método para atualizar o ambiente na base
     *  */    
    public function update(Request $request,int $id)
    {     
        //aplicando regras de validação nos dados da request
        $validator = Validator::make($request->all(),[
            'nome_ambiente' => 'required|max:191',
        ],[
            'nome_ambiente.required' => 'O campo NOME é obrigatório',
            'nome_ambiente.max' => 'O NOME deve ter no máximo :max caracteres!',
        ]);
        //relata erros do usuário nos dados da request
        if($validator->fails()){
            return response()->json([
                'status'   => 400,
                'errors'   => $validator->errors()->getMessages(), 
            ]);
        }else{           
           //Com o request satisfazendo as regras, localiza-se o registro e atribui o request
            $ambiente = $this->ambiente->find($id);                                               
            if($ambiente){
                     $ambiente->nome_ambiente = strtoupper($request->input('nome_ambiente'));
                     //efetiva a atualização
                     $ambiente->update(); 
                     //retornando o registro atualizado
                     $a = Ambiente::find($id);                      
                     
                     return response()->json([             
                         'ambiente' => $a,                     
                         'status'    => 200,
                         'message'   => 'Ambiente atualizado com sucesso!',
                     ]);
                } else {
                    //erro de registro não encontrado
                      return response()->json([
                         'status'   => 404,
                         'message'  => 'Ambiente não localizado!',
            ]);
        }
    }

    }

    /**
     * Método para exclusão de registro com opção recursiva (exclusão dos relacionamentos) para o adm
     *  */ 
    public function destroy(int $id)
    {        
        $ambiente = $this->ambiente->find($id);
        $vms = $ambiente->virtual_machine;          
        //verifica a existência de relacionamentos
        if($ambiente->virtual_machine()->count()){
            //Caso positivo verifica se o usuário é adm e está ativo          
            if((auth()->user()->moderador)&&(!(auth()->user()->inativo))){                
                //exclui virtual machines $vms
                foreach ($vms as $vm) {
                    $v = VirtualMachine::find($vm->id);
                    $bases = $v->bases;
                    //verifica se a $vm tem bases relacionadas, caso positivo exclui
                    if($v->bases()->count()){
                    foreach ($bases as $base) {
                        $b = Base::find($base->id);
                        $apps = $b->apps;
                        //verifica se as bases da vm tem apps relacionadas, caso positivo exclui                        
                        if($b->apps()->count()){
                        foreach ($apps as $app) {
                            $a = App::find($app->id);
                            $a->delete(); //exclui app
                        }
                        }
                        $b->delete(); //exclui base
                    }
                    }
                    //verfica se existem vlans relacionadas à VM
                    $vmXvlans = $v->vlans;
                    if($v->vlans()->count()){
                    $v->vlans()->detach($vmXvlans); //exclui o relacionamento com as vlans
                    $v->delete(); //exclui a virtual machine
                    }
                }          
                //feedback da exclusão do ambiente com relacionamentos pelo adm                            
                $status = 200;
                $message = $ambiente->nome_ambiente.' excluído com sucesso!';                
                $ambiente->delete();
            }else{
                //impedimento da exclusão caso hajam relacionamentos porque o usuário não é adm
                $status = 400;
                $message = $ambiente->nome_ambiente.' não pode ser excluído. Pois há outros registros que dependem dele! Procure um administrador!';
            }
        }else{
            //feedback da exclusão do ambiente sem relacionamento pelo usuário de qualquer perfil
            $status = 200;
            $message = $ambiente->nome_ambiente.' excluído com sucesso!';            
            $ambiente->delete();        
        }

        return response()->json([
            'status'  => $status,
            'message' => $message,
        ]);
    }
}
