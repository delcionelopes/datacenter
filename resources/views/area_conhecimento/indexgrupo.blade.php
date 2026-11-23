@extends('adminlte::page')

@section('title', 'Datacenter - Áreas por setor')

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

<!--Inicio OpenFileModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="OpenFileModal" tabindex="-1" role="dialog" aria-labelledby="titleFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleFileModalLabel" style="color: white;">Arquivos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="fileform" name="fileform" class="form-horizontal" role="form">
                    <ul id="fileform_errList"></ul>
                    <input type="hidden" id="edit_filegrupo_id">
                    <input type="hidden" id="edit_filesetor_id">
                    <table id="listadocs" class="table table-hover">
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <span class="btn btn-{{$color}} fileinput-button"><i class="fas fa-folder-open" style="color: orange"></i><input class="arquivo" type="file" name="arquivo[]" accept="application/pdf" multiple></span>
            </div>
        </div>
    </div>
</div>
<!--Fim OpenFileModal -->

<!--Inicio EditGrupoModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditGrupoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar PASTA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_grupo_id">
                    <input type="hidden" id="edit_setor_id">
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
            <form action="{{route('datacenter.sistemadearquivos.indexareasrelacionadas',['id' => $setor->idsetor,'color'=>$color])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                        <nav class="navbar navbar-expand-md navbar-light bg-light">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do grupo" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background:transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                               <i class="fas fa-search"></i>
                            </button>                            
                            <button data-color="{{$color}}" type="button" class="voltarmenu_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-door-open"></i></button>
                        </nav>
                        </div>
                    </div>
            </form>    
            </section>      

