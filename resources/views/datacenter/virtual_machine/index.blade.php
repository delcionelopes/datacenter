@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')
<!--Inicio AddVirtualMachineModal-->
<div class="modal fade" id="AddVirtualMachineModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Virtual Machine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_cluster_id">
                    <ul id="saveform_errList"></ul>                    
                    <div class="form-group mb-3">
                        <label for="">Projeto</label>
                        <select name="projeto_id" id="projeto_id" class="custom-select">
                            @foreach($projetos as $projeto)
                            <option value="{{$projeto->id}}">{{$projeto->nome_projeto}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Cluster:</label>
                        <label for="" id="nome_cluster" style="font-style:italic;">{{$cluster->nome_cluster}}</label>
                    </div>             
                    <div class="form-group mb-3">
                        <label for="">Orgão</label>
                        <select name="orgao_id" id="orgao_id" class="custom-select">
                            @foreach($orgaos as $orgao)                            
                                <option value="{{$orgao->id}}">{{$orgao->nome}}</option>
                            @endforeach                                
                        </select>
                    </div>       
                    <div class="form-group mb-3">
                        <label for="">Ambiente</label>
                        <select name="ambiente_id" id="ambiente_id" class="custom-select">
                            @foreach($ambientes as $ambiente)
                            <option value="{{$ambiente->id}}">{{$ambiente->nome_ambiente}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nome da VM</label>
                        <input type="text" class="nome_vm form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">CPU</label>
                        <input type="text" class="cpu form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Memória</label>
                        <input type="text" class="memoria form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Disco</label>
                        <input type="text" class="disco form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" class="ip form-control" data-mask="099.099.099.099">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Resource Pool</label>
                        <input type="text" class="resource_pool form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Sistema Operacional</label>
                        <input type="text" class="sistema_operacional form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Gatway</label>
                        <input type="text" class="gatway form-control">
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
                <button type="button" class="btn btn-primary add_virtualmachine">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim AddVirtualMachineModal-->

<!--inicio AddBaseModal -->
<div class="modal fade" id="AddBaseModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Base de dados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addbaseform" name="addbaseform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_vm_id">
                    <ul id="saveformbase_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Virtual Machine:</label>
                        <Label id="label_nome_vm" style="font-style:italic;"></Label>
                    </div> 
                    <div class="form-group mb-3">
                        <label for="">Projeto</label>
                        <select name="baseprojeto_id" id="baseprojeto_id" class="custom-select">
                            @foreach($projetos as $projeto)
                            <option value="{{$projeto->id}}">{{$projeto->nome_projeto}}</option>
                            @endforeach
                        </select>
                    </div>                    
                    <div class="form-group mb-3">
                        <label for="">Nome da base</label>
                        <input type="text" class="nome_base form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" class="baseip form-control" data-mask="099.099.099.099">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Dono</label>
                        <input type="text" class="dono form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Encoding</label>
                        <input type="text" class="encoding form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_base_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- fim AddBaseModal -->

<!--Inicio EditVirtualMachineModal-->
<div class="modal fade" id="EditVirtualMachineModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Virtual Machine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_vm_id">
                    <input type="hidden" id="edit_cluster_id">
                    <div class="form-group mb-3">
                        <label for="">Projeto</label>
                        <select name="projeto_id" id="projeto_id" class="custom-select">
                            @foreach($projetos as $projeto)
                            <option value="{{$projeto->id}}">{{$projeto->nome_projeto}}</option>
                            @endforeach
                        </select>
                    </div>   
                    <div class="form-group mb-3">
                        <label for="">Cluster:</label>
                        <label for="" id="nome_cluster" style="font-style:italic;">{{$cluster->nome_cluster}}</label>
                    </div>                 
                    <div class="form-group mb-3">
                        <label for="">Orgão</label>
                        <select name="orgao_id" id="orgao_id" class="custom-select">
                            @foreach($orgaos as $orgao)                            
                                <option value="{{$orgao->id}}">{{$orgao->nome}}</option>
                            @endforeach                                
                        </select>
                    </div>       
                    <div class="form-group mb-3">
                        <label for="">Ambiente</label>
                        <select name="ambiente_id" id="ambiente_id" class="custom-select">
                            @foreach($ambientes as $ambiente)
                            <option value="{{$ambiente->id}}">{{$ambiente->nome_ambiente}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nome da VM</label>
                        <input type="text" id="nome_vm" class="nome_vm form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">CPU</label>
                        <input type="text" id="cpu" class="cpu form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Memória</label>
                        <input type="text" id="memoria" class="memoria form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Disco</label>
                        <input type="text" id="disco" class="disco form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" id="ip" class="ip form-control" data-mask="099.099.099.099">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Resource Pool</label>
                        <input type="text" id="resource_pool" class="resource_pool form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Sistema Operacional</label>
                        <input type="text" id="sistema_operacional" class="sistema_operacional form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Gateway</label>
                        <input type="text" id="gatway" class="gatway form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">VLANs</label>
                        <div class="form-group mb3">
                            @foreach($vlans as $vlan)
                            <label>
                                <input type="checkbox" id="check{{$vlan->id}}" name="vlans[]" value="{{$vlan->id}}">{{$vlan->nome_vlan}}
                            </label>
                            @endforeach
                        </div>
                    </div>                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_virtualmachine">Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim EditVMModal-->
<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container py-5">
    <div id="success_message"></div> 
   
            <section class="border p-4 mb-4 d-flex align-items-left">
            <form action="{{route('datacenter.vm.index',['id'=>$id])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="hidden" id="clusterid" value="{{$id}}">
                            <input type="hidden" id="vlanid" name="vlanid" value=""> 
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome da VM" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background:transparent;border: none;">
                               <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-id="{{$id}}" class="AddVMModal_btn input-group-text border-0" style="background: transparent;border: none;">
                               <i class="fas fa-plus"></i>
                            </button>
                            <a href="{{route('datacenter.cluster.index')}}" type="button" data-id="{{$id}}" class="cluster_btn input-group-text border-0" style="background: transparent;border: none;">
                               {{$cluster->nome_cluster}}
                            </a>                            
                        </div>
                    </div>
            </form>    
            </section>
            <table class="table table-hover">
                <thead class="sidebar-dark-primary" style="color: white">
                    <tr>                        
                        <th scope="col">VM</th>
                        <th scope="col">IP</th>                       
                        <th scope="col">VLAN(s)</th>
                        <th scope="col">BASE(s)</th>                                         
                        <th scope="col">AÇÕES</th>                       
                    </tr>                    
                </thead>
                <tbody id="lista_VM">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($virtualmachines as $vm)
                    <tr id="vm{{$vm->id}}">                        
                        <th scope="row">{{$vm->nome_vm}}</th>
                        <td>{{$vm->ip}}</td>                       
                        <td>                            
                        <div class="btn-group">                                
                                <button type="button" class="btn btn-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                vlan(s)<span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown{{$vm->id}}">
                                    @foreach($vm->vlans as $vl)                                                                                                            
                                    <li class="dropdown-item"><a href="{{route('datacenter.vm.index_vlanXvm',['id'=>$id,'vlid'=>$vl->id])}}" class="dropdown-item">{{$vl->nome_vlan}}</a></li>
                                    @endforeach
                                </ul>                                
                        </div>                           
                        </td>
                        <td>
                            <div class="btn-group">
                                @if($vm->bases->count())
                                <form action="{{route('datacenter.base.index',['id' => $vm->id])}}" method="get">
                                    <button type="submit" data-id="{{$vm->id}}" class="list_base_btn fas fa-database" style="background: transparent;border: none; color: green;"> {{$vm->bases->count()}}</button>
                                </form>   
                                @else
                                    <button type="button" data-id="{{$vm->id}}" data-nome_vm="{{$vm->nome_vm}}" class="nova_base_btn fas fa-folder" style="background: transparent;border:none;color: orange;"></button> 
                                @endif                             
                            </div>
                        </td>                       
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$vm->id}}" class="edit_vm_btn fas fa-edit" style="background: transparent;border: none;"></button>
                                <button type="button" data-id="{{$vm->id}}" data-vm="{{$vm->nome_vm}}" class="delete_vm_btn fas fa-trash" style="background: transparent;border: none;"></button>
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
                {{$virtualmachines->links()}}                
            </div>                   
            <div>
                <button type="button" class="fas fa-arrow-left" style="background: transparent; border: none;" onclick="history.back()"></button>
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
        //inicio delete vm
        $(document).on('click','.delete_vm_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var id = $(this).data("id");       
            var nomevm = ($(this).data("vm")).trim();
            Swal.fire({
                title:nomevm,
                text: "Deseja excluir?",
                imageUrl: 'http://redmine.prodap.ap.gov.br/system/rich/rich_files/rich_files/000/000/004/original/logo_prodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){                                
                    $.ajax({
                        url:'/datacenter/delete-vm/'+id,
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
                                $('#vm'+id).remove();
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
        //fim delete vm
        //Inicio Exibe EditVirtualMachineModal
        $('#EditVirtualMachineModal').on('shown.bs.modal',function(){
            $('.nome_vm').focus();
        });
    
        $(document).on('click','.edit_vm_btn',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");        
            $('#editform').trigger('reset');
            $('#EditVirtualMachineModal').modal('show');
            $('#updateform_errList').html('<ul id="updateform_errList"></ul>');
    
            $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'/datacenter/edit-vm/'+id,
                success:function(response){
                    if(response.status==200){                    
                        $('#edit_vm_id').val(response.virtualmachine.id);
                        $('#edit_cluster_id').val(response.virtualmachine.cluster_id);
                        //seta projeto                         
                        if(response.projeto != null){               
                            var opcaoprojeto = response.projeto.id;
                        }else{
                            var opcaoprojeto = response.virtualmachine.projeto_id;
                        }
                        $('#projeto_id option')
                        .removeAttr('selected')
                        .filter('[value='+opcaoprojeto+']')
                        .attr('selected',true);
                        //fim seta projeto
                        //seta orgao                  
                        if(response.orgao != null){               
                            var opcaoorgao = response.orgao.id;
                        }else{
                            var opcaoorgao = response.virtualmachine.orgao_id;
                        }
                        $('#orgao_id option')
                        .removeAttr('selected')
                        .filter('[value='+opcaoorgao+']')
                        .attr('selected',true);
                        //fim seta projeto
                        //seta ambiente                    
                        if(response.ambiente != null){               
                            var opcaoambiente = response.ambiente.id;
                        }else{
                            var opcaoambiente = response.virtualmachine.ambiente_id;
                        }
                        $('#ambiente_id option')
                        .removeAttr('selected')
                        .filter('[value='+opcaoambiente+']')
                        .attr('selected',true);                      
                        //fim seta projeto
                        var vnomevm = (response.virtualmachine.nome_vm).trim();
                        $('.nome_vm').val(vnomevm);
                        var vcpu = (response.virtualmachine.cpu).trim();
                        $('.cpu').val(vcpu);     
                        var vmemoria = (response.virtualmachine.memoria).trim();
                        $('.memoria').val(vmemoria);
                        var vdisco = (response.virtualmachine.disco).trim();
                        $('.disco').val(vdisco);
                        var vip = (response.virtualmachine.ip).trim();
                        $('.ip').val(vip);
                        var vresourcepool = (response.virtualmachine.resource_pool).trim();
                        $('.resource_pool').val(vresourcepool);
                        var vsistemaoperacional = (response.virtualmachine.sistema_operacional).trim();
                        $('.sistema_operacional').val(vsistemaoperacional);
                        var vgatway = (response.virtualmachine.gatway).trim();
                        $('.gatway').val(vgatway);
                        var vnomecluster = (response.virtualmachine.cluster).trim();
                        $('#nome_cluster').val(vnomecluster);
                        //Atribuindo as vlan relacionadas aos checkboxes
                        $("input[name='vlans[]'").attr('checked',false); //desmarca todos
                        //apenas as vlans relacionadas
                        $.each(response.vlans,function(key,values){
                            $("#check"+values.id).attr('checked',true); //marcação seletiva
                        });
                    }
                }
            });
    
        });
        //Fim Exibe EditVirtualMachineModal
        //inicio reconfigura o option selected do select html
        $('select[name="projeto_id"]').on('change',function(){
            var optprojeto = this.value;
            $('#projeto_id option')
            .removeAttr('selected')
            .filter('[value='+optprojeto+']')
            .attr('selected',true);
        });
        $('select[name="orgao_id"]').on('change',function(){
            var optorgao = this.value;
            $('#orgao_id option')
            .removeAttr('selected')
            .filter('[value='+optorgao+']')
            .attr('selected',true);
        });
        $('select[name="ambiente_id"]').on('change',function(){
            var optambiente = this.value;
            $('#ambiente_id option')
            .removeAttr('selected')
            .filter('[value='+optambiente+']')
            .attr('selected',true);
        });    
        //fim reconfigura o option selected do select html
        //inicio da atualização da VirtualMachine
        $(document).on('click','.update_virtualmachine',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            $(this).text("Atualizando...");        
    
            var id = $('#edit_vm_id').val();
            var cluster_id = $('#edit_cluster_id').val();
            var opt_projeto = $('#projeto_id').val();
            var opt_orgao = $('#orgao_id').val();
            var opt_ambiente = $('#ambiente_id').val();
    
            //Array apenas com os checkboxes marcados
            var vlans = new Array;
                $("input[name='vlans[]']:checked").each(function(){
                    vlans.push($(this).val());
                });
    
            var data = {            
                'projeto_id': opt_projeto,
                'orgao_id' : opt_orgao,
                'ambiente_id' : opt_ambiente,
                'cluster_id' : cluster_id,
                'nome_vm': ($('#nome_vm').val()).trim(),            
                'cpu': ($('#cpu').val()).trim(),
                'memoria' : ($('#memoria').val()).trim(),
                'disco' : ($('#disco').val()).trim(),
                'ip' : ($('#ip').val()).trim(),
                'resource_pool' : ($('#resource_pool').val()).trim(),
                'cluster' : ($('#nome_cluster').val()).trim(),
                'gatway' : ($('#gatway').val()).trim(),  
                'sistema_operacional' : ($('#sistema_operacional').val()).trim(),                      
                'vlans': vlans, //Array
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }   
            
            $.ajax({
                type:'POST',
                data:data,
                dataType:'json',
                url:'/datacenter/update-vm/'+id,
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
                        $('#EditVirtualMachineModal').modal('hide');
    
                        //atualizando a tr da table html                                     
    
                        var linha1 = "";                        
                            linha2 = "";
                            linha1 = '<tr id="vm'+response.virtualmachine.id+'">\
                            <th scope="row">'+response.virtualmachine.nome_vm+'</th>\
                            <td>'+response.virtualmachine.ip+'</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" class="btn btn-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
                                        vlan(s)\
                                    </button>\
                                    <ul class="dropdown-menu" id="dropdown'+response.virtualmachine.id+'" role="menu">';
                                        $('#dropdown'+response.virtualmachine.id).html("");
                                        $.each(response.vlans,function(key,vl){   
                                            var ref = response.virtualmachine.cluster_id;
                                            var strref = String(ref);
                                            var num = vl.id;
                                            var strnum = String(num);                                                                                                       
                                            var meulink = ""; 
                                                meulink = "{{route('datacenter.vm.index_vlanXvm',[':id',':vlid'])}}";
                                                meulink = meulink.replace(':id',strref);
                                                meulink = meulink.replace(':vlid',strnum);                                            
                                            $('#dropdown'+response.virtualmachine.id).append('<li data-id="'+vl.id+'" class="dropdown-item"><a href="'+meulink+'" class="dropdown-item">'+vl.nome_vlan+'</a></li>');
                                        });                                 
                                        
                            linha2 = '</ul>\
                                </div>\
                            </td>\
                            <td>'+response.virtualmachine.ambiente.nome_ambiente+'</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.virtualmachine.id+'" class="edit_vm_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.virtualmachine.id+'" data-vm="'+response.virtualmachine.nome_vm+'" class="delete_vm_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        $("#vm"+id).replaceWith(linha1+linha2);
                    }
                }
            });
    
        });
        //Fim da atualização de VirtualMachine
        //Exibe form de adição de VirtualMachine
        $('#AddVirtualMachineModal').on('shown.bs.modal',function(){
            $('.nome_vm').focus();
        });
        $(document).on('click','.AddVMModal_btn',function(e){
            e.preventDefault();
            $('#addform').trigger('reset');
            $('#AddVirtualMachineModal').modal('show');
            $('#add_cluster_id').val($(this).data("id"));
            $('#saveform_errList').html('<ul id="saveform_errList"></ul>');
        });
        //fim exibe form de adição da VirtualMachine
        //Início da adição da VirtualMachine
        $(document).on('click','.add_virtualmachine',function(e){
            e.preventDefault();      
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var vlans = new Array;
            $("input[name='vlans[]']:checked").each(function(){
                vlans.push($(this).val());
            });    
    
            var data = {
                'cluster_id': $('#add_cluster_id').val(),
                'projeto_id': $('.projeto_id').val(),
                'orgao_id': $('.orgao_id').val(),
                'ambiente_id': $('.ambiente_id').val(),
                'nome_vm': ($('.nome_vm').val()).trim(),
                'cpu': ($('.cpu').val()).trim(),
                'memoria': ($('.memoria').val()).trim(),
                'disco': ($('.disco').val()).trim(),
                'ip': ($('.ip').val()).trim(),
                'resource_pool': ($('.resource_pool').val()).trim(),
                'cluster': ($('#nome_cluster').val()).trim(),
                'sistema_operacional': ($('.sistema_operacional').val()).trim(),
                'gatway': ($('.gatway').val()).trim(),            
                'vlans': vlans,
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }    
           
            $.ajax({
                url:'/datacenter/adiciona-vm/',
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(response){
                    if(response.status==400){
                        //erros
                        $('#saveform_errList').html('<ul id="saveform_errList"></ul>');
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key, err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });
                        $(this).text("Adicionado!");
                    }else{
                        //sucesso na operação
                        $('#saveform_errList').html('<ul id="saveform_errList"></ul>');
                        $('#success_message').html('<div id="success_message"></div>');                    
                        $('#success_message').addClass("alert alert-success");
                        $('$success_message').text(response.message);
                        $('#addform').trigger('reset');
                        $('#AddVirtualMachineModal').modal('hide');
                        //inclui uma linha nova na tabela html                                                          
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";                        
                        var linha2 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="vm'+response.virtualmachine.id+'">\
                            <th scope="row">'+response.virtualmachine.nome_vm+'</th>\
                            <td>'+response.virtualmachine.ip+'</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" class="btn btn-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
                                        vlan(s)\
                                    </button>\
                                    <ul class="dropdown-menu" id="dropdown'+response.virtualmachine.id+'" role="menu">';
                                        $('#dropdown'+response.virtualmachine.id).html("");
                                        $.each(response.vlans,function(key,vl){                                                                                                                     
                                            var ref = response.virtualmachine.cluster_id;
                                            var strref = String(ref);
                                            var num = vl.id;
                                            var strnum = String(num);                                                                                                       
                                            var meulink = ""; 
                                                meulink = "{{route('datacenter.vm.index_vlanXvm',[':id',':vlid'])}}";
                                                meulink = meulink.replace(':id',strref);
                                                meulink = meulink.replace(':vlid',strnum);                                            
                                            $('#dropdown'+response.virtualmachine.id).append('<li data-id="'+vl.id+'" class="dropdown-item"><a href="'+meulink+'" class="dropdown-item">'+vl.nome_vlan+'</a></li>');
                                        });                                 
                                        
                            linha2 = '</ul>\
                                </div>\
                            </td>\
                            <td>'+response.virtualmachine.ambiente.nome_ambiente+'</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.virtualmachine.id+'" class="edit_vm_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.virtualmachine.id+'" data-vm="'+response.virtualmachine.nome_vm+'" class="delete_vm_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        if(!$('#nadaencontrado').html()=="")
                        {
                            $('#nadaencontrado').remove();
                        }
                        tupla = linha0+linha1+linha2;
                        $('#novo').replaceWith(tupla);                    
    
                    }
                }
    
            });
        });
        //Fim da adição da VirtualMachine    
        //inicio executa o button dropdown
        $(function(){
        $('.dropdown-toggle').dropdown();
        });    
        //fim executa o button dropdown               
    
    //Inicio exibe nova base de dados caso não possua nenhuma
    $('select[name="baseprojeto_id"]').on('change',function(){
            var optbaseprojeto = this.value;
            $('#baseprojeto_id option')
            .removeAttr('selected')
            .filter('[value='+optbaseprojeto+']')
            .attr('selected',true);
        });
        
    $('#AddBaseModal').on('shown.bs.modal',function(){
            $('.nome_rede').focus();
        });
        $(document).on('click','.nova_base_btn',function(e){
            e.preventDefault();
    
            var labelHtml = ($(this).data("nome_vm")).trim();
    
            $('#addbaseform').trigger('reset');
            $('#AddBaseModal').modal('show');
            $('#add_vm_id').val($(this).data("id"));
            $('#label_nome_vm').html('<Label id="label_nome_vm" style="font-style:italic;">'+labelHtml+'</Label>');
            $('#saveformbase_errList').html('<ul id="saveformbase_errList"></ul>');
    
        });
        //Fim exibe nova base de dados caso não possua nenhuma
        //Inicio adiciona nova base
        $(document).on('click','.add_base_btn',function(e){
            e.preventDefault();   
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var baseoptprojeto = $('#baseprojeto_id').val();
                  
            var data = {
                'nome_base': ($('.nome_base').val()).trim(),
                'projeto_id': baseoptprojeto,
                'ip': ($('.baseip').val()).trim(),
                'dono': ($('.dono').val()).trim(),
                'virtual_machine_id': $('#add_vm_id').val(),
                'encoding': ($('.encoding').val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }
           
            $.ajax({            
                url: '/datacenter/adiciona-basededados',
                type: 'POST',
                dataType:'json',
                data:data,
                success:function(response){
                    if(response.status==400){
                        $('#saveformbase_errList').html('<ul id="saveformbase_errList"></ul>');
                        $('#saveformbase_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveformbase_errList').append('<li>'+err_values+'</li>');
                        });
                    }else{
                        $('#saveformbase_errList').html('<ul id="saveformbase_errList"></ul>');    
                        $('#success_message').html('<div id="success_message"></div>');                  
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
    
                        $('#addbaseform').trigger('reset');
                        $('#AddBaseModal').modal('hide');
    
                        location.reload();
                    }
                }
            });
        });
        //Fim adiciona nova base de dados no VM
    
    });
    
</script>
@stop
