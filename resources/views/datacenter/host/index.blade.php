@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')
    <!--inicio AddHostModal -->
<div class="modal fade" id="AddHostModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
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
                        <input type="text" class="ip form-control">
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
<div class="modal fade" id="EditHostModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
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
                        <input type="text" id="edit_ip" class="ip form-control">
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
<!--index-->
<div class="container py-5">
    <div id="success_message"></div>   
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenter.host.index',['id'=>$id])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do host" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background:transparent;border: none;">
                               <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-id="{{$id}}" class="AddHostModal_btn input-group-text border-0" style="background: transparent;border: none;">
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
                        <th scope="col">IP</th>
                        <th scope="col">CLUSTER</th>                       
                        <th scope="col">AÇÕES</th>                       
                    </tr>                    
                </thead>
                <tbody id="lista_hosts">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($hosts as $host)
                    <tr id="host{{$host->id}}">
                        <th scope="row">{{$host->datacenter}}</th>
                        <td>{{$host->ip}}</td>
                        <td><a href="{{route('datacenter.cluster.index')}}">{{$host->cluster}}</a></td>                       
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$host->id}}" class="edit_host fas fa-edit" style="background: transparent;border: none;"></button>
                                <button type="button" data-id="{{$host->id}}" data-nomedatacenter="{{$host->datacenter}}" class="delete_host_btn fas fa-trash" style="background: transparent;border: none;"></button>
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
                <button type="button" class="fas fa-arrow-left" style="background: transparent; border: none;" onclick="history.back()"></button>
            </div>
        
</div>
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
            var resposta = confirm("Deseja excluir "+nomedatacenter+"?")                     
                if(resposta==true){                               
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
                                $('#success_message').addClass('alert alert-success');
                                $('#success_message').text(response.message);
                            }
                        }
                    });
                }         
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
                        $('#updateform_errList').html("");
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key, err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });
                        $(this).text("Atualizado");
                    }else if(response.status==404){
                        $("#updateform_errList").html("");
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        $(this).text("Atualizado");
                    }else{
                        $('#updateform_errList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $(this).text("Atualizado");
    
                        $('editform').trigger('reset');
                        $('#EditHostModal').modal('hide');
    
                        //atualizando a tr da table html                       
    
                        var linha = '<tr id="host'+response.host.id+'">\
                            <th scope="row">'+response.host.datacenter+'</th>\
                            <td>'+response.host.ip+'</td>\
                            <td>'+response.host.cluster+'</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.host.id+'" class="edit_host fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.host.id+'" data-nomedatacenter="'+response.host.datacenter+'" class="delete_host_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        $("#host"+id).replaceWith(linha);
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
                        $('#saveform_errList').html("");
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });                    
                    }else{
                        $('#saveform_errList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
    
                        $('#addform').trigger('reset');
                        $('#AddHostModal').modal('hide');
    
                        //adiciona a linha na tabela html
                                       
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="host'+response.host.id+'">\
                            <th scope="row">'+response.host.datacenter+'</th>\
                            <td>'+response.host.ip+'</td>\
                            <td>'+response.host.cluster+'</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.host.id+'" class="edit_host fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.host.id+'" data-nomedatacenter="'+response.host.datacenter+'" class="delete_host_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        if(!$('#nadaencontrado').html==""){
                            $('#nadaencontrado').remove();
                        }
                        tupla = linha0+linha1;
                        $('#novo').replaceWith(tupla);
                    }
                }
            });
        });
        //Fim adição de host
    });
    
</script>
@stop

