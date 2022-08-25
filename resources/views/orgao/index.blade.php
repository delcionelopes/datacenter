@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content_header')
    <h1>Órgãos</h1>
@stop

@section('content')
    <!---AddOrgaoModal-->

<div class="modal fade" id="AddOrgaoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Órgão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="myform" name="myform" class="form-horizontal" role="form">
                    <ul id="saveform_errList"></ul>

                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" class="nome_orgao form-control">
                    </div>
                    <div class="form-group mb3">
                        <label for="">Telefone</label>
                        <input type="text" class="telefone form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary add_orgao">Salvar</button>
                </div>
            </div>
        </div>

    </div>

</div>

<!--Fim AddOrgaoModal-->

<!--EditOrgaoModal-->

<div class="modal fade" id="EditOrgaoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Órgão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="myform" name="myform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>

                    <input type="hidden" id="edit_orgao_id">
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" id="edit_nome_orgao" class="nome_orgao form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Telefone</label>
                        <input type="text" id="edit_telefone" class="telefone form-control">
                    </div>                    
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" >Fechar</button>
                    <button type="button" class="btn btn-primary update_orgao">Atualizar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!--Fim EditOrgaoModal-->

<!--index-->

<div class="container py-5">
    <div id="success-message"></div>
    <div class="row">
        <div class="card-body">
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('admin.orgao.index')}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisanome" class="form-control rounded float-left" placeholder="Nome do órgão" aria-label="Search"
                            aria-describedby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                                <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="AddOrgaoModal_btn input-group-text border-0" style="background: transparent;border: none;"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </form>                
            </section>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ÓRGÃOS</th>
                        <th>TELEFONE</th>
                        <th>CRIADO EM</th>
                        <th>MODIFICADO EM</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_orgao">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($orgaos as $orgao)
                    <tr id="orgao{{$orgao->id}}">
                        <td>{{$orgao->nome}}</td>
                        <td>{{$orgao->telefone}}</td>
                        @if(is_null($orgao->created_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($orgao->created_at))}}</td>
                        @endif
                        @if(is_null($orgao->updated_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($orgao->updated_at))}}</td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$orgao->id}}" class="edit_orgao fas fa-edit" style="background:transparent;border:none;"></button>
                                <button type="button" data-id="{{$orgao->id}}" data-nomeorgao="{{$orgao->nome}}" class="delete_orgao_btn fas fa-trash" style="background: transparent;border: none;"></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="nadaencontrado">
                        <td colspan="4">Nada encontrado!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="col-12">
                {{$orgaos->links("pagination::bootstrap-4")}}
            </div>
        </div>
    </div>
</div>

