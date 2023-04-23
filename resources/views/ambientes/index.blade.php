@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--AddAmbienteModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddAmbienteModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Ambientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="addform" name="addform" class="form-horizontal" role="form">                 
                <ul id="saveform_errList"></ul>                   
                <div class="form-group mb-3">
                    <label for="">Nome</label>
                    <input type="text" class="nome_ambiente form-control">
                </div>                
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_ambiente"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddAmbienteModal-->

<!--EditAmbienteModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="editAmbienteModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Ambiente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="editform" name="editform" class="form-horizontal" role="form">                
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
                <button type="button" class="btn btn-primary update_ambiente"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container-fluid py-5">   
    <div id="success_message"></div>    
    <section class="border p-4 mb-4 d-flex align-items-left">    
    <form action="{{route('admin.ambiente.index')}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="nome" class="form-control rounded float-left" placeholder="nome do ambiente" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>        
            <button type="button" data-setoradmin="{{auth()->user()->setor_idsetor}}" class="AddAmbienteModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                <i class="fas fa-plus"></i>
            </button>                
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="sidebar-dark-primary" style="color: white">
                            <tr>                                
                                <th scope="col">AMBIENTES</th>                    
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_ambiente">
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($ambientes as $ambiente)   
                            <tr id="ambiente{{$ambiente->id}}">                                
                                <th scope="row">{{$ambiente->nome_ambiente}}</th>                                
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <button type="button" data-id="{{$ambiente->id}}" data-admin="{{auth()->user()->admin}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-nomeambiente="{{$ambiente->nome_ambiente}}" class="edit_ambiente fas fa-edit" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar AMBIENTE"></button>
                                            <button type="button" data-id="{{$ambiente->id}}" data-admin="{{auth()->user()->admin}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-nomeambiente="{{$ambiente->nome_ambiente}}" class="delete_ambiente_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir AMBIENTE"></button>
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
@else 
  <i class="fas fa-lock"></i><b class="title"> USUÁRIO INATIVO OU NÃO LIBERADO! CONTACTE O ADMINISTRADOR.</b>
