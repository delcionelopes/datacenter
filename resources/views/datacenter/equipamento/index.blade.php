@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--inicio AddEquipamentoModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddEquipamentoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Equipamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">                              
                    <ul id="saveform_errList"></ul>                                 
                    <div class="form-group mb-3">
                        <label for="">Nome do equipamento</label>
                        <input type="text" class="nome form-control">
                    </div>                  
                    <div class="form-group mb-3">
                        <label for="">Descrição do equipamento</label>
                        <textarea class="descricao form-control" cols="30" rows="10"></textarea>
                    </div>  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_equipamento_btn"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- fim AddEquipamentoModal -->

<!--inicio EditEquipamentoModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditEquipamentoModal" tabindex="-1" role="dialog" aria-labelledby="edittitleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="edittitleModalLabel" style="color: white;">Editar e atualizar Equipamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">                   
                    <input type="hidden" id="edit_equipamento_id">
                    <ul id="updateform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Nome do equipamento</label>
                        <input type="text" id="edit_nome" class="nome form-control">
                    </div>                  
                    <div class="form-group mb-3">
                        <label for="">Senha admin</label>
                        <input type="text" id="edit_pass_admin" class="pass_admin form-control">
                    </div>                     
                    <div class="form-group mb-3">
                        <label for="">Descrição do equipamento</label>
                        <textarea id="edit_descricao" class="descricao form-control" cols="30" rows="10"></textarea>
                    </div> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_equipamento_btn"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- fim EditEquipamentoModal -->

<!-- início AddSenhaEquipAdmin -->
   <div class="modal fade animate__animated animate__bounce animate__faster" id="AddSenhaEquipAdmin" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Administrar acesso ao equipamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addformsenha" name="addformsenha" class="form-horizontal" role="form">
                    <input type="hidden" id="add_equipamentosenhaadmin_id">
                    <ul id="saveformsenha_errList"></ul>   
                    <div class="card">
                    <div class="card-body">         
                     <fieldset>
                    <legend>Dados de segurança</legend>                    
                    <div class="form-group mb-3">
                        <label  for="">Nome do equipamento:</label>
                        <label  id="nomeequipamento"></label>
                    </div>                        
                    <div class="form-group mb-3">
                        <label  for="">Senha ADMIN:</label><i id="mostrasenhaadmin_btn" class="fas fa-eye" data-status="true" style="border:none;"></i>
                        <input type="hidden" id="edit_senhaadmin">
                        <label  id="senhaadmin"></label>
                    </div>    
                     <div class="form-group mb-3">
                        <label  for="">Criação:</label>
                        <label  id="editdatacriacao"></label><br>
                        <label  for="">Modificação:</label>
                        <label  id="editdatamodificacao"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Criador:</label>
                        <label  id="editcriador"></label><br>
                        <label  for="">Modificador:</label>
                        <label  id="editmodificador"></label>
                    </div>                    
                    <div class="form-group mb-3">
                        <label for="" id="senhaindividualdeadmin">Sua senha individual de </label>                        
                        <input type="text" id="edit_senhaindividualequip" class="senhaindividual form-control">
                    </div>                   
                    </fieldset>
                    </div>
                    </div>
                     <div class="card">
                        <div class="card-body">                        
                            <fieldset>
                                <legend>Quem tem acesso a este equipamento?</legend>
                                <div class="form-check">
                                    @foreach ($users as $user)
                                    <label class="form-check-label" for="CheckUser{{$user->id}}">
                                        <input type="checkbox" id="CheckUser{{$user->id}}" name="users[]" value="{{$user->id}}" class="form-check-input">
                                        @if($user->admin) 
                                            <i class="fas fa-user" style="color: green "></i> 
                                        @else 
                                            <i class="fas fa-user" style="color: gray"></i> 
                                        @endif 
                                            {{$user->name}}
                                    </label><br>
                                    @endforeach
                                </div>
                            </fieldset>  
                            </div>
                     </div>                             
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_senhaequipadmin_btn"><img id="imgeaddequipamento" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim AddSenhaEquipAdmin -->

