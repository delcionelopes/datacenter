@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')
  <!--AddVlanModal-->

<div class="modal fade" id="AddVlanModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-primary add_vlan">Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddVlanModal-->

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
                <button type="button" class="btn btn-primary add_rede">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim AddRedeModal -->


<!--EditVlanModal-->

<div class="modal fade" id="EditVlanModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-primary update_vlan">Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim EditVlanModal-->
<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container py-5"> 
    <div id="success_message"></div> 
    <section class="border p-4 mb-4 d-flex align-items-left">    
    <form action="{{route('datacenter.vlan.index')}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome da VLAN" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                <i class="fas fa-search"></i>
            </button>        
            <button type="button" class="AddVlanModal_btn input-group-text border-0" style="background: transparent;border: none;"><i class="fas fa-plus"></i></button>                
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="sidebar-dark-primary" style="color: white">
                            <tr>                                
                                <th scope="col">VLAN</th>
                                <th scope="col">REDES</th>                             
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_vlan">  
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($vlans as $vlan)   
                            <tr id="vlan{{$vlan->id}}">                                
                                <th scope="row">{{$vlan->nome_vlan}}</th>
                                <td>
                                    @if($vlan->redes()->count())
                                    <form action="{{route('datacenter.rede.index',['id' => $vlan->id])}}" method="get">
                                        <button type="submit" data-id="{{$vlan->id}}" class="list_rede_btn fas fa-network-wired" style="background: transparent;border:none;color:green;"> {{$vlan->redes()->count()}}</button>
                                    </form>
                                    @else
                                        <button type="button" data-id="{{$vlan->id}}" class="nova_rede_btn fas fa-folder" style="background: transparent;border:none;color:orange;"></button>
                                    @endif    
                                </td>                               
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <button type="button" data-id="{{$vlan->id}}" class="edit_vlan fas fa-edit" style="background:transparent;border:none"></button>
                                            <button type="button" data-id="{{$vlan->id}}" data-nomevlan="{{$vlan->nome_vlan}}" class="delete_vlan_btn fas fa-trash" style="background:transparent;border:none"></button>
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
            var nomevlan = ($(this).data("nomevlan")).trim();
            Swal.fire({
                title:nomevlan,
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
                    url: 'delete-vlan/'+id,
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
        
        });  ///fim delete vlan
        //início da exibição do form EditVlanModal
        $('#EditVlanModal').on('shown.bs.modal',function(){
            $('#edit_nome_vlan').focus();
        });
        $(document).on('click','.edit_vlan',function(e){  
            e.preventDefault();
            
            var id = $(this).data("id");                                   
            $('editform').trigger('reset');
            $('#EditVlanModal').modal('show');
            $('#updateform_errList').html('<ul id="updateform_errList"></ul>');                   
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: 'edit-vlan/'+id,                                
                success: function(response){           
                    if(response.status==200){            
                        $('#edit_nome_vlan').val((response.vlan.nome_vlan).trim());
                        $('#edit_vlan_id').val(response.vlan.id);                                                                                                       
                    }      
                }
            });
    
        }); //fim da da exibição do form EditVlanModal
    
        $(document).on('click','.update_vlan',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $(this).text("Atualizando...");
    
            var id = $('#edit_vlan_id').val();        
    
            var data = {
                'nome_vlan' : ($('#edit_nome_vlan').val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }

            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: 'update-vlan/'+id,         
                success: function(response){                                                    
                    if(response.status==400){
                        //erros
                        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });
    
                        $('.update_vlan').text("Atualizado");
    
                    } else if(response.status==404){
                        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');    
                        $('#success_message').html('<div id="success_message"></div>');                     
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        $('.update_vlan').text("Atualizado");
    
                    } else {
                        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');        
                        $('#success_message').html('<div id="success_message"></div>');                  
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);
                        $('.update_vlan').text("Atualizado");                    
    
                        $('#editform').trigger('reset');
                        $('#EditVlanModal').modal('hide');                  
                        
                        location.reload();
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro
    
        //exibe form de adição de registro
        $('#AddVlanModal').on('shown.bs.modal',function(){
            $('.nome_vlan').focus();
        });
        $(document).on('click','.AddVlanModal_btn',function(e){  //início da exibição do form AddVlanModal
            e.preventDefault();       
            
            $('#addform').trigger('reset');
            $('#AddVlanModal').modal('show');  
            $('#saveform_errList').html('<ul id="saveform_errList"></ul>');                      
    
        });
    
        //fim exibe form de adição de registro
    
        $(document).on('click','.add_vlan',function(e){ //início da adição de Registro
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');     
            var data = {
                'nome_vlan': ($('.nome_vlan').val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }    
          
            $.ajax({
                type: 'POST',
                url: 'adiciona-vlan',
                data: data,
                dataType: 'json',
                success: function(response){
                    if(response.status==400){
                        $('#saveform_errList').html('<ul id="saveform_errList"></ul>');
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });
                    } else {
                        $('#saveform_errList').html('<ul id="saveform_errList"></ul>');              
                        $('#success_message').html('<div id="success_message"></div>');            
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
    
                        $('#addform').trigger('reset');                    
                        $('#AddVlanModal').modal('hide');
    
                        //adiciona a linha na tabela html
                        
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="ambiente'+response.vlan.id+'">\
                                    <th scope="row">'+response.vlan.nome_vlan+'</th>\
                                    <td>\
                                    <button type="button" data-id="'+response.vlan.id+'" class="nova_rede_btn fas fa-folder" style="background: transparent;border:none;color:orange;"></button>\
                                    </td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.vlan.id+'" class="edit_vlan fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.vlan.id+'" data-nomevlan="'+response.vlan.nome_vlan+'" class="delete_vlan_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';                             
                        if(!$('#nadaencontrado')==""){
                            $('#nadaencontrado').remove();
                        }
                        tupla = linha0+linha1;
                        $("#novo").replaceWith(tupla);                                                             
                        
                    }
                    
                }
            });
    
        }); //Fim da adição de registro
    
        //Inicio exibe nova rede do VLAN caso não possua nenhuma
        $('#AddRedeModal').on('shown.bs.modal',function(){
            $('.nome_rede').focus();
        });
        $(document).on('click','.nova_rede_btn',function(e){
            e.preventDefault();
            $('#addredeform').trigger('reset');
            $('#AddRedeModal').modal('show');
            $('#add_vlan_id').val($(this).data("id"));
            $('#saveformrede_errList').html('<ul id="saveformrede_errList"></ul>');
        });
        //Fim exibe nova rede do VLAN caso não possua nenhuma
        //Inicio adiciona nova rede no vlan
        $(document).on('click','.add_rede',function(e){
            e.preventDefault(); 
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');      
            var data = {
                'nome_rede': ($('.nome_rede').val()).trim(),
                'mascara': ($('.mascara').val()).trim(),
                'tipo_rede': ($('.tipo_rede').val()).trim(),
                'vlan_id': $('#add_vlan_id').val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }          
            $.ajax({
                url: 'adiciona-vlanrede',
                type: 'POST',
                dataType:'json',
                data:data,
                success:function(response){
                    if(response.status==400){
                        $('#saveformrede_errList').html('<ul id="saveformrede_errList"></ul>');
                        $('#saveformrede_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveformrede_errList').append('<li>'+err_values+'</li>');
                        });
                    }else{
                        $('#saveformrede_errList').html('<ul id="saveformrede_errList"></ul>');    
                        $('#success_message').html('<div id="success_message"></div>');                   
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
    
                        $('#addredeform').trigger('reset');
                        $('#AddRedeModal').modal('hide');
    
                        location.reload();
                    }
                }
            });
        });
        //Fim adiciona nova rede no vlan
    }); ///Fim do escopo do script
    
</script>
@stop