<!--Fim index-->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script type="text/javascript">

    $(document).ready(function(){
    
    //inicio delete orgao    
        $(document).on('click','.delete_orgao_btn',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");
            var nomeorgao = $(this).data("nomeorgao");
            swal({
                title:"Processo de exclusão!",
                text: "Você vai excluir "+nomeorgao+". Deseja prosseguir?",
                icon:"warning",
                buttons:true,
                dangerMode:true,
              
                }).then(willDelete=>{
                if (willDelete) {
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
                $.ajax({
                    url:'delete-orgao/'+id,
                    assync:true,
                    type:'POST',                
                    dataType: 'json',
                    data:{
                        "id":id,
                        "_method":'DELETE',
                    },
                    success:function(response){
                        if(response.status==200){                           
                            //remove a linha correspondente da tabela html
                            $("#orgao"+id).remove();
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                        }
                    }
                });
            }    
        
        });
        }); //fim delete orgao
    
    //início exibição edit orgao
    $('#EditOrgaoModal').on('shown.bs.modal',function(){
            $('#edit_nome_orgao').focus();
        });
    
    $(document).on('click','.edit_orgao',function(e){
        e.preventDefault();
        
        var id = $(this).data("id");
        $('#myform').trigger('reset');
        $('#EditOrgaoModal').modal('show');
    
        $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: 'edit-orgao/'+id,
                    assync: true,
                    success:function(response){
                        if(response.status==200){
                            $('.nome_orgao').val(response.orgao.nome);
                            $('.telefone').val(response.orgao.telefone);
                            $('#edit_orgao_id').val(response.orgao.id);
                        }
                    }
                });
    
    });//fim exibição edit orgão    
    
    //inicio da atualização do orgão
    $(document).on('click','.update_orgao',function(e){
        e.preventDefault();
    
        $(this).text("Atualizando...");
    
        var id = $('#edit_orgao_id').val();
        
        var data = {
            'nome' : $('#edit_nome_orgao').val(),
            'telefone' : $('#edit_telefone').val(),
        } 
    
        $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'POST',
                    data: data,
                    dataType: 'json',
                    url:'update-orgao/'+id,
                    assync: true,
                    success:function(response){
                        if(response.status==400){
                            //erros
                            $('#updateform_errList').html("");
                            $('#updateform_errList').addClass('alert alert-danger');
                            $.each(response.errors,function(key,err_values){
                                $('#updateform_errList').append('<li>'+err_values+'</li>');
                            });
                            $('.update_orgao').text("Atualizado");
                        }else if(response.status==404){
                            $('#updateform_errList').html("");
                            $('#success_message').addClass('alert alert-warning');
                            $('#success_message').text(response.message);
                            $('.update_orgao').text("Atualizado");
                        }else{  
                            $('#updateform_errList').html("");
                            $('#sucess_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.update_orgao').text("Atualizado");
    
                            $('#EditOrgaoModal').modal('hide');
    
                            //atualizando a linha na tabela html
                            var datacriacao = new Date(response.orgao.created_at).toLocaleString();
                            if(datacriacao=="31/12/1969 21:00:00"){
                                datacriacao = "";                            
                            }else{
                                datacriacao = datacriacao;
                            }
                            var dataatualizacao = new Date(response.orgao.updated_at).toLocaleString();
                            if(dataatualizacao=="31/12/1969 21:00:00"){
                                dataatualizacao = "";                            
                            }else{
                                dataatualizacao = dataatualizacao;
                            }
                            var linha = '<tr id="orgao'+response.orgao.id+'">\
                                         <td>'+response.orgao.nome+'</td>\
                                         <td>'+response.orgao.telefone+'</td>\
                                         <td>'+datacriacao+'</td>\
                                         <td>'+dataatualizacao+'</td>\
                                         <td>\
                                             <div class="btn-group">\
                                                 <button type="button" data-id="'+response.orgao.id+'" class="edit_orgao fas fa-edit" style="background:transparent;border:none;"></button>\
                                                 <button type="button" data-id="'+response.orgao.id+'" data-nomeorgao="'+response.orgao.nome+'" class="delete_orgao_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                             </div>\
                                         </td>\
                                         </tr>';
                            $("#orgao"+id).replaceWith(linha);             
                        }
                    }
                });
    
    });//fim da atualização do orgão
    
    //exibe form de adição de registro
    $('#AddOrgaoModal').on('shown.bs.modal',function(){
            $('.nome_orgao').focus();
        });
    
    $(document).on('click','.AddOrgaoModal_btn',function(e){                  
            e.preventDefault();        
                                           
            $('#myform').trigger('reset');
            $('#AddOrgaoModal').modal('show');                
    
        });
    
    //fim exibe form de adição de registro
    
    
    //início da adição de órgão
    $(document).on('click','.add_orgao',function(e){     
        e.preventDefault();
    
        var data = {
            'nome' : $('.nome_orgao').val(),
            'telefone' : $('.telefone').val(),
        }
    
        $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
            
                $.ajax({                
                    url: 'adiciona-orgao',                                                                            
                    type: 'POST',
                    dataType: 'json',
                    data: data,               
                    cache: false, 
                    success: function(response){
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
    
                            $('#myform').trigger('reset');
                            $('#AddOrgaoModal').modal('hide');
    
                            //adiciona a linha na tabela html
                            var datacriacao = new Date(response.orgao.created_at).toLocaleString();
                            if(datacriacao=="31/12/1969 21:00:00"){
                                datacriacao = "";                            
                            }else{
                                datacriacao = datacriacao;
                            }                        
                            var tupla = "";
                            var linha0 = "";
                            var linha1 = "";
                                linha0 = '<tr id="novo" style="display:none;"></tr>'; 
                                linha1 = '<tr id="orgao'+response.orgao.id+'">\
                                         <td>'+response.orgao.nome+'</td>\
                                         <td>'+response.orgao.telefone+'</td>\
                                         <td>'+datacriacao+'</td>\
                                         <td></td>\
                                         <td>\
                                             <div class="btn-group">\
                                                 <button type="button" data-id="'+response.orgao.id+'" class="edit_orgao fas fa-edit" style="background:transparent;border:none;"></button>\
                                                 <button type="button" data-id="'+response.orgao.id+'" data-nomeorgao="'+response.orgao.nome+'" class="delete_orgao_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                             </div>\
                                         </td>\
                                         </tr>';
                        if(!$('#nadaencontrado').html==""){
                            $('#nadaencontrado').remove();
                        }
                            tupla = linha0+linha1;
                            $("#novo").replaceWith(tupla);             
    
                        } 
                    }
                });
    });//fim da adição de orgão
    
    
    });
    
    
    </script>
@stop