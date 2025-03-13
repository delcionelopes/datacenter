<?php

namespace App\Http\Controllers;

use App\Models\Artigo;
use App\Models\Tema;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $artigo;
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct(Artigo $artigo)
    {
        $this->middleware('auth');
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->admin){       
        return view('home');
        }else{
            return $this->master;
        }
    }
}
