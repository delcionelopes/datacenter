@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!---AddOrgaoModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddOrgaoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Órgão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <ul id="saveform_errList"></ul>

                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" class="nome_orgao form-control">
                    </div>
                    <div class="form-group mb3">
                        <label for="">Telefone</label>
                        <input type="text" class="telefone form-control" placeholder="(00)00000-0000" data-mask="(00)00000-0000">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" data-color="{{$color}}" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" data-color="{{$color}}" class="btn btn-{{$color}} add_orgao"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
                </div>
            </div>
        </div>

    </div>

</div>

<!--Fim AddOrgaoModal-->

<!--EditOrgaoModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="EditOrgaoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Órgão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>

                    <input type="hidden" id="edit_orgao_id">
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" id="edit_nome_orgao" class="nome_orgao form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Telefone</label>
                        <input type="text" id="edit_telefone" class="telefone form-control" placeholder="(00)00000-0000" data-mask="(00)00000-0000">
                    </div>                    
                </form>
                <div class="modal-footer">
                    <button type="button" data-color="{{$color}}" class="btn btn-default" data-dismiss="modal" >Fechar</button>
                    <button type="button" data-color="{{$color}}" class="btn btn-{{$color}} update_orgao"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!--Fim EditOrgaoModal-->

<!--index-->
@auth
<div class="container-fluid py-5">
    <div id="success_message"></div>
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenteradmin.orgao.orgao.index',['color'=>$color])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisanome" class="form-control rounded float-left" placeholder="Nome do órgão" aria-label="Search"
                            aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                                <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="AddOrgaoModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>                
            </section>
            <table class="table table-hover">
                <thead class="bg-{{$color}}" style="color: white">
                    <tr>
                        <th scope="col">ÓRGÃOS</th>
                        <th scope="col">TELEFONE</th>                     
                        <th scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_orgao">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($orgaos as $orgao)
                    <tr id="orgao{{$orgao->id}}">
                        <th scope="row">{{$orgao->nome}}</th>
                        <td>{{$orgao->telefone}}</td>                        
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$orgao->id}}" data-admin="{{auth()->user()->admin}}" data-nomeorgao="{{$orgao->nome}}" class="edit_orgao fas fa-edit" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>
                                <button type="button" data-id="{{$orgao->id}}" data-admin="{{auth()->user()->admin}}" data-nomeorgao="{{$orgao->nome}}" class="delete_orgao_btn fas fa-trash" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
                {{$orgaos->links()}}
    </div>