@endif
@endauth
<!--End Index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){        
    
        $(document).on('click','.delete_ambiente_btn',function(e){   ///inicio delete ambiente
            e.preventDefault();          
            var linklogo = "{{asset('storage')}}";
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var id = $(this).data("id");            
            var nome = ($(this).data("nomeambiente")).trim();
            var admin = $(this).data("admin");
            var setoradmin = $(this).data("setoradmin")
        
            if((admin==true)&&(setoradmin==1)){
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nome,
                text: "Deseja excluir?",
                imageUrl: linklogo+'./logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){             
                $.ajax({
                    url: 'delete-ambiente/'+id,
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
                            $("#ambiente"+id).remove();     
                            $("#success_message").replaceWith('<div id="success_message"></div>');                       
                            $("#success_message").addClass('alert alert-success');
                            $("#success_message").text(response.message);         
                        }else{
                            //Não pôde excluir por causa dos relacionamentos    
                            $("#success_message").replaceWith('<div id="success_message"></div>');                        
                            $("#success_message").addClass('alert alert-danger');
                            $("#success_message").text(response.message);         
                        }
                    }
                }); 
            } 
        })
                 
             }else{    
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nome,
                text: "Você não pode excluir este registro. Procure um administrador do setor INFRA !",
                imageUrl: linklogo+'./logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'OK!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){  
             }
            })
    
            }          
   
      
        });  ///fim delete ambiente
        //início da exibição do form EditAmbientModal de ambiente                
        $("#editAmbienteModal").on('shown.bs.modal',function(){
            $("#edit_nome_ambiente").focus();
        });
        $(document).on('click','.edit_ambiente',function(e){  
            e.preventDefault();
            var linklogo = "{{asset('storage')}}";
            var id = $(this).data("id");
            var admin = $(this).data("admin");
            var setoradmin = $(this).data("setoradmin");
            var nome = $(this).data("nomeambiente");
            if((admin)&&(setoradmin==1)){
            $("#editform").trigger('reset');
            $("#editAmbienteModal").modal('show');          
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');      
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: 'edit-ambiente/'+id,                                
                success: function(response){           
                    if(response.status==200){   
                        var nomeambiente = (response.ambiente.nome_ambiente).trim();                        
                        $(".nome_ambiente").val(nomeambiente);
                        $("#edit_ambiente_id").val(response.ambiente.id);                                                                                                       
                    }      
                }
            });
        }else{
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nome,
                text: "Você não pode alterar este registro. Procure um administrador do setor INFRA !",
                imageUrl: linklogo+'./logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'OK!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){  
             }
            })
        
        }
    
        }); //fim da da exibição do form EditAmbientModal de ambiente
    
        $(document).on('click','.update_ambiente',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var loading = $("#imgedit");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');            
    
            var id = $("#edit_ambiente_id").val();        
    
            var data = {
                'nome_ambiente' : ($("#edit_nome_ambiente").val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }
            
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: 'update-ambiente/'+id,         
                success: function(response){                                                    
                    if(response.status==400){
                        //erros
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                        $("#updateform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#updateform_errList").append('<li>'+err_values+'</li>');
                        });
    
                        loading.hide();
    
                    } else if(response.status==404){
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');    
                        $("#success_message").replaceWith('<div id="success_message"></div>');             
                        $("#success_message").addClass('alert alert-warning');
                        $("#success_message").text(response.message);
                        loading.hide();
    
                    } else {
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');      
                        $("#success_message").replaceWith('<div id="success_message"></div>');                 
                        $("#success_message").addClass("alert alert-success");
                        $("#success_message").text(response.message);
                        loading.hide();
    
                        $("#editform").trigger('reset');
                        $("#editAmbienteModal").modal('hide');                  
                        
                        //atualizando a linha na tabela html                      
    
                            var linha = '<tr id="ambiente'+response.ambiente.id+'">\
                                    <th scope="row">'+response.ambiente.nome_ambiente+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.ambiente.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomeambiente="'+response.ambiente.nome_ambiente+'" class="edit_ambiente fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.ambiente.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomeambiente="'+response.ambiente.nome_ambiente+'" class="delete_ambiente_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';                             
                        $("#ambiente"+id).replaceWith(linha);                                                                                
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro
    
        //exibe form de adição de registro
        $("#AddAmbienteModal").on('shown.bs.modal',function(){
            $(".nome_ambiente").focus();
        });
        $(document).on('click','.AddAmbienteModal_btn',function(e){  //início da exibição do form EditAmbientModal de ambiente                
            e.preventDefault();     
            
            var link = "{{asset('storage')}}";
            var setoradmin = $(this).data("setoradmin");

            if(setoradmin==1){
            
            $("#addform").trigger('reset');
            $("#AddAmbienteModal").modal('show'); 
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');                       
            }else{
                 Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:"ALERTA INFRA !",
                text: "Você não pode criar um registro. Pois seu usuário não pertence ao setor INFRA !",
                imageUrl: linklogo+'./logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'OK!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){  
             }
            })
            }
    
        });
    
        //fim exibe form de adição de registro
    
        $(document).on('click','.add_ambiente',function(e){ //início da adição de Registro
            e.preventDefault();
            var loading = $("#imgadd");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var data = {
                'nome_ambiente': ($(".nome_ambiente").val()).trim(),               
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            } 
            
            $.ajax({
                type: 'POST',
                url: 'adiciona-ambiente',
                data: data,
                dataType: 'json',
                success: function(response){
                    if(response.status==400){
                        $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
                        $("#saveform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#saveform_errList").append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    } else {
                        $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');     
                        $("#success_message").replaceWith('<div id="success_message"></div>');              
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);                                        
                        loading.hide();
                        $("#addform").trigger('reset');                    
                        $("#AddAmbienteModal").modal('hide');
    
                        //adiciona a linha na tabela html                      
                            
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="ambiente'+response.ambiente.id+'">\
                                    <th scope="row">'+response.ambiente.nome_ambiente+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.ambiente.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomeambiente="'+response.ambiente.nome_ambiente+'" class="edit_ambiente fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.ambiente.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomeambiente="'+response.ambiente.nome_ambiente+'" class="delete_ambiente_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';
                        if(!$("#nadaencontrado").html==""){
                            $("#nadaencontrado").remove();
                        }
                        tupla = linha0+linha1;                             
                        $("#novo").replaceWith(tupla);                                                     
                        
                    }
                    
                }
            });
    
        }); //Fim da adição de registro
    ///tooltip
    $(function(){             
        $(".AddAmbienteModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_ambiente_btn").tooltip();
        $(".edit_ambiente").tooltip();    
    });
    ///fim tooltip

    
    }); ///Fim do escopo do script
    
    </script>
@stop