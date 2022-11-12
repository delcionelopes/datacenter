@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--inicio AddHostModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddHostModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Host</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_cluster_id">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Datacenter</label>
                        <input type="text" class="datacenter form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" class="ip form-control" data-mask="099.099.099.099">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Cluster</label>
                        <input type="text" class="cluster form-control" value="{{$cluster->nome_cluster}}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Observações do Host</label>
                        <textarea name="obs_host" cols="30" rows="10" class="obs_host form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_host">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim AddHostModal -->
<!--Inicio EditHostModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditHostModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Host</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_host_id">
                    <input type="hidden" id="edit_cluster_id">
                    <div class="form-group mb-3">
                        <label for="">Datacenter</label>
                        <input type="text" id="edit_datacenter" class="datacenter form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" id="edit_ip" class="ip form-control" data-mask="099.099.099.099">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Cluster</label>
                        <input type="text" id="edit_cluster" class="cluster form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Observações do Host</label>
                        <textarea name="obs_host" id="obs_host" cols="30" rows="10" class="obs_host form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_host">Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim EditHostModal -->

<!-- início AddSenhaHost -->
   <div class="modal fade animate__animated animate__bounce animate__faster" id="AddSenhaHost" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
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
                    <input type="hidden" id="add_hostsenha_id">
                    <ul id="saveformsenha_errList"></ul>   
                    <div class="card">
                    <div class="card-body">         
                     <fieldset>
                    <legend>Dados da Senha</legend>                    
                    <div class="form-group mb-3">
                        <label  for="">Nome HOST:</label>
                        <label  id="nomehost"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Cluster/IP:</label>
                        <label  id="clusterip"></label>
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
                                        <input type="checkbox" id="CheckUser{{$user->id}}" name="users[]" value="{{$user->id}}" class="form-check-input"> {{$user->name}}
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
                <button type="button" class="btn btn-primary add_senhahost_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim AddSenhaHost -->

<!-- início EditSenhaHost -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSenhaHost" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
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
                    <input type="hidden" id="edit_hostsenha_id">
                    <ul id="updateformsenha_errList"></ul>  
                    <div class="card">
                    <div class="card-body"> 
                    <fieldset>
                    <legend>Dados da Senha</legend>                 
                    <div class="form-group mb-3">
                        <label  for="">Nome HOST:</label>
                        <label  id="editnomehost"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Cluster/IP:</label>
                        <label  id="editclusterip"></label>
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
                                        <input type="checkbox" id="check{{$user->id}}" name="users[]" value="{{$user->id}}" class="form-check-input"> {{$user->name}}
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
                <button type="button" class="btn btn-primary update_senhahost_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim EditSenhahost -->

<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container-fluid py-5">
    <div id="success_message"></div>   
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenter.host.index',['id'=>$id])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do host" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background:transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                               <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-id="{{$id}}" class="AddHostModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                               <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-hover">
                <thead class="sidebar-dark-primary" style="color: white">
                    <tr>
                        <th scope="col">HOSTS</th>
                        <th scope="col"><i class="fas fa-key"></i> PASS</th>
                        <th scope="col">AÇÕES</th>                       
                    </tr>                    
                </thead>
                <tbody id="lista_hosts">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($hosts as $host)
                    <tr id="host{{$host->id}}" style="white-space: nowrap;" data-toggle="tooltip" title="IP:{{$host->ip}}">
                        <th scope="row">{{$host->datacenter}}</th>
                         <td id="senha{{$host->id}}">
                            @if(!$host->senha)
                            <button id="botaosenha{{$host->id}}" type="button" data-id="{{$host->id}}" data-nomehost="{{$host->datacenter}}" data-clusterip="{{$host->cluster}}/{{$host->ip}}" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Registrar senha e dar<br>permissões de visualização"></button>
                            @else
                            @if($host->users()->count())                           
                            @foreach($host->users as $user)
                                  @if(($user->id) == (auth()->user()->id))                                  
                                  <button id="botaosenha{{$host->id}}" type="button" data-id="{{$host->id}}" data-nomehost="{{$host->datacenter}}" data-clusterip="{{$host->cluster}}/{{$host->ip}}" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="{{$host->users->implode('name','<br>')}}"></button>
                                  @break
                                  @elseif ($loop->last)
                                  <button id="botaosenha{{$host->id}}" type="button" data-id="{{$host->id}}" data-nomehost="{{$host->datacenter}}" data-clusterip="{{$host->cluster}}/{{$host->ip}}" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="{{$host->users->implode('name','<br>')}}"></button>
                                  @endif                                                        
                            @endforeach                            
                            @endif
                            @endif                                                        
                        </td>                        
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$host->id}}" class="edit_host fas fa-edit" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar HOST"></button>
                                <button type="button" data-id="{{$host->id}}" data-nomedatacenter="{{$host->datacenter}}" class="delete_host_btn fas fa-trash" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir HOST"></button>
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
                {{$hosts->links()}}               
            </div>
            <div>
                <button type="button" class="voltar_btn fas fa-arrow-left" style="background: transparent; border: none; white-space: nowrap;" onclick="history.back()" data-html="true" data-placement="right" data-toggle="popover" title="Voltar para Cluster(s)"></button>
            </div>
        
