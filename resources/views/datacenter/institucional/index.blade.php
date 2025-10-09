@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--index-->
<div class="container-fluid py-5">   
    <div id="success_message"></div>    

    <section class="border p-4 mb-4 d-flex align-items-left">
    
    <form action="{{route('admin.institucionais.index',['color'=>$color])}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">
            <nav class="navbar navbar-expand-md navbar-light bg-light">
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome da instituição" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>        
            <a href="{{route('admin.institucionais.create',['color'=>$color])}}" type="button" class="AddInstituicao_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro"><i class="fas fa-plus"></i></a>
            <button data-color="{{$color}}" type="button" class="voltarmenu_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-door-open"></i></button>
            </nav>
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="bg-{{$color}}" style="color: white">
                            <tr>                                
                                <th scope="col">INSTITUIÇÃO</th>                                
                                <th scope="col">SIGLA</th>                                
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_artigos">
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($institucionais as $instituicao)   
                            <tr id="instituicao{{$instituicao->id}}">                                
                                <th scope="row">{{$instituicao->nome}}</th>                                
                                <td>{{$instituicao->sigla}}</td>
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <a href="{{route('admin.institucionais.edit',['id'=>$instituicao->id,'color'=>$color])}}" type="button" data-id="{{$instituicao->id}}" class="edit_instituicao fas fa-edit" style="background:transparent;border:none; color:black; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></a>
                                            <button type="button" data-id="{{$instituicao->id}}" data-sigla="{{$instituicao->sigla}}" class="delete_instituicao_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
                    {{$institucionais->links()}}
                    </div>  
   
    </div>        
    
</div>

@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
    <link href="{{asset('css/styles.css')}}" rel="stylesheet"/>
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){        
    
        $(document).on('click','.delete_instituicao_btn',function(e){   ///inicio delete 
            e.preventDefault();           
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var id = $(this).data("id");    
            var linklogo = "{{asset('storage')}}";        
            var sigla = $(this).data("sigla");
            
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:sigla,
                text: "Deseja excluir?",
                imageUrl: linklogo+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do sistema',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){             
                $.ajax({
                    url: '/admin/institucionais/delete/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,
                        '_method': 'DELETE',                    
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente da tabela html
                            $("#instituicao"+id).remove();     
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
    

    ///tooltip
    $(function(){             
        $(".AddInstituicao_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_instituicao_btn").tooltip();
        $(".edit_instituicao").tooltip();    
    });
    ///fim tooltip

    $(document).on('click','.voltarmenu_btn',function(e){
        e.preventDefault();  
        var color = $(this).data("color");
        location.replace('/datacenteradmin/principal/operacoes/2/'+color);
        });
    
    
    }); ///Fim do escopo do script
    
    </script>
@stop