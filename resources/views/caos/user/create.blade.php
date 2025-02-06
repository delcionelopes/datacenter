@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')

<form role="form" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PUT')
    <ul id="saveform_errList"></ul> 
    <div class="container-fluid py-5">
        <div class="card">
            <div class="card-body">
              <div class="card p-3" style="background-image: url('/assets/img/home-bg.jpg')">
                <div class="d-flex align-items-center">
                    <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <div class="image">                            
                            <img src="{{asset('storage/user.png')}}" class="imgfoto rounded-circle" width="100" >     
                        </div>
                       <label for="">Foto</label>                        
                       <span class="btn btn-none fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="upimagem" type="file" name="imagem" class="btn btn-primary" accept="image/x-png,image/gif,image/jpeg">
                       </span>                       
                     </div>  
                     <!--arquivo de imagem--> 
                </div>
              </div>
                  <fieldset>
                    <legend>Dados de Identificação</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" required class="form-control" name="nome" id="nome" placeholder="Nome do usuário">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="matricula">Matrícula</label>
                                <input type="text" required class="form-control" name="matricula" id="matricula">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input type="text" required class="form-control" name="cpf" id="cpf" placeholder="000.000.000-00" data-mask="000.000.000-00" data-mask-reverse="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rg">RG</label>
                                <input type="text" class="form-control" name="rg" id="rg">
                            </div>
                        </div>   
                    </div>                                        
                </fieldset>               

                <fieldset>
                    <legend>Dados de Controle</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">e-Mail</label>
                                <input type="text" class="email form-control" name="email" id="email" placeholder="e-Mail do usuário">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" class="password form-control" name="password" id="password">
                            </div>
                        </div>                    
                    </div>                    
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="idperfil">Perfil</label>
                                <select name="idperfil" id="idperfil" class="idperfil custom-select">
                                    @foreach ($perfis as $perfil)
                                    <option value="{{$perfil->id}}">{{$perfil->nome}}</option>
                                    @endforeach                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="idfuncao">Função</label>
                                <select name="idfuncao" id="idfuncao" class="idfuncao custom-select">
                                    @foreach ($funcoes as $funcao)
                                    <option value="{{$funcao->id}}">{{$funcao->nome}}</option>
                                    @endforeach                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="idsetor">Setor</label>
                                <select name="idsetor" id="idsetor" class="idsetor custom-select">
                                    @foreach ($setores as $setor)
                                    <option value="{{$setor->id}}">{{$setor->sigla}}</option>
                                    @endforeach                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">Acessos</label>
                            <div class="form-group">
                                <label for="sistema">
                                <input type="checkbox" class="sistema checkbox" name="sistema" id="sistema"> Sistema</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">Privilégio</label>
                            <div class="form-group">
                                <label for="admin">
                                <input type="checkbox" class="admin checkbox" name="admin" id="admin"> ADMIN</label>
                            </div>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_instagram">URL Instagram</label>
                                <input type="text" class="link_instagram form-control" name="link_instagram" id="link_instagram" placeholder="https://..instagram">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_facebook">URL Facebook</label>
                                <input type="text" class="link_facebook form-control" name="link_facebook" id="link_facebook" placeholder="https://..facebook">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_site">URL Site</label>
                                <input type="text" class="link_site form-control" name="link_site" id="link_site" placeholder="https://..site">
                            </div>
                        </div>                 
                    </div>                    
                </fieldset>               
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button type="button" class="cancelar_btn btn btn-default">Cancelar</button>
                            <button class="salvar_btn btn btn-primary" type="button"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop

@section('css')

<link href="{{asset('css/styles.css')}}" rel="stylesheet"/>
    
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){

    $(document).on('click','.salvar_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
        var loading = $('#imgadd');
            loading.show();
        
        var data = new FormData();        

            data.append('perfil_id',$('#idperfil').val());
            data.append('funcao_id',$('#idfuncao').val());
            data.append('setor_id',$('#idsetor').val());                        
            data.append('name',$('#nome').val());            
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('inativo', 'false'); //$('#inativo').is(":checked")?'true':'false');
            data.append('sistema',$('#sistema').is(":checked")?'true':'false');
            data.append('admin',$('#admin').is(":checked")?'true':'false');
            data.append('matricula',$('#matricula').val());
            data.append('cpf',$('#cpf').val());
            data.append('rg',$('#rg').val());
            data.append('email',$('#email').val());
            data.append('password',$('#password').val());
            data.append('link_instagram',$('#link_instagram').val());
            data.append('link_facebook',$('#link_facebook').val());
            data.append('link_site',$('#link_site').val());           
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');              

        $.ajax({
            url: '/admin/user/store',
            type: 'POST',
            dataType: 'json',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            async:true,
            success: function(response){
                if(response.status==400){
                      $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                } else{
                    loading.hide();
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                    loading.hide();
                     location.replace('/admin/user/index');
                }  
            }  
        });

    });

    //upload da foto temporária
         $(document).on('change','#upimagem',function(){  
          
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var fd = new FormData();
            var files = $(this)[0].files;                      

            if(files.length > 0){
            // Append data 
            fd.append('imagem',$(this)[0].files[0]);      
            fd.append('_token',CSRF_TOKEN);
            fd.append('_enctype','multipart/form-data');
            fd.append('_method','put');      
            
        $.ajax({                      
                type: 'POST',                             
                url:'/admin/user/armazenar-imgtemp',                
                dataType: 'json',            
                data: fd,
                cache: false,
                processData: false,
                contentType: false,                                                                                     
                success: function(response){                              
                    if(response.status==400){
                        $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });
                }else{                                                     
                        var arq = response.filepath; 
                            arq = arq.toString();                  ;
                        var linkimagem = '{{asset('')}}'+arq;                        
                        var imagemnova = '<img src="'+linkimagem+'" class="imgfoto rounded-circle" width="100" >';
                        $(".imgfoto").replaceWith(imagemnova);
                    }   
                }                                  
            });
        }
        });   
    //fim upload da foto temporária
    ///excluir imagem temporário pelo cancelamento
    $(document).on('click','.cancelar_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var files = $('#upimagem')[0].files;                      

        if(files.length > 0){
        var data = new FormData();
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('_token',CSRF_TOKEN);
            data.append('_enctype','multipart/form-data');
            data.append('_method','delete');   
             $.ajax({                      
                type: 'POST',                             
                url:'/admin/user/delete-imgtemp',                
                dataType: 'json',            
                data: data,
                cache: false,
                processData: false,
                contentType: false,                                                                                     
                success: function(response){                              
                    if(response.status==200){
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');                         
                    location.replace('/admin/user/index');
                } 
                }                                  
            });

        }else{
            location.replace('/admin/user/index');
        }

    });
    //fim excluir imagem temporária pelo cancelamento

});

</script>

@stop