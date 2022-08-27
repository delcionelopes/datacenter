@extends('adminlte::page')

@section('title', 'Datacenter')

@section('body')
    <!--inicio AddRedeModal -->
<div class="modal fade" id="AddRedeModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar REDE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_vlan_id">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Nome da REDE</label>
                        <input type="text" class="nome_rede form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Máscara</label>
                        <input type="text" class="mascara form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Tipo de REDE</label>
                        <input type="text" class="tipo_rede form-control">
                    </div>                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_rede">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim AddRedeModal -->
<!--Inicio AddIPModal-->
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
                <form id="addipform" name="addform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_rede_id">
                    <ul id="saveipform_errList"></ul>                    
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" class="ip form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Status</label>
                        <input type="text" class="status form-control">
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
<!--Inicio EditRedeModal -->
<div class="modal fade" id="EditRedeModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar REDE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_rede_id">
                    <input type="hidden" id="edit_vlan_id">
                    <div class="form-group mb-3">
                        <label for="">Nome da REDE</label>
                        <input type="text" id="edit_nome_rede" class="nome_rede form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Máscara</label>
                        <input type="text" id="edit_mascara" class="mascara form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Tipo de REDE</label>
                        <input type="text" id="edit_tipo_rede" class="tipo_rede form-control">
                    </div>                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_rede">Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim EditRedeModal -->
<!--index-->
<div class="container py-5">
    <div id="success_message"></div>   
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenter.rede.index',['id'=>$id])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome da rede" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background:transparent;border: none;">
                               <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-id="{{$id}}" class="AddRedeModal_btn input-group-text border-0" style="background: transparent;border: none;">
                               <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>REDE</th>
                        <th>VLAN</th>
                        <th>CAD IPs</th>
                        <th>CRIADO EM</th>
                        <th>MODIFICADO EM</th> 
                        <th>AÇÕES</th>                       
                    </tr>                    
                </thead>
                <tbody id="lista_redes">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($redes as $rede)
                    <tr id="rede{{$rede->id}}">
                        <td>{{$rede->nome_rede}}</td>
                        <td><a href="{{route('datacenter.vlan.index')}}">{{$vlan->nome_vlan}}</a></td>
                        <td>
                            <div class="btn-group">
                                @if($rede->cadastro_ips->count())
                                <form action="{{route('datacenter.ip.index',['id' => $rede->id])}}" method="get">
                                    <button type="submit" data-id="{{$rede->id}}" class="list_ip_btn fas fa-network-wired" style="background: transparent;border: none;color:green;"> {{$rede->cadastro_ips->count()}}</button>
                                </form>
                                @else
                                <button type="button" data-id="{{$rede->id}}" data-nomerede="{{$rede->nome_rede}}" class="novo_ip_btn fas fa-folder" style="background: transparent;border: none;color: orange;"></button>
                                @endif
                            </div>
                        </td>                        
                        @if(is_null($rede->created_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($rede->created_at))}}</td>
                        @endif
                        @if(is_null($rede->updated_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($rede->updated_at))}}</td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$rede->id}}" class="edit_rede fas fa-edit" style="background: transparent;border: none;"></button>
                                <button type="button" data-id="{{$rede->id}}" data-nomerede="{{$rede->nome_rede}}" class="delete_rede_btn fas fa-trash" style="background: transparent;border: none;"></button>
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
                {{$redes->links()}}
            </div>      
