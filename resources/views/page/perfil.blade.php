@extends('layouts.page')
@section('content')

<!-- Cabeçalho-->
<header class="masthead" style="background-image: url('/assets/img/home-bg.jpg')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>PRODAP/DATACENTER</h1>
                            <span class="subheading">Inovação, Tecnologia e Suporte</span>
                        </div>
                    </div>
                </div>
            </div>
</header>
<div class="container px-4 px-lg-5">
<!--FormUserPerfil-->
<div id="FormUserPerfil" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar navbar-default bg-default">
                <h5 class="modal-title" id="titleModalLabel">Atualize o seu perfil</h5>                
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editfom" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_user_id" value="{{$user->id}}">
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" id="edit_name" class="name form-control" value="{{$user->name}}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">e-Mail</label>
                        <input type="text" id="edit_email" class="email form-control" value="{{$user->email}}">
                    </div>                    
                    <div class="form-group mb-3">
                        <label for="">Senha</label>
                        <input type="password" id="edit_password" class="password form-control">
                    </div>                                        
                    <div class="form-group mb-3">
                        <label for="">URL Instagram</label>
                        <input type="text" id="edit_link_instagram" class="link_instagram form-control" value="{{$user->link_instagram}}">
                    </div>                                        
                    <div class="form-group mb-3">
                        <label for="">URL Facebook</label>
                        <input type="text" id="edit_link_facebook" class="link_facebook form-control" value="{{$user->link_facebook}}">
                    </div>                                      
                    <div class="form-group mb-3">
                        <label for="">URL Site</label>
                        <input type="text" id="edit_link_site" class="link_site form-control" value="{{$user->link_site}}">
                    </div> 
                     <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <label for="">Imagem do perfil</label>                        
                       <span class="btn btn-default fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="upimagem" type="file" name="imagem" accept="image/x-png,image/gif,image/jpeg">
                       </span>                       
                     </div>  
                     <!--arquivo de imagem-->                
            <div class="modal-footer">
                <a href="{{route('page.master')}}" type="button" class="btn btn-default">Fechar</a>
                <button type="submit" class="btn btn-primary update_user">Atualizar</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!--Fim FormUserPerfil-->
</div>
        <!-- Rodapé-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">                        
                        <div class="small text-center text-muted fst-italic">copyright &copy; prodap</div>
                    </div>
                </div>
            </div>
        </footer>      
@endsection

@section('scripts')
<script type="text/javascript">

//Início escopo geral
$(document).ready(function(){
//Início processo perfil usuário
$(document).on('click','.update_user',function(e){
        e.preventDefault();
        $(this).text("Atualizando...");
        var CSRF_TOKEN = document.querySelector('meta[name="_token"]').getAttribute("content");        
        var id = $('#edit_user_id').val();
        var data = new FormData();
            data.append('name',$('#edit_name').val());
            data.append('email',$('#edit_email').val());
            data.append('password',$('#edit_password').val());            
            data.append('link_instagram',$('#edit_link_instagram').val());
            data.append('link_facebook',$('#edit_link_facebook').val());
            data.append('link_site',$('#edit_link_site').val());
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','put');                           
        $.ajax({
            type:'POST',            
            dataType:'json',            
            url:'/perfil/'+id,
            data:data,
            cache: false,
            processData: false,
            contentType: false, 
            success:function(response){
                if(response.status==400){
                    //erros
                    $('#updateform_errList').html("");
                    $('#updateform_errList').addClass('alert alert-danger');
                    $.each(response.errors,function(key,err_values){
                        $('#updateform_errList').append('<li>'+err_values+'</li>');
                    });
                    $(this).text("Atualizar");
                }else{
                    $(this).text("Obrigado!");
                    location.replace('/');
                }
            }
        });
    });   
    //Fim processo perfil do usuario
});
</script>
@endsection
