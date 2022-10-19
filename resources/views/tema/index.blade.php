@extends('layouts.app')
@section('content')
<!--AddTemaModal-->
<div class="modal fade" id="AddTemaModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
           <div class="modal-header navbar navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Tema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Título</label>
                        <input type="text" class="titulo form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Descrição</label>
                        <input type="text" class="descricao form-control">
                    </div>
                    <!--<div class="form-group mb-3">
                        <label for="">Slug</label>
                        <input type="text" class="slug form-control">
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button class="btn btn-primary add_tema">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim AddTemaModal-->
<!--EditTemaModal-->
<div class="modal fade" id="EditTemaModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Tema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_tema_id">
                    <div class="form-group mb-3">
                        <label for="">Título</label>
                        <input type="text" id="edit_titulo" class="titulo form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Descrição</label>
                        <input type="text" id="edit_descricao" class="descricao form-control">
                    </div>
                    <!--<div class="form-group mb-3">
                        <label for="">Slug</label>
                        <input type="text" id="edit_slug" class="slug form-control">
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_tema">Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim EditTemaModal-->
<!--Início Index-->
<div class="container py-5">
    <div id="success_message"></div>
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('admin.tema.index')}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Busca" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                                <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="AddTemaModal_btn input-group-text border-0" style="background: transparent;border: none;">
                                 <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>TÍTULO</th>
                        <th>CRIADO EM</th>
                        <th>MODIFICADO EM</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_tema">
                    @forelse($temas as $tema)
                    <tr id="tema{{$tema->id}}" data-toggle="tooltip" title="{{$tema->descricao}}">
                        <td>{{$tema->id}}</td>
                        <td>{{$tema->titulo}}</td>
                        @if(is_null($tema->created_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($tema->created_at))}}</td>
                        @endif
                        @if(is_null($tema->updated_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s',strtotime($tema->updated_at))}}</td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$tema->id}}" class="edit_tema_btn fas fa-edit" style="background: transparent;border: none;"></button>
                                <button type="button" data-id="{{$tema->id}}" data-titulotema="{{$tema->titulo}}" class="delete_tema_btn fas fa-trash" style="background: transparent;border: none;"></button>
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
            <div class="col-12">
                {{$temas->links("pagination::bootstrap-4")}}
            </div>                
</div>
<!--Fim Index-->
@endsection

@section('scripts')
<script type="text/javascript">

//Início escopo geral
$(document).ready(function(){
    //inicio delete Tema
    $(document).on('click','.delete_tema_btn',function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var titulotema = $(this).data("titulotema");
        var resposta = confirm(titulotema+". Deseja excluir?");

        if(resposta==true){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url:'delete/'+id,
                type:'POST',
                dataType:'json',
                data:{
                    "id":id,
                    "_method":'DELETE',
                },                
                success:function(response){
                    if(response.status==200){
                        //remove a linha correspondente
                        $("#tema"+id).remove();
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);
                    }
                }
            });
        }
    });
    //fim delete Tema
