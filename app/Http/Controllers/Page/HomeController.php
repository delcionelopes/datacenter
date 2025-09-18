<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Mail\SendMailUser;
use App\Models\Arquivo;
use App\Models\Artigo;
use App\Models\Comentario;
use App\Models\Entidade;
use App\Models\Institucional;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    private $artigo;
    private $entidade;
    private $institucional;
    private $arquivo;

    public function __construct(Artigo $artigo, Entidade $entidade, Institucional $institucional, Arquivo $arquivo)
    {        
        $this->artigo = $artigo;
        $this->entidade = $entidade;
        $this->institucional = $institucional;
        $this->arquivo = $arquivo;
    }   
    
    public function master(Request $request){
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        if(is_null($request->pesquisa)){
            $artigos = $this->artigo->orderBy('id')->paginate(5);
        }else{
            $query = $this->artigo->query()
                   ->where('titulo','LIKE','%'.$request->pesquisa.'%');
            $artigos = $query->orderByDesc('id')->paginate(5);
        }        
        $temas = Tema::all();
        $entidade = $this->entidade->orderByDesc('id')->first();
        $institucionais = $this->institucional->all();
        return view('page.artigos.master',[
            'temas' => $temas,
            'artigos' => $artigos,
            'entidade' => $entidade,
            'institucionais' => $institucionais,
        ]);
    }

    public function detail($slug){        
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $artigo = $this->artigo->whereSlug($slug)->first();

        $query = Comentario::query()
                 ->where('artigos_id','=',$artigo->id);
        $comentarios = $query->orderByDesc('id')->paginate(10);
        $institucionais = $this->institucional->all();
        return view('page.artigos.detail',[
            'artigo' => $artigo,
            'comentarios' => $comentarios,
            'institucionais' => $institucionais,
        ]);
    }

    public function downloadArquivo($id){        
        $arquivo = $this->arquivo->find($id);
        return response()->json([
            'status' => 200,
            'arquivo' => $arquivo,
        ]);
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

      
}
