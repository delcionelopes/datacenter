@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--AddArea_ConhecimentoModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddArea_ConhecimentoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Área de Conhecimento</h5>
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
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-{{$color}} add_area_conhecimento"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--fim AddArea_ConhecimentoModal-->

<!--EditArea_ConhecimentoModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditArea_ConhecimentoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Área do Conhecimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                     <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_area_conhecimento_id">
                    <div class="form-group mb-3">
                        <label for="">Descrição</label>
                        <input type="text" id="edit_descricao" class="descricao form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-{{$color}} update_area_conhecimento"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--fim EditArea_ConhecimentoModal-->

<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container-fluid py-5">
    <div id="success_message"></div>
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenteradmin.areaconhecimento.areaconhecimento.index',['color'=>$color])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="nomepesquisa" class="form-control rounded float-left" placeholder="Descrição da área" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                            <i class="fas fa-search"></i>                            
                            </button>
                            <button type="button" class="AddArea_ConhecimentoModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-hover">
            <thead class="bg-{{$color}}" style="color: white">
                    <tr>
                        <th scope="col">ÁREAS DE CONHECIMENTO</th>                    
                        <th scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_area_conhecimento">
                    <tr id="novo" style="display:none;"></tr>
                    @forelse($areas_conhecimento as $area_conhecimento)
                    <tr id="area{{$area_conhecimento->id}}">
                        <th scope="row">{{$area_conhecimento->descricao}}</th>                        
                        <td>
                            <div class="btn-group">
                                <button data-id="{{$area_conhecimento->id}}" data-admin="{{auth()->user()->admin}}" data-descricao="{{$area_conhecimento->descricao}}" class="edit_area_conhecimento fas fa-edit" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar ÁREA"></button>
                                <button data-id="{{$area_conhecimento->id}}" data-admin="{{auth()->user()->admin}}" data-descricao="{{$area_conhecimento->descricao}}" class="delete_area_conhecimento_btn fas fa-trash" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir ÁREA"></button>
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
            <div class="d-flex hover justify-content-center bg-{{$color}}">
            {{$areas_conhecimento->links()}}
      
    </div>
