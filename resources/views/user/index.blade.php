@extends('adminlte::page')

@section('title', 'Usuários')

@section('content')
<!--AddUserModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddUserModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Órgão:</label>
                        <select name="add_selorgao_id" id="add_selorgao_id" class="custom-select">
                            @foreach($orgaos as $orgao)
                            <option value="{{$orgao->id}}">{{$orgao->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">CPF</label>
                        <input type="input" class="cpf form-control" data-mask="000.000.000-00" data-mask-reverse="true">
                    </div>                                      
                    <div class="form-group mb-3">
                        <label for="">Matrícula</label>
                        <input type="text" class="matricula form-control">
                    </div> 
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" class="name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">e-Mail</label>
                        <input type="text" class="email form-control">
                    </div>                                        
                    <div class="form-group mb-3">
                        <label for="">Senha</label>
                        <input type="password" class="password form-control">
                    </div>                                        
                    <div class="form-group mb-3">
                        <label for="">
                        <input type="checkbox" id="moderador" name="moderador" class="moderador checkbox">
                        Moderador
                        </label>
                    </div>                   
                     <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <label for="">Foto do perfil</label>                        
                       <span class="btn btn-default fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="addimagem" type="file" name="imagem" accept="image/x-png,image/gif,image/jpeg">
                       </span>                       
                     </div>  
                     <!--arquivo de imagem-->                                                      
                     <div class="form-group mb-3">
                        <label for="">URL Linkedin</label>
                        <input type="text" class="link_instagram form-control">
                    </div>                                   
                    <div class="form-group mb-3">
                        <label for="">URL Facebook</label>
                        <input type="text" class="link_facebook form-control">
                    </div>                                   
                    <div class="form-group mb-3">
                        <label for="">URL Site</label>
                        <input type="text" class="link_site form-control">
                    </div>                                   
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary add_user">Salvar</button>
            </div>
            </form>
            </div>
        </div>

    </div>
</div>

<!--Fim AddUserModal-->
<!--EditUserModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditUserModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editfom" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_user_id">
                    <div class="form-group mb-3">
                        <label for="">Órgão:</label>
                        <select name="edit_selorgao_id" id="edit_selorgao_id" class="custom-select">
                            @foreach($orgaos as $orgao)
                            <option value="{{$orgao->id}}">{{$orgao->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">CPF</label>
                        <input type="input" name="cpf" id="edit_cpf" class="cpf form-control" data-mask="000.000.000-00" data-mask-reverse="true">
                    </div>                                      
                    <div class="form-group mb-3">
                        <label for="">Matrícula</label>
                        <input type="text" id="edit_matricula" class="matricula form-control">
                    </div> 
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" id="edit_name" class="name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">e-Mail</label>
                        <input type="text" id="edit_email" class="email form-control">
                    </div>                    
                    <div class="form-group mb-3">
                        <label for="">Senha</label>
                        <input type="password" id="edit_password" class="password form-control">
                    </div>                                        
                    <div class="form-group mb-3">
                        <label for="">
                        <input type="checkbox" id="edit_moderador" name="moderador" class="moderador checkbox">
                        Moderador
                        </label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">
                        <input type="checkbox" id="edit_inativo" name="inativo" class="inativo checkbox">
                        Inativo
                        </label>
                    </div>                    
                     <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <label for="">Foto do perfil</label>                        
                       <span class="btn btn-default fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="upimagem" type="file" name="imagem" accept="image/x-png,image/gif,image/jpeg">
                       </span>                       
                     </div>  
                     <!--arquivo de imagem--> 
                     <div class="form-group mb-3">
                        <label for="">URL Linkedin</label>
                        <input type="text" id="edit_link_instagram" class="link_instagram form-control">
                    </div>                                   
                    <div class="form-group mb-3">
                        <label for="">URL Facebook</label>
                        <input type="text" id="edit_link_facebook" class="link_facebook form-control">
                    </div>                                   
                    <div class="form-group mb-3">
                        <label for="">URL Site</label>
                        <input type="text" id="edit_link_site" class="link_site form-control">
                    </div>                                   
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary update_user">Atualizar</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!--Fim EditTemaModal-->
<!--Início Index-->
@auth
@if((auth()->user()->moderador)&&(!(auth()->user()->inativo)))
<div class="container py-5">
    <div id="success_message"></div>   
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('admin.user.index')}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do usuário" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                                <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="AddUserModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;">
                                 <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>USUÁRIOS</th>
                        <th>MODERADOR</th>
                        <th>ATIVO</th>                      
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_users">
                    <tr id="novo" style="display: none;"></tr>
                    @forelse($users as $user)
                    <tr id="user{{$user->id}}">
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        @if($user->moderador)
                        <td id="moderador{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-moderador="0" class="moderador_user fas fa-lock" style="background: transparent; color: green; border: none;"></button></td>
                        @else
                        <td id="moderador{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-moderador="1" class="moderador_user fas fa-lock-open" style="background: transparent; color: red; border: none;"></button></td>
                        @endif
                        @if($user->inativo)
                        <td id="inativo{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-inativo="false" class="inativo_user fas fa-lock" style="background: transparent; color: red; border: none;"></button></td>
                        @else
                        <td id="inativo{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-inativo="true" class="inativo_user fas fa-lock-open" style="background: transparent; color: green; border: none;"></button></td>
                        @endif                       
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$user->id}}" class="edit_user_btn fas fa-edit" style="background: transparent;border: none;"></button>
                                <button type="button" data-id="{{$user->id}}" data-nomeusuario="{{$user->name}}" class="delete_user_btn fas fa-trash" style="background: transparent;border: none;"></button>
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
                {{$users->links()}}
            </div>            
      
</div>
@else 
  <i class="fas fa-lock"></i> <b class="title"> VOCÊ NÃO É UM ADMINISTRADOR!</b>
@endif
@endauth
<!--Fim Index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

<script type="text/javascript">

//Início escopo geral
$(document).ready(function(){    
    //inicio delete usuário
    $(document).on('click','.delete_user_btn',function(e){
        e.preventDefault();     
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var id = $(this).data("id");
        var nomeusuario = ($(this).data("nomeusuario")).trim();

        Swal.fire({
            showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomeusuario,
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
                url:'delete-user/'+id,
                type:'POST',
                dataType:'json',
                data:{
                    'id':id,
                    '_method':'DELETE',
                    '_token':CSRF_TOKEN,
                },                
                success:function(response){
                    if(response.status==200){
                        //remove a linha correspondente
                        $("#user"+id).remove();     
                        $('#success_message').html('<div id="success_message"></div>');
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);
                    }
                    } 
                });
            }                                       
        
        });                        
        
        });
    //fim delete usuário
