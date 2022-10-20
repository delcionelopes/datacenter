<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Tema;
use Illuminate\Http\Request;

class TemaArtigoController extends Controller
{
    private $tema;

    public function __construct(Tema $tema)
    {
        $this->tema = $tema;
    }

    public function index($slug){
        $tema = $this->tema->whereSlug($slug)->first();
        $artigos = $tema->artigos()->orderByDesc('id')->paginate(5);
        return view('page.temas',[
            'tema' => $tema,
            'artigos' =>$artigos,
        ]);
    }
}
