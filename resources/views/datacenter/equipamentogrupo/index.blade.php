@extends('adminlte::page')

@section('title', 'Datacenter - Grupos')

@section('content')

<style>  

  .card {
    transition: transform 0.2s ease;
    box-shadow: 0 4px 6px 0 rgba(22, 22, 26, 0.18);
    border-radius: 0;
    border: 0;
    margin-bottom: 1.5em;
  }
  .card:hover {
    transform: scale(1.1);
  }

    .tooltip-inner {
    text-align: left;
    }
    div.halfOpacity{
        opacity: 0.6 !important;
    }

    .tooltip-inner {
    text-align: left;
    }
    
</style>

<!--inicio AddGrupoModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddGrupoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar GRUPO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <ul id="saveform_errList"></ul>
                    <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="addsigla">Sigla do GRUPO</label>
                        <input type="text" id="addsigla" class="form-control">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="adddescricao">Descrição</label>
                        <input type="text" id="adddescricao" class="form-control">
                    </div>
                    </div>                    
                    </div>         
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="{{$color}}" class="btn btn-{{$color}} add_grupo"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim AddGrupoModal -->

<!--Inicio EditGrupoModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditGrupoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar GRUPO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_grupo_id">                    
                    <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Sigla do GRUPO</label>
                        <input type="text" id="editsigla" class="sigla form-control">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="editdescricao">Descrição</label>
                        <input type="text" id="editdescricao" class="descricao form-control">
                    </div>
                    </div>                    
                    </div>         
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="{{$color}}" class="btn btn-{{$color}} update_grupo"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim EditGrupoModal -->

<div class="container-fluid py-5"> 

    <div id="success_message"></div>        
            <section class="border p-4 mb-4 d-flex align-items-left">
            <form action="{{route('datacenteradmin.grupo.index',['color'=>$color])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                        <nav class="navbar navbar-expand-md navbar-light bg-light">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do grupo" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background:transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                               <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="AddGrupo_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo GRUPO">
                               <i class="fas fa-plus"></i>
                            </button>
                            <button data-color="{{$color}}" type="button" class="voltarmenu_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-door-open"></i></button>
                        </nav>
                        </div>
                    </div>
            </form>    
            </section>      

<section class="border p-4 mb-4 d-flex align-items-left">  
<div class="row">
@if($grupos->count())
  @foreach($grupos as $grupo)  
  <div class="p-2 mt-2" id="grupo{{$grupo->id}}">   
  <div class="card card-hover mb-3">
  <div class="row no-gutters">
    <div class="col-md-4">
      <a href="{{route('datacenteradmin.equipamento.equipamento.index',['id' => $grupo->id, 'color'=>$color])}}">
      <img src="{{asset('storage/'.$grupo->ico)}}" class="card-img">
      </a>
    </div>
    <div class="col-md-8">
      <div class="card-body text-right">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">{{$grupo->sigla}}</h5>
        <div class="dropleft">
        <button type="button" class="btn btn_primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
         <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li data-id="{{$grupo->id}}" class="edit_grupo_menu dropdown-item" data-color="{{$color}}" style="cursor: pointer;"><i class="fas fa-edit"></i> Editar</li>
            <li data-id="{{$grupo->id}}" data-sigla="{{$grupo->sigla}}" class="delete_grupo_menu dropdown-item" data-color="{{$color}}" style="cursor: pointer;"><i class="fas fa-trash"></i> Excluir</li>
        </ul>   
        </div>
        </div>
        <p class="card-text">{{$grupo->descricao}}</p>        
        <a href="{{route('datacenteradmin.equipamento.equipamento.index',['id' => $grupo->id, 'color'=>$color])}}" class="btn btn-{{$color}}">Executar</a>
      </div>
    </div>
  </div>
  </div>
  </div>  
@endforeach

@else
<div class="p-2 mt-2">
<div class="card" style="width: 18rem;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="{{asset('logoprodap.jpg')}}" class="card-img" alt="prodap">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title"><b>{{auth()->user()->name}}</b>,</h5>
        <p class="card-text">Não há grupos cadastrados!</p>
        <p class="card-text"><small class="text-muted">Crie grupos e cadastre equipamentos.</small></p>
      </div>
    </div>
  </div>
</div>
</div>
@endif
</div>
</section>
</div>