</div>
@else 
<i class="fas fa-lock"></i><b class="title"> USUÁRIO INATIVO OU NÃO LIBERADO! CONTACTE O ADMINISTRADOR.</b>
@endif
@endauth
<!--End Index -->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){
        //inicio delete host
        $(document).on('click','.delete_host_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var id = $(this).data("id");
            var nomedatacenter = ($(this).data("nomedatacenter")).trim();
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomedatacenter,
                text: "Deseja excluir?",
                imageUrl: '../../logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){                                     
                    $.ajax({
                        url:'/datacenter/delete-host/'+id,
                        type:'POST',                    
                        dataType:'json',
                        data:{
                            'id':id,
                            '_method':'DELETE',
                            '_token':CSRF_TOKEN,
                        },
                        success:function(response){
                            if(response.status==200){
                                //remove a linha tr da table html
                                $('#host'+id).remove();  
                                $('#success_message').html('<div id="success_message"></div>');
                                $('#success_message').addClass('alert alert-success');
                                $('#success_message').text(response.message);
                            }else{               
                                $('#success_message').html('<div id="success_message"></div>');                 
                                $('#success_message').addClass('alert alert-danger');
                                $('#success_message').text(response.message);
                            }
                    } 
                });
            }                                       
        
        });                        
        
        }); 
        //fim delete host
        //Inicio Exibe EditHostModal
        $('#EditHostModal').on('shown.bs.modal',function(){
            $('#edit_datacenter').focus();
        });
    
        $(document).on('click','.edit_host',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");        
            $('#editform').trigger('reset');
            $('#EditHostModal').modal('show');
            $('#updateform_errList').html('<ul id="updateform_errList"></ul>'); 
    
            $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'/datacenter/edit-host/'+id,
                success:function(response){
                    if(response.status==200){        
                        var vdatacenter = (response.host.datacenter).trim();
                        $('#edit_datacenter').val(vdatacenter);
                        var vip = (response.host.ip).trim();
                        $('#edit_ip').val(vip);
                        var vcluster = (response.host.cluster).trim();
                        $('#edit_cluster').val(vcluster);
                        var vobshost = (response.host.obs_host).trim();
                        $('#obs_host').val(vobshost);    
                        $('#edit_host_id').val(response.host.id);
                        $('#edit_cluster_id').val(response.host.cluster_id);
                    }
                }
            });
    
        });
        //Fim Exibe EditHostModal
        //inicio da atualização do host
        $(document).on('click','.update_host',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            $(this).text("Atualizando...");
    
            var id = $('#edit_host_id').val();
    
            var data = {
                'datacenter': ($('#edit_datacenter').val()).trim(),
                'ip': ($('#edit_ip').val()).trim(),
                'cluster': ($('#edit_cluster').val()).trim(),
                'obs_host': ($('#obs_host').val()).trim(),
                'cluster_id':$('#edit_cluster_id').val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }   
            
            $.ajax({
                type:'POST',
                data:data,
                dataType:'json',
                url:'/datacenter/update-host/'+id,
                success:function(response){
                    if(response.status==400){
                        //erros
                        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key, err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });
                        $(this).text("Atualizado");
                    }else if(response.status==404){
                        $("#updateform_errList").html('<ul id="updateform_errList"></ul>');  
                        $('#success_message').html('<div id="success_message"></div>');                      
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        $(this).text("Atualizado");
                    }else{
                        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');     
                        $('#success_message').html('<div id="success_message"></div>');                   
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $(this).text("Atualizado");
    
                        $('editform').trigger('reset');
                        $('#EditHostModal').modal('hide');
    
                        //atualizando a tr da table html 
                        var tupla = ""; 
                        var limita1 = "";                    
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";
                        var limita5 = "";
   
                        var limita1 = '<tr id="host'+response.host.id+'">\
                            <th scope="row">'+response.host.datacenter+'</th>';
                            var bloqueia = true;                        
                            if((response.host.senha)==""){
                            limita2 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                            }else{
                                $.each(response.users,function(key,user_values){
                                    if(user_values.id == response.user.id){                                    
                                        limita3 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                        bloqueia = false;                              
                                    }
                                });                            
                                if(bloqueia){
                                limita4 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                                }
                            }  
                            limita5 = '<td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.host.id+'" class="edit_host fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.host.id+'" data-nomedatacenter="'+response.host.datacenter+'" class="delete_host_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        tupla = limita1+limita2+limita3+limita4+limita5;
                        $("#host"+id).replaceWith(tupla);
                    }
                }
            });
    
        });
        //Fim da atualização do host
        //Exibe form de adição de host
        $('#AddHostModal').on('shown.bs.modal',function(){
            $('.datacenter').focus();
        });
        $(document).on('click','.AddHostModal_btn',function(e){
            e.preventDefault();
            $('#addform').trigger('reset');
            $('#AddHostModal').modal('show');
            $('#add_cluster_id').val($(this).data("id"));
            $('#saveform_errList').html('<ul id="saveform_errList"></ul>'); 
        });
        //fim exibe form de adição de host
        //inicio da adição de host
        $(document).on('click','.add_host',function(e){
            e.preventDefault();  
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");      
            var data = {
                'datacenter': ($('.datacenter').val()).trim(),
                'ip': ($('.ip').val()).trim(),
                'cluster': ($('.cluster').val()).trim(),
                'obs_host': ($('.obs_host').val()).trim(),
                'cluster_id': $('#add_cluster_id').val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }           
            $.ajax({
                url:'/datacenter/adiciona-host',
                type:'POST',
                dataType:'json',
                data: data,
                success:function(response){                
                    if(response.status==400){
                        $('#saveform_errList').html('<ul id="saveform_errList"></ul>');                        
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });                    
                    }else{
                        $('#saveform_errList').html('<ul id="saveform_errList"></ul>');      
                        $('#success_message').html('<div id="success_message"></div>');                  
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
    
                        $('#addform').trigger('reset');
                        $('#AddHostModal').modal('hide');
    
                        //adiciona a linha na tabela html                                       
                        var tupla = "";
                        var limita0 = "";
                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";
                        var limita5 = "";                     

                            limita0 = '<tr id="novo" style="display:none;"></tr>';
                            limita1 = '<tr id="host'+response.host.id+'">\
                            <th scope="row">'+response.host.datacenter+'</th>';
                            var bloqueia = true;                        
                            if((response.host.senha)==""){
                            limita2 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                            }else{
                                $.each(response.users,function(key,user_values){
                                    if(user_values.id == response.user.id){                                    
                                        limita3 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                        bloqueia = false;                              
                                    }
                                });                            
                                if(bloqueia){
                                limita4 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                                }
                            }  
                            limita5 = '<td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.host.id+'" class="edit_host fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.host.id+'" data-nomedatacenter="'+response.host.datacenter+'" class="delete_host_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        if(!$('#nadaencontrado').html==""){
                            $('#nadaencontrado').remove();
                        }
                        tupla = limita0+limita1+limita2+limita3+limita4+limita5;
                        $('#novo').replaceWith(tupla);
                    }
                }
            });
        });
        //Fim adição de host

        //cadastro de senha
        $('#AddSenhaHost').on('shown.bs.modal',function(){
            $('.add_senha').focus();
        });


        $(document).on('click','.cadsenha_btn',function(e){
            e.preventDefault();
            var labelHtml = ($(this).data("nomehost")).trim();            
            var labelclusterip = ($(this).data("clusterip")).trim();            
            $('#addformsenha').trigger('reset');
            $('#AddSenhaHost').modal('show');
            $('#add_hostsenha_id').val($(this).data("id"));
            $('#nomehost').html('<Label id="nomehost" style="font-style:italic;">'+labelHtml+'</Label>');            
            $('#clusterip').html('<Label id="clusterip" style="font-style:italic;">'+labelclusterip+'</Label>');            
            $('#saveformsenha_errList').html('<ul id="saveformsenha_errList"></ul>'); 
        });

         $(document).on('click','.add_senhahost_btn',function(e){
            e.preventDefault();
            $(this).text('Salvando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $('#add_hostsenha_id').val();
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
                'senha':$('.add_senha').val(),
                'validade':formatDate($('.add_validade').val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/storesenhahost/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $('#saveformsenha_errList').html("");
                            $('#saveformsenha_errList').addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $('#saveformsenha_errList').append('<li>'+err_values+'</li>');
                            });
          
                }else{
                        $('#saveformsenha_errList').html('<ul id="saveformsenha_errList"></ul>');     
                        $('#success_message').html('<div id="success_message"></div>');              
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
    
                        $('#addformsenha').trigger('reset');                    
                        $('#AddSenhaHost').modal('hide');

                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var bloqueia = true;                        
                        if((response.host.senha)==""){
                        limita1 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita2 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita3 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }                       

                        var elemento = limita1+limita2+limita3;
                        $('#botaosenha'+id).replaceWith(elemento);

                } 
                }   
            });
    }); 
        //fim cadastro de senha
    ////inicio alteração de senha
    $('#EditSenhaHost').on('shown.bs.modal',function(){
        $('#edit_senha').focus();
    });
    $(document).on('click','.senhabloqueada_btn',function(e){
        e.preventDefault();

        var opcaosenha = $(this).data("opt");

        if(opcaosenha){
    
        var id = $(this).data("id");
        var labelHtml = ($(this).data("nomehost")).trim();            
        var labelclusterip = ($(this).data("clusterip")).trim(); 
        $('#editformsenha').trigger('reset');
        $('#EditSenhaHost').modal('show');  
        $('#editnomehost').html('<Label id="editnomehost" style="font-style:italic;">'+labelHtml+'</Label>');            
        $('#editclusterip').html('<Label id="editclusterip" style="font-style:italic;">'+labelclusterip+'</Label>');     
        $('#edit_hostsenha_id').val(id);  
        $('#updateformsenha_errList').html('<ul id="updateformsenha_errList"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editsenhahost/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.host.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.host.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.host.validade);
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
                    if(new Date(response.host.validade)<new Date()){
                    $('#senhavencida').html('<small id="senhavencida" style="color: red">Senha vencida!</small>');
                    }else{
                    $('#senhavencida').html('<small id="senhavencida" style="color: green">Senha na validade. OK!</small>');  
                    }                
                    $('#edit_validade').val(datavalidade);
                    $('#editdatacriacao').html('<label  id="editdatacriacao">'+datacriacao+'</label>');
                    $('#editdatamodificacao').html('<label  id="editdatamodificacao">'+dataatualizacao+'</label>');
                    $('#editcriador').html('<label  id="editcriador">'+criador+'</label>');
                    $('#editmodificador').html('<label  id="editmodificador">'+alterador+'</label>');                         
                    $('#edit_senha').val(response.senha);
                    if(response.host.val_indefinida){
                      $("input[name='edit_val_indefinida']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinida']").attr('checked',false);  
                    }

                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados ao artigo
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
                imageUrl: '../../logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'Ok, obrigado!',                
                cancelButtonText: 'Não necessito, obrigado!',
            });      
    }
             
    });
    //fim exibe 
    ///inicio alterar senha
    $(document).on('click','.update_senhahost_btn',function(e){
            e.preventDefault();
            $(this).text('Salvando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $('#edit_hostsenha_id').val();
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
                'senha':$('.senha').val(),
                'validade':formatDate($('.validade').val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/updatesenhahost/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $('#updateformsenha_errList').html("");
                            $('#updateformsenha_errList').addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $('#updateformsenha_errList').append('<li>'+err_values+'</li>');
                            });
          
                }else{
                        $('#updateformsenha_errList').html('<ul id="updateformsenha_errList"></ul>');     
                        $('#success_message').html('<div id="success_message"></div>');              
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
    
                        $('#editformsenha').trigger('reset');                    
                        $('#EditSenhaHost').modal('hide');

                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var bloqueia = true;                        
                        if((response.host.senha)==""){
                        limita1 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita2 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita3 = '<button id="botaosenha'+response.host.id+'" type="button" data-id="'+response.host.id+'" data-nomehost="'+response.host.datacenter+'" data-clusterip="'+response.host.cluster+'/'+response.host.ip+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }                       

                        var elemento = limita1+limita2+limita3;
                        $('#botaosenha'+id).replaceWith(elemento);

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
        $('.senhabloqueada_btn').tooltip();       
        $('.cadsenha_btn').tooltip();        
        $('.AddHostModal_btn').tooltip();       
        $('.pesquisa_btn').tooltip();        
        $('.delete_host_btn').tooltip();
        $('.edit_host').tooltip();
        $('.voltar_btn').tooltip();        
    });
    ///fim tooltip


    });
    
</script>
@stop

