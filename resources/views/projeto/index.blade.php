@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')
    <!--AddProjetoModal-->

<div class="modal fade" id="AddProjetoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Projeto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="myform" name="myform" class="form-horizontal" role="form">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" class="nome_projeto form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" >Fechar</button>
                    <button type="button" class="btn btn-primary add_projeto">Salvar</button>
                </div>
            </div>
        </div>

    </div>

</div>
<!--Fim AddProjetoModal-->

<!--EditProjetoModal-->
<div class="modal fade" id="EditProjetoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Projeto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="myform" name="myform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_projeto_id">
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" id="edit_nome_projeto" class="nome_projeto form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary update_projeto">Atualizar</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!--Fim EditProjetoModal-->

<!--index-->
<div class="container py-5">
    <div id="success_message"></div>
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('admin.projeto.index')}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisanome" class="form-control rounded float-left" placeholder="Nome do projeto" aria-label="Search" aria-describedby="search-addon">                            
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                                <i class="fas fa-search"></i>
                            </button>                                                                                                             
                            <button type="button" class="AddProjetoModal_btn input-group-text border-0" style="background: transparent;border: none;"><i class="fas fa-plus"></i></button>
                        </div>                        
                    </div>                    
                </form>                                
            </section>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>PROJETOS</th>                       
                        <TH>AÇÕES</TH>
                    </tr>
                </thead>
                <tbody id="lista_projeto">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($projetos as $projeto)
                    <tr id="projeto{{$projeto->id}}">
                        <th scope="row">{{$projeto->nome_projeto}}</th>                       
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$projeto->id}}" class="edit_projeto fas fa-edit" style="background: transparent;border: none;"></button>
                                <button type="button" data-id="{{$projeto->id}}" data-nomeprojeto="{{$projeto->nome_projeto}}" class="delete_projeto_btn fas fa-trash" style="background: transparent;border: none;"></button>
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
            <div class="d-flex hover justify-content-center">
                {{$projetos->links()}}
    </div>
</div>

<!--Fim index-->
@stop

@section('js')
<script type="text/javascript">
    //inicio do escopo geral
    $(document).ready(function(){
        //inicio delete projeto
        $(document).on('click','.delete_projeto_btn',function(e){
            e.preventDefault();
            var id = $(this).data("id");
            var nomeprojeto = $(this).data("nomeprojeto");
            swal({
                title:"Processo de exclusão!",
                text: "Você vai excluir "+nomeprojeto+". Deseja prosseguir?",
                icon:"warning",
                buttons:true,
                dangerModal:true,
            }).then(willDelete=>{
                if(willDelete){
                    $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
                $.ajax({
                    url:'delete-projeto/'+id,
                    type:'POST',
                    dataType:'json',
                    data:{
                        "id":id,
                        "_method":'DELETE',
                    },
                    success:function(response){
                        if(response.status==200){
                            //remove a linha correspondente da tabela html
                            $("#projeto"+id).remove();
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);         
                        }
                    }
                });
            }
        });
        });//fim delete projeto
    
        //início exibição edit projeto
        $('#EditProjetoModal').on('shown.bs.modal',function(){
            $('#edit_nome_projeto').focus();
        });
    
        $(document).on('click','.edit_projeto',function(e){
            e.preventDefault();
            
            var id = $(this).data("id");             
            $('#myform').trigger('reset');
            $('#EditProjetoModal').modal('show');
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'GET',
                    dataType:'json',
                    url:'edit-projeto/'+id,
                    success:function(response){
                        if(response.status==200){                        
                            $('.nome_projeto').val(response.projeto.nome_projeto);
                            $('#edit_projeto_id').val(response.projeto.id);
                        }
                    }
                });
        });//fim exibição edit projeto
    
        //inicio da atualização do projeto
        $(document).on('click','.update_projeto',function(e){
            $(this).text("Atualizando...");
    
            var id = $('#edit_projeto_id').val();
            var data = {
                'nome_projeto' : $('#edit_nome_projeto').val(),
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
                    url:'update-projeto/'+id,
                    success:function(response){
                        if(response.status==400){
                            //erros
                            $('#updateform_errList').html("");
                            $('#updateform_errList').addClass('alert alert-danger');
                            $.each(reponse.errors,function(key,err_values){
                                $('#updateform_errList').append('<li>'+err_values+'</li>');
                            });
                        }else if(response.status==404){
                            $('#updateform_errList').html("");
                            $('#success_message').addClass('alert alert-warning');
                            $('#success_message').text(response.message);
                            $('.update_projeto').text("Atualizado");
                        }else{
                            $('#updataform_errList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.update_projeto').text("Atualizado");
    
                            $('#myform').trigger('reset');
                            $('#EditProjetoModal').modal('hide');    
                          
    
                            var linha = '<tr id="projeto'+response.projeto.id+'">\
                                    <th scope="row">'+response.projeto.nome_projeto+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.projeto.id+'" class="edit_projeto fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.projeto.id+'" data-nomeprojeto="'+response.projeto.nome_projeto+'" class="delete_projeto_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';    
                            $("#projeto"+id).replaceWith(linha); 
    
    
                        }
                    }
                });
    
    
        });//fim da atualização do projeto
    
    //exibe form de adição de registro
    $('#AddProjetoModal').on('shown.bs.modal',function(){
            $('.nome_projeto').focus();
        });
    
    $(document).on('click','.AddProjetoModal_btn',function(e){                  
            e.preventDefault();       
            
            $('#myform').trigger('reset');
            $('#AddProjetoModal').modal('show');                
    
        });
    
    //fim exibe form de adição de registro
    
    
        //inicio da adição de projeto
        $(document).on('click','.add_projeto',function(e){
            e.preventDefault();
    
            var data = {
                'nome_projeto' : $('.nome_projeto').val(),
            }
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'POST',
                    url:'adiciona-projeto',
                    data:data,
                    dataType:'json',
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
    
                            $('#myform').trigger('reset');
                            $('#AddProjetoModal').modal('hide');
    
                        //adiciona a linha na tabela html                       
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>'; 
                            linha1 = '<tr id="projeto'+response.projeto.id+'">\
                                    <th scope="row">'+response.projeto.nome_projeto+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.projeto.id+'" class="edit_projeto fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.projeto.id+'" data-nomeprojeto="'+response.projeto.nome_projeto+'" class="delete_projeto_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';
                        if(!$('#nadaencontrado').html==""){
                            $('#nadaencontrado').remove();
                        }
                            tupla = linha0+linha1;
                        $("#novo").replaceWith(tupla); 
                        }
                    }
                });
        });//fim da adição de projeto
    
    });//fim do escopo geral
    
    </script>
@stop