//Início chamada EditTemaModal
$('#EditTemaModal').on('shown.bs.modal',function(){
        $('.titulo').focus();
    });
    $(document).on('click','.edit_tema_btn',function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $('#editform').trigger('reset');
        $('#EditTemaModal').modal('show');

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type:'GET',
            dataType:'json',
            url:'edit/'+id,
            success:function(response){
                if(response.status==200){
                    $('#edit_tema_id').val(response.tema.id);
                    $('.titulo').val(response.tema.titulo);
                    $('.descricao').val(response.tema.descricao);
                    //$('.slug').val(response.tema.slug);
                }
            }
        });
    });
    //Fim chamada EditTemaModal
    //Início processo update do tema
    $(document).on('click','.update_tema',function(e){
        e.preventDefault();
        $(this).text("Atualizando...");
        var id = $('#edit_tema_id').val();
        var data = {
            'titulo':$('#edit_titulo').val(),
            'descricao':$('#edit_descricao').val(),
            //'slug':$('#edit_slug').val(),
        }
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type:'POST',            
            dataType:'json',
            method:'PUT',
            url:'update/'+id,
            data:data,
            success:function(response){
                if(response.status==400){
                    //erros
                    $('#updateform_errList').html("");
                    $('#updateform_errList').addClass('alert alert-danger');
                    $.each(response.errors,function(key,err_values){
                        $('#updateform_errList').append('<li>'+err_values+'</li>');
                    });
                    $(this).text("Atualizado");
                }else if(response.status==404){
                    //Não localizado
                    $('#updateform_errList').html("");
                    $('#success_message').addClass('alert alert-warning');
                    $('#success_message').text(response.message);
                    $(this).text("Atualizado");
                }else{
                    //Êxito na operação
                    $('#updateform_errList').html("");
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $(this).text("Atualizado");
                    $('#editform').trigger('reset');
                    $('#EditTemaModal').modal('hide');
                    //Atualizando a <tr> identificada na tabela html
             var datacriacao = new Date(response.tema.created_at).toLocaleString('pt-BR');
                    if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                    }
         var dataatualizacao = new Date(response.tema.updated_at).toLocaleString('pt-BR');                
                    if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao="";
                    }
                    var linhaatualizada = '<tr id="tema'+response.tema.id+'" data-toggle="tooltip" title="'+response.tema.descricao+'">\
                                <td>'+response.tema.id+'</td>\
                                <td>'+response.tema.titulo+'</td>\
                                <td>'+datacriacao+'</td>\
                                <td>'+dataatualizacao+'</td>\
                                <td><div class="btn-group">\
                                <button type="button" data-id="'+response.tema.id+'" \
                                class="edit_tema_btn fas fa-edit" \
                                style="background:transparent;border:none;"></button>\
                                <button type="button" data-id="'+response.tema.id+'" \
                                data-titulotema="'+response.tema.titulo+'" \
                                class="delete_tema_btn fas fa-trash" \
                                style="background:transparent;border:none;"></button>\
                                </div></td>\
                                </tr>';                                             
                    $("#tema"+id).replaceWith(linhaatualizada);
                }
            }
        });
    });   
    //Fim processo update do tema
 //Chamar AddTemaModal
 $('#AddTemaModal').on('shown.bs.modal',function(){
        $('.titulo').focus();
    });
    $(document).on('click','.AddTemaModal_btn',function(e){
        e.preventDefault();
        $('#addform').trigger('reset');
        $('#AddTemaModal').modal('show');
    });
    //Fim chamar AddTemaModal
    //Adicionar tema na base
    $(document).on('click','.add_tema',function(e){
        e.preventDefault();
        var data = {
            'titulo':$('.titulo').val(),
            'descricao':$('.descricao').val(),
            //'slug':$('.slug').val(),
        }
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url:'store',
            type:'POST',
            dataType:'json',
            data:data,
            success:function(response){
                if(response.status==400){
                    //erros
                    $('#saveform_errList').html("");
                    $('#saveform_errList').addClass('alert alert-danger');
                    $.each(response.errors,function(key,err_values){
                        $('#saveform_errList').append('<li>'+err_values+'</li>');
                    });                    
                }else{
                    //sucesso                    
                    $('#saveform_errList').html("");
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#addform').trigger('reset');
                    $('#AddTemaModal').modal('hide');
                    //formata data                    
   var datacriacao = new Date(response.tema.created_at).toLocaleString('pt-BR');          
                    if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao="";
                    }
    var dataatualizacao = new Date(response.tema.updated_at).toLocaleString('pt-BR');                      
                    if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao="";
                    }                       
                    //Insere linha nova na tabela html do index
                    var linhacriada = '<tr id="tema'+response.tema.id+'" data-toggle="tooltip" title="'+response.tema.descricao+'">\
                                <td>'+response.tema.id+'</td>\
                                <td>'+response.tema.titulo+'</td>\
                                <td>'+datacriacao+'</td>\
                                <td>'+dataatualizacao+'</td>\
                                <td><div class="btn-group">\
                                <button type="button" data-id="'+response.tema.id+'" \
                               class="edit_tema_btn fas fa-edit" \
                               style="background:transparent;border:none;"></button>\
                               <button type="button" data-id="'+response.tema.id+'" \
                               data-titulotema="'+response.tema.titulo+'" \
                               class="delete_tema_btn fas fa-trash" \
                               style="background:transparent;border:none;"></button>\
                               </div></td>\
                               </tr>';
                    if(!$('#nadaencontrado').html()=="")
                    {
                        $('#nadaencontrado').remove();
                    }
                    $('#lista_tema').append(linhacriada);
                }                
            }
        });
    });
    //Fim adicionar tema na base
});
//Fim escopo geral
</script>
@endsection