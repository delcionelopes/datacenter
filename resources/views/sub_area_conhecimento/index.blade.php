@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--AddSub_Area_Conhecimento-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddSub_Area_Conhecimento" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
            <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Sub-Área de Conhecimento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
            </button>
            </div>
        <div class="modal-body form-horizontal">
            <form id="addform" name="addform" class="form-horizontal" role="form">
                <ul id="saveform_errList"></ul>
                <div class="form-group mb-3">
                    <label for="">Descrição</label>
                    <input type="text" class="descricao form-control">
                </div>    
                <div class="form-group mb-3">
                    <label for="">Área de Conhecimento</label>
                    <select class="custom-select" id="area_id" name="area_id">
                            @foreach($areas_conhecimento as $area)
                            <option value="{{$area->id}}">{{$area->descricao}}</option>
                            @endforeach                        
                    </select>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_sub_area_conhecimento"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
        </div>
    </div>
</div>
<!--fim AddSub_Area_Conhecimento-->

<!--EditSub_Area_Conhecimento-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSub_Area_Conhecimento" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Sub-Áreas de Conhecimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_sub_area_conhecimento_id">
                    <div class="form-group mb-3">
                        <label for="">Descrição</label>
                        <input type="text" id="edit_descricao" class="descricao form-control">
                    </div>    
                    <div class="form-group mb-3">
                        <label for="">Conhecimento</label>                        
                        <select class="custom-select" id="area_id" name="area_id">
                            @foreach($areas_conhecimento as $area)                                      
                            <option value="{{$area->id}}">{{$area->descricao}}</option>                                                        
                            @endforeach
                        </select>                                                                                             
                    </div>                 
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary update_sub_area_conhecimento"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--fim EditSub_Area_Conhecimento-->

