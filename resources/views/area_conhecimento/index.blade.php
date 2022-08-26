@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')
    <!--AddArea_ConhecimentoModal-->

<div class="modal fade" id="AddArea_ConhecimentoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Área de Conhecimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="myform" name="myform" class="form-horizontal" role="form">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Descrição</label>
                        <input type="text" class="descricao form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary add_area_conhecimento">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--fim AddArea_ConhecimentoModal-->

<!--EditArea_ConhecimentoModal-->
<div class="modal fade" id="EditArea_ConhecimentoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Área do Conhecimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                     <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="myform" name="myform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_area_conhecimento_id">
                    <div class="form-group mb-3">
                        <label for="">Descrição</label>
                        <input type="text" id="edit_descricao" class="descricao form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary update_area_conhecimento">Atualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--fim EditArea_ConhecimentoModal-->

<!--index-->
<div class="container py-5">
    <div id="success_message"></div>
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('admin.areaconhecimento.index')}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="nomepesquisa" class="form-control rounded float-left" placeholder="Descrição da área" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                            <i class="fas fa-search"></i>                            
                            </button>
                            <button type="button" class="AddArea_ConhecimentoModal_btn input-group-text border-0" style="background: transparent;border: none;"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ÁREAS DE CONHECIMENTO</th>
                        <th>CRIADO EM</th>
                        <th>MODIFICADO EM</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_area_conhecimento">
                    <tr id="novo" style="display:none;"></tr>
                    @forelse($areas_conhecimento as $area_conhecimento)
                    <tr id="area{{$area_conhecimento->id}}">
                        <td>{{$area_conhecimento->descricao}}</td>
                        @if(is_null($area_conhecimento->created_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($area_conhecimento->created_at))}}</td>
                        @endif
                        @if(is_null($area_conhecimento->updated_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($area_conhecimento->updated_at))}}</td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button data-id="{{$area_conhecimento->id}}" class="edit_area_conhecimento fas fa-edit" style="background: transparent;border: none;"></button>
                                <button data-id="{{$area_conhecimento->id}}" data-descricao="{{$area_conhecimento->descricao}}" class="delete_area_conhecimento_btn fas fa-trash" style="background: transparent;border: none;"></button>
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
            {{$areas_conhecimento->links()}}
      
    </div>
</div>
<!--fim Index-->
@stop

@section('css')
    <link rel="stylesheet" href="vendor/adminlte/dist/css/adminlte.min.css">
@stop