<!-- início EditSenhaIndividual -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSenhaIndividual" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Minha senha individual</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editformsenha" name="editformsenha" class="form-horizontal" role="form">
                    <input type="hidden" id="edit_equipamentosenhaindividual_id">
                    <ul id="updateformsenha_errList"></ul>  
                    <div class="card">
                    <div class="card-body"> 
                    <fieldset>
                    <legend>Dados da Senha</legend>                 
                    <div class="form-group mb-3">
                        <label  for="">Nome do equipamento:</label>
                        <label  id="editnomeequipamento"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" id="nomedousuario">Senha de </label>
                        <input type="text" id="edit_senhaindividual" class="senha form-control">                       
                    </div>                                 
                    </fieldset>    
                    </div>
                    </div>                                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_senhaindividual_btn"><img id="imgeditindividual" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim EditSenhaIndividual -->

<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container-fluid py-5">
    <div id="success_message"></div>        
            <section class="border p-4 mb-4 d-flex align-items-left">
            <form action="{{route('datacenter.equipamento.index')}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">                                                  
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do equipamento" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background:transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                               <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="AddEquipamento_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                               <i class="fas fa-plus"></i>
                            </button>                              
                        </div>
                    </div>
            </form>    
            </section>
            <table class="table table-hover">
                <thead class="sidebar-dark-primary" style="color: white">
                    <tr>                        
                        <th scope="col">EQUIPAMENTO(s)</th>
                        <th scope="col"><i class="fas fa-key"></i> PASS</th>                        
                        <th scope="col">AÇÕES</th>                       
                    </tr>                    
                </thead>
                <tbody id="lista_equipamentos">
                    <tr id="novo" style="display:none;"></tr>
                    @forelse($equipamentos as $equipamento)
                    <tr id="equipamento{{$equipamento->idequipamento_rede}}" data-toggle="tooltip" title="{{$equipamento->descricao}}">
                        <th scope="row">{{$equipamento->nome}}</th>
                        <td id="senha{{$equipamento->idequipamento_rede}}">
                            @if(!$equipamento->pass_admin)
                            <button id="botaosenha{{$equipamento->idequipamento_rede}}" type="button" data-id="{{$equipamento->idequipamento_rede}}" data-admin="{{auth()->user()->admin}}" data-useridsetor="{{auth()->user()->setor_idsetor}}" data-idsetor="{{$equipamento->setor_idsetor}}" data-setor="{{$equipamento->setor->sigla}}" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Registrar senha de Admin"></button>
                            @else
                            @if((!$equipamento->users()->count())&&((auth()->user()->admin==true)&&($equipamento->setor_idsetor==auth()->user()->setor_idsetor)))
                                 <button id="botaosenha{{$equipamento->idequipamento_rede}}" type="button" data-id="{{$equipamento->idequipamento_rede}}" data-nome="{{$equipamento->nome}}" data-opt="1" data-admin="{{auth()->user()->admin}}" data-useridsetor="{{auth()->user()->setor_idsetor}}" data-idsetor="{{$equipamento->setor_idsetor}}" data-setor="{{$equipamento->setor->sigla}}" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Primeira autorização"></button>
                            @else     
                            @if($equipamento->users()->count())                           
                            @foreach($equipamento->users as $user)
                                  @if($user->id == auth()->user()->id)
                                  <button id="botaosenha{{$equipamento->idequipamento_rede}}" type="button" data-id="{{$equipamento->idequipamento_rede}}" data-nome="{{$equipamento->nome}}" data-opt="1" data-admin="{{auth()->user()->admin}}" data-useridsetor="{{auth()->user()->setor_idsetor}}" data-idsetor="{{$equipamento->setor_idsetor}}" data-setor="{{$equipamento->setor->sigla}}" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="{{$equipamento->users->implode('name','<br>')}}"></button>
                                  @break
                                  @elseif ($loop->last)
                                  <button id="botaosenha{{$equipamento->idequipamento_rede}}" type="button" data-id="{{$equipamento->idequipamento_rede}}" data-nome="{{$equipamento->nome}}" data-opt="0" data-admin="{{auth()->user()->admin}}" data-useridsetor="{{auth()->user()->setor_idsetor}}" data-idsetor="{{$equipamento->setor_idsetor}}" data-setor="{{$equipamento->setor->sigla}}" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="{{$equipamento->users->implode('name','<br>')}}"></button>
                                  @endif                                                        
                            @endforeach                            
                            @endif
                            @endif
                            @endif                                                                                   
                        </td>                        
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$equipamento->idequipamento_rede}}" data-admin="{{auth()->user()->admin}}" data-useridsetor="{{auth()->user()->setor_idsetor}}" data-idsetor="{{$equipamento->setor_idsetor}}" data-setor="{{$equipamento->setor->sigla}}" class="edit_equipamento_btn fas fa-edit" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>
                                <button type="button" data-id="{{$equipamento->idequipamento_rede}}" data-nome="{{$equipamento->nome}}" data-admin="{{auth()->user()->admin}}" data-useridsetor="{{auth()->user()->setor_idsetor}}" data-idsetor="{{$equipamento->setor_idsetor}}" data-setor="{{$equipamento->setor->sigla}}" class="delete_equipamento_btn fas fa-trash" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="nadaencontrado">
                        <td class="col-12">Nada Encontrado!</td>                       
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex hover justify-content-center">
                {{$equipamentos->links()}}               
            </div>     
