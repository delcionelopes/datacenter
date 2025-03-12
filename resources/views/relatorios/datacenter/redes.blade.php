<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">       
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <title>Relatório de Redes</title>  
    
    <style>
     .child  {
       display: inline-block;
       flex-wrap: wrap;
       justify-items: center;
       text-align: center;
       position: relative;       
     }
</style>

</head>

<body>   
    <div class="container-fluid py-5">
   <nav>
    <div class="container-fluid" style="align-content: center; padding-left: 22%">
    <div class="child">
        <img src="brazao_amapa.png" alt="" width="80" height="80">
    </div>
    <div class="child" style="font-style: bold">        
                    GOVERNO DO ESTADO DO AMAPÁ<br>
                    CENTRO DE GESTÃO DE TECNOLOGIA DA INFORMAÇÃO<br>                    
                    {{$setor}}
    </div>
    <div class="child">
        <img src="logo_prodap.png" alt="" width="80" height="80">
    </div>        
    </div>
    <h3 style="text-align: center; text-decoration-style: solid">RELATÓRIO DE REDES</h3>
    </nav>    
    <div>    
    </div>    
    <table class="table table-sm">    
    <thead>        
        <tr>
            <th scope="row" style="text-align: justify">NOME</th>
            <th scope="row" style="text-align: justify">TIPO</th>
            <th scope="row" style="text-align: justify">VLAN</th>
            <th scope="row" style="text-align: justify">CRIAÇÃO</th>
            <th scope="row" style="text-align: justify">ATUALIZAÇÃO</th>
        </tr>       
    </thead>
    <tbody>
           {{$pagina=1}}
           {{$linha=0}}
            @foreach($redes as $rede)            
            <tr>
                <td>{{$rede->nome_rede}}</td>
                <td>{{$rede->tipo_rede}}</td>
                <td>{{$rede->vlan->nome_vlan}}</td>
                @if($rede->created_at==null)
                <td></td>
                @else
                <td>{{date('d/m/Y H:i:s',strtotime($rede->created_at))}}</td>
                @endif
                @if($rede->updated_at==null)
                <td></td>
                @else
                <td>{{date('d/m/Y H:i:s',strtotime($rede->updated_at))}}</td>
                @endif
            </tr>
            {{$linha++}}
            @if(($linha==21)&&($linha % 21==0)&&($pagina<2))
           <!-- Rodapé-->
            <footer class="border-top">
               <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">                        
                        <div class="small text-center text-muted fst-italic">Gerado em {{date('d/m/Y H:i:s',strtotime($date))}} - Página {{$pagina}}</div>
                    </div>
                </div>
             </div>
           </footer>
            {{$pagina++}}
            {{$linha=0}}            
           @endif            
           @if(($linha>=28)&&($linha % 28==0)&&($pagina>1))
            <!-- Rodapé-->
            <footer class="border-top">
               <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">                        
                        <div class="small text-center text-muted fst-italic">Gerado em {{date('d/m/Y H:i:s',strtotime($date))}} - Página {{$pagina}}</div>
                    </div>
                </div>
             </div>
           </footer>
            {{$pagina++}}                        
            @endif            
            @if($loop->last)
            <!-- Rodapé-->
            <footer class="border-top">
               <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">                        
                        <div class="small text-center text-muted fst-italic">Gerado em {{date('d/m/Y H:i:s',strtotime($date))}} - Página {{$pagina}}</div>
                    </div>
                </div>
             </div>
           </footer>
            @endif
            @endforeach            
    </tbody>    
    </table>     
     
    </div>
            
</body>
</html>