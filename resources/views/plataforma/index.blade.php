@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--AddPlataformaModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddPlataformaModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Plataforma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" class="nome_plataforma form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" data-color="{{$color}}" class="btn btn-default" data-dismiss="modal" >Fechar</button>
                    <button type="button" data-color="{{$color}}" class="btn btn-{{$color}} add_plataforma"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!--fim AddPlataformaModal-->

<!--EditPlataformaModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditPlataformaModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Plataforma</h5>
                <button type="button" class="close" data-dismiss="modal" arial-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_plataforma_id">
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" id="edit_nome_plataforma" class="nome_plataforma form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" data-color="{{$color}}" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" data-color="{{$color}}" class="btn btn-{{$color}} update_plataforma"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!--fim EditPlataformaModal-->

<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container-fluid py-5">
    <div id="success_message"></div>
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenteradmin.plataforma.plataforma.index',['color'=>$color])}}"  class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisanome" class="form-control rounded float-left" placeholder="Nome da plataforma" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER"><i class="fas fa-search"></i></button>
                            <button type="button" class="AddPlataformaModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </form>                
            </section>
            <table class="table table-hover">
            <thead class="bg-{{$color}}" style="color: white">
                    <tr>
                        <th scope="col">PLATAFORMAS</th>                     
                        <th scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_plataforma">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($plataformas as $plataforma)
                    <tr id="plataforma{{$plataforma->id}}">
                        <th scope="row">{{$plataforma->nome_plataforma}}</th>                        
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$plataforma->id}}" data-admin="{{auth()->user()->admin}}" data-nomeplataforma="{{$plataforma->nome_plataforma}}" class="edit_plataforma fas fa-edit" style="background: transparent; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>
                                <button type="button" data-id="{{$plataforma->id}}" data-admin="{{auth()->user()->admin}}" data-nomeplataforma="{{$plataforma->nome_plataforma}}" class="delete_plataforma_btn fas fa-trash" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
                  {{$plataformas->links()}}                       
    </div>
</div>
@else 
<i class="fas fa-lock"></i><b class="title"> USUÁRIO INATIVO OU NÃO LIBERADO! CONTACTE O ADMINISTRADOR.</b>
@endif
@endauth
<!--fim index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')
<script type="text/javascript">

    $(document).ready(function(){
        //inicio delete plataforma
        $(document).on('click','.delete_plataforma_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var link = "{{asset('storage')}}";
            var id = $(this).data("id");
            var admin = $(this).data("admin");            
            var nomeplataforma = ($(this).data("nomeplataforma")).trim();
            if(admin=true){
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomeplataforma,
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
                    url:'/datacenteradmin/plataforma/delete-plataforma/'+id,
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
                            $("#plataforma"+id).remove();         
                            $("#success_message").replaceWith('<div id="success_message"></div>');
                            $("#success_message").addClass('alert alert-success');
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
                title:nomeplataforma,
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
        });//fim delete plataforma
    
        //inicio exibição edit plataforma
        $("#EditPlataformaModal").on('shown.bs.modal',function(){
            $("#edit_nome_plataforma").focus();
        });
    
        $(document).on('click','.edit_plataforma',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");
            var nome = $(this).data("nomeplataforma");
            if(admin=true){
            $("#editform").trigger('reset');
            $("#EditPlataformaModal").modal('show');
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>'); 
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'GET',
                    dataType:'json',
                    url: '/datacenteradmin/plataforma/edit-plataforma/'+id,
                    success:function(response){
                        if(response.status==200){
                            var vnomeplataforma = (response.plataforma.nome_plataforma).trim();
                            $(".nome_plataforma").val(vnomeplataforma);
                            $("#edit_plataforma_id").val(response.plataforma.id);
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
                text: "Você não pode alterar este registro. Procure um administrador de INFRA !",
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
    
        });//fim exibição do edit plataforma
    
        //inicio da atualização da plataforma
    
        $(document).on('click','.update_plataforma',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            var loading = $("#imgedit");
                loading.show();
    
            var id = $("#edit_plataforma_id").val();
    
            var data = {
                'nome_plataforma' : ($("#edit_nome_plataforma").val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }    
                $.ajax({
                    type:'POST',
                    data: data,
                    dataType:'json',
                    url:'/datacenteradmin/plataforma/update-plataforma/'+id,
                    success:function(response){
                        if(response.status==400){
                            //erros
                            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>'); 
                            $("#updateform_errList").addClass('alert alert-danger');
                            $.each(response.errors,function(key,err_values){
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
                            $("#EditPlataformaModal").modal('hide');
    
                              
                            var linha = '<tr id="plataforma'+response.plataforma.id+'">\
                                    <th scope="row">'+response.plataforma.nome_plataforma+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.plataforma.id+'" data-admin="'+response.user.admin+'" data-nomeplataforma="'+response.plataforma.nome_plataforma+'" class="edit_plataforma fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.plataforma.id+'" data-admin="'+response.user.admin+'" data-nomeplataforma="'+response.plataforma.nome_plataforma+'" class="delete_plataforma_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';    
                            $("#plataforma"+id).replaceWith(linha); 
    
                        }
                    }
                });
    
        });//fim da atualização da plataforma
    
    //exibe form de adição de registro
    $("#AddPlataformaModal").on('shown.bs.modal',function(){
            $(".nome_plataforma").focus();
        });
    
    $(document).on('click','.AddPlataformaModal_btn',function(e){                  
            e.preventDefault();     
            
            var link = "{{asset('storage')}}";            
            
            $("#addform").trigger('reset');
            $("#AddPlataformaModal").modal('show');   
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');          
    
        });
    
    //fim exibe form de adição de registro
    
    
        //início da adição de plataforma
    
        $(document).on('click','.add_plataforma',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $("#imgadd");
                loading.show();
            var data = {
                'nome_plataforma' : ($(".nome_plataforma").val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }        
        
                $.ajax({
                    type:'POST',
                    url:'/datacenteradmin/plataforma/adiciona-plataforma',
                    data: data,
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
                            $("#AddPlataformaModal").modal('hide');
    
                            //adiciona a linha na tabela html                            
                                             
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="plataforma'+response.plataforma.id+'">\
                                    <th scope="row">'+response.plataforma.nome_plataforma+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.plataforma.id+'" data-admin="'+response.user.admin+'" data-nomeplataforma="'+response.plataforma.nome_plataforma+'" class="edit_plataforma fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.plataforma.id+'" data-admin="'+response.user.admin+'" data-nomeplataforma="'+response.plataforma.nome_plataforma+'" class="delete_plataforma_btn fas fa-trash" style="background:transparent;border:none"></button>\
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
    
        });//fim da adição de plataforma
    ///tooltip
    $(function(){             
        $(".AddPlataformaModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_plataforma_btn").tooltip();
        $(".edit_plataforma").tooltip();    
    });
    ///fim tooltip
    
    
    }); //fim do escopo geral
    
    </script>
@stop

