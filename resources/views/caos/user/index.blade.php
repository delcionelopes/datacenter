@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--Início Index-->
@auth
<div class="container-fluid py-5">
    <div id="success_message"></div>
    <div class="row">
        <div class="card-body">
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('admin.user.index')}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Busca" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent; border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{route('admin.user.create')}}" type="button" class="AddUserModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                                 <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-hover">
                <thead class="sidebar-dark-primary" style="color: white">
                    <tr>                        
                        <th>USUÁRIOS</th>
                        <th>DatacenterADMIN</th>
                        <th>ATIVO</th>
                        <th>ADMIN</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_users">
                    @forelse($users as $user)
                    <tr id="user{{$user->id}}">                        
                        <td>{{$user->name}}</td>
                        @if($user->sistema)                        
                        <td id="sistema{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-sistema="false" class="sistema_user fas fa-thumbs-up" style="background: transparent; color: green; border: none;"></button></td>
                        @else
                        <td id="sistema{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-sistema="true" class="sistema_user fas fa-thumbs-down" style="background: transparent; color: red; border: none;"></button></td>
                        @endif
                        @if($user->inativo)
                        <td id="inativo{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-inativo="false" class="inativo_user fas fa-thumbs-down" style="background: transparent; color: red; border: none;"></button></td>
                        @else
                        <td id="inativo{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-inativo="true" class="inativo_user fas fa-thumbs-up" style="background: transparent; color: green; border: none;"></button></td>
                        @endif
                        @if($user->admin)
                        <td id="admin{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-admin="false" class="admin_user fas fa-thumbs-up" style="background: transparent; color: green; border: none;"></button></td>
                        @else
                        <td id="admin{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-admin="true" class="admin_user fas fa-thumbs-down" style="background: transparent; color: red; border: none;"></button></td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <a href="{{route('admin.user.edit',['id' => $user->id])}}" type="button" data-id="{{$user->id}}" class="edit_user_btn fas fa-edit" style="background: transparent;border: none; color: black; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></a>
                                <button type="button" data-id="{{$user->id}}" data-nomeusuario="{{$user->name}}" class="delete_user_btn fas fa-trash" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
    </div>
</div>
<!--Fim Index-->
@endauth
<!--End Index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
    <link href="{{asset('css/styles.css')}}" rel="stylesheet"/>  {{-- css da aplicação --}}
@stop

@section('js')
<script type="text/javascript">

//Início escopo geral
$(document).ready(function(){
    //inicio delete usuário
    $(document).on('click','.delete_user_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var linklogo = "{{asset('storage')}}";
        var id = $(this).data("id");
        var nomeusuario = $(this).data("nomeusuario");
        

       Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomeusuario,
                text: "Deseja excluir?",
                imageUrl: linklogo+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do sistema',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){     
            $.ajax({
                url:'/admin/user/delete/'+id,
                type:'POST',
                dataType:'json',
                data:{
                    "id":id,
                    "_method":'DELETE',
                    "_token":CSRF_TOKEN,
                },                
                success:function(response){
                    if(response.status==200){
                        //remove a linha correspondente
                        $("#user"+id).remove();
                        $('#success_message').replaceWith('<div id="success_message"></div>');
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);
                    }else{
                        //não pôde excluir por causa dos relacionamentos
                        $('#success_message').replaceWith('<div id="success_message"></div>');                                                    
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(response.message); 
                    }
                }
            });
        }
    });
});   
    //fim delete usuário

//inicio acesso sistema usuario
$(document).on('click','.sistema_user',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var id = $(this).data("id");        
        var sistema = $(this).data("sistema");
        
        var data = {
            'sistema':sistema,
            '_method':'PUT',
            '_token':CSRF_TOKEN,
        }        
            $.ajax({
                type: 'post',
                dataType: 'json',
                data:data,
                url:'/admin/user/sistema/'+id,
                success: function(response){
                    if(response.status==200){                                                                               
                        var limita1 = "";
                        var limita2 = "";                        
                        if(response.user.sistema==true){
                        limita1 = '<td id="sistema'+response.user.id+'"><button type="button"\
                                   data-id="'+response.user.id+'" \
                                   data-sistema="false" \
                                   class="sistema_user fas fa-thumbs-up"\
                                   style="background: transparent; color: green; border: none;">\
                                   </button></td>';
                                }else{
                        limita2 = '<td id="sistema'+response.user.id+'"><button type="button" \
                                   data-id="'+response.user.id+'" \
                                   data-sistema="true" \
                                   class="sistema_user fas fa-thumbs-down" \
                                   style="background: transparent; color: red; border: none;">\
                                   </button></td>';
                                }
                        var celula = limita1+limita2;
                        $('#sistema'+id).replaceWith(celula);        
                    }
                }
            });
    });
    //fim acesso ao sistema usuario

    //inicio admin usuario
$(document).on('click','.admin_user',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var id = $(this).data("id");        
        var admin = $(this).data("admin");
        
        var data = {
            'admin':admin,
            '_method':'PUT',
            '_token':CSRF_TOKEN,
        }        
            $.ajax({
                type: 'post',
                dataType: 'json',
                data:data,
                url:'/admin/user/admin/'+id,
                success: function(response){
                    if(response.status==200){   
                        var celula = "";
                        var limita1 = "";
                        var limita2 = "";                        
                        if(response.user.admin==true){
                        limita1 = '<td id="admin'+response.user.id+'"><button type="button"\
                                   data-id="'+response.user.id+'" \
                                   data-admin="false" \
                                   class="admin_user fas fa-thumbs-up"\
                                   style="background: transparent; color: green; border: none;">\
                                   </button></td>';
                                }else{
                        limita2 = '<td id="admin'+response.user.id+'"><button type="button" \
                                   data-id="'+response.user.id+'" \
                                   data-admin="true" \
                                   class="admin_user fas fa-thumbs-down" \
                                   style="background: transparent; color: red; border: none;">\
                                   </button></td>';
                                }
                        var celula = limita1+limita2;                        
                        $('#admin'+id).replaceWith(celula);        
                    }
                }
            });
    });
    //fim admin usuario

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
                url:'/admin/user/inativo/'+id,
                success: function(response){
                    if(response.status==200){                                                                               
                        var limita1 = "";
                        var limita2 = "";                        
                        if(response.user.inativo==true){
                        limita1 = '<td id="inativo'+response.user.id+'"><button type="button" \
                                  data-id="'+response.user.id+'" \
                                  data-inativo="false" \
                                  class="inativo_user fas fa-thumbs-down" \
                                  style="background: transparent; color: red; border: none;">\
                                  </button></td>';
                        }else{
                        limita1 = '<td id="inativo'+response.user.id+'"><button type="button" \
                                   data-id="'+response.user.id+'" \
                                   data-inativo="true" \
                                   class="inativo_user fas fa-thumbs-up" \
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

    ///tooltip
    $(function(){             
        $(".AddUserModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_user_btn").tooltip();
        $(".edit_user_btn").tooltip();    
    });
    ///fim tooltip

});
//Fim escopo geral
</script>
@endsection