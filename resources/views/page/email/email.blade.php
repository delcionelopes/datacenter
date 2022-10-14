<!doctype html>
<html lang="pt">
<head>               
        <!-- Font Awesome icons (versão livre)-->        
        <script src="{{asset('https://use.fontawesome.com/releases/v5.15.4/js/all.js')}}" crossorigin="anonymous"></script> 
        <link href="{{asset('css/styles.css')}}" rel="stylesheet"/>        
</head>
<body>        
  <!-- Cabeçalho-->
 <header class="masthead" style="background-image: url({{asset('/storage/'.$artigo->imagem)}})">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="post-heading">
                            <h1>{{$artigo->titulo}}</h1>
                            <h2 class="subheading">{{$artigo->descricao}}</h2>
                            <span class="meta">
                                Postado por
                                <a href="#!">{{$artigo->user->name}}</a>                                
                                <span class="caret"></span><br>                               
                                {{ucwords(strftime('%A, %d de %B de %Y', strtotime($artigo->created_at)))}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
</header>                        
<!-- Conteúdo do artigo -->
<article class="mb-3">
            <div class="container px-1 px-lg-1">
                <div class="row gx-1 gx-lg-1 justify-content-center">
                <div class="col-md-10 col-lg-10 col-xl-9">                                    
                <div class="preformated">
                        <pre style="display: block; 
                                    text-align: justify; 
                                    font-family: monospace; 
                                    white-space: pre-line;">
                           {{$artigo->conteudo}}                                                   
                        </pre>             
                </div>                
              </div>
              </div>                
            </div>            
</article> 
<!-- Rodapé-->
<footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">                       
                        <div class="small text-center text-muted fst-italic">Copyright &copy; Laravel & Ajax - meuBlog: Aprenda Fazendo</div>
                    </div>
                </div>
            </div>
</footer> 
    </body>
</html>