</div>
@endauth
<!--Fim index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')
<script type="text/javascript">

    $(document).ready(function(){
    
    //inicio delete orgao    
        $(document).on('click','.delete_orgao_btn',function(e){
            e.preventDefault();
            var linklogo = "{{asset('storage')}}";
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $(this).data("id");
            var admin = $(this).data("admin");
            var nomedoorgao = $(this).data("nomeorgao");
            if(admin=true){
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomedoorgao,
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
                    url:'/datacenteradmin/orgao/delete-orgao/'+id,
                    assync:true,
                    type:'POST',                
                    dataType: 'json',
                    data:{
                        'id':id,
                        '_method':'DELETE',
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){                           
                            //remove a linha correspondente da tabela html
                            $("#orgao"+id).remove();    
                            $("#success_message").replaceWith('<div id="success_message"></div>');
                            $("#success_message").addClass('alert alert-success');
                            $("#success_message").text(response.message);
                        }else{
                            //O registro não pôde ser excluído      
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
                title:nomedoorgao,
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
        
        });//fim delete orgao
    
    //início exibição edit orgao
    $("#EditOrgaoModal").on('shown.bs.modal',function(){
            $("#edit_nome_orgao").focus();
        });
    
    $(document).on('click','.edit_orgao',function(e){
        e.preventDefault();
        var link = "{{asset('storage')}}";
        var id = $(this).data("id");
        var admin = $(this).data("admin");        
        var nome = $(this).data("nomeorgao");
        if(admin=true){
        $("#editform").trigger('reset');
        $("#EditOrgaoModal").modal('show');
        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');     
    
        $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '/datacenteradmin/orgao/edit-orgao/'+id,
                    assync: true,
                    success:function(response){
                        if(response.status==200){
                            var vnomedoorgao = response.orgao.nome;
                            $(".nome_orgao").val(vnomedoorgao);
                            var vtelefone = response.orgao.telefone;
                            $(".telefone").val(vtelefone);
                            $("#edit_orgao_id").val(response.orgao.id);
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
    });//fim exibição edit orgão    
    
    //inicio da atualização do orgão
    $(document).on('click','.update_orgao',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var loading = $("#imgedit");
            loading.show();
            
        var id = $("#edit_orgao_id").val();
        
        var data = {
            'nome' : $("#edit_nome_orgao").val(),
            'telefone' : $("#edit_telefone").val(),
            '_method':'PUT',
            '_token':CSRF_TOKEN,
        }    
                $.ajax({
                    type:'POST',
                    data: data,
                    dataType: 'json',
                    url:'/datacenteradmin/orgao/update-orgao/'+id,
                    assync: true,
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
                            $("#EditOrgaoModal").modal('hide');
    
                            //atualizando a linha na tabela html
                           
                            var linha = '<tr id="orgao'+response.orgao.id+'">\
                                         <th scope="row">'+response.orgao.nome+'</th>\
                                         <td>'+response.orgao.telefone+'</td>\
                                         <td>\
                                             <div class="btn-group">\
                                                 <button type="button" data-id="'+response.orgao.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomeorgao="'+response.orgao.nome+'" class="edit_orgao fas fa-edit" style="background:transparent;border:none;"></button>\
                                                 <button type="button" data-id="'+response.orgao.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomeorgao="'+response.orgao.nome+'" class="delete_orgao_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                             </div>\
                                         </td>\
                                         </tr>';
                            $("#orgao"+id).replaceWith(linha);             
                        }
                    }
                });
    
    });//fim da atualização do orgão
    
    //exibe form de adição de registro
    $("#AddOrgaoModal").on('shown.bs.modal',function(){
            $(".nome_orgao").focus();
        });
    
    $(document).on('click','.AddOrgaoModal_btn',function(e){                  
            e.preventDefault();        
                                           
            $("#addform").trigger('reset');
            $("#AddOrgaoModal").modal('show');         
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');        
    
        });
    
    //fim exibe form de adição de registro
    
    
    //início da adição de órgão
    $(document).on('click','.add_orgao',function(e){     
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var loading = $("#imgadd");
            loading.show();
        var data = {
            'nome' : $(".nome_orgao").val(),
            'telefone' : $(".telefone").val(),
            '_method':'PUT',
            '_token':CSRF_TOKEN,
        }            
                $.ajax({                
                    url: '/datacenteradmin/orgao/adiciona-orgao',                                                                            
                    type: 'POST',
                    dataType: 'json',
                    data: data,               
                    cache: false, 
                    success: function(response){
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
                            $("#AddOrgaoModal").modal('hide');
    
                            //adiciona a linha na tabela html                            
                            var tupla = "";
                            var linha0 = "";
                            var linha1 = "";
                                linha0 = '<tr id="novo" style="display:none;"></tr>'; 
                                linha1 = '<tr id="orgao'+response.orgao.id+'">\
                                         <th scope="row">'+response.orgao.nome+'</th>\
                                         <td>'+response.orgao.telefone+'</td>\
                                         <td>\
                                             <div class="btn-group">\
                                                 <button type="button" data-id="'+response.orgao.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomeorgao="'+response.orgao.nome+'" class="edit_orgao fas fa-edit" style="background:transparent;border:none;"></button>\
                                                 <button type="button" data-id="'+response.orgao.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomeorgao="'+response.orgao.nome+'" class="delete_orgao_btn fas fa-trash" style="background: transparent;border: none;"></button>\
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
    });//fim da adição de orgão
    
///tooltip
    $(function(){             
        $(".AddOrgaoModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_orgao_btn").tooltip();
        $(".edit_orgao").tooltip();    
    });
    ///fim tooltip
    
    });
    
    
    </script>
@stop