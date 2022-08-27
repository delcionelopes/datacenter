@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')
   <!--Inicion AddIPModal-->
<div class="modal fade" id="AddIPModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
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
                        <input type="text" class="ip form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Status</label>
                        <label for="" style="color: green;"> LIVRE</label>
                    </div>                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_ip">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim AddIPmodal-->
<!--Inicio EditIPModal-->
<div class="modal fade" id="EditIPModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
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
                        <input type="text" id="edit_ip" class="ip form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Status</label>
                        <label id="edit_status" class="status"></label>
                    </div>                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_ip">Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim EditIPModal-->
<!--index-->
<div class="container py-5">
    <div id="success_message"></div>   
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenter.ip.index',['id'=>$id])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Busca IP" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background:transparent;border: none;">
                               <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-id="{{$id}}" class="AddIPModal_btn input-group-text border-0" style="background: transparent;border: none;">
                               <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>                        
                        <th>IP</th>
                        <th>REDE</th>
                        <th>STATUS</th>
                        <th>CRIADO EM</th>
                        <th>MODIFICADO EM</th> 
                        <th>AÇÕES</th>                       
                    </tr>                    
                </thead>
                <tbody id="lista_ips">
                    <tr id="novo" style="display: none;"></tr>    
                    @forelse($cadastroIps as $ip)
                    <tr id="ip{{$ip->id}}">                        
                        <td>{{$ip->ip}}</td>
                        <td><a href="{{route('datacenter.rede.index',['id' => $vlan_id])}}">{{$ip->rede->nome_rede}}</a></td>
                        @if($ip->status=="OCUPADO")
                        <td id="stipid{{$ip->id}}"><button type="button" data-id="{{$ip->id}}" data-status="LIVRE" class="status_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button></td>
                        @else
                        <td id="stipid{{$ip->id}}"><button type="button" data-id="{{$ip->id}}" data-status="OCUPADO" class="status_btn fas fa-check" style="background: transparent; color: green; border: none;"></button></td>
                        @endif                                                
                        @if(is_null($ip->created_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($ip->created_at))}}</td>
                        @endif
                        @if(is_null($ip->updated_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($ip->updated_at))}}</td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$ip->id}}" class="edit_ip_btn fas fa-edit" style="background: transparent;border: none;"></button>
                                <button type="button" data-id="{{$ip->id}}" data-enderecoip="{{$ip->ip}}" class="delete_ip_btn fas fa-trash" style="background: transparent;border: none;"></button>
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
                <button type="button" class="fas fa-arrow-left" style="background: transparent; border: none;" onclick="history.back()"></button>
            </div>
</div>
<!--Fim Index-->
@stop

@section('css')
    <link rel="stylesheet" href="vendor/adminlte/dist/css/adminlte.min.css">
@stop