//Início chamada EditUserModal
$('#EditUserModal').on('shown.bs.modal',function(){
        $('.name').focus();
    });
    $(document).on('click','.edit_user_btn',function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $('#editform').trigger('reset');
        $('#EditUserModal').modal('show');
        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');   

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'GET',
            dataType:'json',
            url:'edit-user/'+id,
            success:function(response){
                if(response.status==200){
                    $('#edit_user_id').val(response.user.id);
                    $('.name').val((response.user.name).trim());                   
                    $('.email').val(response.user.email);
                    if(response.user.moderador){
                    $('.moderador').attr('checked',true);
                    }else{
                    $('.moderador').attr('checked',false);
                    }
                    if(response.user.inativo){
                    $('.inativo').attr('checked',true);
                    }else{
                    $('.inativo').attr('checked',false);
                    }                    
                    $('.cpf').val(response.user.cpf);                    
                    $('.matricula').val(response.user.matricula);
                    $('.link_instagram').val(response.user.link_instagram);
                    $('.link_facebook').val(response.user.link_facebook);
                    $('.link_site').val(response.user.link_site);
                    var opcaoorgao = response.user.orgao_id;
                    $('#edit_selorgao_id option')
                    .removeAttr('selected')
                    .filter('[value='+opcaoorgao+']')
                    .attr('selected',true);                                      
                }
            }
        });
    });
    //Fim chamada EditUserModal
    $('select[name="edit_selorgao_id"]').on('change',function(){
            var opteditorgao = this.value;
            $('#edit_selorgao_id option')
            .removeAttr('selected')
            .filter('[value='+opteditorgao+']')
            .attr('selected',true);
        }); 
    $('select[name="add_selorgao_id"]').on('change',function(){
            var optaddorgao = this.value;
            $('#add_selorgao_id option')
            .removeAttr('selected')
            .filter('[value='+optaddorgao+']')
            .attr('selected',true);
        }); 
    //Início processo update do usuário
    $(document).on('click','.update_user',function(e){
        e.preventDefault();
        $(this).text("Atualizando...");
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var upd_orgao_id = $('#edit_selorgao_id').val();
        var moderador = 0;
        var inativo = false;
        $("#edit_moderador:checked").each(function(){moderador = 1;});             
        $("#edit_inativo:checked").each(function(){inativo = true;});                     
        var id = $('#edit_user_id').val();
        var data = new FormData();
            data.append('name',($('#edit_name').val()).trim());            
            data.append('email',$('#edit_email').val());
            data.append('link_instagram',($('#edit_link_instagram').val()).trim());
            data.append('link_facebook',($('#edit_link_facebook').val()).trim());
            data.append('link_site',($('#edit_link_site').val()).trim());
            data.append('password',$('#edit_password').val());
            data.append('moderador',moderador);
            data.append('inativo',inativo),
            data.append('cpf',($('#edit_cpf').val()).trim());
            data.append('matricula',($('#edit_matricula').val()).trim());
            data.append('orgao_id',upd_orgao_id);
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');               
        $.ajax({
            type:'POST',            
            dataType:'json',            
            url:'update-user/'+id,
            data:data,
            cache: false,
            processData: false,
            contentType: false, 
            success:function(response){
                if(response.status==400){
                    //erros
                    $('#updateform_errList').html('<ul id="updateform_errList"></ul>');
                    $('#updateform_errList').addClass('alert alert-danger');
                    $.each(response.errors,function(key,err_values){
                        $('#updateform_errList').append('<li>'+err_values+'</li>');
                    });
                    $(this).text("Atualizado");
                }else if(response.status==404){
                    //Não localizado
                    $('#updateform_errList').html('<ul id="updateform_errList"></ul>');       
                    $('#success_message').html('<div id="success_message"></div>');             
                    $('#success_message').addClass('alert alert-warning');
                    $('#success_message').text(response.message);
                    $(this).text("Atualizado");
                }else{
                    //Êxito na operação
                    $('#updateform_errList').html('<ul id="updateform_errList"></ul>');        
                    $('#success_message').html('<div id="success_message"></div>');            
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $(this).text("Atualizado");
                    $('#editform').trigger('reset');
                    $('#EditUserModal').modal('hide');
                    //montando a <tr> identificada na tabela html                   
                    var limita1 = "";
                    var limita2 = "";
                    var limita3 = "";
                    var limita4 = "";
                    var limita5 = "";
                    var limita6 = "";
                        limita1 = '<tr id="user'+response.user.id+'">\
                                <td>'+response.user.id+'</td>\
                                <td>'+response.user.name+'</td>';
                        if(response.user.moderador==1){
                        limita2 = '<td id="moderador'+response.user.id+'"><button type="button"\
                                   data-id="'+response.user.id+'" \
                                   data-moderador="0" \
                                   class="moderador_user fas fa-lock"\
                                   style="background: transparent; color: green; border: none;">\
                                   </button></td>';
                        }else{
                        limita3 = '<td id="moderador'+response.user.id+'"><button type="button" \
                                   data-id="'+response.user.id+'" \
                                   data-moderador="1" \
                                   class="moderador_user fas fa-lock-open" \
                                   style="background: transparent; color: red; border: none;">\
                                   </button></td>';
                        }
                        if(response.user.inativo){
                        limita4 = '<td id="inativo'+response.user.id+'"><button type="button" \
                                  data-id="'+response.user.id+'" \
                                  data-inativo="false" \
                                  class="inativo_user fas fa-lock" \
                                  style="background: transparent; color: red; border: none;">\
                                  </button></td>';
                        }else{
                        limita5 = '<td id="inativo'+response.user.id+'"><button type="button" \
                                   data-id="'+response.user.id+'" \
                                   data-inativo="true" \
                                   class="inativo_user fas fa-lock-open" \
                                   style="background: transparent; color: green; border: none;">\
                                   </button></td>';
                        }
                        limita6 = '<td><div class="btn-group">\
                                <button type="button" data-id="'+response.user.id+'"\
                                 class="edit_user_btn fas fa-edit"\
                                 style="background:transparent;border:none"></button>\
                                <button type="button" data-id="'+response.user.id+'"\
                                 data-nomeusuario="'+response.user.name+'" \
                                 class="delete_user_btn fas fa-trash" \
                                 style="background:transparent;border:none;"></button>\
                                </div></td>\
                                </tr>';                                             
                    var linha = limita1+limita2+limita3+limita4+limita5+limita6;            
                    $("#user"+id).replaceWith(linha);
                }
            }
        });
    });   
    //Fim processo update do usuario
    //Chamar AddUserModal
    $('#AddTemaModal').on('shown.bs.modal',function(){
        $('.name').focus();
    });
    $(document).on('click','.AddUserModal_btn',function(e){
        e.preventDefault();        
        $('#addform').trigger('reset');
        $('#AddUserModal').modal('show');
        $('#saveform_errList').html('<ul id="saveform_errList"></ul>'); 
    });
    //Fim chamar AddUserModal
    //Enviar usuário para o controller
    $(document).on('click','.add_user',function(e){
        e.preventDefault();
        $(this).text("Salvando...");        
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
        var ins_orgao_id = $('#add_selorgao_id').val();
        var moderador = 0;        
        $("#moderador:checked").each(function(){moderador = 1;});                     
        var data = new FormData();        
            data.append('name',($('.name').val()).trim());
            data.append('email',($('.email').val()).trim());
            data.append('link_instagram',($('.link_instagram').val()).trim());
            data.append('link_facebook',($('.link_facebook').val()).trim());
            data.append('link_site',($('.link_site').val()).trim());
            data.append('password',($('.password').val()).trim());
            data.append('moderador',moderador);
            data.append('cpf',($('.cpf').val()).trim());
            data.append('matricula',($('.matricula').val()).trim());
            data.append('orgao_id',ins_orgao_id);
            data.append('imagem',$('#addimagem')[0].files[0]);
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');
        $.ajax({
            url:'store-user',
            type:'POST',
            dataType:'json',
            data:data,            
            cache: false,
            processData: false,
            contentType: false, 
            success:function(response){
                if(response.status==400){
                    //erros
                    $('#saveform_errList').html('<ul id="saveform_errList"></ul>');
                    $('#saveform_errList').addClass('alert alert-danger');
                    $.each(response.errors,function(key,err_values){
                        $('#saveform_errList').append('<li>'+err_values+'</li>');
                    });
                    $(this).text("Ok");                    
                }else{
                    //sucesso
                    $('#saveform_errList').html('<ul id="saveform_errList"></ul>');          
                    $('#success_message').html('<div id="success_message"></div>');          
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $(this).text("Ok");                    
                    $('#addform').trigger('reset');
                    $('#AddUserModal').modal('hide');
                     //montando a <tr> identificada na tabela html                    
                    var limita0 = "";
                    var limita1 = "";
                    var limita2 = "";
                    var limita3 = "";
                    var limita4 = "";
                    var limita5 = "";
                    var limita6 = "";
                        limita0 = '<tr id="novo" style="display:none;"></tr>';
                        limita1 = '<tr id="user'+response.user.id+'">\
                                <td>'+response.user.id+'</td>\
                                <td>'+response.user.name+'</td>';
                        if(response.user.moderado){
                        limita2 = '<td id="moderador'+response.user.id+'"><button type="button"\
                                   data-id="'+response.user.id+'" \
                                   data-moderador="0" \
                                   class="moderador_user fas fa-lock"\
                                   style="background: transparent; color: green; border: none;">\
                                   </button></td>';
                        }else{
                        limita3 = '<td id="moderador'+response.user.id+'"><button type="button" \
                                   data-id="'+response.user.id+'" \
                                   data-moderador="1" \
                                   class="moderador_user fas fa-lock-open" \
                                   style="background: transparent; color: red; border: none;">\
                                   </button></td>';
                        }
                        if(response.user.inativo){
                        limita4 = '<td id="inativo'+response.user.id+'"><button type="button" \
                                  data-id="'+response.user.id+'" \
                                  data-inativo="false" \
                                  class="inativo_user fas fa-lock" \
                                  style="background: transparent; color: red; border: none;">\
                                  </button></td>';
                        }else{
                        limita5 = '<td id="inativo'+response.user.id+'"><button type="button" \
                                   data-id="'+response.user.id+'" \
                                   data-inativo="true" \
                                   class="inativo_user fas fa-lock-open" \
                                   style="background: transparent; color: green; border: none;">\
                                   </button></td>';
                        }
                        limita6 = '<td><div class="btn-group">\
                                <button type="button" data-id="'+response.user.id+'" \
                                class="edit_user_btn fas fa-edit" \
                                style="background:transparent;border:none"></button>\
                                <button type="button" data-id="'+response.user.id+'" \
                                data-nomeusuario="'+response.user.name+'" \
                                class="delete_user_btn fas fa-trash" \
                                style="background:transparent;border:none;"></button>\
                                </div></td>\
                                </tr>';                                             
                    var linha = limita0+limita1+limita2+limita3+limita4+limita5+limita6;
                    if(!$('#nadaencontrado').html()=="")
                    {
                        $('#nadaencontrado').remove();
                    }
                    $('#novo').replaceWith(linha);
                }                
            }
        });
    });
    //Fim Enviar usuário para o controller
