@extends('adminlte::page')

@section('title', 'Ambientes')


@section('content')
   <!--AddAmbienteModal-->

<div class="modal fade" id="AddAmbienteModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Ambientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="myform" name="myform" class="form-horizontal" role="form">                 
                <ul id="saveform_errList"></ul>                   
                <div class="form-group mb-3">
                    <label for="">Nome</label>
                    <input type="text" class="nome_ambiente form-control">
                </div>                
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_ambiente">Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddAmbienteModal-->

<!--EditAmbienteModal-->

<div class="modal fade" id="editAmbienteModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Ambiente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="myform" name="myform" class="form-horizontal" role="form">                
                <ul id="updateform_errList"></ul>               
                <input type="hidden" id="edit_ambiente_id">
                <div class="form-group mb-3">
                    <label for="">Nome</label>
                    <input type="text" id="edit_nome_ambiente" class="nome_ambiente form-control">
                </div>         
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_ambiente">Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!--index-->

<div class="container py-5">   
    <div id="success_message"></div>    
    <div class="row">   

    <div class="card-body">

    <section class="border p-4 mb-4 d-flex align-items-left">
    
    <form action="{{route('admin.ambiente.index')}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="nome" class="form-control rounded float-left" placeholder="nome do ambiente" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                <i class="fas fa-search"></i>
            </button>        
            <button type="button" class="AddAmbienteModal_btn input-group-text border-0" style="background: transparent;border: none;"><i class="fas fa-plus"></i></button>                
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>                                
                                <th>AMBIENTES</th>
                                <th>CRIADO EM</th>
                                <th>MODIFICADO EM</th>
                                <th>AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_ambiente">
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($ambientes as $ambiente)   
                            <tr id="ambiente{{$ambiente->id}}">                                
                                <td>{{$ambiente->nome_ambiente}}</td>
                                @if(is_null($ambiente->created_at))
                                <td></td>
                                @else
                                <td>{{date('d/m/Y H:i:s', strtotime($ambiente->created_at))}}</td>
                                @endif
                                @if(is_null($ambiente->updated_at))
                                <td></td>
                                @else
                                <td>{{date('d/m/Y H:i:s', strtotime($ambiente->updated_at))}}</td>
                                @endif
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <button type="button" data-id="{{$ambiente->id}}" class="edit_ambiente fas fa-edit" style="background:transparent;border:none"></button>
                                            <button type="button" data-id="{{$ambiente->id}}" data-nomeambiente="{{$ambiente->nome_ambiente}}" class="delete_ambiente_btn fas fa-trash" style="background:transparent;border:none"></button>
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
                    {{$ambientes->links()}}
                    </div>  
            </div>
        
        </div>   
    </div>        
    
