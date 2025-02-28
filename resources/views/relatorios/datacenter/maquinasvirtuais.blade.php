<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">       
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <title>Relatório de Máquinas Virtuais</title>  
    
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
    <h3 style="text-align: center; text-decoration-style: solid">RELATÓRIO DE MÁQUINAS VIRTUAIS</h3>
    </nav>    
    <div>    
    </div>
    {{--@for ($pagina = 1; $pagina <= $num_paginas; $pagina++) --}}
    <table class="table table-sm">    
    <thead>        
        <tr>
            <th>NOME</th>
            <th>CPU</th>
            <th>MEM</th>
            <th>DISCO</th>
            <th>IP</th>
            <th>SISTEMA OPERACIONAL</th>
            {{--<th>AMBIENTE</th>
            <th>ORGÃO</th>
            <th>CLUSTER</th>
            <th>PROJETO</th>  --}}
        </tr>       
    </thead>
    <tbody>
            @foreach($maquinasvirtuais as $vm)
            <tr>
                <td>{{$vm->nome_vm}}</td>                 
                <td>{{$vm->cpu}}</td>
                <td>{{$vm->memoria}}</td>
                <td>{{$vm->disco}}</td>
                <td>{{$vm->ip}}</td>
                <td>{{$vm->sistema_operacional}}</td>
                {{--@if($vm->ambiente_id)
                <td>{{$vm->ambiente->nome_ambiente}}</td>
                @else
                <td></td>    
                @endif
                @if($vm->orgao_id)
                <td>{{$vm->orgao->nome_orgao}}</td>
                @else
                <td></td>
                @endif
                @if($vm->cluster_id)
                <td>{{$vm->clusterref->nome_cluster}}</td>
                @else
                <td></td>
                @endif
                @if($vm->projeto_id)
                <td>{{$vm->projeto->nome_projeto}}</td>
                @else
                <td></td>  
                @endif  --}}
            </tr>               
            @endforeach
            {{--@if($num_linhas_impressas+1<$num_linhas_total)
            @for ($i = $num_linhas_impressas+1; $i <= $num_linhas_total; $i++)            
            <tr>
                <td style="color: white">$i</td>
                <td> </td>
                <td> </td>
            </tr>            
            @endfor            
            @endif  --}}
    </tbody>
    </table>
     <!-- Rodapé-->
        {{--<footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">                        
                        <div class="small text-center text-muted fst-italic">copyright &copy; prodap / gerado em {{date('d/m/Y H:i:s',strtotime($date))}} <br> Página {{$pagina}} de {{$num_paginas}}</div>
                    </div>
                </div>
            </div>
        </footer>  
    @endfor  --}}
    </div>
            
</body>
</html>