@section('js')
<script type="text/javascript">

    //inicio do escopo geral
    $(document).ready(function(){
        //inicio delete area_conhecimento
        $(document).on('click','.delete_area_conhecimento_btn',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");
            var descricao = $(this).data("descricao");
    
            swal({
                title:"Exclusão!",
                text:"Deseja excluir "+descricao+"?",
                icon:"warning",
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
                    url:'delete-areaconhecimento/'+id,
                    type:'POST',
                    dataType:'json',
                    data:{
                        "id":id,
                        "_method":'DELETE',
                    },
                    success:function(response){
                        //remove a tr correspondente da tabela html
                        $("#area"+id).remove();
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);         
                    }
                });
                }
            });
        });//fim delete area_conhecimento
    
        //Exibe EditArea_ConhecimentoModal
        $('#EditArea_ConhecimentoModal').on('shown.bs.modal',function(){
            $('#edit_descricao').focus();
        });
        $(document).on('click','.edit_area_conhecimento',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");
            $('#myform').trigger('reset');
            $('#EditArea_ConhecimentoModal').modal('show');
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'GET',
                    dataType:'json',
                    url:'edit-areaconhecimento/'+id,
                    success:function(response){
                        if(response.status==200){
                            $('.descricao').val(response.area_conhecimento.descricao);
                            $('#edit_area_conhecimento_id').val(response.area_conhecimento.id);
                        }
                    }
                 });
    
        });//fim da exibição de EditArea_ConhecimentoModal
    
        //inicio da atualização do registro envio para o controller
        $(document).on('click','.update_area_conhecimento',function(e){
            e.preventDefault();
            $(this).text("Atualizando...");
            var id = $('#edit_area_conhecimento_id').val();
            var data = {
                'descricao' : $('#edit_descricao').val(),
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
                    url:'update-areaconhecimento/'+id,
                    success:function(response){
                        if(response.status==400){
                            //erros
                            $('#updateform_errList').html("");
                            $('#updateform_errList').addClass('alert alert-danger');
                            $.each(response.errors,function(key,err_values){
                                $('#updateform_errList').append('<li>'+err_values+'</li>');
                            });
                            $('.update_area_conhecimento').text("Atualizado");
                        }else if(response.status==404){
                            $('#updateform_errList').html("");
                            $('#success_message').addClass('alert alert-warning');
                            $('#success_message').text(response.message);
                            $('.update_area_conhecimento').text("Atualizado");
                        }else{
                            $('#updateform_errList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.update_area_conhecimento').text("Atualizado");
    
                            $('#myform').trigger('reset');
                            $('#EditArea_ConhecimentoModal').modal('hide');
                            //atualizando a tr da tabela html
                            var datacriacao = new Date(response.area_conhecimento.created_at).toLocaleString();
                            if(datacriacao=="31/12/1969 21:00:00"){
                                datacriacao = "";                            
                            }else{
                                datacriacao = datacriacao;
                            }
                            var dataatualizacao = new Date(response.area_conhecimento.updated_at).toLocaleString();
                            if(dataatualizacao=="31/12/1969 21:00:00"){
                                dataatualizacao = "";                            
                            }else{
                                dataatualizacao = dataatualizacao;
                            }
                            var linha = '<tr id="area'+response.area_conhecimento.id+'">\
                                    <td>'+response.area_conhecimento.descricao+'</td>\
                                    <td>'+datacriacao+'</td>\
                                    <td>'+dataatualizacao+'</td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.area_conhecimento.id+'" class="edit_area_conhecimento fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.area_conhecimento.id+'" data-descricao="'+response.area_conhecimento.descricao+'" class="delete_area_conhecimento_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';                             
                             $("#area"+id).replaceWith(linha);                                                                                                        
    
                        }
                    }
                });
        });
        //fim da atualização do registro envio para o controller
    
        //inicio exibição da adição do novo registro
        $('#AddArea_ConhecimentoModal').on('shown.bs.modal',function(){
            $('.descricao').focus();
        });
        $(document).on('click','.AddArea_ConhecimentoModal_btn',function(e){  //início da exibição do form EditAmbientModal de ambiente                
            e.preventDefault();       
            
            $('#myform').trigger('reset');
            $('#AddArea_ConhecimentoModal').modal('show');                        
    
        });    
        //fim exibição da adição do novo registro
    
        //inicio do envio do novo registro para o Area_ConhecimentoController
        $(document).on('click','.add_area_conhecimento',function(e){
            e.preventDefault();
    
            var data = {
                'descricao' : $('.descricao').val(),
            }
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'POST',
                    url:'adiciona-areaconhecimento',
                    data:data,
                    dataType:'json',
                    success:function(response){
                        if(response.status==400){
                            //erros
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
                            $('#AddArea_ConhecimentoModal').modal('hide');     
                            //inserindo a nova linha no corpo da table html 
                            var datacriacao = new Date(response.area_conhecimento.created_at).toLocaleString();
                            if(datacriacao=="31/12/1969 21:00:00"){
                                datacriacao = "";                            
                            }else{
                                datacriacao = datacriacao;
                            }                        
                            var tupla = "";
                            var linha0 = "";
                            var linha1 = "";
                                linha0 = '<tr id="novo" style="display:none;"></tr>';
                                linha1 = '<tr id="area'+response.area_conhecimento.id+'">\
                                    <td>'+response.area_conhecimento.descricao+'</td>\
                                    <td>'+datacriacao+'</td>\
                                    <td></td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.area_conhecimento.id+'" class="edit_area_conhecimento fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.area_conhecimento.id+'" data-descricao="'+response.area_conhecimento.descricao+'" class="delete_area_conhecimento_btn fas fa-trash" style="background:transparent;border:none"></button>\
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
            
        });
        //fim do envio do novo registro para o Area_ConhecimentoController
    
    });//fim do escopo geral
    
    </script>
@stop