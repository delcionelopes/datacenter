@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--AddProjetoModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddProjetoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Projeto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" class="nome_projeto form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" >Fechar</button>
                    <button type="button" class="btn btn-{{$color}} add_projeto"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
                </div>
            </div>
        </div>

    </div>

</div>
<!--Fim AddProjetoModal-->

<!--EditProjetoModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditProjetoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Projeto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_projeto_id">
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" id="edit_nome_projeto" class="nome_projeto form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-{{$color}} update_projeto"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!--Fim EditProjetoModal-->

<!--index-->
<div class="container-fluid py-5">
    <div id="success_message"></div>
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenteradmin.projeto.projeto.index',['color'=>$color])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                        <nav class="navbar navbar-expand-md navbar-light bg-light">
                            <input type="text" name="pesquisanome" class="form-control rounded float-left" placeholder="Nome do projeto" aria-label="Search" aria-describedby="search-addon">                            
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                                <i class="fas fa-search"></i>
                            </button>                                                                                                             
                            <button type="button" class="AddProjetoModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro"><i class="fas fa-plus"></i></button>
                            <button data-color="{{$color}}" type="button" class="voltarmenu_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-door-open"></i></button>
                        </nav>
                        </div>                        
                    </div>                    
                </form>                                
            </section>
            <table class="table table-hover">
            <thead class="bg-{{$color}}" style="color: white">
                    <tr>
                        <th>PROJETOS</th>                       
                        <TH>AÇÕES</TH>
                    </tr>
                </thead>
                <tbody id="lista_projeto">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($projetos as $projeto)
                    <tr id="projeto{{$projeto->id}}">
                        <th scope="row">{{$projeto->nome_projeto}}</th>                       
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$projeto->id}}" data-admin="{{auth()->user()->admin}}" data-nomeprojeto="{{$projeto->nome_projeto}}" class="edit_projeto fas fa-edit" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>
                                <button type="button" data-id="{{$projeto->id}}" data-admin="{{auth()->user()->admin}}" data-nomeprojeto="{{$projeto->nome_projeto}}" class="delete_projeto_btn fas fa-trash" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
            <div class="d-flex hover justify-content-center bg-{{$color}}">
                {{$projetos->links()}}
    </div>
</div>
<!--Fim index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')
<script type="text/javascript">
    //inicio do escopo geral
    $(document).ready(function(){
        //inicio delete projeto
        $(document).on('click','.delete_projeto_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var link = "{{asset('storage')}}";
            var id = $(this).data("id");
            var admin = $(this).data("admin");
            var nomeprojeto = $(this).data("nomeprojeto");
            if(admin){
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomeprojeto,
                text: "Deseja excluir?",
                imageUrl: link+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){        
                $.ajax({
                    url:'/datacenteradmin/projeto/delete-projeto/'+id,
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
                            $("#projeto"+id).remove();      
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
                title:nomeprojeto,
                text: "Você não pode excluir este registro. Procure um administrador do setor INFRA !",
                imageUrl: link+'/logoprodap.jpg',
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
        
        });//fim delete projeto
    
        //início exibição edit projeto
        $("#EditProjetoModal").on('shown.bs.modal',function(){
            $("#edit_nome_projeto").focus();
        });
    
        $(document).on('click','.edit_projeto',function(e){
            e.preventDefault();            
            var id = $(this).data("id");             
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");
            var nome = $(this).data("nomeprojeto");
            if(admin){
            $("#editform").trigger('reset');
            $("#EditProjetoModal").modal('show');
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>'); 
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'GET',
                    dataType:'json',
                    url:'/datacenteradmin/projeto/edit-projeto/'+id,
                    success:function(response){
                        if(response.status==200){  
                            var vnomeprojeto = response.projeto.nome_projeto;
                            $(".nome_projeto").val(vnomeprojeto);
                            $("#edit_projeto_id").val(response.projeto.id);
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
                imageUrl: link+'/logoprodap.jpg',
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
        });//fim exibição edit projeto
    
        //inicio da atualização do projeto
        $(document).on('click','.update_projeto',function(e){            
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $("#imgedit");
                loading.show();
            var id = $("#edit_projeto_id").val();
            var data = {
                'nome_projeto' : $("#edit_nome_projeto").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }            
                $.ajax({
                    type:'POST',
                    data:data,
                    dataType:'json',
                    url:'/datacenteradmin/projeto/update-projeto/'+id,
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
                            $("#EditProjetoModal").modal('hide');    
                          
    
                            var linha = '<tr id="projeto'+response.projeto.id+'">\
                                    <th scope="row">'+response.projeto.nome_projeto+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.projeto.id+'" data-admin="'+response.user.admin+'" data-nomeprojeto="'+response.projeto.nome_projeto+'" class="edit_projeto fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.projeto.id+'" data-admin="'+response.user.admin+'" data-nomeprojeto="'+response.projeto.nome_projeto+'" class="delete_projeto_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';    
                            $("#projeto"+id).replaceWith(linha); 
    
    
                        }
                    }
                });
    
    
        });//fim da atualização do projeto
    
    //exibe form de adição de registro
    $("#AddProjetoModal").on('shown.bs.modal',function(){
            $(".nome_projeto").focus();
        });
    
    $(document).on('click','.AddProjetoModal_btn',function(e){                  
            e.preventDefault();       
            var link = "{{asset('storage')}}";
            
            $("#addform").trigger('reset');
            $("#AddProjetoModal").modal('show');               
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>'); 
    
        });
    
    //fim exibe form de adição de registro
    
    
        //inicio da adição de projeto
        $(document).on('click','.add_projeto',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $("#imgadd");
                loading.show();
            var data = {
                'nome_projeto' : $(".nome_projeto").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }    
                $.ajax({
                    type:'POST',
                    url:'/datacenteradmin/projeto/adiciona-projeto',
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
                            $("#AddProjetoModal").modal('hide');
    
                        //adiciona a linha na tabela html                       
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>'; 
                            linha1 = '<tr id="projeto'+response.projeto.id+'">\
                                    <th scope="row">'+response.projeto.nome_projeto+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.projeto.id+'" data-admin="'+response.user.admin+'" data-nomeprojeto="'+response.projeto.nome_projeto+'" class="edit_projeto fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.projeto.id+'" data-admin="'+response.user.admin+'" data-nomeprojeto="'+response.projeto.nome_projeto+'" class="delete_projeto_btn fas fa-trash" style="background:transparent;border:none"></button>\
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
        });//fim da adição de projeto
    
    ///tooltip
    $(function(){             
        $(".AddProjetoModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_projeto_btn").tooltip();
        $(".edit_projeto").tooltip();    
    });
    ///fim tooltip

    $(document).on('click','.voltarmenu_btn',function(e){
        e.preventDefault();  
        var color = $(this).data("color");
        location.replace('/datacenteradmin/principal/operacoes/1/'+color);
    });
    
    });//fim do escopo geral
    
    </script>
@stop

