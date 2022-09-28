@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')
   <!-- início AddAppModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddAppModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar APP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_base_id">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">VM:</label>
                        <label id="add_nome_vm" style="font-style: italic;"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Base:</label>
                        <label id="add_nome_base" style="font-style: italic;"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Base:</label>
                        <select name="add_selbase_id" id="add_selbase_id" class="custom-select">
                            @foreach($bases as $base)
                            <option value="{{$base->id}}">{{$base->nome_base}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Órgão:</label>
                        <select name="add_selorgao_id" id="add_selorgao_id" class="custom-select">
                            @foreach($orgaos as $orgao)
                            <option value="{{$orgao->id}}">{{$orgao->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Projeto:</label>
                        <select name="add_selprojeto_id" id="add_selprojeto_id" class="custom-select">
                            @foreach($projetos as $projeto)
                            <option value="{{$projeto->id}}">{{$projeto->nome_projeto}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nome APP:</label>
                        <input type="text" class="add_nome_app form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Domínio:</label>
                        <input type="text" class="add_dominio form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for=""> 
                        <input type="checkbox" name="add_https" id="add_https"> HTTPS
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_app_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim AddAppModal -->

<!-- início EditAppModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditAppModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar APP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close"> 
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <input type="hidden" id="edit_base_id">
                    <input type="hidden" id="edit_app_id">
                    <ul id="updateform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">VM:</label>
                        <label id="edit_nome_vm" style="font-style: italic;"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Base:</label>
                        <label id="edit_nome_base" style="font-style: italic;"></label>                    
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Base:</label>
                        <select name="edit_selbase_id" id="edit_selbase_id" class="custom-select">
                            @foreach($bases as $base)
                            <option value="{{$base->id}}">{{$base->nome_base}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Órgão:</label>
                        <select name="edit_selorgao_id" id="edit_selorgao_id" class="custom-select">
                            @foreach($orgaos as $orgao)
                            <option value="{{$orgao->id}}">{{$orgao->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Projeto:</label>
                        <select name="edit_selprojeto_id" id="edit_selprojeto_id" class="custom-select">
                            @foreach($projetos as $projeto)
                            <option value="{{$projeto->id}}">{{$projeto->nome_projeto}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nome APP:</label>
                        <input type="text" id="edit_nome_app" class="edit_nome_app form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Domínio:</label>
                        <input type="text" id="edit_dominio" class="edit_dominio form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for=""> 
                        <input type="checkbox" name="edit_https" id="edit_https" value=""> HTTPS
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_app_btn">Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!-- início EditAppModal -->

<!-- início index -->
@auth
@if(!(auth()->user()->inativo))
<div class="container py-5">
    <div id="success_message"></div>    
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenter.app.index',['id'=>$id])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="hidden" id="baseid" value="{{$id}}">
                            <input type="hidden" id="vmnome" value="{{$vm->nome_vm}}"> 
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do APP" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent; border: none;">
                            <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-id="{{$id}}" data-nome_base="{{$bd->nome_base}}" class="AddApp_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent; border: none;">
                            <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-hover">
                <thead class="sidebar-dark-primary" style="color: white">
                    <tr>
                        <th scope="col">APP</th>
                        <th scope="col">DOMÍNIO</th>
                        <th scope="col">HTTPS</th>                       
                        <th scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_app">
                    <tr id="novo" style="display: none;"></tr>
                    @forelse($apps as $app)
                    <tr id="app{{$app->id}}">
                        <th scope="row">{{$app->nome_app}}</th>
                        <td>{{$app->dominio}}</td>
                        @if($app->https)
                        <td id="st_https{{$app->id}}"><button type="button" data-id="{{$app->id}}" data-https="0" class="https_btn fas fa-lock" style="background: transparent; color: green; border: none;"></button></td>
                        @else
                        <td id="st_https{{$app->id}}"><button type="button" data-id="{{$app->id}}" data-https="1" class="https_btn fas fa-lock-open" style="background: transparent; color: red; border: none;"></button></td>
                        @endif                       
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$app->id}}" class="edit_app_btn fas fa-edit" style="background: transparent;border: none;"></button>
                                <button type="button" data-id="{{$app->id}}" data-nomeapp="{{$app->nome_app}}" class="delete_app_btn fas fa-trash" style="background: transparent;border: none;"></button>
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
                {{$apps->links()}}                
            </div>
            <div>
                <button type="button" class="fas fa-arrow-left" style="background: transparent; border: none;" onclick="history.back()"></button>
            </div>
        
</div>
@else 
<i class="fas fa-lock"></i><b class="title"> USUÁRIO INATIVO OU NÃO LIBERADO! CONTACTE O ADMINISTRADOR.</b>
@endif
@endauth
<!-- fim index -->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')
<script type="text/javascript">
    //inicio escopo geral
    $(document).ready(function(){
    
    //início exclui app
    $(document).on('click','.delete_app_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var id = $(this).data("id");
        var nomeapp = ($(this).data("nomeapp")).trim();
        Swal.fire({
            showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomeapp,
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
                    url: '/datacenter/delete-app/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'id':id,
                        '_method': 'DELETE',
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){
                            //remove a tr da table html
                            $('#app'+id).remove();
                            $('#success_message').html('<div id="success_message"></div>');
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                        }
                    } 
                });
            }                                       
        
        });                        
        
        });
    ///fim delete app
    
    //inicio exibe EditAppModal
    $('#EditAppModal').on('shown.bs.modal',function(){
        $('#nome_app').focus();
    });
    $(document).on('click','.edit_app_btn',function(e){
        e.preventDefault();
    
        var id = $(this).data("id");
        $('#editform').trigger('reset');
        $('#EditAppModal').modal('show');    
        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/edit-app/'+id,
            success: function(response){
                if(response.status==200){ 
                    $('#edit_app_id').val(id);               
                    //seta a base
                    var vnomebase = (response.base.nome_base).trim();
                    $('#edit_nome_base').html('<label id="edit_nome_base" style="font-style: italic;">'+vnomebase+'</label>');
                    var vnomevm = (response.vm.nome_vm).trim();
                    $('#edit_nome_vm').html('<label id="edit_nome_vm" style="font-style: italic;">'+vnomevm+'</label>');
                    var opcaobase = response.base.id;
                    $('#edit_selbase_id option')
                    .removeAttr('selected')
                    .filter('[value='+opcaobase+']')
                    .attr('selected',true);
                    //fim seta a base
                    //seta o orgão
                    var opcaoorgao = response.orgao.id;
                    $('#edit_selorgao_id option')
                    .removeAttr('selected')
                    .filter('[value='+opcaoorgao+']')
                    .attr('selected',true);
                    //fim seta o orgao
                    //seta o projeto
                    var opcaoprojeto = response.projeto.id;
                    $('#edit_selprojeto_id option')
                    .removeAttr('selected')
                    .filter('[value='+opcaoprojeto+']')
                    .attr('selected',true);
                    //fim seta o projeto
                    var vnomeapp = (response.app.nome_app).trim();
                    $('#edit_nome_app').val(vnomeapp);
                    var vdominio = (response.app.dominio).trim();
                    $("#edit_dominio").val(vdominio);                               
                    if(response.app.https){
                        $("#edit_https").attr('checked',true);                
                    }else{
                        $("#edit_https").attr('checked',false); 
                    }
                }
            }
        });
    });
    //fim exibe EditAppModal
      //reconfigura o option selected do select html
      $('select[name="edit_selprojeto_id"]').on('change',function(){
            var opteditproj = this.value;
            $('#edit_selprojeto_id option')
            .removeAttr('selected')
            .filter('[value='+opteditproj+']')
            .attr('selected',true);
        }); 
        $('select[name="edit_selbase_id"]').on('change',function(){
            var opteditbase = this.value;
            $('#edit_selbase_id option')
            .removeAttr('selected')
            .filter('[value='+opteditbase+']')
            .attr('selected',true);
        }); 
        $('select[name="edit_selorgao_id"]').on('change',function(){
            var opteditorgao = this.value;
            $('#edit_selorgao_id option')
            .removeAttr('selected')
            .filter('[value='+opteditorgao+']')
            .attr('selected',true);
        }); 
        $('select[name="add_selprojeto_id"]').on('change',function(){
            var optaddproj = this.value;
            $('#add_selprojeto_id option')
            .removeAttr('selected')
            .filter('[value='+optaddproj+']')
            .attr('selected',true);
        }); 
        $('select[name="add_selbase_id"]').on('change',function(){
            var optaddbase = this.value;
            $('#add_selbase_id option')
            .removeAttr('selected')
            .filter('[value='+optaddbase+']')
            .attr('selected',true);
        }); 
        $('select[name="add_selorgao_id"]').on('change',function(){
            var optaddorgao = this.value;
            $('#add_selorgao_id option')
            .removeAttr('selected')
            .filter('[value='+optaddorgao+']')
            .attr('selected',true);
        }); 
        //fim reconfigura o option selected do select html
        //inicio da atualização do registro
        $(document).on('click','.update_app_btn',function(e){
            e.preventDefault();
            $(this).text('Atualizando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $('#edit_app_id').val();
            var upd_projeto_id = $('#edit_selprojeto_id').val();
            var upd_orgao_id = $('#edit_selorgao_id').val();
            var upd_base_id = $('#edit_selbase_id').val();
            var edit_https = false;
            $("input[name='edit_https']:checked").each(function(){
                edit_https = true
            });
            var data = {
                'id':id,
                'orgao_id': upd_orgao_id,
                'projetos_id': upd_projeto_id,
                'bases_id': upd_base_id,
                'nome_app': ($('.edit_nome_app').val()).trim(),
                'dominio': ($('.edit_dominio').val()).trim(),
                'https': edit_https,
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }    
            $.ajax({
                type: 'POST',
                data: data,
                dataType: 'json',
                url: '/datacenter/update-app/'+id,
                success:function(response){
                    if(response.status==400){
                        //erros
                        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });
                        $(this).value("Atualizado");
                    }else if(response.status==404){
                        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');  
                        $('#success_message').html('<div id="success_message"></div>');                      
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        $(this).text('Atualizado');
                    }else{
                        //atualizando a tr da table html
                        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');         
                        $('#success_message').html('<div id="success_message"></div>');               
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $(this).text('Atualizado');
                        $('#editform').trigger('reset');
                        $('#EditAppModal').modal('hide');
    
                       
                        var tupla = ""; 
                        var linha1 = "";                    
                        var linha2 = "";
                        var linha3 = "";
                        var linha4 = "";
                        linha1 = '<tr id="app'+response.app.id+'">\
                            <th scope="row">'+response.app.nome_app+'</th>\
                            <td>'+response.app.dominio+'</td>';
                            if(response.app.https){
                               linha2 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-https="0" class="https_btn fas fa-lock" style="background: transparent; color: green; border: none;"></button></td>';
                            }else{
                               linha3 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-https="1" class="https_btn fas fa-lock-open" style="background: transparent; color: red; border: none;"></button></td>';
                            }
                            linha4 = '<td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.app.id+'" class="edit_app_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" class="delete_app_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';   
                        tupla = linha1+linha2+linha3+linha4;          
                        $('#app'+id).replaceWith(tupla);
                    }
                }
            });
        });
        //fim da atualização do registro
        //inicio exibição do form AddAppModal
        $('#AddAppModal').on('shown.bs.modal',function(){
            $('.add_nome_app').focus();
        });
        $(document).on('click','.AddApp_btn',function(e){
            e.preventDefault();
            var labelHtml = ($(this).data("nome_base")).trim();
            var labelHtmlVm = ($('#vmnome').val()).trim(); 
            $('#addform').trigger('reset');
            $('#AddAppModal').modal('show');
            $('#add_base_id').val($(this).data("id"));
            $('#add_nome_base').html('<Label id="add_nome_base" style="font-style:italic;">'+labelHtml+'</Label>');
            $('#add_nome_vm').html('<Label id="add_nome_vm" style="font-style:italic;">'+labelHtmlVm+'</Label>');
            $('#saveform_errList').html('<ul id="saveform_errList"></ul>'); 
        });
        //fim exibição do form AddAppModal
        //inicio do envio novo registro
        $(document).on('click','.add_app_btn',function(e){
            e.preventDefault();
    
            $(this).text('Salvando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var ins_projeto_id = $('#add_selprojeto_id').val();
            var ins_orgao_id = $('#add_selorgao_id').val();
            var ins_base_id = $('#add_selbase_id').val();
            var add_https = false;
            $("input[name='add_https']:checked").each(function(){
                add_https = true
            });
           
            var data = {            
                'orgao_id': ins_orgao_id,
                'projetos_id': ins_projeto_id,
                'bases_id': ins_base_id,
                'nome_app': $('.add_nome_app').val(),
                'dominio': $('.add_dominio').val(),
                'https': add_https,     
                '_method':'PUT',
                '_token': CSRF_TOKEN,       
            };            
    
            $.ajax({
                type: 'POST',
                url: '/datacenter/adiciona-app',
                data: data,
                dataType: 'json',
                success:function(response){
                    //erros
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
                        $('#AddAppModal').modal('hide');
    
                        //inserindo a tr na table html                       
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                        var linha2 = "";
                        var linha3 = "";
                        var linha4 = "";
                       
                        linha0 = '<tr id="novo" style="display:none;"></tr>';
                        linha1 = '<tr id="app'+response.app.id+'">\
                            <th scope="row">'+response.app.nome_app+'</th>\
                            <td>'+response.app.dominio+'</td>';
                            if(response.app.https){
                            linha2 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-https="0" class="https_btn fas fa-lock" style="background: transparent; color: green; border: none;"></button></td>';
                             }else{
                            linha3 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-https="1" class="https_btn fas fa-lock-open" style="background: transparent; color: red; border: none;"></button></td>';
                            }
                            linha4 = '<td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.app.id+'" class="edit_app_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" class="delete_app_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        if(!$('#nadaencontrado').html==""){
                            $('#nadaencontrado').remove();
                        }
                        tupla = linha0+linha1+linha2+linha3+linha4;                           
                        $('#novo').replaceWith(tupla);
                    }
                }
            });        
        });
        //fim do envio novo registro
        //inicio muda o https na lista index
        $(document).on('click','.https_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $(this).data("id");        
            var vhttps = false;
            if($(this).data("https")=="1"){
                vhttps = true;
            }else{
                vhttps = false;
            }
            var data = {
                'https': vhttps,
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }
            $.ajax({
                type:'POST',
                dataType:'json',
                data:data,            
                url:'/datacenter/https-app/'+id,
                success:function(response){
                    if(response.status==200){
                        var limita1 = "";
                        var limita2 = "";
                        if(response.app.https){
                            limita1 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-https="0" class="https_btn fas fa-lock" style="background: transparent; color: green; border: none;"></button></td>';
                        }else{
                            limita2 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-https="1" class="https_btn fas fa-lock-open" style="background: transparent; color: red; border: none;"></button></td>';
                        }
                        var celula = limita1+limita2;
                        $('#st_https'+id).replaceWith(celula);
                    }
                }
            });
    
        });
        //fim muda o https na lista index
    });
    //fim escopo geral
    
    </script>
@stop

