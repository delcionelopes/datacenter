@extends('adminlte::page')

@section('title', 'Módulos')

@section('content')

<!--index-->
@auth
<div class="container-fluid py-5">   
    <div id="success_message"></div>    

    <section class="border p-4 mb-4 d-flex align-items-left">
    
    <form action="{{route('datacenteradmin.modulo.index')}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="nome do módulo" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                <i class="fas fa-search"></i>
            </button>            
            
            <a href="{{route('datacenteradmin.modulo.create')}}" type="button" class="AddModuloModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-plus"></i></a>
            
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="sidebar-dark-primary" style="color: white">
                            <tr>                                
                                <th scope="col">MÓDULOS</th>
                                <th scope="col">ICO</th>
                                <th scope="col">OPERAÇÕES</th>
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_modulo">
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($modulos as $modulo)   
                            <tr id="modulo{{$modulo->id}}">                                
                                <th scope="row">{{$modulo->nome}}</th>                                                  
                                @if($modulo->ico)                 
                                <td>  
                                <img src="{{asset('storage/'.$modulo->ico)}}" alt="Icone de {{$modulo->nome}}"
                                class="rounded-circle" width="100">                                
                                </td>                               
                                @else
                                <td><img src="{{asset('storage/user.png')}}" alt="Sem imagem"
                                class="rounded-circle" width="100"></td>
                                @endif                                                               
                                <td>
                                <div class="btn-group">                                
                                        @if($modulo->operacoes->count())                                
                                        <button type="button" class="btn btn-{{$modulo->color}} dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-tools"></i><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" id="dropdown{{$modulo->id}}">
                                            @foreach($modulo->operacoes as $operacao)                                                                                                            
                                            <li class="dropdown-item"><a href="{{route('datacenteradmin.modulo.moduloxoperacao',['operacao_id'=>$operacao->id])}}" class="dropdown-item">{{$operacao->nome}}</a></li>
                                            @endforeach
                                        </ul>                                           
                                        @endif                               
                                </div>       
                                </td>
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <a href="{{route('datacenteradmin.modulo.edit',['id'=>$modulo->id])}}" type="button" data-id="{{$modulo->id}}" class="edit_modulo fas fa-edit" style="color: black; background:transparent;border:none"></a>
                                            <button type="button" data-id="{{$modulo->id}}" data-nome="{{$modulo->nome}}" class="delete_modulo_btn fas fa-trash" style="background:transparent;border:none"></button>
                                        </div>                                    
                                </td>
                            </tr>  
                            @empty
                            <tr id="nadaencontrado">
                                <td colspan="4">Nada Encontrado!</td>
                            </tr>                      
                            @endforelse                                                    
                        </tbody>
                    </table> 
                    <div class="d-flex hover justify-content-center">
                    {{$modulos->links()}}
                    </div>  
   
    </div>        
    
</div>
@endauth
<!--End Index-->
@stop

@section('css')

<link href="{{asset('css/styles.css')}}" rel="stylesheet"/>  {{-- css da aplicação --}}
    
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){

     $(document).on('click','.delete_modulo_btn',function(e){   ///inicio delete 
            e.preventDefault();           
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var id = $(this).data("id");
            var linklogo = "{{asset('storage')}}";

            var nome = $(this).data("nome");            
            
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nome,
                text: "Deseja excluir?",
                imageUrl: linklogo+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'Brasão do GEA',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){             
                $.ajax({
                    url: '/datacenteradmin/modulo/delete-modulo/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{                        
                        'id': id,                                         
                        '_token':CSRF_TOKEN,                        
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente da tabela html
                            $('#modulo'+id).remove();     
                            $('#success_message').replaceWith('<div id="success_message"></div>');                       
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);         
                        }else{
                            //Não pôde excluir por causa dos relacionamentos    
                            $('#success_message').replaceWith('<div id="success_message"></div>');                                                    
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.errors);         
                        }
                    }
                }); 
            }  
        });        
       
      
    });  ///fim delete


});

</script>

@stop