//inicio moderador usuario
$(document).on('click','.moderador_user',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var id = $(this).data("id");        
        var moderador = $(this).data("moderador");
        
        var data = {
            'moderador':moderador,
            '_method':'PUT',
            '_token':CSRF_TOKEN,
        }           
            $.ajax({
                type: 'post',
                dataType: 'json',
                data:data,
                url:'moderador-user/'+id,
                success: function(response){
                    if(response.status==200){                                                                               
                        var limita1 = "";
                        var limita2 = "";                        
                        if(response.user.moderador==1){
                        limita1 = '<td id="moderador'+response.user.id+'"><button type="button"\
                                   data-id="'+response.user.id+'" \
                                   data-moderador="0" \
                                   class="moderador_user fas fa-lock\
                                   style="background: transparent; color: green; border: none;">\
                                   </button></td>';
                                }else{
                        limita2 = '<td id="moderador'+response.user.id+'"><button type="button" \
                                   data-id="'+response.user.id+'" \
                                   data-moderador="1" \
                                   class="moderador_user fas fa-lock-open" \
                                   style="background: transparent; color: red; border: none;">\
                                   </button></td>';
                                }
                        var celula = limita1+limita2;
                        $('#moderador'+id).replaceWith(celula);        
                    }
                }
            });
    });
    //fim moderador usuario
    //inicio inativa usuario
    $(document).on('click','.inativo_user',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var id = $(this).data("id");
        var inativo = $(this).data("inativo");
        var data = {
            'inativo':inativo,
            '_method':'PUT',
            '_token':CSRF_TOKEN,
        }        
            $.ajax({
                type: 'post',
                dataType: 'json',
                data:data,
                url:'inativo-user/'+id,
                success: function(response){
                    if(response.status==200){                                                                               
                        var limita1 = "";
                        var limita2 = "";                        
                        if(response.user.inativo==1){
                        limita1 = '<td id="inativo'+response.user.id+'"><button type="button" \
                                  data-id="'+response.user.id+'" \
                                  data-inativo="false" \
                                  class="inativo_user fas fa-lock" \
                                  style="background: transparent; color: red; border: none;">\
                                  </button></td>';
                        }else{
                        limita1 = '<td id="inativo'+response.user.id+'"><button type="button" \
                                   data-id="'+response.user.id+'" \
                                   data-inativo="true" \
                                   class="inativo_user fas fa-lock-open" \
                                   style="background: transparent; color: green; border: none;">\
                                   </button></td>';
                        }
                        var celula = limita1+limita2;
                        $('#inativo'+id).replaceWith(celula);        
                    }
                }
            });
    });
    //fim inativa usuario
});
//Fim escopo geral
</script>
@stop

