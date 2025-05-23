@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--AddClusterModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddClusterModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Cluster</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="addmyform" name="addmyform" class="form-horizontal" role="form"> 
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
                <button type="button" data-color="{{$color}}" class="btn btn-{{$color}} add_cluster"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>

</div> 
<!--End AddClusterModal-->

<!--inicio AddHostModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddHostModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
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
                        <input type="text" class="ip form-control" data-mask="099.099.099.099">
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
                <button type="button" data-color="{{$color}}" class="btn btn-{{$color}} add_host"><img id="imgaddhost" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim AddHostModal -->

<!--Inicio AddVirtualMachineModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddVirtualMachineModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Virtual Machine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="vm_addform" name="vm_addform" class="form-horizontal" role="form">
                    <input type="hidden" id="vm_add_cluster_id">
                    <ul id="vm_saveform_errList"></ul>                    
                    <div class="form-group mb-3">
                        <label for="">Projeto</label>
                        <select name="vm_projeto_id" id="vm_projeto_id" class="custom-select">
                            @foreach($projetos as $projeto)
                            <option value="{{$projeto->id}}">{{$projeto->nome_projeto}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Cluster:</label>
                        <label for="" id="vm_nome_cluster" style="font-style:italic;"></label>
                        <input type="hidden" id="input_nome_cluster">
                    </div>             
                    <div class="form-group mb-3">
                        <label for="">Orgão</label>
                        <select name="vm_orgao_id" id="vm_orgao_id" class="custom-select">
                            @foreach($orgaos as $orgao)                            
                                <option value="{{$orgao->id}}">{{$orgao->nome}}</option>
                            @endforeach                                
                        </select>
                    </div>       
                    <div class="form-group mb-3">
                        <label for="">Ambiente</label>
                        <select name="vm_ambiente_id" id="vm_ambiente_id" class="custom-select">
                            @foreach($ambientes as $ambiente)
                            <option value="{{$ambiente->id}}">{{$ambiente->nome_ambiente}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nome da VM</label>
                        <input type="text" class="vm_nome_vm form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">CPU</label>
                        <input type="text" class="vm_cpu form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Memória</label>
                        <input type="text" class="vm_memoria form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Disco</label>
                        <input type="text" class="vm_disco form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" class="vm_ip form-control" data-mask="099.099.099.099">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Resource Pool</label>
                        <input type="text" class="vm_resource_pool form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Sistema Operacional</label>
                        <input type="text" class="vm_sistema_operacional form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Gatway</label>
                        <input type="text" class="vm_gatway form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">VLANs</label>
                        <div class="form-group mb3">
                            @foreach($vlans as $vlan)
                            <label>
                                <input type="checkbox" name="vlans[]" value="{{$vlan->id}}">{{$vlan->nome_vlan}}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="{{$color}}" class="btn btn-{{$color}} add_virtualmachine"><img id="imgaddvm" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div> 
<!--Fim AddVirtualMachineModal-->

<!--EditClusterModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditClusterModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Cluster</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="editmyform" name="editmyform" class="form-horizontal" role="form">
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
                <button type="button" data-color="{{$color}}" class="btn btn-{{$color}} update_cluster"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!--index-->
@auth
<div class="container-fluid py-5"> 
    <div id="success_message"></div>  
    <section class="border p-4 mb-4 d-flex align-items-left">    
    <form action="{{route('datacenteradmin.cluster.cluster.index',['color'=>$color])}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do cluster" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>        
            <button type="button" class="AddClusterModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                <i class="fas fa-plus"></i>
            </button>                
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                    <thead class="bg-{{$color}}" style="color: white">
                            <tr>                                
                                <th scope="col">CLUSTERS</th>
                                <th scope="col">HOSTS</th>
                                <th scope="col">VM</th>                                
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
                                        @if($cluster->hosts()->count())
                                        <form action="{{route('datacenteradmin.host.host.index',['id' => $cluster->id,'color'=>$color])}}" method="get">
                                        <button type="submit" data-id="{{$cluster->id}}" class="list_host_btn fas fa-server" style="background: transparent;border:none;color: green; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Lista HOSTS"> {{$cluster->hosts->count()}}</button>
                                        </form>
                                        @else
                                        <button type="button" data-id="{{$cluster->id}}" data-nomecluster="{{$cluster->nome_cluster}}" class="novo_host_btn fas fa-folder" style="background: transparent;border:none;color: orange; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Novo HOST"></button>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                     <div class="btn-group">                                        
                                        @if($cluster->virtual_machines()->count())
                                        <form action="{{route('datacenteradmin.vm.vm.index',['id' => $cluster->id,'color'=>$color])}}" method="get">
                                        <button type="submit" data-id="{{$cluster->id}}" class="list_vm_btn fas fa-network-wired" style="background: transparent;border:none;color: green; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Lista VMs"> {{$cluster->virtual_machines->count()}}</button>
                                        </form>
                                        @else
                                        <button type="button" data-id="{{$cluster->id}}" data-nomecluster="{{$cluster->nome_cluster}}" class="novo_vm_btn fas fa-folder" style="background: transparent;border:none;color: orange; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Nova VM"></button>
                                        @endif
                                    </div> 
                                </td>                                                            
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <button type="button" data-color="{{$color}}" data-id="{{$cluster->id}}" data-admin="{{auth()->user()->admin}}" data-nomecluster="{{$cluster->nome_cluster}}" class="edit_cluster fas fa-edit" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar CLUSTER"></button>
                                            <button type="button" data-id="{{$cluster->id}}" data-admin="{{auth()->user()->admin}}" data-nomecluster="{{$cluster->nome_cluster}}" class="delete_cluster_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir CLUSTER"></button>
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
                    {{$clusters->links()}}
                    </div>  
            </div>     
             
</div>
@endauth
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
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $(this).data("id");
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");            
            var nomecluster = $(this).data("nomecluster");
            if(admin){
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomecluster,
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
                    url: '/datacenteradmin/cluster/delete-cluster/'+id,
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
                            $("#cluster"+id).remove();        
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
        
        });  ///fim delete cluster
        $('#EditClusterModal').on('shown.bs.modal',function(){
            $("#edit_nome_cluster").focus();
        });
        $(document).on('click','.edit_cluster',function(e){  //início da exibição do form EditClusterModal de ambiente                
            e.preventDefault();
            
            var id = $(this).data("id");  
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");
            if(admin){
            $("#editmyform").trigger('reset');
            $("#EditClusterModal").modal('show');    
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');             
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/datacenteradmin/cluster/edit-cluster/'+id,                                
                success: function(response){           
                    if(response.status==200){    
                        var vnomecluster = response.cluster.nome_cluster;
                        $(".nome_cluster").val(vnomecluster);
                        var vtotalmemoria = response.cluster.total_memoria;
                        $(".total_memoria").val(vtotalmemoria);
                        var vtotalprocessador = response.cluster.total_processador;
                        $(".total_processador").val(vtotalprocessador);
                        $("#edit_cluster_id").val(response.cluster.id);                                                                                                       
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
    
        }); //fim da da exibição do form EditClusterModal
    
        $(document).on('click','.update_cluster',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $("#imgedit");
                loading.show();
    
            var id = $("#edit_cluster_id").val();        
    
            var data = {
                'nome_cluster' : $("#edit_nome_cluster").val(),
                'total_memoria': $("#edit_total_memoria").val(),
                'total_processador': $("#edit_total_processador").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }    
           
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: '/datacenteradmin/cluster/update-cluster/'+id,         
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
    
                        $("#editmyform").trigger('reset');
                        $("#EditClusterModal").modal('hide');                  
                        
                        location.reload();
                                    
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro
    
        //exibe form de adição de registro
        $('#AddClusterModal').on('shown.bs.modal',function(){
            $("#nome_cluster").focus();
        });
        $(document).on('click','.AddClusterModal_btn',function(e){  //início da exibição do form AddClusterModal
            e.preventDefault();  
            var link = "{{asset('storage')}}";
            
            $("#addmyform").trigger('reset');        
            $("#AddClusterModal").modal('show');           
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');   
            
        });   
    
        //fim exibe form de adição de registro
    
        $(document).on('click','.add_cluster',function(e){ //início da adição de Registro
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $("#imgadd");
                loading.show();
            var strcolor = $(this).data("color");
            var data = {
                'nome_cluster': $(".nome_cluster").val(),
                'total_memoria': $(".total_memoria").val(),
                'total_processador': $(".total_processador").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }           
            $.ajax({            
                url: '/datacenteradmin/cluster/adiciona-cluster',
                type: 'POST',
                dataType: 'json',
                data: data,                  
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
    
                        $("#addmyform").trigger('reset');                    
                        $("#AddClusterModal").modal('hide');                   
                        
                                         
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="cluster'+response.cluster.id+'">\
                                    <th scope="row">'+response.cluster.nome_cluster+'</th>\
                                    <td>\
                                        <div class="btn-group">\
                                            <button type="button" data-color="'+strcolor+'" data-id="'+response.cluster.id+'" class="novo_host_btn fas fa-folder" style="background: transparent;border:none;color: orange;"></button>\
                                        </div>\
                                    </td>\
                                    <td>\
                                    <div class="btn-group">\
                                        <button type="button" data-color="'+strcolor+'" data-id="'+response.cluster.id+'" data-nomecluster="'+response.cluster.nome_cluster+'" class="novo_vm_btn fas fa-folder" style="background: transparent;border:none;color: orange;"></button>\
                                    </div>\
                                </td>\
                                    <td>\
                                            <div class="btn-group">\
                                                <button type="button" data-color="'+strcolor+'" data-id="'+response.cluster.id+'" data-admin="'+response.user.admin+'" data-nomecluster="'+response.cluster.nome_cluster+'" class="edit_cluster fas fa-edit" style="background:transparent;border:none;"></button>\
                                                <button type="button" data-id="'+response.cluster.id+'" data-admin="'+response.user.admin+'" data-nomecluster="'+response.cluster.nome_cluster+'" class="delete_cluster_btn fas fa-trash" style="background:transparent;border:none;"></button>\
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
    
        }); //Fim da adição de registro            
    
        ///Inicio Novo Host do cluster caso não possua nenhum
        $('#AddHostModal').on('shown.bs.modal',function(){
            $("#datacenter").focus();
        });
        $(document).on('click','.novo_host_btn',function(e){
            e.preventDefault();
            var link = "{{asset('storage')}}";
            
            $("#addform").trigger('reset');
            $("#AddHostModal").modal('show');                                       
            $(".cluster").val($(this).data("nomecluster"));
            $("#add_cluster_id").val($(this).data("id"));
            $("#saveformHost_errList").replaceWith('<ul id="saveformHost_errList"></ul>');
            
        });
        //Fim Novo Host do cluster caso não possua nenhum
    
        ///Inicio Adiciona Novo Host do Cluster
        $(document).on('click','.add_host',function(e){                
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $("#imgaddhost");
                loading.show();
            var data = {
                'datacenter': $(".datacenter").val(),
                'ip': $('.ip').val(),
                'cluster': $(".cluster").val(),
                'obs_host': $(".obs_host").val(),
                'cluster_id': $("#add_cluster_id").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }              
           
            $.ajax({            
                url: '/datacenteradmin/cluster/adiciona-hostcluster',
                type: 'POST',
                dataType: 'json',
                data: data,                  
                success: function(response){
                    if(response.status==400){
                        $("#saveformHost_errList").replaceWith('<ul id="saveformHost_errList"></ul>');
                        $("#saveformHost_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#saveformHost_errList").append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    } else {
                        $("#saveformHost_errList").replaceWith('<ul id="saveformHost_errList"></ul>');
                        $("#success_message").replaceWith('<div id="success_message"></div>');                   
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);                                        
                        loading.hide();
    
                        $("#addform").trigger('reset');                    
                        $("#AddHostModal").modal('hide');
                        
                        location.reload();
                                   
                    }
                    
                }
            });
        });    
        //Fim Adiciona Novo Host do Cluster  
        
        //inicio reconfigura o option selected do select html
        $('select[name="vm_projeto_id"]').on('change',function(){
            var optprojeto = this.value;
            $("#vm_projeto_id option")
            .removeAttr('selected')
            .filter('[value='+optprojeto+']')
            .attr('selected',true);
        });
        $('select[name="vm_orgao_id"]').on('change',function(){
            var optorgao = this.value;
            $("#vm_orgao_id option")
            .removeAttr('selected')
            .filter('[value='+optorgao+']')
            .attr('selected',true);
        });
        $('select[name="vm_ambiente_id"]').on('change',function(){
            var optambiente = this.value;
            $("#vm_ambiente_id option")
            .removeAttr('selected')
            .filter('[value='+optambiente+']')
            .attr('selected',true);
        });    
        //fim reconfigura o option selected do select html

        ///Inicio Nova VM do cluster caso não possua nenhuma
        $('#AddVirtualMachineModal').on('shown.bs.modal',function(){
            $(".vm_nome_vm").focus();
        });
        $(document).on('click','.novo_vm_btn',function(e){
            e.preventDefault();
            var labelHtml = $(this).data("nomecluster");
            $("#vm_addform").trigger('reset');
            $("#AddVirtualMachineModal").modal('show');
            $("#vm_add_cluster_id").val($(this).data("id"));
            $("#vm_nome_cluster").replaceWith('<Label id="vm_nome_cluster" style="font-style:italic;">'+labelHtml+'</Label>');
            $("#input_nome_cluster").val($(this).data("nomecluster"));
            $("#vm_saveform_errList").replaceWith('<ul id="vm_saveform_errList"></ul>'); 
           
        });
        ///Fim Nova VM do cluster caso não possua nenhuma
//Início da adição da VirtualMachine
$(document).on('click','.add_virtualmachine',function(e){
            e.preventDefault();      
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var loading = $("#imgaddvm");
                loading.show();
            var vmprojetoid = $("#vm_projeto_id").val();
            var vmorgaoid = $("#vm_orgao_id").val();
            var vmambienteid = $("#vm_ambiente_id").val()

            var vlans = new Array;
            $("input[name='vlans[]']:checked").each(function(){
                vlans.push($(this).val());
            });    
    
            var data = {
                'cluster_id': $("#vm_add_cluster_id").val(),
                'projeto_id': vmprojetoid,
                'orgao_id': vmorgaoid,
                'ambiente_id': vmambienteid,
                'nome_vm': $(".vm_nome_vm").val(),
                'cpu': $(".vm_cpu").val(),
                'memoria': $(".vm_memoria").val(),
                'disco': $(".vm_disco").val(),
                'ip': $(".vm_ip").val(),
                'resource_pool': $(".vm_resource_pool").val(),
                'cluster': $("#input_nome_cluster").val(),
                'sistema_operacional': $(".vm_sistema_operacional").val(),
                'gatway': $(".vm_gatway").val(),
                'vlans': vlans,
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }   
                      
            $.ajax({
                url:'/datacenteradmin/cluster/cluster-adiciona-vm',
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(response){
                    if(response.status==400){
                        //erros
                        $("#vm_saveform_errList").replaceWith('<ul id="vm_saveform_errList"></ul>');
                        $("#vm_saveform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key, err_values){
                            $("#vm_saveform_errList").append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    }else{
                        //sucesso na operação
                        $("#vm_saveform_errList").replaceWith('<ul id="vm_saveform_errList"></ul>'); 
                        $("#success_message").replaceWith('<div id="success_message"></div>');                   
                        $("#success_message").addClass("alert alert-success");
                        $("#success_message").text(response.message);
                        loading.hide();
                        $("#vm_addform").trigger('reset');
                        $("#AddVirtualMachineModal").modal('hide');
                        
                        location.reload();
    
                    }
                }
    
            });
        });
        //Fim da adição da VirtualMachine 

            ///tooltip
    $(function(){      
        $(".list_host_btn").tooltip();       
        $(".novo_host_btn").tooltip();        
        $(".list_vm_btn").tooltip();
        $(".novo_vm_btn").tooltip();
        $(".AddClusterModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_cluster_btn").tooltip();
        $(".edit_cluster").tooltip();        
    });
    ///fim tooltip

        
    }); ///Fim do escopo do script
    
    </script>

@stop

