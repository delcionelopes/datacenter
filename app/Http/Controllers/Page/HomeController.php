<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Mail\SendMailUser;
use App\Models\Arquivo;
use App\Models\Artigo;
use App\Models\Comentario;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    private $artigo;

    public function __construct(Artigo $artigo)
    {        
        $this->artigo = $artigo;
    }   
    
    public function master(Request $request){

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        if(is_null($request->pesquisa)){
            $artigos = $this->artigo->orderByDesc('id')->paginate(5);            
        }else{
            $query = $this->artigo->query()
                   ->where('titulo','LIKE','%'.$request->pesquisa.'%');
            $artigos = $query->orderByDesc('id')->paginate(5);
        }
        $temas = Tema::all();
        return view('page.artigos.master',[
            'temas' => $temas,
            'artigos' => $artigos,
        ]);
    }

    public function detail($slug){        
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $artigo = $this->artigo->whereSlug($slug)->first();

        $query = Comentario::query()
                 ->where('artigos_id','=',$artigo->id);
        $comentarios = $query->orderByDesc('id')->paginate(10);                    

        return view('page.artigos.detail',[
            'artigo' => $artigo,
            'comentarios' => $comentarios,
        ]);
    }

    public function downloadArquivo($id){                      
        
        $arquivo = Arquivo::find($id);                
        $downloadPath = public_path('/storage/'.$arquivo->path);                

        $headers = [
            'HTTP/1.1 200 OK',
            'Pragma: public',
            'Content-Type: application/pdf'
        ];                   
        return response()->download($downloadPath,$arquivo->rotulo,$headers);    
    }

    public function showPerfil($id){
        $user = User::find($id);
        return view('page.perfil',[
            'user' => $user,
            ]);
    }

    public function perfilUsuario(Request $request,$id){                
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|min:8|max:100',            
        ],[
            'name.required'  => 'O campo NOME é obrigatório!',
            'name.max'       => 'O NOME deve ter no máximo :max caracteres!',
            'email.required' => 'O campo EMAIL é obrigatório!',
            'email.email'    => 'O EMAIL é inválido!',
            'email.max'      => 'O EMAIL deve conter no máximo :max caracteres!',
            'password.required' => 'A SENHA é obrigatória!',
            'password.min' => 'A SENHA deve ter no mínimo :min caracteres!',
            'password.max' => 'A SENHA deve ter no máximo :max caracteres!',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{         
        $user = User::find($id);        
        $filePath="";
        if($request->hasFile('imagem')){
        //exclui o arquivo de avatar anterior se houver
          if($user->avatar){
            $antigoPath = public_path('/storage/'.$user->avatar);
            if(file_exists($antigoPath)){
            unlink($antigoPath);
            }
          }
        //upload do novo arquivo se houver
        $file = $request->file('imagem');                           
        $fileName =  $user->id.'_'.$file->getClientOriginalName();
        $filePath = 'avatar/'.$fileName;
        $storagePath = public_path().'/storage/avatar/';
        $file->move($storagePath,$fileName);
        }        
        $data['name'] = $request->input('name');
        $data['email'] = strtolower($request->input('email'));
        $data['password'] = bcrypt($request->input('password'));        
        if($filePath){
        $data['avatar']  = $filePath;
        }
        $data['link_instagram'] = strtolower($request->input('link_instagram'));
        $data['link_facebook'] = strtolower($request->input('link_facebook'));
        $data['link_site'] = strtolower($request->input('link_site'));                
        
        $user->update($data);          

        return response()->json([
            'status' => 200,            
        ]);
    }
    
    }

    public function enviarEmail(Request $request, $slug){
        $notificar = $request->input('notificar');        
        //Atualizando o campo notificarassinante
        $artigo = $this->artigo->whereSlug($slug)->first();
        $data = [
            'notificarassinantes'  => $notificar,
        ];
        $artigo->update($data);
        if($notificar==1){
        //Montando a lista de emails
        $contatos = User::all('email');        
        $emails = [];
        $i=0;
        foreach($contatos as $contato){
            $emails[$i] = $contato->email;
            $i++;
        }
        Mail::to($emails)->send(new SendMailUser($artigo));
        }
        return response()->json([
            'status' => 200,
            'id' => $artigo->id,
            'slug' => $slug,
            'notificar' => $notificar,
        ]);
    }


    
}
