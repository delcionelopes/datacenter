<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">    
        
        <!-- CSRF Token -->    
        <meta name="_token" content="{{ csrf_token() }}">

        <title>PRODAP - Datacenter</title>        
        
        <link type="text/css" rel="stylesheet" href="{{mix('css/app.css') }}">

        <link rel="icon" type="image/x-icon" href="{{asset('assets/favicon.ico')}}" />                    
        <!-- Font Awesome ícones (versão livre)-->
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>

         <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        
        <link href="{{asset('css/styles.css')}}" rel="stylesheet"/>
        <link href="{{asset('css/menu_estilo.css')}}" rel="stylesheet"/>
    </head>
    <body>
         <!-- Navegação-->
         <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
            <div class="container px-4 px-lg-5">
               @auth
                      @if(auth()->user()->avatar)
                       <img src="{{asset('storage/'.auth()->user()->avatar)}}" alt="Foto de {{auth()->user()->name}}"
                        class="rounded-circle" width="50">
                      @else
                       <img src="{{asset('storage/user.png')}}" alt="usuário"
                        class="rounded-circle" width="50">
                      @endif
                      <span class="caret"></span>
                @endauth

                <a class="navbar-brand" href="https://www.prodap.ap.gov.br" target="_blank">PRODAP</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto py-4 py-lg-0">                
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('page.master')}}">Home</a></li>
                @guest
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('login')}}">Login</a></li>   
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('register')}}">Registre-se</a></li>
                @endguest
                @auth
                @if((auth()->user()->admin) && (auth()->user()->inativo!=1))
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('sistema.index')}}">DATACENTER</a></li>
                @endif   
                @if(auth()->user()->inativo!=1)                     
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('page.showperfil',['id' => auth()->user()->id])}}">{{auth()->user()->name}}</a></li>
                @endif
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('exit-form').submit();">Sair</a>
                   <form id="exit-form" action="{{route('logout')}}" method="post" style="display: none;">
                    @csrf
                   </form>
                </li> 
                @endauth
                </ul>
                </div>
            </div>
        </nav>         
            @yield('content')
        <!--jQuery-->
        <script src="{{asset('jquery/jquery-3.6.0.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>                
        <script src="{{asset('js/scripts.js')}}"></script>                              
        <script src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.0/sweetalert2.min.js')}}"></script>
      @yield('scripts')
    </body>
</html>
