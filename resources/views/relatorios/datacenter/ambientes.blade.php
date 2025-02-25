<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Relatório de ambientes</title>
</head>
<body>
    <h1>Relatório de ambientes</h1>    
    <p>Gerado em {{$date}}</p>
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
</body>
</html>