</div>
@else 
<i class="fas fa-lock"></i><b class="title"> USUÁRIO INATIVO OU NÃO LIBERADO! CONTACTE O ADMINISTRADOR.</b>
@endif
@endauth
<!--fim Index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')
<script type="text/javascript">

    //inicio do escopo geral
    $(document).ready(function(){
        //inicio delete area_conhecimento
        $(document).on('click','.delete_area_conhecimento_btn',function(e){
            e.preventDefault();
            var linklogo = "{{asset('storage')}}";
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $(this).data("id");           
            var nomedaarea = ($(this).data("descricao")).trim();
            var admin = $(this).data("admin");            
            if(admin){
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomedaarea,
                text: "Deseja excluir?",
                imageUrl: linklogo+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){             
                    $.ajax({
                    url:'/datacenteradmin/areaconhecimento/delete-areaconhecimento/'+id,
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
                        $("#area"+id).remove();   
                        $("#success_message").replaceWith('<div id="success_message"></div>');
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);         
                        }else{
                        //Não pôde ser excluído                      
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
                title:nomedaarea,
                text: "Você não pode excluir este registro. Procure um administrador!",
                imageUrl: linklogo+'/logoprodap.jpg',
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
        
        });//fim delete area_conhecimento
    
        //Exibe EditArea_ConhecimentoModal
        $("#EditArea_ConhecimentoModal").on('shown.bs.modal',function(){
            $("#edit_descricao").focus();
        });
        $(document).on('click','.edit_area_conhecimento',function(e){
            e.preventDefault();
            
            var linklogo = "{{asset('storage')}}";
            var admin = $(this).data("admin");            
            var nome = $(this).data("descricao");
            var id = $(this).data("id");
            if(admin){
            $("#editform").trigger('reset');
            $("#EditArea_ConhecimentoModal").modal('show');
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'GET',
                    dataType:'json',
                    url:'/datacenteradmin/areaconhecimento/edit-areaconhecimento/'+id,
                    success:function(response){
                        if(response.status==200){
                            var descricaoarea = (response.area_conhecimento.descricao).trim();
                            $(".descricao").val(descricaoarea);
                            $("#edit_area_conhecimento_id").val(response.area_conhecimento.id);
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
                text: "Você não pode alterar este registro. Procure um administrador!",
                imageUrl: linklogo+'/logoprodap.jpg',
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
    
        });//fim da exibição de EditArea_ConhecimentoModal
    
        //inicio da atualização do registro envio para o controller
        $(document).on('click','.update_area_conhecimento',function(e){
            e.preventDefault();
            var loading = $("#imgedit");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $("#edit_area_conhecimento_id").val();
            var data = {
                'descricao' : ($("#edit_descricao").val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }           
                $.ajax({
                    type:'POST',
                    data:data,
                    dataType:'json',
                    url:'/datacenteradmin/areaconhecimento/update-areaconhecimento/'+id,
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
                            $("#EditArea_ConhecimentoModal").modal('hide');
                            //atualizando a tr da tabela html                            
                            var linha = '<tr id="area'+response.area_conhecimento.id+'">\
                                    <th scope="row">'+response.area_conhecimento.descricao+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.area_conhecimento.id+'" data-admin="'+response.user.admin+'" data-descricao="'+response.area_conhecimento.descricao+'" class="edit_area_conhecimento fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.area_conhecimento.id+'" data-admin="'+response.user.admin+'" data-descricao="'+response.area_conhecimento.descricao+'" class="delete_area_conhecimento_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';                             
                             $("#area"+id).replaceWith(linha);                                                                                                        
    
                        }
                    }
                });
        });
        //fim da atualização do registro envio para o controller
    
        //inicio exibição da adição do novo registro
        $("#AddArea_ConhecimentoModal").on('shown.bs.modal',function(){
            $(".descricao").focus();
        });
        $(document).on('click','.AddArea_ConhecimentoModal_btn',function(e){  //início da exibição do form EditAmbientModal de ambiente                
            e.preventDefault();       
            
            $("#addform").trigger('reset');
            $("#AddArea_ConhecimentoModal").modal('show'); 
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');                      
    
        });    
        //fim exibição da adição do novo registro
    
        //inicio do envio do novo registro para o Area_ConhecimentoController
        $(document).on('click','.add_area_conhecimento',function(e){
            e.preventDefault();
            var loading = $("#imgadd");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var data = {
                'descricao' : ($(".descricao").val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN
            }   
            $.ajax({
                    type:'POST',
                    url:'/datacenteradmin/areaconhecimento/adiciona-areaconhecimento',
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
                            $("#success_message").replaceWith('<div id="success_message"></div>');                       
                            $("#success_message").addClass('alert alert-success');
                            $("#success_message").text(response.message);

                            loading.hide();
    
                            $("#addform").trigger('reset');
                            $("#AddArea_ConhecimentoModal").modal('hide');     
                            //inserindo a nova linha no corpo da table html 
                            var datacriacao = new Date(response.area_conhecimento.created_at).toLocaleString();
                            if(datacriacao=="31/12/1969 21:00:00"){
                                datacriacao = "";                            
                            }else{
                                datacriacao = datacriacao;
                            }                        
                            var tupla = "";
                            var linha0 = "";
                            var linha1 = "";
                                linha0 = '<tr id="novo" style="display:none;"></tr>';
                                linha1 = '<tr id="area'+response.area_conhecimento.id+'">\
                                    <th scope="row">'+response.area_conhecimento.descricao+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.area_conhecimento.id+'" data-admin="'+response.user.admin+'" data-descricao="'+response.area_conhecimento.descricao+'" class="edit_area_conhecimento fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.area_conhecimento.id+'" data-admin="'+response.user.admin+'" data-descricao="'+response.area_conhecimento.descricao+'" class="delete_area_conhecimento_btn fas fa-trash" style="background:transparent;border:none"></button>\
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
            
        });
        //fim do envio do novo registro para o Area_ConhecimentoController
    
     ///tooltip
    $(function(){             
        $(".AddArea_ConhecimentoModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_area_conhecimento_btn").tooltip();
        $(".edit_area_conhecimento").tooltip();    
    });
    ///fim tooltip
    
    });//fim do escopo geral
    
    </script>
@stop