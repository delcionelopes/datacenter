<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">       
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <title>Relatório de Autorizações</title>  
    
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
    <div class="container-fluid" style="align-content: center; padding-left: 7%">
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
    <h3 style="text-align: center; text-decoration-style: solid">RELATÓRIO DE PERMISSÕES PARA {{$user->name}}</h3>
    <br>
    <p>Usuário:&nbsp;{{$user->email}}</p>
    <p>Perfil:&nbsp;{{$user->perfil->nome}}</p>
    <br>
    </nav>    
    <div>    
    </div>    
    <table class="table table-sm">    
    <thead>        
        <tr>
            <th scope="row" style="text-align: justify">MÓDULO</th>
            <th scope="row" style="text-align: justify">DATA AUT</th>
            <th scope="row" style="text-align: justify">AUTORIZADOR</th>
        </tr>       
    </thead>
    <tbody>
        @if($autorizacoes->count())
        @foreach($modulos as $mod)
            @foreach($autorizacoes as $aut)
            @if($aut->modulo_has_operacao_modulo_id==$mod->id)
            <tr>
                <td><span>&#8226;</span>&nbsp;{{$mod->nome}}</td>
                @if($aut->created_at==null)
                <td></td>
                @else
                <td>{{date('d/m/Y H:i:s',strtotime($aut->created_at))}}</td>
                @endif                
                <td>{{$aut->usercreater->cpf}}</td>
                <tr>
                   <th scope="row" style="text-align: justify">&nbsp;&nbsp;OPERAÇÕES</th>
                   <th scope="row" style="text-align: justify"></th>
                   <th scope="row" style="text-align: justify"></th>
                </tr>
                <div id="listaoperacoes" data-perfil="{{$user->perfil_id}}" data-modulo="{{$mod->id}}" onload="mostraOperacoes();"></div>
            </tr>
            @break
            @elseif ($loop->last)
              {{-- cessa a construção de cards --}}
            @endif      
            @endforeach
        @endforeach
        @endif
    </tbody>    
    </table>     
     
    </div>
            
</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        const minhaDiv = document.getElementById('listaoperacoes');
        minhaDiv.addEventListener('load',function(){            
            var perfil = $(this).data("perfil");
            var modulo = $(this).data("modulo");
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });                
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/datacenteradmin/relatorios/relatorio-listaoperacoes/'+perfil+'/'+modulo,                                
                success: function(response){
                    if(response.status==200){
                        $.each(response.operacoes,function(key, operacao){
                            $.each(response.autope,function(key, autope){
                                if(autope.modulo_has_operacao_operacao_id == operacao.id){
                                    $('#listaoperacoes').append('<tr><td>'+operacao.nome+'</td><td></td><td></td></tr>');
                                }
                            });
                        });
                    }
                }
        });
        
    });

        });        
   
</script>