<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container-fluid py-5">
    <div id="success_message"></div>
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenteradmin.subareaconhecimento.subareaconhecimento.index')}}" class="form-search" method="GET">                    
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="nomepesquisa" class="form-control rounded float-left" placeholder="Descrição da sub-área" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                            <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="Add_Sub_Area_Conhecimento_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                            <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-hover">
                <thead class="sidebar-dark-primary" style="color: white">
                    <tr>
                        <th scope="col">SUB-AREAS DE CONHECIMENTO</th>
                        <th scope="col">AREAS REF</th>                   
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_sub_area_conhecimento">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($sub_areas_conhecimento as $sub)
                    <tr id="sub{{$sub->id}}">
                        <th scope="row">{{$sub->descricao}}</th>
                        <td>{{$sub->area_conhecimento->descricao}}</td>                       
                        <td>
                            <div class="btn-group">
                                <button data-id="{{$sub->id}}" data-admin="{{auth()->user()->admin}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-descricao="{{$sub->descricao}}" class="edit_sub_area_conhecimento fas fa-edit" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>
                                <button data-id="{{$sub->id}}" data-admin="{{auth()->user()->admin}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-descricao="{{$sub->descricao}}" class="delete_area_conhecimento_btn fas fa-trash" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
            {{$sub_areas_conhecimento->links()}}
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

    //inicio do escopo geral
    $(document).ready(function(){      
    
        //inicio delete registro
        $(document).on('click','.delete_area_conhecimento_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var link = "{{asset('storage')}}";
            var id = $(this).data("id");
            var admin = $(this).data("admin");
            var setoradmin = $(this).data("setoradmin");
            var descricao = ($(this).data("descricao")).trim();
            if(admin){
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:descricao,
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
                        url:'/datacenteradmin/subareaconhecimento/delete-subareaconhecimento/'+id,
                        type:'POST',
                        dataType:'json',
                        data:{
                            'id':id,
                            '_method':'DELETE',
                            '_token':CSRF_TOKEN,
                        },
                        success:function(response){
                            if(response.status==200){
                            //remove a tr correspondente da tabela html
                            $("#sub"+id).remove();          
                            $("#Success_message").replaceWith('<div id="success_message"></div>');
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
                title:descricao,
                text: "Você não pode excluir este registro. Procure um administrador!",
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
        
        });
        //fim delete registro
    
        //início Exibe EditSub_Area_Conhecimento
        $("#EditSub_area_Conhecimento").on('shown.bs.modal',function(){
            $("#edit_descricao").focus();
        });
    
        $(document).on('click','.edit_sub_area_conhecimento',function(e){
            e.preventDefault();        
            
            var id = $(this).data("id");        
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");
            var setoradmin = $(this).data("setoradmin");
            var descricao = $(this).data("descricao");
            if(admin){
            $("#editform").trigger('reset');
            $("#EditSub_Area_Conhecimento").modal('show');     
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');                   
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'GET',
                    dataType:'json',
                    url:'/datacenteradmin/subareaconhecimento/edit-subareaconhecimento/'+id,                                
                    success:function(response){
                        if(response.status==200){
                            var vdescricao = (response.sub_area_conhecimento.descricao).trim();
                            $(".descricao").val(vdescricao);
                            //seta a opção certa no select html
                            var opcao = response.area_conhecimento.id;                        
                            $("#area_id option")
                            .removeAttr('selected')
                            .filter('[value='+opcao+']')
                            .attr('selected', true);
                            //fim seta area_conhecimento
                            $("#edit_sub_area_conhecimento_id").val(response.sub_area_conhecimento.id);                        
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
                title:descricao,
                text: "Você não pode alterar este registro. Procure um administrador!",
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
    
        });
        //fim Exibe EditSub_Area_Conhecimento    
        
        //inicio Reconfigura o option selected do select html
        $('select[name="area_id"]').on('change', function() {
               var opt = this.value; 
                            $("#area_id option")
                            .removeAttr('selected')
                            .filter('[value='+opt+']')
                            .attr('selected', true);        
    
        });
        //fim Reconfigura o option selected do select html
       
        //inicio da atualização do registro
        $(document).on('click','.update_sub_area_conhecimento',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $("#imgedit");
                loading.show();
            
            var opt = $("#area_id").val(); 
            var id = $("#edit_sub_area_conhecimento_id").val();
            var data = {
                'area_conhecimento_id' : opt,
                'descricao' : ($("#edit_descricao").val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }           
                $.ajax({
                    type:'POST',
                    data:data,
                    dataType:'json',
                    url:'/datacenteradmin/subareaconhecimento/update-subareaconhecimento/'+id,
                    success:function(response){
                        if(response.status==400){
                            //erros
                            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                            $("#updateform_errList").addClass('alert alert-danger');
                            $.each(response.errors,function(key,err_values){
                                $("#updateform_errList").append('<li>'+err_values+'</li');
                            });          
                            loading.hide();
                        }else if(response.status==404){
                            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                            $("#Success_message").replaceWith('<div id="success_message"></div>');
                            $("#success_message").addClass('alert alert-warning');
                            $("#success_message").text(response.message);
                            loading.hide();
                        }else{
                            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                            $("#Success_message").replaceWith('<div id="success_message"></div>');
                            $("#success_message").addClass('alert alert-success');
                            $("#success_message").text(response.message);
                            loading.hide();
    
                            $("#editform").trigger('reset');
                            $("#EditSub_Area_Conhecimento").modal('hide');
    
                            //atualizando a tr da tabela html
                           
                            var linha = '<tr id="sub'+response.sub_area_conhecimento.id+'">\
                                    <th scope="row">'+response.sub_area_conhecimento.descricao+'</th>\
                                    <td>'+response.area_conhecimento.descricao+'</td>\
                                    <td>\
                                    <div class="btn-group">\
                                    <button type="button" data-id="'+response.sub_area_conhecimento.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-descricao="'+response.sub_area_conhecimento.descricao+'" class="edit_sub_area_conhecimento fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.sub_area_conhecimento.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-descricao="'+response.sub_area_conhecimento.descricao+'" class="delete_area_conhecimento_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div>\
                                    </td>\
                                    </tr>';                             
                             $("#sub"+id).replaceWith(linha);         
    
                        }
                    }
                });
    
        });
        //fim da atualização do registro
    
        //início exibição da adição do novo registro
        $("#AddSub_Area_Conhecimento").on('shown.bs.modal',function(){
            $(".descricao").focus();
        });
    
        $(document).on('click','.Add_Sub_Area_Conhecimento_btn',function(e){
            e.preventDefault();
    
            $("#addform").trigger('reset');
            $("#AddSub_Area_Conhecimento").modal('show');
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
    
        });
        //fim exibição da adição do novo registro
    
        //início do envio do novo registro para o Sub_Area_ConhecimentoController
        $(document).on('click','.add_sub_area_conhecimento',function(e){
            e.preventDefault();               
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $("#imgadd");
                loading.show();
            var data = {
                'area_conhecimento_id' : $("#area_id").val(),
                'descricao' : ($(".descricao").val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }
                $.ajax({
                    type:'POST',
                    url:'/datacenteradmin/subareaconhecimento/adiciona-subareaconhecimento',
                    data:data,
                    dataType:'json',
                    success:function(response){
                        if(response.status==400){
                            //erros
                            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
                            $("#saveform_errList").addClass('alert alert-danger');
                            $.each(response.errors,function(key,err_values){
                                $("#saveform_errList").append('<li>'+err_values+'</li>');
                            });
                            loading.hide();
                        }else{
                            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
                            $("#Success_message").replaceWith('<div id="success_message"></div>');                          
                            $("#success_message").addClass('alert alert-success');
                            $("#success_message").text(response.message);
                            loading.hide();
    
                            $("#addform").trigger('reset');
                            $("#AddSub_Area_Conhecimento").modal('hide');
    
                            //inserindo a nova tr no corpo da table html                       
                            
                            var tupla = "";
                            var linha0 = "";
                            var linha1 = "";
                                linha0 = '<tr id="novo" style="display:none;"></tr>';
                                linha1 = '<tr id="sub'+response.sub_area_conhecimento.id+'">\
                                    <th scope="row">'+response.sub_area_conhecimento.descricao+'</th>\
                                    <td>'+response.area_conhecimento.descricao+'</td>\
                                    <td>\
                                    <div class="btn-group">\
                                    <button type="button" data-id="'+response.sub_area_conhecimento.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-descricao="'+response.sub_area_conhecimento.descricao+'" class="edit_sub_area_conhecimento fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.sub_area_conhecimento.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-descricao="'+response.sub_area_conhecimento.descricao+'" class="delete_area_conhecimento_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div>\
                                    </td>\
                                    </tr>';
                        if(!$("#nadaencontrado").html==""){
                            $("#nadaencontrado").remove();
                        }
                                tupla = linha0+linha1;
                                $("#novo").replaceWith(tupla); 
    
                        }
                    }
                });
        });
        //fim do envio do novo registro para o Sub_Area_ConhecimentoController    
    
    ///tooltip
    $(function(){             
        $(".Add_Sub_Area_Conhecimento_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_area_conhecimento_btn").tooltip();
        $(".edit_sub_area_conhecimento").tooltip();    
    });
    ///fim tooltip
      
    });
    //fim do escopo geral
    
    </script>
@stop