<section class="border p-4 mb-4 d-flex align-items-left">  
<div class="row">
@if($areas->count())
  @foreach($areas as $area)  
  <div class="p-2 mt-2" id="grupo{{$grupo->id}}">   
  <div class="card card-hover mb-3">
  <div class="row no-gutters">
    <div class="col-md-4">
      <a href="#" data-setorid="{{$setor->idsetor}}" data-grupoid="{{$area->id}}" data-grupo="{{$area->descricao}}" data-color="{{$color}}" class="mostrararquivos_btn">
      <img src="{{asset('storage/ico_operacao/icn-enterprise-storage.png')}}" class="card-img">
      </a>
    </div>
    <div class="col-md-8">
      <div class="card-body text-right">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">{{$setor->sigla}}</h5>
        <div class="dropleft">
        <button type="button" class="btn btn_primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
         <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li data-setorid="{{$setor->idsetor}}" data-id="{{$area->id}}" class="edit_grupo_menu dropdown-item" data-color="{{$color}}" style="cursor: pointer;"><i class="fas fa-edit"></i> Editar</li>
            <li data-id="{{$area->id}}" data-sigla="{{$area->descricao}}" class="delete_grupo_menu dropdown-item" data-color="{{$color}}" style="cursor: pointer;"><i class="fas fa-trash"></i> Excluir</li>
        </ul>   
        </div>
        </div>
        <p class="card-text">{{$area->descricao}}</p>        
        <a href="#" data-setorid="{{$setor->idsetor}}" data-grupoid="{{$area->id}}" data-grupo="{{$area->descricao}}" data-color="{{$color}}" class="btn btn-{{$color}} mostrararquivos_btn">Executar</a>
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
      <img src="{{asset('logo.ico')}}" class="card-img" alt="Sistema">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title"><b>{{auth()->user()->name}}</b>,</h5>
        <p class="card-text">Não há pastas para este setor!</p>
        <p class="card-text"><small class="text-muted">Crie pastas e adicione arquivos.</small></p>
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
                        url: '/datacenter/sistemadearquivos/deletearea/'+id,
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
        //fim delete grupo

        //início da exibição do form EditGrupoModal
        $('#EditGrupooModal').on('shown.bs.modal',function(){
            $('#editdescricao').focus();
        });
        $(document).on('click','.edit_grupo_menu',function(e){  
            e.preventDefault();            
            var id = $(this).data('id');
            var empresaid = $(this).data('empresaid');
                $('#edit_grupo_id').val(id);            
                $('#edit_setor_id').val(setorid);            
            
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
                url: '/datacenter/sistemadearquivos/editarea/'+id,                                
                success: function(response){           
                    if(response.status==200){                        
                        $('.descricao').val(response.grupo.descricao);
                    }      
                }
            });

        
    
        }); //fim da da exibição do form
    
        $(document).on('click','.update_grupo',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var setorid = $('#edit_setor_id').val();
            
            var loading = $('#imgedit');
                loading.show();
    
            var id = $('#edit_grupo_id').val();
            var strcolor = $(this).data("color");        
    
            var data = new FormData();
                data.append('descricao', $('#editdescricao').val());
                data.append('_method','PUT');
                data.append('_token',CSRF_TOKEN);
            
            
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: '/datacenter/sistemadearquivos/updatearea/'+id,       
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
                        location.replace('/datacenter/sistemadearquivos/indexareasrelacionadas/'+setorid+'/'+strcolor);
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro do grupo 

        ///mostrar arquivos
        $(document).on('click','.mostrararquivos_btn',function(e){
            e.preventDefault();
            var setorid = $(this).data("setorid");
            var grupoid = $(this).data("grupoid");
            var color = $(this).data("color");
            var grupo = $(this).data("grupo");

            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/datacenter/sistemadearquivos/mostraarquivos/'+setorid+'/'+grupoid,                                
                success: function(response){           
                    if(response.status==200){
                        if(response.arquivos.length>0){
                        $("#nadaencontrado").remove();
                        $(".linha").remove();                        
                        var strlimita1 = '';
                        var strlimita2 = '';
                        var strlimita3 = '';
                        var strlim3a = '';
                        var strlim3b = '';
                        var strlim3c = '';
                        var strlim3d = '';
                        var strlimita4 = '';
                        var strlim4a = '';
                        var strlim4b = '';
                        var strlim4c = '';
                        var strlim4d = '';
                        var strlimita5 = '';                        
                        $.each(response.arquivos,function(key,docs){
                        strlimita1 = '<tr id="doc'+docs.id+'" class="linha">\
                                                  <td class="abredoc" data-id="'+docs.id+'" style="cursor:pointer">'+docs.rotulo+'</td>\
                                                  <td>\
                                                  <div class="btn-group">';
                        strlimita2 = '<div class="btn-group">\
                                                        <button type="button" data-id="'+docs.id+'" data-descricao="'+docs.rotulo+'" class="excluirarquivo_btn fas fa-trash" style="background:transparent;border:none;"></button>\
                                                    </div>';
                        strlimita3 = '<div class="btn-group">\
                                                        <button type="button" data-id="'+docs.id+'" class="copiararquivo_btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="background:transparent;border:none;"><i class="fas fa-copy"></i><span class="caret"></span></button>';
                        strlim3a = '<ul class="dropdown-menu">';
                                  $.each(response.setorgrupos, function(key,grupoemp){                                    
                                    strlim3b = strlim3b+'<li data-id="'+docs.id+'" data-grupoid="'+grupoemp.area_conhecimento_id+'" class="copiararquivo_opt dropdown-item" style="cursor:pointer">'+grupoemp.areaconhecimento.descricao+'</li>';
                                  });
                        strlim3c = '</ul>';
                        strlim3d ='</div>';
                        strlimita4 = '<div class="btn-group">\
                                                        <button type="button" data-id="'+docs.id+'" class="moverarquivo_btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="background:transparent;border:none;"><i class="fas fa-cut"></i><span class="caret"></span></button>';                                                        
                        strlim4a = '<ul class="dropdown-menu">';
                                  $.each(response.setorgrupos, function(key,grupoemp){                                    
                                    strlim4b = strlim4b+'<li data-id="'+docs.id+'" data-grupoid="'+grupoemp.area_conhecimento_id+'" class="moverarquivo_opt dropdown-item" style="cursor:pointer">'+grupoemp.areaconhecimento.descricao+'</li>';
                                  });
                        strlim4c = '</ul>';
                        strlim4d ='</div>';
                        strlimita5 = '</div>\
                                      </td>\
                                      </tr>';                                        
                        
                        $('#listadocs').append(strlimita1+
                                               strlimita2+
                                               strlimita3+
                                               strlim3a+
                                               strlim3b+
                                               strlim3c+
                                               strlim3d+
                                               strlimita4+
                                               strlim4a+
                                               strlim4b+
                                               strlim4c+
                                               strlim4d+
                                               strlimita5);
                      });
                      }else{
                        $('.linha').remove();
                        $("#nadaencontrado").remove();
                        $('#listadocs').append('<tr id="nadaencontrado">\
                                <td colspan="4">Nada Encontrado!</td>\
                            </tr>');
                      }
                    }      
                }
            });

            $('#titleFileModalLabel').replaceWith('<h5 class="modal-title" id="titleFileModalLabel" style="color: white;">'+grupo+'</h5>');
            $('#edit_filegrupo_id').val(grupoid);            
            $('#edit_filesetor_id').val(setorid);            
            
            $('#fileform').trigger('reset');
            $('#OpenFileModal').modal('show');          
            $('#fileform_errList').replaceWith('<ul id="fileform_errList"></ul>');
        });

        //fim mostrar arquivos

        //inicio enviar docs
    $(document).on('change','.arquivo',function(){
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var formData = new FormData();
            let setorid = $("#edit_filesetor_id").val();
            let grupoid = $("#edit_filegrupo_id").val();
            let TotalFiles = $('.arquivo')[0].files.length;
            let files = $('.arquivo')[0];    

            for(let i=0; i < TotalFiles; i++){
                formData.append('arquivo'+i, files.files[i]);                            
            }

            formData.append('TotalFiles',TotalFiles);                    
            formData.append('_token',CSRF_TOKEN);
            formData.append('_enctype','multipart/form-data');
            formData.append('_method','PUT'); 
            
            $('.arquivo').val(""); ///limpa o input
                                
            $.ajax({                                             
                url: '/datacenter/sistemadearquivos/upload-docs/'+setorid+'/'+grupoid,
                type:'POST',
                dataType: 'json',        
                data:formData,
                cache:false,        
                contentType: false,        
                processData: false, 
                async: true,       
                success: function(response){                              
                if(response.status==200){                      
                       if(response.arquivos.length>0){
                        $("#nadaencontrado").remove();
                        $(".linha").remove();                        
                        var strlimita1 = '';
                        var strlimita2 = '';
                        var strlimita3 = '';
                        var strlim3a = '';
                        var strlim3b = '';
                        var strlim3c = '';
                        var strlim3d = '';
                        var strlimita4 = '';
                        var strlim4a = '';
                        var strlim4b = '';
                        var strlim4c = '';
                        var strlim4d = '';
                        var strlimita5 = '';                        
                        $.each(response.arquivos,function(key,docs){
                        strlimita1 = '<tr id="doc'+docs.id+'" class="linha">\
                                                  <td class="abredoc" data-id="'+docs.id+'" style="cursor:pointer">'+docs.rotulo+'</td>\
                                                  <td>\
                                                  <div class="btn-group">';
                        strlimita2 = '<div class="btn-group">\
                                                        <button type="button" data-id="'+docs.id+'" data-descricao="'+docs.rotulo+'" class="excluirarquivo_btn fas fa-trash" style="background:transparent;border:none;"></button>\
                                                    </div>';
                        strlimita3 = '<div class="btn-group">\
                                                        <button type="button" data-id="'+docs.id+'" class="copiararquivo_btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="background:transparent;border:none;"><i class="fas fa-copy"></i><span class="caret"></span></button>';
                        strlim3a = '<ul class="dropdown-menu">';
                                  $.each(response.setorgrupos, function(key,grupoemp){                                    
                                    strlim3b = strlim3b+'<li data-id="'+docs.id+'" data-grupoid="'+grupoemp.area_conhecimento_id+'" class="copiararquivo_opt dropdown-item" style="cursor:pointer">'+grupoemp.areaconhecimento.descricao+'</li>';
                                  });
                        strlim3c = '</ul>';
                        strlim3d ='</div>';
                        strlimita4 = '<div class="btn-group">\
                                                        <button type="button" data-id="'+docs.id+'" class="moverarquivo_btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="background:transparent;border:none;"><i class="fas fa-cut"></i><span class="caret"></span></button>';
                        strlim4a = '<ul class="dropdown-menu">';
                                  $.each(response.setorgrupos, function(key,grupoemp){                                    
                                    strlim4b = strlim4b+'<li data-id="'+docs.id+'" data-grupoid="'+grupoemp.area_conhecimento_id+'" class="moverarquivo_opt dropdown-item" style="cursor:pointer">'+grupoemp.areaconhecimento.descricao+'</li>';
                                  });
                        strlim4c = '</ul>';
                        strlim4d ='</div>';
                        strlimita5 = '</div>\
                                      </td>\
                                      </tr>';                                        
                        
                        $('#listadocs').append(strlimita1+
                                               strlimita2+
                                               strlimita3+
                                               strlim3a+
                                               strlim3b+
                                               strlim3c+
                                               strlim3d+
                                               strlimita4+
                                               strlim4a+
                                               strlim4b+
                                               strlim4c+
                                               strlim4d+
                                               strlimita5);
                      });
                      }else{
                        $('.linha').remove();
                        $("#nadaencontrado").remove();
                        $('#listadocs').append('<tr id="nadaencontrado">\
                                <td colspan="4">Nada Encontrado!</td>\
                            </tr>');
                      }
                }   
                }                                  
        });  
    });
    ////fim enviar docs

    $(document).on('click','.abredoc',function(e){
              e.preventDefault();            
            var id = $(this).data("id"); 

               $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/datacenter/sistemadearquivos/abrir-doc/'+id,                                
                success: function(response){ 
                    if(response.status==200){
                      var link = "{{asset('')}}"+'storage/'+response.arquivo.caminho;
                      //visualizar o pdf no browser                
                          window.open(link);                    
                    }
                }
            });
    });

    $(document).on('click','.excluirarquivo_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        var id = $(this).data("id");        
            var linklogo = "{{asset('storage')}}";        
            var descricao = $(this).data("descricao");
            
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title: descricao,
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
                    url: '/datacenter/sistemadearquivos/excluirarquivo/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,
                        '_method': 'DELETE',                    
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){
                            $("#doc"+id).remove();     
                            $('#fileform_errList').replaceWith('<ul id="fileform_errList"></ul>');                       
                            $('#fileform_errList').addClass('alert alert-success');
                            $('#fileform_errList').append(response.message);         
                        }
                    }
                });            
            }  
        });
    });

    $(document).on('click','.moverarquivo_opt',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        var id = $(this).data("id");
        var grupoid = $(this).data("grupoid");
                
        var data = new FormData();

        data.append('id',id);
        data.append('grupoid',grupoid);
        data.append('_token',CSRF_TOKEN);
        data.append('_method','PUT');

         $.ajax({
                   url: '/datacenter/sistemadearquivos/moverarquivo/'+id+'/'+grupoid,
                   type:'POST',
                   dataType: 'json',        
                   data:data,
                   cache:false,        
                   contentType: false,        
                   processData: false, 
                   async: true,    
                   success:function(response){
                   var status = response.status;
                   switch (status) {
                    case 200:
                        $("#doc"+id).remove();     
                        $('#fileform_errList').replaceWith('<ul id="fileform_errList"></ul>');                       
                        $('#fileform_errList').addClass('alert alert-success');
                        $('#fileform_errList').append(response.message);
                        break;
                   case 400:
                        $('#fileform_errList').replaceWith('<ul id="fileform_errList"></ul>');                       
                        $('#fileform_errList').addClass('alert alert-warning');
                        $('#fileform_errList').append(response.message);         
                        break;
                    case 404:
                        $('#fileform_errList').replaceWith('<ul id="fileform_errList"></ul>');                       
                        $('#fileform_errList').addClass('alert alert-danger');
                        $('#fileform_errList').append(response.message);
                        break;
                    default:
                        break;
                   }
                   
                   }
       });

    });

     $(document).on('click','.copiararquivo_opt',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        var id = $(this).data("id");
        var grupoid = $(this).data("grupoid");
                
        var data = new FormData();

        data.append('id',id);
        data.append('grupoid',grupoid);
        data.append('_token',CSRF_TOKEN);
        data.append('_method','PUT');

         $.ajax({
                   url: '/datacenter/sistemadearquivos/copiararquivo/'+id+'/'+grupoid,
                   type:'POST',
                   dataType: 'json',        
                   data:data,
                   cache:false,        
                   contentType: false,        
                   processData: false, 
                   async: true,    
                   success:function(response){
                   var status = response.status;
                   switch (status) {
                    case 200:
                        $('#fileform_errList').replaceWith('<ul id="fileform_errList"></ul>');                       
                        $('#fileform_errList').addClass('alert alert-success');
                        $('#fileform_errList').append(response.message);
                        break;
                   case 400:
                        $('#fileform_errList').replaceWith('<ul id="fileform_errList"></ul>');                       
                        $('#fileform_errList').addClass('alert alert-warning');
                        $('#fileform_errList').append(response.message);         
                        break;
                    case 404:
                        $('#fileform_errList').replaceWith('<ul id="fileform_errList"></ul>');                       
                        $('#fileform_errList').addClass('alert alert-danger');
                        $('#fileform_errList').append(response.message);
                        break;
                    default:
                        break;
                   }
                   
                   }
       });

    });


        $(document).on('click','.voltarmenu_btn',function(e){
        e.preventDefault();  
        var color = $(this).data("color");
        location.replace('/datacenter/sistemadearquivos/indexsetores/'+color);
        });


    ///tooltip
    $(function(){
        $(".pesquisa_btn").tooltip();
    });
    ///fim tooltip    




});

</script>

@stop