</div>
<!--End Index -->
@stop

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        //inicio delete rede
        $(document).on('click','.delete_rede_btn',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");
            var nomerede = $(this).data("nomerede");
    
            swal({
                title:nomerede,
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
                        url:'/datacenter/delete-rede/'+id,
                        type:'POST',                    
                        dataType:'json',
                        data:{
                            "id":id,
                            "_method":'DELETE',                                                                         
                        },
                        success:function(response){
                            if(response.status==200){
                                //remove a linha tr da table html
                                $('#rede'+id).remove();
                                $('#success_message').addClass('alert alert-success');
                                $('#success_message').text(response.message);
                            }
                        }
                    });
                }
            });
        });
        //fim delete rede
        //Inicio Exibe EditRedeModal
        $('#EditRedeModal').on('shown.bs.modal',function(){
            $('#edit_nome_rede').focus();
        });
    
        $(document).on('click','.edit_rede',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");        
            $('#editform').trigger('reset');
            $('#EditRedeModal').modal('show');
    
            $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'/datacenter/edit-rede/'+id,
                success:function(response){
                    if(response.status==200){                  
                        $('#edit_nome_rede').val(response.rede.nome_rede);
                        $('#edit_mascara').val(response.rede.mascara);
                        $('#edit_tipo_rede').val(response.rede.tipo_rede);                    
                        $('#edit_rede_id').val(response.rede.id);
                        $('#edit_vlan_id').val(response.rede.vlan_id);
                    }
                }
            });
    
        });
        //Fim Exibe EditRedeModal
        //inicio da atualização da rede
        $(document).on('click','.update_rede',function(e){
            e.preventDefault();
            $(this).text("Atualizando...");
    
            var id = $('#edit_rede_id').val();
    
            var data = {
                'nome_rede': $('#edit_nome_rede').val(),
                'mascara': $('#edit_mascara').val(),
                'tipo_rede': $('#edit_tipo_rede').val(),            
                'vlan_id':$('#edit_vlan_id').val(),
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
                url:'/datacenter/update-rede/'+id,
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
                        $('#EditRedeModal').modal('hide');
    
                        //atualizando a tr da table html
                        var datacriacao = new Date(response.rede.created_at).toLocaleString("pt-BR");
                        if(datacriacao=='31/12/1969 21:00:00'){
                            datacriacao = "";
                        }
                        var dataatualizacao = new Date(response.rede.updated_at).toLocaleString("pt-BR");
                        if(dataatualizacao=='31/12/1969 21:00:00'){
                            dataatualizacao = "";
                        }
    
                        var linha = '<tr id="rede'+response.rede.id+'">\
                            <td>'+response.rede.nome_rede+'</td>\
                            <td>'+response.vlan.nome_vlan+'</td>\
                            <td>BTN</td>\
                            <td>'+datacriacao+'</td>\
                            <td>'+dataatualizacao+'</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.rede.id+'" class="edit_rede fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.rede.id+'" data-nomerede="'+response.rede.nome_rede+'" class="delete_rede_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        $("#rede"+id).replaceWith(linha);
                    }
                }
            });
    
        });
        //Fim da atualização da rede
        //Exibe form de adição da rede
        $('#AddRedeModal').on('shown.bs.modal',function(){
            $('.nome_rede').focus();
        });
        $(document).on('click','.AddRedeModal_btn',function(e){
            e.preventDefault();
            $('#addform').trigger('reset');
            $('#AddRedeModal').modal('show');
            $('#add_vlan_id').val($(this).data("id"));
        });
        //fim exibe form de adição da rede
        //inicio da adição da rede
        $(document).on('click','.add_rede',function(e){
            e.preventDefault();        
            var data = {
                'nome_rede': $('.nome_rede').val(),            
                'mascara': $('.mascara').val(),
                'tipo_rede': $('.tipo_rede').val(),
                'vlan_id': $('#add_vlan_id').val(),
            }
            $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url:'/datacenter/adiciona-rede',
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
                        $('#AddRedeModal').modal('hide');                    
                        //adiciona a linha na tabela html
                        var datacriacao = new Date(response.rede.created_at).toLocaleString('pt-BR');
                        if(datacriacao=='31/12/1969 21:00:00'){
                            datacriacao = "";
                        }
                        var dataatualizacao = new Date(response.rede.updated_at).toLocaleString('pt-BR');
                        if(dataatualizacao=='31/12/1969 21:00:00'){
                            dataatualizacao="";
                        }
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="rede'+response.rede.id+'">\
                            <td>'+response.rede.nome_rede+'</td>\
                            <td>'+response.vlan.nome_vlan+'</td>\
                            <td>BTN</td>\
                            <td>'+datacriacao+'</td>\
                            <td>'+dataatualizacao+'</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.rede.id+'" class="edit_rede fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.rede.id+'" data-nomerede="'+response.rede.nome_rede+'" class="delete_rede_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        if(!$('#nadaencontrado').html()==""){
                            $('#nadaencontrado').remove();
                        }
                        tupla = linha0+linha1;
                        $('#novo').replaceWith(tupla);
                    }
                }
            });
        });
        //Fim adição de rede    
    //Exibe form de adição de ip
    $('#AddIPModal').on('shown.bs.modal',function(){
            $('.ip').focus();
        });
        $(document).on('click','.novo_ip_btn',function(e){
            e.preventDefault();
            $('#addipform').trigger('reset');
            $('#AddIPModal').modal('show');
            $('#add_rede_id').val($(this).data("id"));
        });
        //fim exibe form de adição de ip
        //inicio da adição de ip
        $(document).on('click','.add_ip',function(e){
            e.preventDefault();        
            var data = {            
                'ip': $('.ip').val(),
                'status': $('.status').val(),            
                'rede_id': $('#add_rede_id').val(),
            }
            $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url:'/datacenter/adiciona-redeip',
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
    
                        $('#addipform').trigger('reset');
                        $('#AddIPModal').modal('hide');
    
                        location.reload();
                    }
                }
            });
        });
        //Fim adição de ip
    
    });
    
    </script>
@stop

