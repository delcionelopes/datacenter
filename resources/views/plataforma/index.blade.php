@extends('adminlte::page')

@section('title', 'Datacenter')

@section('body')
    <!--AddPlataformaModal-->

<div class="modal fade" id="AddPlataformaModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Plataforma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
                <form id="myform" name="myform" class="form-horizontal" role="form">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" class="nome_plataforma form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" >Fechar</button>
                    <button type="button" class="btn btn-primary add_plataforma">Salvar</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!--fim AddPlataformaModal-->

<!--EditPlataformaModal-->
<div class="modal fade" id="EditPlataformaModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Plataforma</h5>
                <button type="button" class="close" data-dismiss="modal" arial-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="myform" name="myform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>

                    <input type="hidden" id="edit_plataforma_id">
                    <div class="form-group mb-3">
                        <label for="">Nome</label>
                        <input type="text" id="edit_nome_plataforma" class="nome_plataforma form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary update_plataforma">Atualizar</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!--fim EditPlataformaModal-->

<!--index-->
<div class="container py-5">
    <div id="success-message"></div>
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('admin.plataforma.index')}}"  class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisanome" class="form-control rounded float-left" placeholder="Nome da plataforma" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;"><i class="fas fa-search"></i></button>
                            <button type="button" class="AddPlataformaModal_btn input-group-text border-0" style="background: transparent;border: none;"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </form>                
            </section>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>PLATAFORMAS</th>
                        <th>CRIADO EM</th>
                        <th>MODIFICADO EM</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_plataforma">
                <tr id="novo" style="display:none;"></tr>
                    @forelse($plataformas as $plataforma)
                    <tr id="plataforma{{$plataforma->id}}">
                        <td>{{$plataforma->nome_plataforma}}</td>
                        @if(is_null($plataforma->created_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($plataforma->created_at))}}</td>
                        @endif
                        @if(is_null($plataforma->updated_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($plataforma->updated_at))}}</td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$plataforma->id}}" class="edit_plataforma fas fa-edit" style="background: transparent; border: none;"></button>
                                <button type="button" data-id="{{$plataforma->id}}" data-nomeplataforma="{{$plataforma->nome_plataforma}}" class="delete_plataforma_btn fas fa-trash" style="background: transparent;border: none;"></button>
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
                  {{$plataformas->links()}}                       
    </div>
</div>

<!--fim index-->
@stop

@section('js')
<script type="text/javascript">

    $(document).ready(function(){
        //inicio delete plataforma
        $(document).on('click','.delete_plataforma_btn',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");
            var nomeplataforma = $(this).data("nomeplataforma");
            swal({
                title:"Processo de exclusão!",
                text: "Você vai excluir "+nomeplataforma+". Deseja prosseguir?",
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
                    url:'delete-plataforma/'+id,
                    type:'POST',
                    dataType:'json',
                    data:{
                        "id":id,
                        "_method":'DELETE',
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove a linha correspondente da tabela html
                            $("#plataforma"+id).remove();
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);         
                        }
                    }
                });
            }
        });
    
        });//fim delete plataforma
    
        //inicio exibição edit plataforma
        $('#EditPlataformaModal').on('shown.bs.modal',function(){
            $('#edit_nome_plataforma').focus();
        });
    
        $(document).on('click','.edit_plataforma',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");
            $('#myform').trigger('reset');
            $('#EditPlataformaModal').modal('show');
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'GET',
                    dataType:'json',
                    url: 'edit-plataforma/'+id,
                    success:function(response){
                        if(response.status==200){
                            $('.nome_plataforma').val(response.plataforma.nome_plataforma);
                            $('#edit_plataforma_id').val(response.plataforma.id);
                        }
                    }
                });
    
        });//fim exibição do edit plataforma
    
        //inicio da atualização da plataforma
    
        $(document).on('click','.update_plataforma',function(e){
            e.preventDefault();
    
            $(this).text("Atualizando...");
    
            var id = $('#edit_plataforma_id').val();
    
            var data = {
                'nome_plataforma' : $('#edit_nome_plataforma').val(),
            }
            
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'POST',
                    data: data,
                    dataType:'json',
                    url:'update-plataforma/'+id,
                    success:function(response){
                        if(response.status==400){
                            //erros
                            $('#updateform_errList').html("");
                            $('#updateform_errList').addClass('alert alert-danger');
                            $.each(response.errors,function(key,err_values){
                                $('#updateform_errList').append('<li>'+err_values+'</li>');
                            });
                            $('#update_plataforma').text("Atualizado");
                        }else if(response.status==404){
                            $('#updateform_errList').html("");
                            $('#success_message').addClass('alert alert-warning');
                            $('#success_message').text(response.message);
                            $('.update_plataforma').text("Atualizado");                        
                        }else{
                            $('#updateform_errList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.update_plataforma').text("Atualizado");
    
                            $('#myform').trigger('reset');
                            $('#EditPlataformaModal').modal('hide');
    
                            var datacriacao = new Date(response.plataforma.created_at).toLocaleString();
                            if(datacriacao=="31/12/1969 21:00:00"){
                                datacriacao = "";                            
                            }else{
                                datacriacao = datacriacao;
                            }
                            var dataatualizacao = new Date(response.plataforma.updated_at).toLocaleString();
                            if(dataatualizacao=="31/12/1969 21:00:00"){
                                dataatualizacao = "";                            
                            }else{
                                dataatualizacao = dataatualizacao;
                            }
    
                            var linha = '<tr id="plataforma'+response.plataforma.id+'">\
                                    <td>'+response.plataforma.nome_plataforma+'</td>\
                                    <td>'+datacriacao+'</td>\
                                    <td>'+dataatualizacao+'</td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.plataforma.id+'" class="edit_plataforma fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.plataforma.id+'" data-nomeplataforma="'+response.plataforma.nome_plataforma+'" class="delete_plataforma_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';    
                            $("#plataforma"+id).replaceWith(linha); 
    
                        }
                    }
                });
    
        });//fim da atualização da plataforma
    
    //exibe form de adição de registro
    $('#AddPlataformaModal').on('shown.bs.modal',function(){
            $('.nome_plataforma').focus();
        });
    
    $(document).on('click','.AddPlataformaModal_btn',function(e){                  
            e.preventDefault();       
                                              
            $('#myform').trigger('reset');
            $('#AddPlataformaModal').modal('show');                
    
        });
    
    //fim exibe form de adição de registro
    
    
        //início da adição de plataforma
    
        $(document).on('click','.add_plataforma',function(e){
            e.preventDefault();
    
            var data = {
                'nome_plataforma' : $('.nome_plataforma').val(),
            }        
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type:'POST',
                    url:'adiciona-plataforma',
                    data: data,
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
                            $('#AddPlataformaModal').modal('hide');
    
                            //adiciona a linha na tabela html
                            
                            var datacriacao = new Date(response.plataforma.created_at).toLocaleString();
                            if(datacriacao=="31/12/1969 21:00:00"){
                                datacriacao = "";                            
                            }else{
                                datacriacao = datacriacao;
                            }                       
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="plataforma'+response.plataforma.id+'">\
                                    <td>'+response.plataforma.nome_plataforma+'</td>\
                                    <td>'+datacriacao+'</td>\
                                    <td></td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.plataforma.id+'" class="edit_plataforma fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.plataforma.id+'" data-nomeplataforma="'+response.plataforma.nome_plataforma+'" class="delete_plataforma_btn fas fa-trash" style="background:transparent;border:none"></button>\
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
    
        });//fim da adição de plataforma
    
    
    }); //fim do escopo geral
    
    </script>
@stop