@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){

//inicio delete grupo
        $(document).on('click','.delete_grupo_menu',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var link = "{{asset('storage')}}";
            var id = $(this).data("id");
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
                        url: '/datacenteradmin/grupo/delete/'+id,
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            'id':id,
                            '_method':'DELETE',
                            '_token':CSRF_TOKEN,
                        },
                        success:function(response){
                            if(response.status==200){
                                //remove a linha da table html
                                $("#grupo"+id).remove();
                                $("#success_message").replaceWith('<div id="success_message"></div>');
                                $("#success_message").addClass('alert alert-success');
                                $("#success_message").text(response.message);
                            }else{      
                                $("#success_message").html('<div id="success_message"></div>');                          
                                $("#success_message").addClass('alert alert-danger');
                                $("#success_message").text(response.message);
                            }
                    } 
                });
            }                                       
        
        });                
        
        });
        //fim delete base

  //inicio exibição do form AddGrupoModal
        $('#AddGrupoModal').on('shown.bs.modal',function(){
            $("#addsigla").focus();
        });
        $(document).on('click','.AddGrupo_btn',function(e){
            e.preventDefault();            
            $("#addform").trigger('reset');
            $("#AddGrupoModal").modal('show');            
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>'); 
            
        });
        //fim exibição do form AddGrupoModal

         //inicio do envio do novo registro
        $(document).on('click','.add_grupo',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var loading = $("#imgadd");
                loading.show();            
            var strcolor = $(this).data("color");
            var data = new FormData();

            data.append('sigla',$('#addsigla').val());
            data.append('descricao',$('#adddescricao').val());
            data.append('ico','ico_modulo/icn-invisible-infrastructure-2.png');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');
             
            $.ajax({
                url: '/datacenteradmin/grupo/store',
                type: 'POST',
                dataType: 'json',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                async: true,
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
                        $("#success_message").replaceWith('<div id="success_message"></div>');                
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);
                        loading.hide();
    
                        $("#addform").trigger('reset');
                        $("#AddGrupoModal").modal('hide');
                        
                        location.replace('/datacenteradmin/grupo/index/'+strcolor);
                     
                    }
                }
            });        
        });
        //fim do envio do novo registro

        //início da exibição do form EditGrupoModal
        $('#EditGrupooModal').on('shown.bs.modal',function(){
            $('#editsigla').focus();
        });
        $(document).on('click','.edit_grupo_menu',function(e){  
            e.preventDefault();            
            var id = $(this).data('id');
                $('#edit_grupo_id').val(id);            
            
            $('#editform').trigger('reset');
            $('#EditGrupoModal').modal('show');          
            $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/datacenteradmin/grupo/edit/'+id,                                
                success: function(response){           
                    if(response.status==200){
                        $('.sigla').val(response.grupo.sigla);
                        $('.descricao').val(response.grupo.descricao);
                        $('#edit_grupo_id').val(response.grupo.id);
                    }      
                }
            });

        
    
        }); //fim da da exibição do form
    
        $(document).on('click','.update_grupo',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            var loading = $('#imgedit');
                loading.show();
    
            var id = $('#edit_grupo_id').val();
            var strcolor = $(this).data("color");        
    
            var data = new FormData();                
                data.append('sigla', $('#editsigla').val());
                data.append('descricao', $('#editdescricao').val());
                data.append('_method','PUT');
                data.append('_token',CSRF_TOKEN);
            
            
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: '/datacenteradmin/grupo/update/'+id,       
                cache: false,
                processData: false,
                contentType: false,      
                success: function(response){                                                    
                    if(response.status==400){
                        //erros
                        $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });    
                       loading.hide();
    
                    } else if(response.status==404){
                        $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');    
                        $('#success_message').replaceWith('<div id="success_message"></div>');             
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        loading.hide();
                    } else {
                        $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');      
                        $('#success_message').replaceWith('<div id="success_message"></div>');                 
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);                             
                        
                        loading.hide();
                        $('#editform').trigger('reset');
                        $('#EditGrupoModal').modal('hide');
                        location.replace('/datacenteradmin/grupo/index/'+strcolor);
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro do orgão 


        $(document).on('click','.voltarmenu_btn',function(e){
        e.preventDefault();  
        var color = $(this).data("color");
        location.replace('/datacenteradmin/principal/operacoes/3/'+color);
        });


    ///tooltip
    $(function(){             
        $(".AddGrupo_btn").tooltip();
        $(".pesquisa_btn").tooltip();
    });
    ///fim tooltip    




});

</script>

@stop

