@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

  <!--AddVlanModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddVlanModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar VLAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="addform" name="addform" class="form-horizontal" role="form"> 
                <ul id="saveform_errList"></ul>

                
                <div class="form-group mb-3">
                    <label for="">Nome</label>
                    <input type="text" class="nome_vlan form-control">
                </div>
            </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_vlan"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddVlanModal-->

<!--inicio AddRedeModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddRedeModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar REDE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">                
                <form id="addredeform" name="addredeform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_vlan_id">                    
                    <ul id="saveformrede_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Nome REDE</label>
                        <input type="text" id="nome_rede" class="nome_rede form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Máscara</label>
                        <input type="text" class="mascara form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Tipo REDE</label>
                        <input type="text" class="tipo_rede form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_rede"><img id="imgaddrede" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim AddRedeModal -->


<!--EditVlanModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="EditVlanModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar VLAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="editform" name="editform" class="form-horizontal" role="form">
                <ul id="updateform_errList"></ul>

                <input type="hidden" id="edit_vlan_id">
                <div class="form-group mb-3">
                    <label for="">Nome VLAN</label>
                    <input type="text" id="edit_nome_vlan" class="nome_vlan form-control">
                </div>
            </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_vlan"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim EditVlanModal-->

<!-- início AddSenhaVLAN -->
   <div class="modal fade animate__animated animate__bounce animate__faster" id="AddSenhaVLAN" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addformsenha" name="addformsenha" class="form-horizontal" role="form">
                    <input type="hidden" id="add_vlansenha_id">
                    <ul id="saveformsenha_errList"></ul>   
                    <div class="card">
                    <div class="card-body">         
                     <fieldset>
                    <legend>Dados da Senha</legend>                    
                    <div class="form-group mb-3">
                        <label  for="">Nome da VLAN:</label>
                        <label  id="nomevlan"></label>
                    </div>                    
                    <div class="form-group mb-3">
                        <label for="">Senha</label>
                        <input type="text" class="add_senha form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Validade</label>
                        <input type="text" class="add_validade form-control" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="flexCheck"> 
                        <input type="checkbox" class="add_val_indefinida form-check-input" name="add_val_indefinida" id="flexCheck"> Validade indeterminada
                        </label>
                    </div>         
                     </fieldset>
                    </div>
                    </div>
                     <div class="card">
                        <div class="card-body">                        
                            <fieldset>
                                <legend>Quem tem acesso a esta informação?</legend>
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
                <button type="button" class="btn btn-primary add_senhavlan_btn"><img id="imgaddsenha" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim AddSenhaVLAN -->

<!-- início EditSenhaVLAN -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSenhaVLAN" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editformsenha" name="editformsenha" class="form-horizontal" role="form">
                    <input type="hidden" id="edit_vlansenha_id">
                    <ul id="updateformsenha_errList"></ul>  
                    <div class="card">
                    <div class="card-body"> 
                    <fieldset>
                    <legend>Dados da Senha</legend>                 
                    <div class="form-group mb-3">
                        <label  for="">Nome da VLAN:</label>
                        <label  id="editnomevlan"></label>
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
                        <label for="">Senha</label>
                        <input type="text" id="edit_senha" class="senha form-control">
                        <label for=""><small id="senhavencida" style="color: red">Senha vencida!</small></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Validade</label>
                        <input type="text" id="edit_validade" class="validade form-control" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="edit_val_indefinida"> 
                        <input type="checkbox" class="val_indefinida form-check-input" name="edit_val_indefinida" id="edit_val_indefinida"> Validade indeterminada
                        </label>
                    </div>                
                    </fieldset>    
                    </div>
                    </div>
                     <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Quem tem acesso a esta informação?</legend>
                                <div class="form-check">
                                    @foreach ($users as $user)
                                    <label class="form-check-label" for="check{{$user->id}}">
                                        <input type="checkbox" id="check{{$user->id}}" name="users[]" value="{{$user->id}}" class="form-check-input"> 
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
                <button type="button" class="btn btn-primary update_senhavlan_btn"><img id="imgeditsenha" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim EditSenhaVLAN -->

