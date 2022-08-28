@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')
    <!--AddClusterModal-->

<div class="modal fade" id="AddClusterModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Cluster</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="myform" name="myform" class="form-horizontal" role="form"> 
                <ul id="saveform_errList"></ul>                
                <div class="form-group mb-3">
                    <label for="">Nome do Cluster</label>
                    <input type="text" id="nome_cluster" class="nome_cluster form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Total de Memória</label>
                    <input type="text" class="total_memoria form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Total de Processador</label>
                    <input type="text" class="total_processador form-control">
                </div>            
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_cluster">Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddClusterModal-->

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
                    <ul id="saveformHost_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Datacenter</label>
                        <input type="text" id="datacenter" class="datacenter form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" class="ip form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Cluster</label>
                        <input type="text" class="cluster form-control">
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

<!--EditClusterModal-->

<div class="modal fade" id="EditClusterModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Cluster</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="myform" name="myform" class="form-horizontal" role="form">
                <ul id="updateform_errList"></ul>

                <input type="hidden" id="edit_cluster_id">
                <div class="form-group mb-3">
                    <label for="">Nome do Cluster</label>
                    <input type="text" id="edit_nome_cluster" class="nome_cluster form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Total de Memória</label>
                    <input type="text" id="edit_total_memoria" class="total_memoria form-control">
                </div>                
                <div class="form-group mb-3">
                    <label for="">Total de Processador</label>
                    <input type="text" id="edit_total_processador" class="total_processador form-control">
                </div>            
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_cluster">Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!--index-->

<div class="container py-5"> 
    <div id="success_message"></div>   
  
    <section class="border p-4 mb-4 d-flex align-items-left">
    
    <form action="{{route('datacenter.cluster.index')}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do cluster" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                <i class="fas fa-search"></i>
            </button>        
            <button type="button" class="AddClusterModal_btn input-group-text border-0" style="background: transparent;border: none;">
                <i class="fas fa-plus"></i>
            </button>                
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="sidebar-dark-primary" style="color: white">
                            <tr>                                
                                <th scope="col">CLUSTERS</th>
                                <th scope="col">HOSTS</th>
                                <th scope="col">VM</th>
                                <th scope="col">TOTAL DE MEMÓRIA</th>
                                <th scope="col">TOTAL DE PROCESSADOR</th>                              
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_clusters">  
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($clusters as $cluster)   
                            <tr id="cluster{{$cluster->id}}">                                
                                <th scope="row">{{$cluster->nome_cluster}}</th>
                                <td>
                                    <div class="btn-group">                                        
                                        @if($cluster->hosts->count())
                                        <form action="{{route('datacenter.host.index',['id' => $cluster->id])}}" method="get">
                                        <button type="submit" data-id="{{$cluster->id}}" class="list_host_btn fas fa-server" style="background: transparent;border:none;color: green;"> {{$cluster->hosts->count()}}</button>
                                        </form>
                                        @else
                                        <button type="button" data-id="{{$cluster->id}}" data-nomecluster="{{$cluster->nome_cluster}}" class="novo_host_btn fas fa-folder" style="background: transparent;border:none;color: orange;"></button>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">                                        
                                        @if($cluster->virtual_machines->count())
                                        <form action="{{route('datacenter.vm.index',['id' => $cluster->id])}}" method="get">
                                        <button type="submit" data-id="{{$cluster->id}}" class="list_vm_btn fas fa-network-wired" style="background: transparent;border:none;color: green;"> {{$cluster->virtual_machines->count()}}</button>
                                        </form>
                                        @else
                                        <button type="button" data-id="{{$cluster->id}}" data-nomecluster="{{$cluster->nome_cluster}}" class="novo_vm_btn fas fa-folder" style="background: transparent;border:none;color: orange;"></button>
                                        @endif
                                    </div>
                                </td>
                                <td>{{$cluster->total_memoria}}</td>
                                <td>{{$cluster->total_processador}}</td>                               
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <button type="button" data-id="{{$cluster->id}}" class="edit_cluster fas fa-edit" style="background:transparent;border:none;"></button>
                                            <button type="button" data-id="{{$cluster->id}}" data-nomecluster="{{$cluster->nome_cluster}}" class="delete_cluster_btn fas fa-trash" style="background:transparent;border:none;"></button>
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
                    {{$clusters->links()}}
                    </div>  
            </div>     
             
