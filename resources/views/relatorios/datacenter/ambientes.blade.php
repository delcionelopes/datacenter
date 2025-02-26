<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">    
    <meta name="_token" content="{{ csrf_token() }}"> 
    <link rel="stylesheet" href="{{asset('bootstrap-4.1.3-dist/css/bootstrap.min.css')}}"/>   
    
    <title>Relatório de Ambientes</title>
</head>
<body>
    @csrf
    <div class="header">
        
                    GOVERNO DO ESTADO DO AMAPÁ<br>
                    CENTRO DE GESTÃO DE TECNOLOGIA DA INFORMAÇÃO<br>
                    DIRETORIA DE SISTEMAS E TRANSFORMAÇÃO DIGITAL<br>
                    NÚCLEO DE SISTEMAS E SOLUÇÕES        
    </div>    
    <h1>Relatório de ambientes</h1>    
    <p>Gerado em {{$date}}</p>
    <div class="container">
    <table class="table table-sm">    
    <thead class="bg-secondary" style="color: white">        
        <tr>
            <th>NOME</th>
            <th>CRIAÇÃO</th>
            <th>ALTERAÇÃO</th>
        </tr>       
    </thead>
    <tbody>
            @foreach($ambientes as $ambiente)
            <tr>
                <th>{{$ambiente->nome_ambiente}}</th> 
                @if($ambiente->created_at==null)
                <td></td>
                @else
                <td>{{date('d/m/Y',strtotime($ambiente->created_at))}}</td>
                @endif
                @if($ambiente->updated_at==null)
                <td></td>
                @else
                <td>{{date('d/m/Y',strtotime($ambiente->updated_at))}}</td>
                @endif
            </tr>               
            @endforeach     
    </tbody>        
    </table>    
    </div>
</body>
</html>