<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container-fluid py-5"> 
    <div id="success_message"></div> 
    <section class="border p-4 mb-4 d-flex align-items-left">    
    <form action="{{route('datacenter.vlan.index')}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome da VLAN" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>        
            <button type="button" data-setoradmin="{{auth()->user()->setor_idsetor}}" class="AddVlanModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro"><i class="fas fa-plus"></i></button>
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="sidebar-dark-primary" style="color: white">
                            <tr>                                
                                <th scope="col">VLAN</th>
                                <th scope="col"><i class="fas fa-key"></i> PASS</th>
                                <th scope="col">REDES</th>                             
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_vlan">  
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($vlans as $vlan)   
                            <tr id="vlan{{$vlan->id}}">                                
                                <th scope="row">{{$vlan->nome_vlan}}</th>
                                 <td id="senha{{$vlan->id}}">
                                    @if(!$vlan->senha)
                                    <button id="botaosenha{{$vlan->id}}" type="button" data-id="{{$vlan->id}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-nomevlan="{{$vlan->nome_vlan}}" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Registrar senha e dar<br>permissões de visualização"></button>
                                    @else
                                    @if($vlan->users()->count())                           
                                    @foreach($vlan->users as $user)
                                        @if(($user->id) == (auth()->user()->id))                                  
                                        <button id="botaosenha{{$vlan->id}}" type="button" data-id="{{$vlan->id}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-nomevlan="{{$vlan->nome_vlan}}" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="{{$vlan->users->implode('name','<br>')}}"></button>
                                        @break
                                        @elseif ($loop->last)
                                        <button id="botaosenha{{$vlan->id}}" type="button" data-id="{{$vlan->id}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-nomevlan="{{$vlan->nome_vlan}}" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="{{$vlan->users->implode('name','<br>')}}"></button>
                                        @endif                                                        
                                    @endforeach                            
                                    @endif
                                    @endif                                                        
                                </td>
                                <td>
                                    @if($vlan->redes()->count())
                                    <form action="{{route('datacenter.rede.index',['id' => $vlan->id])}}" method="get">
                                        <button type="submit" data-id="{{$vlan->id}}" class="list_rede_btn fas fa-network-wired" style="background: transparent;border:none;color:green; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Lista REDE(s)"> {{$vlan->redes()->count()}}</button>
                                    </form>
                                    @else
                                        <button type="button" data-id="{{$vlan->id}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" class="nova_rede_btn fas fa-folder" style="background: transparent;border:none;color:orange; nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Cadastra nova REDE"></button>
                                    @endif    
                                </td>                               
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <button type="button" data-id="{{$vlan->id}}" data-admin="{{auth()->user()->admin}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" class="edit_vlan fas fa-edit" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar VLAN"></button>
                                            <button type="button" data-id="{{$vlan->id}}" data-admin="{{auth()->user()->admin}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-nomevlan="{{$vlan->nome_vlan}}" class="delete_vlan_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir VLAN"></button>
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
                    {{$vlans->links()}}
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
        
    
        $(document).on('click','.delete_vlan_btn',function(e){   ///inicio delete vlan
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $(this).data("id");
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");
            var setoradmin = $(this).data("setoradmin");
            var nomevlan = ($(this).data("nomevlan")).trim();
            if((admin)&&(setoradmin==1)){
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomevlan,
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
                    url: '/datacenter/delete-vlan/'+id,
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
                            $("#vlan"+id).remove();           
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
                title:"ALERTA SETOR DE INFRA!",
                text: "Você não tem permissão para excluir este registro. Procure um administrador do setor INFRA !",
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
        
        });  ///fim delete vlan
        //início da exibição do form EditVlanModal
        $('#EditVlanModal').on('shown.bs.modal',function(){
            $("#edit_nome_vlan").focus();
        });
        $(document).on('click','.edit_vlan',function(e){  
            e.preventDefault();
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");
            var setoradmin = $(this).data("setoradmin");
            var id = $(this).data("id");                
            if((admin)&&(setoradmin==1)){
            $("editform").trigger('reset');
            $("#EditVlanModal").modal('show');
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');                   
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/datacenter/edit-vlan/'+id,                                
                success: function(response){           
                    if(response.status==200){            
                        $("#edit_nome_vlan").val((response.vlan.nome_vlan).trim());
                        $("#edit_vlan_id").val(response.vlan.id);                                                                                                       
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
                title:"ALERTA SETOR DE INFRA!",
                text: "Você não tem permissão para alterar este registro. Procure um administrador do setor INFRA !",
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
    
        }); //fim da da exibição do form EditVlanModal
    
        $(document).on('click','.update_vlan',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $("#imgedit");
                loading.show();
    
            var id = $("#edit_vlan_id").val();        
    
            var data = {
                'nome_vlan' : ($("#edit_nome_vlan").val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }

            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: '/datacenter/update-vlan/'+id,         
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
                        $("#EditVlanModal").modal('hide');                  
                        
                        location.reload();
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro
    
        //exibe form de adição de registro
        $('#AddVlanModal').on('shown.bs.modal',function(){
            $(".nome_vlan").focus();
        });
        $(document).on('click','.AddVlanModal_btn',function(e){  //início da exibição do form AddVlanModal
            e.preventDefault();       
            var link = "{{asset('storage')}}";
            var setoradmin = $(this).data("setoradmin");
            if(setoradmin==1){
            $("#addform").trigger('reset');
            $("#AddVlanModal").modal('show');  
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
            }else{
                  Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:'ALERTA SETOR DE INFRA!',
                text: "Você não pode registrar VLAN. Pois, o seu usuário não pertence ao setor INFRA !",
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
    
        });
    
        //fim exibe form de adição de registro
    
        $(document).on('click','.add_vlan',function(e){ //início da adição de Registro
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');     
            var loading = $("#imgadd");
                loading.show();
            var data = {
                'nome_vlan': ($(".nome_vlan").val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }    
          
            $.ajax({
                type: 'POST',
                url: '/datacenter/adiciona-vlan',
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
                        $("#AddVlanModal").modal('hide');
    
                        //adiciona a linha na tabela html
                        
                        var tupla = "";
                        var limita0 = "";
                        var limita1 = "";                        
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";
                        var limita5 = "";                       

                            limita0 = '<tr id="novo" style="display:none;"></tr>';
                            limita1 = '<tr id="ambiente'+response.vlan.id+'">\
                                    <th scope="row">'+response.vlan.nome_vlan+'</th>';
                                    var bloqueia = true;                        
                                    if((response.vlan.senha)==""){
                                    limita2 = '<button id="botaosenha'+response.vlan.id+'" type="button" data-id="'+response.vlan.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomevlan="'+response.vlan.nome_vlan+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                                    }else{
                                        $.each(response.users,function(key,user_values){
                                            if(user_values.id == response.user.id){                                    
                                                limita3 = '<button id="botaosenha'+response.vlan.id+'" type="button" data-id="'+response.vlan.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomevlan="'+response.vlan.nome_vlan+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                                bloqueia = false;                              
                                            }
                                        });                            
                                        if(bloqueia){
                                        limita4 = '<button id="botaosenha'+response.vlan.id+'" type="button" data-id="'+response.vlan.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomevlan="'+response.vlan.nome_vlan+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                                        }
                                    }  
                            limita5 = '<td>\
                                    <button type="button" data-id="'+response.vlan.id+'" class="nova_rede_btn fas fa-folder" style="background: transparent;border:none;color:orange;"></button>\
                                    </td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.vlan.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" class="edit_vlan fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.vlan.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomevlan="'+response.vlan.nome_vlan+'" class="delete_vlan_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';                             
                        if(!$("#nadaencontrado")==""){
                            $("#nadaencontrado").remove();
                        }
                        tupla = limita0+limita1+limita2+limita3+limita4+limita5;
                        $("#novo").replaceWith(tupla);                                                             
                        
                    }
                    
                }
            });
    
        }); //Fim da adição de registro
    
        //Inicio exibe nova rede do VLAN caso não possua nenhuma
        $('#AddRedeModal').on('shown.bs.modal',function(){
            $(".nome_rede").focus();
        });
        $(document).on('click','.nova_rede_btn',function(e){
            e.preventDefault();
            var link = "{{asset('storage')}}";
            var setoradmin = $(this).data("setoradmin");
            if(setoradmin==1){
            $("#addredeform").trigger('reset');
            $("#AddRedeModal").modal('show');
            $("#add_vlan_id").val($(this).data("id"));
            $("#saveformrede_errList").replaceWith('<ul id="saveformrede_errList"></ul>');
            }else{
                  Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:'ALERTA SETOR DE INFRA!',
                text: "Você não pode registrar REDE. Pois, o seu usuário não pertence ao setor INFRA !",
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
        });
        //Fim exibe nova rede do VLAN caso não possua nenhuma
        //Inicio adiciona nova rede no vlan
        $(document).on('click','.add_rede',function(e){
            e.preventDefault(); 
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $("#imgaddrede");
                loading.show();
            var data = {
                'nome_rede': ($(".nome_rede").val()).trim(),
                'mascara': ($(".mascara").val()).trim(),
                'tipo_rede': ($(".tipo_rede").val()).trim(),
                'vlan_id': $("#add_vlan_id").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }          
            $.ajax({
                url: '/datacenter/adiciona-vlanrede',
                type: 'POST',
                dataType:'json',
                data:data,
                success:function(response){
                    if(response.status==400){
                        $("#saveformrede_errList").replaceWith('<ul id="saveformrede_errList"></ul>');
                        $("#saveformrede_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#saveformrede_errList").append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    }else{
                        $("#saveformrede_errList").replaceWith('<ul id="saveformrede_errList"></ul>');    
                        $("#success_message").replaceWith('<div id="success_message"></div>');                   
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);
                        loading.hide();
    
                        $("#addredeform").trigger('reset');
                        $("#AddRedeModal").modal('hide');
    
                        location.reload();
                    }
                }
            });
        });
        //Fim adiciona nova rede no vlan

//cadastro de senha
        $('#AddSenhaVM').on('shown.bs.modal',function(){
            $(".add_senha").focus();
        });


        $(document).on('click','.cadsenha_btn',function(e){
            e.preventDefault();
            var link = "{{asset('storage')}}";
            var setoradmin = $(this).data("setoradmin");
            var labelHtml = ($(this).data("nomevlan")).trim();
            if(setoradmin==1){
            $("#addformsenha").trigger('reset');
            $("#AddSenhaVLAN").modal('show');
            $("#add_vlansenha_id").val($(this).data("id"));
            $("#nomevlan").replaceWith('<Label id="nomevlan" style="font-style:italic;">'+labelHtml+'</Label>');                        
            $("#saveformsenha_errList").replaceWith('<ul id="saveformsenha_errList"></ul>'); 
            }else{
                 Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:'ALERTA SETOR DE INFRA!',
                text: "Acesso proibido. Pois, o seu usuário não pertence ao setor INFRA !",
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
        });

         $(document).on('click','.add_senhavlan_btn',function(e){
            e.preventDefault();
            $(this).text('Salvando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $("#imgaddsenha");
                loading.show();
            //validade indeterminada
            var id = $("#add_vlansenha_id").val();
            var val_indefinida = 0;
            $("input[name='add_val_indefinida']:checked").each(function(){
                val_indefinida = 1;
            });         

            //array apenas com os checkboxes marcados
            var users = new Array;
            $("input[name='users[]']:checked").each(function(){
                users.push($(this).val());
            });            
            
            var data = {
                'senha':$(".add_senha").val(),
                'validade':formatDate($(".add_validade").val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/storesenhavlan/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $("#saveformsenha_errList").replaceWith('<ul id="saveformsenha_errList"></ul>');
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
                        $("#AddSenhaVLAN").modal('hide');

                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var bloqueia = true;                        
                        if((response.vlan.senha)==""){
                        limita1 = '<button id="botaosenha'+response.vlan.id+'" type="button" data-id="'+response.vlan.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomevlan="'+response.vlan.nome_vlan+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita2 = '<button id="botaosenha'+response.vlan.id+'" type="button" data-id="'+response.vlan.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomevlan="'+response.vlan.nome_vlan+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita3 = '<button id="botaosenha'+response.vlan.id+'" type="button" data-id="'+response.vlan.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomevlan="'+response.vlan.nome_vlan+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }                       

                        var elemento = limita1+limita2+limita3;
                        $("#botaosenha"+id).replaceWith(elemento);

                } 
                }   
            });
    }); 
        //fim cadastro de senha
    ////inicio alteração de senha
    $('#EditSenhaVLAN').on('shown.bs.modal',function(){
        $("#edit_senha").focus();
    });
    $(document).on('click','.senhabloqueada_btn',function(e){
        e.preventDefault();
        var link = "{{asset('storage')}}";
        var opcaosenha = $(this).data("opt");
        var setoradmin = $(this).data("setoradmin");

        if(setoradmin==1){

        if(opcaosenha){
    
        var id = $(this).data("id");
        var labelHtml = ($(this).data("nomevlan")).trim();                   
        $("#editformsenha").trigger('reset');
        $("#EditSenhaVLAN").modal('show');  
        $("#editnomevlan").replaceWith('<Label id="editnomevlan" style="font-style:italic;">'+labelHtml+'</Label>');                    
        $("#edit_vlansenha_id").val(id);  
        $("#updateformsenha_errList").replaceWith('<ul id="updateformsenha_errList"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editsenhavlan/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.vlan.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.vlan.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.vlan.validade);
                    datavalidade = datavalidade.toLocaleDateString("pt-BR");
                     if(datavalidade=="31/12/1969 21:00:00"){
                        datavalidade = "";
                        }  
                    var criador = response.criador;
                        if(!response.criador){
                            criador = "";
                        }
                    var alterador = response.alterador;
                        if(!response.alterador){
                            alterador = "";
                        }           
                    if(new Date(response.vlan.validade)<new Date()){
                    $("#senhavencida").replaceWith('<small id="senhavencida" style="color: red">Senha vencida!</small>');
                    }else{
                    $("#senhavencida").replaceWith('<small id="senhavencida" style="color: green">Senha na validade. OK!</small>');  
                    }         
                    $("#edit_validade").val(datavalidade);
                    $("#editdatacriacao").replaceWith('<label  id="editdatacriacao">'+datacriacao+'</label>');
                    $("#editdatamodificacao").replaceWith('<label  id="editdatamodificacao">'+dataatualizacao+'</label>');
                    $("#editcriador").replaceWith('<label  id="editcriador">'+criador+'</label>');
                    $("#editmodificador").replaceWith('<label  id="editmodificador">'+alterador+'</label>');                         
                    $("#edit_senha").val(response.senha);
                    if(response.vlan.val_indefinida){
                      $("input[name='edit_val_indefinida']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinida']").attr('checked',false);  
                    }
                      
                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados 
                        $.each(response.users,function(key,values){                                                                           
                                $("#check"+values.id).attr('checked',true);  //faz a marcação seletiva                         
                        });
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
                title:"Você não tem acesso a esta informação!",
                text: "Peça sua inclusão a um dos usuários sugeridos na dica!",
                imageUrl: link+'./logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'Ok, obrigado!',                
                cancelButtonText: 'Não necessito, obrigado!',
            });      
    }
}else{
     Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:'ALERTA SETOR DE INFRA!',
                text: "Acesso proibido. Pois, o seu usuário não pertence ao setor INFRA !",
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
             
    });
    //fim exibe 
    ///inicio alterar senha
    $(document).on('click','.update_senhavlan_btn',function(e){
            e.preventDefault();
            var loading = $("#imgeditsenha");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $("#edit_vlansenha_id").val();
            var val_indefinida = 0;
            $("input[name='edit_val_indefinida']:checked").each(function(){
                val_indefinida = 1;
            });         

            //array apenas com os checkboxes marcados
            var users = new Array;
            $("input[name='users[]']:checked").each(function(){
                users.push($(this).val());
            });            
            
            var data = {
                'senha':$(".senha").val(),
                'validade':formatDate($(".validade").val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/updatesenhavlan/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $("#updateformsenha_errList").replaceWith('<ul id="updateformsenha_errList"></ul>');
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
    
                        $("#editformsenha").trigger('reset');                    
                        $("#EditSenhaVLAN").modal('hide');

                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var bloqueia = true;                        
                        if((response.vlan.senha)==""){
                        limita1 = '<button id="botaosenha'+response.vlan.id+'" type="button" data-id="'+response.vlan.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomevlan="'+response.vlan.nome_vlan+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita2 = '<button id="botaosenha'+response.vlan.id+'" type="button" data-id="'+response.vlan.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomevlan="'+response.vlan.nome_vlan+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita3 = '<button id="botaosenha'+response.vlan.id+'" type="button" data-id="'+response.vlan.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-nomevlan="'+response.vlan.nome_vlan+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }                       

                        var elemento = limita1+limita2+limita3;
                        $("#botaosenha"+id).replaceWith(elemento);

                } 
                }   
            });
    });         

    ////fim alteração de senha

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
        $(".AddVlanModal_btn").tooltip();       
        $(".list_rede_btn").tooltip();       
        $(".nova_rede_btn").tooltip();       
        $(".pesquisa_btn").tooltip();        
        $(".delete_vlan_btn").tooltip();
        $(".edit_vlan").tooltip();
        $(".voltar_btn").tooltip();        
    });
    ///fim tooltip

    }); ///Fim do escopo do script
    
</script>
@stop