</div> 
<!--End Index-->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script type="text/javascript">

    $(document).ready(function(){         
        
    
        $(document).on('click','.delete_ambiente_btn',function(e){   ///inicio delete ambiente
            e.preventDefault();
    
            var id = $(this).data("id");
            var nomeambiente = $(this).data("nomeambiente");
    
            swal({
                title:nomeambiente,
                text: "Deseja excluir?",
                icon:"warning",
                buttons:true,
                dangerMode:true,
            })                       
            .then(willDelete=>{
                if(willDelete){
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
                
                $.ajax({
                    url: 'delete-ambiente/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        "id": id,
                        "_method": 'DELETE',
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente da tabela html
                            $("#ambiente"+id).remove();                            
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);         
                        }
                    }
                });            
            } 
        });
    
        });  ///fim delete ambiente
        //início da exibição do form EditAmbientModal de ambiente                
        $('#editAmbienteModal').on('shown.bs.modal',function(){
            $('#edit_nome_ambiente').focus();
        });
        $(document).on('click','.edit_ambiente',function(e){  
            e.preventDefault();
            
            var id = $(this).data("id");                                   
            $('#myform').trigger('reset');
            $('#editAmbienteModal').modal('show');                
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: 'edit-ambiente/'+id,                                
                success: function(response){           
                    if(response.status==200){            
                        $('.nome_ambiente').val(response.ambiente.nome_ambiente);
                        $('#edit_ambiente_id').val(response.ambiente.id);                                                                                                       
                    }      
                }
            });
    
        }); //fim da da exibição do form EditAmbientModal de ambiente
    
        $(document).on('click','.update_ambiente',function(e){ //inicio da atualização de registro
            e.preventDefault();
    
            $(this).text("Atualizando...");
    
            var id = $('#edit_ambiente_id').val();        
    
            var data = {
                'nome_ambiente' : $('#edit_nome_ambiente').val(),
            }        
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: 'update-ambiente/'+id,         
                success: function(response){                                                    
                    if(response.status==400){
                        //erros
                        $('#updateform_errList').html("");
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });
    
                        $('.update_ambiente').text("Atualizado");
    
                    } else if(response.status==404){
                        $('#updateform_errList').html("");
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        $('.update_ambiente').text("Atualizado");
    
                    } else {
                        $('#updateform_errList').html("");
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);
                        $('.update_ambiente').text("Atualizado");                    
    
                        $('#myform').trigger('reset');
                        $('#editAmbienteModal').modal('hide');                  
                        
                        //atualizando a linha na tabela html
                        var datacriacao = new Date(response.ambiente.created_at).toLocaleString();
                            if(datacriacao=="31/12/1969 21:00:00"){
                                datacriacao = "";                            
                            }
                            var dataatualizacao = new Date(response.ambiente.updated_at).toLocaleString();
                            if(dataatualizacao=="31/12/1969 21:00:00"){
                                dataatualizacao = "";                            
                            }
    
                            var linha = '<tr id="ambiente'+response.ambiente.id+'">\
                                    <td>'+response.ambiente.nome_ambiente+'</td>\
                                    <td>'+datacriacao+'</td>\
                                    <td>'+dataatualizacao+'</td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.ambiente.id+'" class="edit_ambiente fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.ambiente.id+'" data-nomeambiente="'+response.ambiente.nome_ambiente+'" class="delete_ambiente_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';                             
                        $("#ambiente"+id).replaceWith(linha);                                                                                
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro
    
        //exibe form de adição de registro
        $('#AddAmbienteModal').on('shown.bs.modal',function(){
            $('.nome_ambiente').focus();
        });
        $(document).on('click','.AddAmbienteModal_btn',function(e){  //início da exibição do form EditAmbientModal de ambiente                
            e.preventDefault();       
            
            $('#myform').trigger('reset');
            $('#AddAmbienteModal').modal('show');                        
    
        });
    
        //fim exibe form de adição de registro
    
        $(document).on('click','.add_ambiente',function(e){ //início da adição de Registro
            e.preventDefault();
    
            var data = {
                'nome_ambiente': $('.nome_ambiente').val(),
            }        
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
            $.ajax({
                type: 'POST',
                url: 'adiciona-ambiente',
                data: data,
                dataType: 'json',
                success: function(response){
                    if(response.status==400){
                        $('#saveform_errList').html("");
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });
                    } else {
                        $('#saveform_errList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
    
                        $('#myform').trigger('reset');                    
                        $('#AddAmbienteModal').modal('hide');
    
                        //adiciona a linha na tabela html
                        var datacriacao = new Date(response.ambiente.created_at).toLocaleString();
                            if(datacriacao=="31/12/1969 21:00:00"){
                                datacriacao = "";                            
                            }
                            
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="ambiente'+response.ambiente.id+'">\
                                    <td>'+response.ambiente.nome_ambiente+'</td>\
                                    <td>'+datacriacao+'</td>\
                                    <td></td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.ambiente.id+'" class="edit_ambiente fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.ambiente.id+'" data-nomeambiente="'+response.ambiente.nome_ambiente+'" class="delete_ambiente_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';
                        if(!$('#nadaencontrado').html==""){
                            $('#nadaencontrado').remove();
                        }
                        tupla = linha0+linha1;                             
                        $("#novo").replaceWith(tupla);                                                     
                        
                    }
                    
                }
            });
    
        }); //Fim da adição de registro
    
    
    }); ///Fim do escopo do script
    
    </script>
@stop