@section('js')
<script type="text/javascript">

    $(document).ready(function(){
        //inicio delete ip
        $(document).on('click','.delete_ip_btn',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");
            var enderecoip = $(this).data("enderecoip");
    
            swal({
                title:enderecoip,
                text: "Deseja excluir?",
                icon: "warning",
                buttons:true,
                dangerMode:true,
            }).then(willDelete=>{            
                if(willDelete){                   
                    $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                    });                
                    $.ajax({
                        url:'/datacenter/delete-ip/'+id,
                        type:'POST',                    
                        dataType:'json',
                        data:{
                            "id":id,
                            "_method":'DELETE',                                                                         
                        },
                        success:function(response){
                            if(response.status==200){
                                //remove a linha tr da table html
                                $('#ip'+id).remove();
                                $('#success_message').addClass('alert alert-success');
                                $('#success_message').text(response.message);
                            }
                        }
                    });
                }
            });
        });
        //fim delete ip
        //Inicio Exibe EditIPModal
        $('#EditIPModal').on('shown.bs.modal',function(){
            $('#edit_ip').focus();
        });
    
        $(document).on('click','.edit_ip_btn',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");        
            $('#editform').trigger('reset');
            $('#EditIPModal').modal('show');
    
            $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'/datacenter/edit-ip/'+id,
                success:function(response){
                    if(response.status==200){                        
                        if(response.cadastroIp.status=="OCUPADO"){
                            var corstatus = 'style="color:red;"';                        
                        }else{
                            var corstatus = 'style="color:green;"';                        
                        }
                        $('#edit_status').replaceWith('<label id="edit_status" class="status"'+corstatus+'>'+response.cadastroIp.status+'</label>');              
                        $('#edit_ip').val(response.cadastroIp.ip);                                        
                        $('#edit_rede_id').val(response.cadastroIp.rede_id);
                        $('#edit_ip_id').val(response.cadastroIp.id);
                    }
                }
            });
    
        });
        //Fim Exibe EditIPModal
        //inicio da atualização do ip
        $(document).on('click','.update_ip',function(e){
            e.preventDefault();
            $(this).text("Atualizando...");
    
            var id = $('#edit_ip_id').val();
    
            var meulink = "{{route('datacenter.rede.index',['id' => $vlan_id])}}";
    
            var data = {            
                'ip': $('#edit_ip').val(),            
                'rede_id':$('#edit_rede_id').val(),
            }
    
            $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                data:data,
                dataType:'json',
                url:'/datacenter/update-ip/'+id,
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
                        $('#EditIPModal').modal('hide');
    
                        //atualizando a tr da table html
                        var datacriacao = new Date(response.cadastroIp.created_at);
                            datacriacao = datacriacao.toLocaleString("pt-BR");
                        if(datacriacao=='31/12/1969 21:00:00'){
                            datacriacao = "";
                        }
                        var dataatualizacao = new Date(response.cadastroIp.updated_at);
                            dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                        if(dataatualizacao=='31/12/1969 21:00:00'){
                            dataatualizacao = "";                    
                        }                    
                        var linha0 = "";
                        var linha1 = "";
                        var linha2 = "";
                        var linha3 = "";
                        var linha4 = "";
                            linha1 = '<tr id="ip'+response.cadastroIp.id+'">\
                            <td>'+response.cadastroIp.ip+'</td>\
                            <td>'+'<a href="'+meulink+'">'+response.rede.nome_rede+'</a></td>';
                            if(response.cadastroIp.status=="OCUPADO"){
                            linha2 ='<td id="stipid'+response.cadastroIp.id+'"><button type="button" data-id="'+response.cadastroIp.id+'" data-status="LIVRE" class="status_btn fas fa-close" style="background: transparent; color: red; border: none;"></button></td>';
                            }else{
                            linha3 ='<td id="stipid'+response.cadastroIp.id+'"><button type="button" data-id="'+response.cadastroIp.id+'" data-status="OCUPADO" class="status_btn fas fa-checked" style="background: transparent; color: green; border: none;"></button></td>';
                            }                        
                            //<td>'+response.cadastroIp.status+'</td>\
                            linha4 = '<td>'+datacriacao+'</td>\
                            <td>'+dataatualizacao+'</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.cadastroIp.id+'" class="edit_ip_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.cadastroIp.id+'" data-enderecoip="'+response.cadastroIp.ip+'" class="delete_ip_btn fas fa-trash" style="background: transparent;border: none;"></button>\
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
            $('.ip').focus();
        });
        $(document).on('click','.AddIPModal_btn',function(e){
            e.preventDefault();
            $('#addform').trigger('reset');
            $('#AddIPModal').modal('show');
            $('#add_rede_id').val($(this).data("id"));
        });
        //fim exibe form de adição de ip
        //inicio da adição de ip
        $(document).on('click','.add_ip',function(e){
            e.preventDefault();        
            var meulink = "{{route('datacenter.rede.index',['id' => $vlan_id])}}";
            var data = {            
                'ip': $('.ip').val(),
                'status': "LIVRE",            
                'rede_id': $('#add_rede_id').val(),
            }
            $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url:'/datacenter/adiciona-ip',
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
                        $('#AddIPModal').modal('hide');
    
                        //adiciona a linha na tabela html
                        var datacriacao = new Date(response.cadastroIp.created_at);
                            datacriacao = datacriacao.toLocaleString("pt-BR");
                        if(datacriacao=='31/12/1969 21:00:00'){
                            datacriacao = "";
                        }                     
                        var linhaalfa = "";
                        var linha0 = "";
                        var linha1 = "";
                        var linha2 = "";
                        var linha3 = "";
                        var linha4 = "";
                            linhaalfa = '<tr id="novo" style="display: none;"></tr>';
                            linha1 = '<tr id="ip'+response.cadastroIp.id+'">\
                            <td>'+response.cadastroIp.ip+'</td>\
                            <td>'+'<a href="'+meulink+'">'+response.rede.nome_rede+'</a></td>';
                            if(response.cadastroIp.status=="OCUPADO"){
                            linha2 ='<td id="stipid'+response.cadastroIp.id+'"><button type="button" data-id="'+response.cadastroIp.id+'" data-status="LIVRE" class="status_btn fas fa-close" style="background: transparent; color: red; border: none;"></button></td>';
                            }else{
                            linha3 ='<td id="stipid'+response.cadastroIp.id+'"><button type="button" data-id="'+response.cadastroIp.id+'" data-status="OCUPADO" class="status_btn fas fa-check" style="background: transparent; color: green; border: none;"></button></td>';
                            }                        
                            //<td>'+response.cadastroIp.status+'</td>\
                            linha4 = '<td>'+datacriacao+'</td>\
                            <td></td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.cadastroIp.id+'" class="edit_ip_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.cadastroIp.id+'" data-enderecoip="'+response.cadastroIp.ip+'" class="delete_ip_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        if(!$('#nadaencontrado').html==""){
                            $('#nadaencontrado').remove();
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
            var id = $(this).data("id");
            var vstatus = $(this).data("status");        
            var data = {
                'pstatus': vstatus,
            }
    
            $.ajaxSetup({            
                headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                dataType:'json',
                data:data,            
                url:'/datacenter/status-ip/'+id,
                success:function(response){
                    if(response.status==200){
                        var limita1 = "";
                        var limita2 = "";
                        if(response.ip.status=="OCUPADO"){
                            limita1 = '<td id="stipid'+response.ip.id+'"><button type="button" data-id="'+response.ip.id+'" data-status="LIVRE" class="status_btn fas fa-close" style="background: transparent; color: red; border: none;"></button></td>';
                        }else{
                            limita2 = '<td id="stipid'+response.ip.id+'"><button type="button" data-id="'+response.ip.id+'" data-status="OCUPADO" class="status_btn fas fa-check" style="background: transparent; color: green; border: none;"></button></td>';
                        }
                        var celula = limita1+limita2;
                        $('#stipid'+id).replaceWith(celula);
                    }
                }
            });
    
        });
        //fim muda o status do ip
    });
    
    </script>
@stop

