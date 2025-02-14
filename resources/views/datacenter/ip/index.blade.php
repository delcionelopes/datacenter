@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--Inicio AddIPModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddIPModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar IP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_rede_id">
                    <ul id="saveform_errList"></ul>                    
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" class="ip form-control" data-mask="099.099.099.099">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Status</label>
                        <label for="" style="color: green;"> LIVRE</label>
                    </div>                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_ip"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim AddIPmodal-->
<!--Inicio EditIPModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditIPModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar IP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_rede_id">
                    <input type="hidden" id="edit_ip_id">                    
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" id="edit_ip" class="ip form-control" data-mask="099.099.099.099">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Status</label>
                        <label id="edit_status" class="status"></label>
                    </div>                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_ip"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim EditIPModal-->
<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container-fluid py-5">
    <div id="success_message"></div>   
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenter.ip.ip.index',['id'=>$id])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Busca IP" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background:transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                               <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-id="{{$id}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" class="AddIPModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                               <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-hover">
                <thead class="sidebar-dark-primary" style="color: white">
                    <tr>                        
                        <th scope="col">IP</th>
                        <th scope="col">REDE</th>
                        <th scope="col">STATUS</th>                    
                        <th scope="col">AÇÕES</th>                       
                    </tr>                    
                </thead>
                <tbody id="lista_ips">
                    <tr id="novo" style="display: none;"></tr>    
                    @forelse($cadastroIps as $ip)
                    <tr id="ip{{$ip->id}}">                        
                        <th scope="row">{{$ip->ip}}</th>
                        <td><a href="{{route('datacenter.rede.index',['id' => $vlan_id])}}">{{$ip->rede->nome_rede}}</a></td>
                        @if($ip->status=="OCUPADO")
                        <td id="stipid{{$ip->id}}"><button type="button" data-id="{{$ip->id}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-status="LIVRE" class="status_btn fas fa-lock" style="background: transparent; color: red; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="OCUPADO"></button></td>
                        @else
                        <td id="stipid{{$ip->id}}"><button type="button" data-id="{{$ip->id}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-status="OCUPADO" class="status_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="LIVRE"></button></td>
                        @endif                       
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$ip->id}}" data-admin="{{auth()->user()->admin}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" class="edit_ip_btn fas fa-edit" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar IP"></button>
                                <button type="button" data-id="{{$ip->id}}" data-admin="{{auth()->user()->admin}}" data-setoradmin="{{auth()->user()->setor_idsetor}}" data-enderecoip="{{$ip->ip}}" class="delete_ip_btn fas fa-trash" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir IP"></button>
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
                {{$cadastroIps->links()}}                
            </div>  
            <div>
                <button type="button" class="voltar_btn fas fa-arrow-left" style="background: transparent; border: none; white-space: nowrap;" onclick="history.back()" data-html="true" data-placement="right" data-toggle="popover" title="Voltar para REDE"></button>
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
        //inicio delete ip
        $(document).on('click','.delete_ip_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var id = $(this).data("id");
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");
            var setoradmin = $(this).data("setoradmin");
            var enderecoip = ($(this).data("enderecoip")).trim();
            if((admin)&&(setoradmin==1)){
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:enderecoip,
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
                        url:'/datacenter/ip/delete-ip/'+id,
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
                                $("#ip"+id).remove();
                                $("#success_message").replaceWith('<div id="success_message"></div>');
                                $("#success_message").addClass('alert alert-success');
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
        }); 
        //fim delete ip
        //Inicio Exibe EditIPModal
        $('#EditIPModal').on('shown.bs.modal',function(){
            $("#edit_ip").focus();
        });
    
        $(document).on('click','.edit_ip_btn',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");
            var link = "{{asset('storage')}}";
            var admin = $(this).data("admin");
            var setoradmin = $(this).data("setoradmin");
            if((admin)&&(setoradmin==1)){
            $("#editform").trigger('reset');
            $("#EditIPModal").modal('show');
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');   
    
            $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'/datacenter/ip/edit-ip/'+id,
                success:function(response){
                    if(response.status==200){                        
                        if(response.cadastroIp.status=="OCUPADO"){
                            var corstatus = 'style="color:red;"';                        
                        }else{
                            var corstatus = 'style="color:green;"';                        
                        }
                        var vstatus = (response.cadastroIp.status).trim();
                        $("#edit_status").replaceWith('<label id="edit_status" class="status"'+corstatus+'>'+vstatus+'</label>');   
                        var vip = (response.cadastroIp.ip).trim();
                        $("#edit_ip").val(vip);                                        
                        $("#edit_rede_id").val(response.cadastroIp.rede_id);
                        $("#edit_ip_id").val(response.cadastroIp.id);
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
        });
        //Fim Exibe EditIPModal
        //inicio da atualização do ip
        $(document).on('click','.update_ip',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var loading = $("#imgedit");
                loading.show();
    
            var id = $("#edit_ip_id").val();
    
            var meulink = "{{route('datacenter.rede.index',['id' => $vlan_id])}}";
    
            var data = {            
                'ip': ($("#edit_ip").val()).trim(),            
                'rede_id':$("#edit_rede_id").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }    
            
            $.ajax({
                type:'POST',
                data:data,
                dataType:'json',
                url:'/datacenter/ip/update-ip/'+id,
                success:function(response){
                    if(response.status==400){
                        //erros
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                        $("#updateform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key, err_values){
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
    
                        $("editform").trigger('reset');
                        $("#EditIPModal").modal('hide');
    
                        //atualizando a tr da table html
                      
                        var linha0 = "";
                        var linha1 = "";
                        var linha2 = "";
                        var linha3 = "";
                        var linha4 = "";
                            linha1 = '<tr id="ip'+response.cadastroIp.id+'">\
                            <td>'+response.cadastroIp.ip+'</td>\
                            <td>'+'<a href="'+meulink+'">'+response.rede.nome_rede+'</a></td>';
                            if(response.cadastroIp.status=="OCUPADO"){
                            linha2 ='<td id="stipid'+response.cadastroIp.id+'"><button type="button" data-id="'+response.cadastroIp.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-status="LIVRE" class="status_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button></td>';
                            }else{
                            linha3 ='<td id="stipid'+response.cadastroIp.id+'"><button type="button" data-id="'+response.cadastroIp.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-status="OCUPADO" class="status_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button></td>';
                            }                    
                           
                            linha4 = '<td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.cadastroIp.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" class="edit_ip_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.cadastroIp.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-enderecoip="'+response.cadastroIp.ip+'" class="delete_ip_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        linha0 = linha1+linha2+linha3+linha4;
                        $("#ip"+id).replaceWith(linha0);
                    }
                }
            });
    
        });
        //Fim da atualização do ip
        //Exibe form de adição de ip
        $('#AddIPModal').on('shown.bs.modal',function(){
            $(".ip").focus();
        });
        $(document).on('click','.AddIPModal_btn',function(e){
            e.preventDefault();
            var link = "{{asset('storage')}}";
            var setoradmin = $(this).data("setoradmin");
            if(setoradmin==1){
            $("#addform").trigger('reset');
            $("#AddIPModal").modal('show');
            $("#add_rede_id").val($(this).data("id"));
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>'); 
            }else{
                Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:"ALERTA SETOR DE INFRA!",
                text: "Você não tem permissão para registrar um IP. Pois, o seu usuário não pertence ao setor INFRA !",
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
        //fim exibe form de adição de ip
        //inicio da adição de ip
        $(document).on('click','.add_ip',function(e){            
            e.preventDefault();        
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var loading = $("#imgadd");
                loading.show();
            var meulink = "{{route('datacenter.rede.rede.index',['id' => $vlan_id])}}";
            var data = {            
                'ip': ($(".ip").val()).trim(),
                'status': "LIVRE",            
                'rede_id': $("#add_rede_id").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }           
            $.ajax({
                url:'/datacenter/ip/adiciona-ip',
                type:'POST',
                dataType:'json',
                data: data,
                success:function(response){                
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
                        $("#AddIPModal").modal('hide');
    
                        //adiciona a linha na tabela html
                                        
                        var linhaalfa = "";
                        var linha0 = "";
                        var linha1 = "";
                        var linha2 = "";
                        var linha3 = "";
                        var linha4 = "";
                            linhaalfa = '<tr id="novo" style="display: none;"></tr>';
                            linha1 = '<tr id="ip'+response.cadastroIp.id+'">\
                            <th scope="row">'+response.cadastroIp.ip+'</th>\
                            <td>'+'<a href="'+meulink+'">'+response.rede.nome_rede+'</a></td>';
                            if(response.cadastroIp.status=="OCUPADO"){
                            linha2 ='<td id="stipid'+response.cadastroIp.id+'"><button type="button" data-id="'+response.cadastroIp.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-status="LIVRE" class="status_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button></td>';
                            }else{
                            linha3 ='<td id="stipid'+response.cadastroIp.id+'"><button type="button" data-id="'+response.cadastroIp.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-status="OCUPADO" class="status_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button></td>';
                            }                            
                            linha4 = '<td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.cadastroIp.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" class="edit_ip_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.cadastroIp.id+'" data-admin="'+response.user.admin+'" data-setoradmin="'+response.user.setor_idsetor+'" data-enderecoip="'+response.cadastroIp.ip+'" class="delete_ip_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        if(!$("#nadaencontrado").html==""){
                            $("#nadaencontrado").remove();
                        }
                        linha0 = linhaalfa+linha1+linha2+linha3+linha4;                    
                        $("#novo").replaceWith(linha0);
                    }
                }
            });
        });
        //Fim adição de ip
        //inicio muda o status do ip
        $(document).on('click','.status_btn',function(e){
            e.preventDefault();            
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var id = $(this).data("id");
            var link = "{{asset('storage')}}";
            var setoradmin = $(this).data("setoradmin");
            var vstatus = ($(this).data("status")).trim();
            if(setoradmin==1){
            var data = {
                'pstatus': vstatus,
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }   
           
            $.ajax({
                type:'POST',
                dataType:'json',
                data:data,            
                url:'/datacenter/ip/status-ip/'+id,
                success:function(response){
                    if(response.status==200){
                        var limita1 = "";
                        var limita2 = "";
                        if(response.ip.status=="OCUPADO"){
                            limita1 = '<td id="stipid'+response.ip.id+'"><button type="button" data-id="'+response.ip.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-status="LIVRE" class="status_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button></td>';
                        }else{
                            limita2 = '<td id="stipid'+response.ip.id+'"><button type="button" data-id="'+response.ip.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-status="OCUPADO" class="status_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button></td>';
                        }
                        var celula = limita1+limita2;
                        $("#stipid"+id).replaceWith(celula);
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
                text: "Você não tem permissão para esta operação. Pois, o seu usuário não pertence ao setor INFRA !",
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
        //fim muda o status do ip
            ///tooltip
    $(function(){             
        $(".status_btn").tooltip();
        $(".AddIPModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_ip_btn").tooltip();
        $(".edit_ip_btn").tooltip();
        $(".voltar_btn").tooltip();
    });
    ///fim tooltip


    });
    
</script>
@stop