</div>
@else 
<i class="fas fa-lock"></i><b class="title"> USUÁRIO INATIVO OU NÃO LIBERADO! CONTACTE O ADMINISTRADOR.</b>
@endif
@endauth
<!--Fim Index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){
    
        //inicio delete
        $(document).on('click','.delete_equipamento_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var link = "{{asset('storage')}}";
            var id = $(this).data("id");
            var admin = $(this).data("admin");
            var setor = $(this).data("setor");
            var idsetor = $(this).data("idsetor");
            var useridsetor = $(this).data("useridsetor");
            var nome = ($(this).data("nome")).trim();
            if((admin==true)&&(idsetor===useridsetor)){ 
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nome,
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
                        url: '/datacenter/delete-equipamento/'+id,
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
                                $("#equipamento"+id).remove();
                                $("#success_message").html('<div id="success_message"></div>');
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
    }else{
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:"ALERTA "+setor+" !",
                text: "Este equipamento pertence à "+setor+" e somente pode ser excluído um administrador do setor "+setor+" !",
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
        //fim delete
    
        //inicio exibe EditEquipamentoModal
        $('#EditEquipamentoModal').on('shown.bs.modal',function(){
            $(".nome").focus();
        });    
        $(document).on('click','.edit_equipamento_btn',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");    
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");
            var setor = $(this).data("setor");
            var idsetor = $(this).data("idsetor");
            var useridsetor = $(this).data("useridsetor");
            var nome = $(this).data("nome");

            if((admin==true)&&(idsetor===useridsetor)){ 

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '/datacenter/edit-equipamento/'+id,
                success:function(response){
                    if(response.status==200){                         
                        $("#editform").trigger('reset');

                        var senhaadmin = "";
                        if(!(response.senhaadmin==null)){
                            senhaadmin = response.senhaadmin;
                        }
                        $(".pass_admin").val(senhaadmin);                        
                        $(".nome").val(response.equipamento.nome);
                        $(".descricao").val(response.equipamento.descricao);
                        $("#edit_equipamento_id").val(response.equipamento.idequipamento_rede);
                        
                        $("#EditEquipamentoModal").modal('show');
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
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
                title:"ALERTA "+setor+" !",
                text: "Este equipamento pertence à "+setor+" e somente pode ser editado por um administrador do setor "+setor+" !",
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
        //fim exibe EditEquipamentoModal
            
        //inicio da atualização do registro
        $(document).on('click','.update_equipamento_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var loading = $("#imgedit");
                loading.show();
            
            var id = $("#edit_equipamento_id").val();
            var data = {                
                'nome': $("#edit_nome").val(),
                'descricao': $("#edit_descricao").val(),
                'senhaadmin': $("#edit_pass_admin").val(),                
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }            
    
            $.ajax({
                type: 'POST',
                data: data,
                dataType: 'json',
                url: '/datacenter/update-equipamento/'+id,
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
                        $("#EditEquipamentoModal").modal('hide');
    
                        //atualizando a tr da table html                      
                        var tupla = "";                 
                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";
                        var limita5 = "";
                        var limita6 = "";
                        limita1 = '<tr id="equipamento'+response.equipamento.idequipamento_rede+'" data-toggle="tooltip" title="'+response.equipamento.descricao+'">\
                            <th scope="row">'+response.equipamento.nome+'</th>\
                            <td id="senha'+response.equipamento.idequipamento_rede+'">';
                        var bloqueia = true;
                        if(!response.equipamento.pass_admin){                        
                        limita2 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Registrar senha de Admin"></button>';
                        }else if((!response.users.count)&&(response.user.admin==true)&&(response.equipamento.setor_idsetor==response.user.setor_idsetor)){
                        limita3 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="1" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Primeira autorização"></button>';     
                        }else if(response.users.count){
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita4 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="1" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita5 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="0" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        } 
                        limita6 = '</td><td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="edit_equipamento_btn fas fa-edit" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>\
                                    <button type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="delete_equipamento_btn fas fa-trash" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>\
                                </div>\
                            </td>\
                        </tr>';    
                        tupla = limita1+limita2+limita3+limita4+limita5+limita6;         
                        $("#equipamento"+id).replaceWith(tupla);
                    }
                }
            });
    
        });
        //fim da atualização do registro
        //inicio exibição do form de inserção de registro
        $('#AddEquipamentoModal').on('shown.bs.modal',function(){
            $(".nome").focus();
        });
        $(document).on('click','.AddEquipamento_btn',function(e){
            e.preventDefault();            
            $("#addform").trigger('reset');
            $("#AddEquipamentoModal").modal('show');          
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>'); 
        });
        //fim exibição do form de inserção de registro
        
        //inicio do envio do novo registro
        $(document).on('click','.add_equipamento_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var loading = $("#imgadd");
                loading.show();
            
            var data = {            
                'nome': ($(".nome").val()).trim(),
                'descricao': $(".descricao").val(),                
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }    
    
            $.ajax({
                type: 'POST',
                url: '/datacenter/adiciona-equipamento',
                data: data,
                dataType: 'json',
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
                        $("#AddEquipamentoModal").modal('hide');
    
                        //inserindo a tr na table html                             
                        var tupla = "";
                        var limita0 = "";
                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";
                        var limita5 = "";                        
                        var limita6 = "";
                       
                        limita0 = '<tr id="novo" style="display:none;"></tr>';
                        limita1 = '<tr id="equipamento'+response.equipamento.idequipamento_rede+'" data-toggle="tooltip" title="'+response.equipamento.descricao+'">\
                            <th scope="row">'+response.equipamento.nome+'</th>\
                            <td id="senha'+response.equipamento.idequipamento_rede+'">';
                        var bloqueia = true;                        
                        if(!response.equipamento.pass_admin){                        
                        limita2 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Registrar senha de Admin"></button>';
                        }else if((!response.users.count)&&(response.user.admin)&&(response.equipamento.setor_idsetor==response.user.setor_idsetor)){
                        limita3 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="1" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Primeira autorização"></button>';     
                        }else if(response.users.count){
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita4 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="1" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita5 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="0" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }                         
                        limita6 = '</td><td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="edit_equipamento_btn fas fa-edit" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>\
                                    <button type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="delete_equipamento_btn fas fa-trash" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        if(!$("#nadaencontrado").html==""){
                            $("#nadaencontrado").remove();
                        }
                        tupla = limita0+limita1+limita2+limita3+limita4+limita5+limita6;                    
                        $("#novo").replaceWith(tupla);
                    }
                }
            });        
        });
        //fim do envio do novo registro        

         //cadastro de senha     
        $(document).on('click','.cadsenha_btn',function(e){
            e.preventDefault();
            var link = "{{asset('storage')}}";
            var id = $(this).data("id");
            var admin = $(this).data("admin");
            var setor = $(this).data("setor");
            var idsetor = $(this).data("idsetor");
            var useridsetor = $(this).data("useridsetor");
            var nome = $(this).data("nome");
            if((admin==true)&&(idsetor===useridsetor)){            
                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/datacenter/edit-equipamento/'+id,
                        success:function(response){
                            if(response.status==200){                       
                                $("#editform").trigger('reset');

                                var senhaadmin = "";
                                if(!(response.senhaadmin==null)){
                                    senhaadmin = response.senhaadmin;
                                }
                                $(".pass_admin").val(senhaadmin);                        
                                $(".nome").val(response.equipamento.nome);
                                $(".descricao").val(response.equipamento.descricao);
                                $("#edit_equipamento_id").val(response.equipamento.idequipamento_rede);
                                
                                $("#EditEquipamentoModal").modal('show');
                                $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
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
                text: "Equipamento sem senha de admin. Procure um administrador do setor "+setor+" !",
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

         
    ////inicio alteração de senha    
    $(document).on('click','.senhabloqueada_btn',function(e){
        e.preventDefault();

        var id = $(this).data("id");
        var link = "{{asset('storage')}}";
        var nome = $(this).data("nome");
        var admin = $(this).data("admin");
        var useridsetor = $(this).data("useridsetor");
        var idsetor = $(this).data("idsetor");
        var setor = $(this).data("setor");
        var opcaosenha = $(this).data("opt");

        if((admin==true)&&(idsetor===useridsetor)&&(opcaosenha=="1")){        
                  
        $("#addformsenha").trigger('reset');
        $("#AddSenhaEquipAdmin").modal('show');  
        $("#add_equipamentosenhaadmin_id").val(id);
        $("#nomeequipamento").replaceWith('<Label id="nomeequipamento" style="font-style:italic;">'+nome+'</Label>');       
        $("#saveformsenha_errList").replaceWith('<ul id="saveformsenha_errList"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editsenhaequipamento/'+id,
            success: function(response){                
                if(response.status==200){                    
                    var datacriacao = new Date(response.equipamento.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.equipamento.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }
                    var criador = response.criador;
                        if(!response.criador){
                            criador = "";
                        }
                    var alterador = response.alterador;
                        if(!response.alterador){
                            alterador = "";
                        }                                                        
                    $("#editdatacriacao").replaceWith('<label  id="editdatacriacao">'+datacriacao+'</label>');
                    $("#editdatamodificacao").replaceWith('<label  id="editdatamodificacao">'+dataatualizacao+'</label>');
                    $("#editcriador").replaceWith('<label  id="editcriador">'+criador+'</label>');
                    $("#editmodificador").replaceWith('<label  id="editmodificador">'+alterador+'</label>');                         
                    $("#senhaindividualdeadmin").replaceWith('<label for="" id="senhaindividualdeadmin">Senha individual de '+response.user.name+'</label>');
                    $("#edit_senhaadmin").val(response.senhaadmin);
                    $(".senhaindividual").val(response.senhaindividual);
                   
                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                       
                        $.each(response.users,function(key,values){                                                        
                                $("#CheckUser"+values.id).attr('checked',true);  //faz a marcação seletiva                         
                        });
                }
            }
        });

    }else if((admin==false)&&(idsetor===useridsetor)&&(opcaosenha=="1")){        
                  
        $("#editformsenha").trigger('reset');
        $("#EditSenhaIndividual").modal('show');
        $("#edit_equipamentosenhaindividual_id").val(id);
        $("#editnomeequipamento").replaceWith('<Label id="editnomeequipamento" style="font-style:italic;">'+nome+'</Label>');       
        $("#updateformsenha_errList").replaceWith('<ul id="updateformsenha_errList"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editsenhaindividual/'+id,
            success: function(response){
                if(response.status==200){                    
                    $("#nomedousuario").replaceWith('<label  id="nomedousuario"> Senha de '+response.user.name+'</label>');
                    $(".senha").val(response.senhaindividual);                   
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
                title:"ALERTA "+setor+" !",
                text: "Você não tem acesso a esta informação. Peça sua inclusão a um administrador do setor "+setor+" !",
                imageUrl: link+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'Ok, obrigado!',                
                cancelButtonText: 'Não necessito, obrigado!',
            });      
    }
             
    });
    
    ///inicio gravar processo admin
    $(document).on('click','.add_senhaequipadmin_btn',function(e){
            e.preventDefault();
            var loading = $("#imgeaddequipamento");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
           
            var id = $("#add_equipamentosenhaadmin_id").val();                   

            //array apenas com os checkboxes marcados
            var users = new Array;
            $("input[name='users[]']:checked").each(function(){
                users.push($(this).val());
            });            
            
            var data = {
                'senha':$("#edit_senhaindividualequip").val(),                            
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/updatesenhaequipamento/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $("#saveformsenha_errList").replaceWith("");
                            $("#saveformsenha_errList").addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $("#saveformsenha_errList").append('<li>'+err_values+'</li>');
                            });
                            loading.hide();
          
                }else{
                        $("#saveformsenha_errList").replaceWith('<ul id="saveformsenha_errList"></ul>');     
                        $("#success_message").replaceWith('<div id="success_message"></div>');              
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);                                        
                        loading.hide();
    
                        $("#addformsenha").trigger('reset');                    
                        $("#AddSenhaEquipAdmin").modal('hide');

                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";                        
                        var bloqueia = true;                        
                       if(!response.equipamento.pass_admin){                        
                        limita1 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Registrar senha de Admin"></button>';
                        }else if((!response.users.count)&&(response.user.admin)&&(response.equipamento.setor_idsetor==response.user.setor_idsetor)){
                        limita2 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="1" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Primeira autorização"></button>';     
                        }else if(response.users.count){
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita3 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="1" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita4 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="0" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }                      

                        var elemento = limita1+limita2+limita3+limita4;
                        $("#botaosenha"+id).replaceWith(elemento);

                } 
                }   
            });
    });         

    ////fim gravar processo admin

     ///inicio gravar processo individual
    $(document).on('click','.update_senhaindividual_btn',function(e){
            e.preventDefault();
            var loading = $("#imgeditindividual");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');           
            var id = $("#edit_equipamentosenhaindividual_id").val();                               
            var data = {
                'senha':$("#edit_senhaindividual").val(),                
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/updatesenhaindividual/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $("#updateformsenha_errList").replaceWith("");
                            $("#updateformsenha_errList").addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $("#updateformsenha_errList").append('<li>'+err_values+'</li>');
                            });
                            loading.hide();
          
                }else{
                        $("#updateformsenha_errList").replaceWith('<ul id="updateformsenha_errList"></ul>');     
                        $("#success_message").replaceWith('<div id="success_message"></div>');              
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);                                        
                        loading.hide();
    
                        $('#editformsenha').trigger('reset');                    
                        $('#EditSenhaIndividual').modal('hide');

                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";
                        var bloqueia = true;                        
                        if(!response.equipamento.pass_admin){                        
                        limita1 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Registrar senha de Admin"></button>';
                        }else if((!response.users.count)&&(response.user.admin)&&(response.equipamento.setor_idsetor==response.user.setor_idsetor)){
                        limita2 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="1" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Primeira autorização"></button>';     
                        }else if(response.users.count){
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita3 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="1" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita4 = '<button id="botaosenha'+response.equipamento.idequipamento_rede+'" type="button" data-id="'+response.equipamento.idequipamento_rede+'" data-nome="'+response.equipamento.nome+'" data-opt="0" data-admin="'+response.user.admin+'" data-useridsetor="'+response.user.setor_idsetor+'" data-idsetor="'+response.equipamento.setor_idsetor+'" data-setor="'+response.setor.sigla+'" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        } 

                        var elemento = limita1+limita2+limita3+limita4;
                        $("#botaosenha"+id).replaceWith(elemento);

                } 
                }   
            });
    });         

    ////fim gravar processo individual

    ///mostra senha admin
    $(document).on('click','#mostrasenhaadmin_btn',function(e){
        e.preventDefault();
        var status = $(this).data("status");
        var senhaadmin = $("#edit_senhaadmin").val();
        if(status==true){
            $("#mostrasenhaadmin_btn").replaceWith('<i id="mostrasenhaadmin_btn" class="fas fa-ban" data-status="false" style="border:none;"></i>');
            $("#senhaadmin").replaceWith('<label  id="senhaadmin">'+senhaadmin+'</label>');
        }else{
            $("#mostrasenhaadmin_btn").replaceWith('<i id="mostrasenhaadmin_btn" class="fas fa-eye" data-status="true" style="border:none;"></i>');
            $("#senhaadmin").replaceWith('<label  id="senhaadmin"></label>');
        }
    });
    ///mostra senha admin

            //formatação str para date
    function formatDate(data, formato) {
        if (formato == 'pt-br') {
            return (data.substr(0, 10).split('-').reverse().join('/'));
        } else {
            return (data.substr(0, 10).split('/').reverse().join('-'));
        }
        }
        //fim formatDate

        ///tooltip
    $(function(){      
        $(".senhabloqueada_btn").tooltip();       
        $(".cadsenha_btn").tooltip();                        
        $(".AddEquipamento_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_equipamento_btn").tooltip();
        $(".edit_equipamento_btn").tooltip();        
    });
    ///fim tooltip

    });
    
    </script>
@stop
