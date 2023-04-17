@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--AddSetorModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddSetorModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Setor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Sigla</label>
                        <input type="text" class="sigla form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" class="nome form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" >Fechar</button>
                    <button type="button" class="btn btn-primary add_setor"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
                </div>
            </div>
        </div>

    </div>

</div>
<!--Fim AddSetorModal-->

<!--EditSetorModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSetorModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Setor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_setor_id">
                    <div class="form-group mb-3">
                        <label for="">Sigla</label>
                        <input type="text" id="edit_sigla" class="sigla form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" id="edit_nome" class="nome form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary update_setor"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!--Fim EditSetorModal-->

<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container-fluid py-5">
    <div id="success_message"></div>
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('admin.setor.index')}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do setor" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                                <i class="fas fa-search"></i>
                            </button>                                                                                                             
                            <button type="button" class="AddSetorModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro"><i class="fas fa-plus"></i></button>
                        </div>                        
                    </div>                    
                </form>                                
            </section>
            <table class="table table-hover">
                <thead class="sidebar-dark-primary" style="color: white">
                    <tr>
                        <th>SIGLA</th>                       
                        <th>NOME</th>                       
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_setor">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($setores as $setor)
                    <tr id="setor{{$setor->idsetor}}">
                        <th scope="row">{{$setor->sigla}}</th>                       
                        <td>{{$setor->nome}}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$setor->idsetor}}" data-admin="{{auth()->user()->admin}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-sigla="{{$setor->sigla}}" class="edit_setor fas fa-edit" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>
                                <button type="button" data-id="{{$setor->idsetor}}" data-admin="{{auth()->user()->admin}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-sigla="{{$setor->sigla}}" class="delete_setor_btn fas fa-trash" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="nadaencontrado">
                        <td colspan="4">Nada encontrado!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex hover justify-content-center">
                {{$setores->links()}}
    </div>
</div>
@else 
<i class="fas fa-lock"></i><b class="title"> USUÁRIO INATIVO OU NÃO LIBERADO! CONTACTE O ADMINISTRADOR.</b>
@endif
@endauth
<!--Fim index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')
<script type="text/javascript">
    //inicio do escopo geral
    $(document).ready(function(){
        //inicio delete
        $(document).on('click','.delete_setor_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");
            var setoradmin = $(this).data("setoradmin");
            var id = $(this).data("id");
            var sigla = ($(this).data("sigla")).trim();
            if(admin){
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:sigla,
                text: "Deseja excluir?",
                imageUrl: link+'./logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){        
                $.ajax({
                    url:'delete-setor/'+id,
                    type:'POST',
                    dataType:'json',
                    data:{
                        'id':id,
                        '_method':'DELETE',
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){
                            //remove a linha correspondente da tabela html
                            $("#setor"+id).remove();      
                            $("#success_message").replaceWith('<div id="success_message"></div>');
                            $("#success_message").addClass('alert alert-success');
                            $("#success_message").text(response.message);         
                        }else{                          
                            $("#success_message").replaceWith('<div id="success_message"></div>');  
                            $("#success_message").addClass('alert alert-danger');
                            $("#success_message").text(response.message);  
                        }
                    } 
                });
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
                title:sigla,
                text: "Você não pode excluir este registro. Procure um administrador!",
                imageUrl: link+'./logoprodap.jpg',
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
        
        });//fim delete
    
        //início exibição edit
        $("#EditSetorModal").on('shown.bs.modal',function(){
            $(".sigla").focus();
        });
    
        $(document).on('click','.edit_setor',function(e){
            e.preventDefault();            
            var id = $(this).data("id");
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");
            var setoradmin = $(this).data("setoradmin");
            var sigla = $(this).data("sigla");
            if(admin){
            $("#editform").trigger('reset');
            $("#EditSetorModal").modal('show');
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>'); 
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'GET',
                    dataType:'json',
                    url:'edit-setor/'+id,
                    success:function(response){
                        if(response.status==200){  
                            var vsigla = (response.setor.sigla).trim();
                            var vnome = (response.setor.nome).trim();
                            $(".sigla").val(vsigla);
                            $(".nome").val(vnome);
                            $("#edit_setor_id").val(response.setor.idsetor);
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
                title:sigla,
                text: "Você não pode alterar este registro. Procure um administrador!",
                imageUrl: link+'./logoprodap.jpg',
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
        });//fim exibição edit
    
        //inicio da atualização
        $(document).on('click','.update_setor',function(e){
            var loading = $("#imgedit");
                loading.show();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $("#edit_setor_id").val();
            var data = {
                'sigla' : ($("#edit_sigla").val()).trim(),
                'nome' : ($("#edit_nome").val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }            
                $.ajax({
                    type:'POST',
                    data:data,
                    dataType:'json',
                    url:'update-setor/'+id,
                    success:function(response){
                        if(response.status==400){
                            //erros
                            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                            $("#updateform_errList").addClass('alert alert-danger');
                            $.each(reponse.errors,function(key,err_values){
                                $("#updateform_errList").append('<li>'+err_values+'</li>');
                            });
                            loading.hide();
                        }else if(response.status==404){
                            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');    
                            $("#success_message").replaceWith('<div id="success_message"></div>');                        
                            $("#success_message").addClass('alert alert-warning');
                            $("#success_message").text(response.message);
                            loading.hide();
                        }else{
                            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                            $("#success_message").replaceWith('<div id="success_message"></div>');
                            $("#success_message").addClass('alert alert-success');
                            $("#success_message").text(response.message);
                            loading.hide();
    
                            $("#editform").trigger('reset');
                            $("#EditSetorModal").modal('hide');    
                          
    
                            var linha = '<tr id="setor'+response.setor.idsetor+'">\
                                    <th scope="row">'+response.setor.sigla+'</th>\
                                    <td>'+response.setor.nome+'</td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.setor.idsetor+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-sigla="'+response.setor.sigla+'" class="edit_setor fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.setor.idsetor+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-sigla="'+response.setor.sigla+'" class="delete_setor_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';    
                            $("#setor"+id).replaceWith(linha); 
    
    
                        }
                    }
                });
    
    
        });//fim da atualização do projeto
    
    //exibe form de adição de registro
    $("#AddSetorModal").on('shown.bs.modal',function(){
            $(".sigla").focus();
        });
    
    $(document).on('click','.AddSetorModal_btn',function(e){                  
            e.preventDefault();       
            
            $("#addform").trigger('reset');
            $("#AddSetorModal").modal('show');               
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>'); 
    
        });
    
    //fim exibe form de adição de registro
    
    
        //inicio da adição de projeto
        $(document).on('click','.add_setor',function(e){
            e.preventDefault();
            var loading = $("#imgadd");
                loading.show();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var data = {
                'sigla' : ($(".sigla").val()).trim(),
                'nome' : ($(".nome").val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }    
                $.ajax({
                    type:'POST',
                    url:'adiciona-setor',
                    data:data,
                    dataType:'json',
                    success:function(response){
                        if(response.status==400){
                            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
                            $("#saveform_errList").addClass('alert alert-danger');
                            $.each(response.errors,function(key,err_values){
                                $("#saveform_errList").append('<li>'+err_values+'</li>');
                            });
                            loading.hide();
                        }else{
                            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
                            $("#success_message").replaceWith('<div id="success_message"></div>');
                            $("#success_message").addClass('alert alert-success');
                            $("#success_message").text(response.message);
                            loading.hide();
    
                            $("#addform").trigger('reset');
                            $("#AddSetorModal").modal('hide');
    
                        //adiciona a linha na tabela html                       
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>'; 
                            linha1 = '<tr id="setor'+response.setor.idsetor+'">\
                                    <th scope="row">'+response.setor.sigla+'</th>\
                                    <td>'+response.setor.nome+'</td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.setor.idsetor+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-sigla="'+response.setor.sigla+'" class="edit_setor fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.setor.idsetor+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-sigla="'+response.setor.sigla+'" class="delete_setor_btn fas fa-trash" style="background:transparent;border:none"></button>\
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
        });//fim da adição de registro
    
    ///tooltip
    $(function(){             
        $(".AddSetorModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_setor_btn").tooltip();
        $(".edit_setor").tooltip();    
    });
    ///fim tooltip
    
    });//fim do escopo geral
    
    </script>
@stop