</div> 
<!--End Index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){         
        
    
        $(document).on('click','.delete_cluster_btn',function(e){   ///inicio delete cluster
            e.preventDefault();
    
            var id = $(this).data("id");
            var nomecluster = $(this).data("nomecluster");
    
            swal({
                title:nomecluster,
                text: "Deseja excluir?",
                icon:"warning",
                buttons:true,
                dangerMode:true,
            })                       
            .then(willDelete=>{
                if(willDelete){
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
                
                $.ajax({
                    url: 'delete-cluster/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        "id": id,
                        "_method": 'DELETE',
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente da tabela html
                            $("#cluster"+id).remove();                                                    
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);         
                        }
                    }
                });            
            } 
        });
    
        });  ///fim delete cluster
        $('#EditClusterModal').on('shown.bs.modal',function(){
            $('#edit_nome_cluster').focus();
        });
        $(document).on('click','.edit_cluster',function(e){  //início da exibição do form EditClusterModal de ambiente                
            e.preventDefault();
            
            var id = $(this).data("id");                                   
            $('#myform').trigger('reset');
            $('#EditClusterModal').modal('show');                
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: 'edit-cluster/'+id,                                
                success: function(response){           
                    if(response.status==200){            
                        $('.nome_cluster').val(response.cluster.nome_cluster);
                        $('.total_memoria').val(response.cluster.total_memoria);
                        $('.total_processador').val(response.cluster.total_processador);
                        $('#edit_cluster_id').val(response.cluster.id);                                                                                                       
                    }      
                }
            });
    
        }); //fim da da exibição do form EditClusterModal
    
        $(document).on('click','.update_cluster',function(e){ //inicio da atualização de registro
            e.preventDefault();
    
            $(this).text("Atualizando...");
    
            var id = $('#edit_cluster_id').val();        
    
            var data = {
                'nome_cluster' : $('#edit_nome_cluster').val(),
                'total_memoria': $('#edit_total_memoria').val(),
                'total_processador': $('#edit_total_processador').val(),
            }        
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: 'update-cluster/'+id,         
                success: function(response){                                                    
                    if(response.status==400){
                        //erros
                        $('#updateform_errList').html("");
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });
    
                        $('.update_cluster').text("Atualizado");
    
                    } else if(response.status==404){
                        $('#updateform_errList').html("");
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        $('.update_cluster').text("Atualizado");
    
                    } else {
                        $('#updateform_errList').html("");
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);
                        $('.update_cluster').text("Atualizado");                    
    
                        $('#myform').trigger('reset');
                        $('#EditClusterModal').modal('hide');                  
                        
                        location.reload();
                                    
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro
    
        //exibe form de adição de registro
        $('#AddClusterModal').on('shown.bs.modal',function(){
            $('#nome_cluster').focus();
        });
        $(document).on('click','.AddClusterModal_btn',function(e){  //início da exibição do form AddClusterModal
            e.preventDefault();             
            $('#myform').trigger('reset');        
            $('#AddClusterModal').modal('show');           
        });   
    
        //fim exibe form de adição de registro
    
        $(document).on('click','.add_cluster',function(e){ //início da adição de Registro
            e.preventDefault();
            
            var data = {
                'nome_cluster': $('.nome_cluster').val(),
                'total_memoria': $('.total_memoria').val(),
                'total_processador': $('.total_processador').val(),
            }                               
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
            $.ajax({            
                url: 'adiciona-cluster',
                type: 'POST',
                dataType: 'json',
                data: data,                  
                success: function(response){
                    if(response.status==400){
                        $('#saveform_errList').html("");
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });
                    } else {
                        $('#saveform_errList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
    
                        $('#myform').trigger('reset');                    
                        $('#AddClusterModal').modal('hide');                   
                        
                                         
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="cluster'+response.cluster.id+'">\
                                    <th scope="row">'+response.cluster.nome_cluster+'</th>\
                                    <td>\
                                        <div class="btn-group">\
                                            <button type="button" data-id="'+response.cluster.id+'" class="novo_host_btn fas fa-folder" style="background: transparent;border:none;color: orange;"></button>\
                                        </div>\
                                    </td>\
                                    <td>'+response.cluster.total_memoria+'</td>\
                                    <td>'+response.cluster.total_processador+'</td>\
                                    <td>\
                                            <div class="btn-group">\
                                                <button type="button" data-id="'+response.cluster.id+'" class="edit_cluster fas fa-edit" style="background:transparent;border:none;"></button>\
                                                <button type="button" data-id="'+response.cluster.id+'" data-nomecluster="'+response.cluster.nome_cluster+'" class="delete_cluster_btn fas fa-trash" style="background:transparent;border:none;"></button>\
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
    
        }); //Fim da adição de registro            
    
        ///Inicio Novo Host do cluster caso não possua nenhum
        $('#AddHostModal').on('shown.bs.modal',function(){
            $('#datacenter').focus();
        });
        $(document).on('click','.novo_host_btn',function(e){
            e.preventDefault();        
            $('#addform').trigger('reset');
            $('#AddHostModal').modal('show');                                       
            $('.cluster').val($(this).data("nomecluster"));
            $('#add_cluster_id').val($(this).data("id"));
        });
        //Fim Novo Host do cluster caso não possua nenhum
    
        ///Inicio Adiciona Novo Host do Cluster
        $(document).on('click','.add_host',function(e){                
            e.preventDefault();
            var data = {
                'datacenter': $('.datacenter').val(),
                'ip': $('.ip').val(),
                'cluster': $('.cluster').val(),
                'obs_host': $('.obs_host').val(),
                'cluster_id': $('#add_cluster_id').val(),
            }                
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
            $.ajax({            
                url: 'adiciona-hostcluster',
                type: 'POST',
                dataType: 'json',
                data: data,                  
                success: function(response){
                    if(response.status==400){
                        $('#saveformHost_errList').html("");
                        $('#saveformHost_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveformHost_errList').append('<li>'+err_values+'</li>');
                        });
                    } else {
                        $('#saveformHost_errList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
    
                        $('#addform').trigger('reset');                    
                        $('#AddHostModal').modal('hide');
                        
                        location.reload();
                                   
                    }
                    
                }
            });
        });    
        //Fim Adiciona Novo Host do Cluster
        
    }); ///Fim do escopo do script
    
    </script>
@stop

