@extends('layouts.app')

@section('content')

<!--AddArtigoModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddArtigoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header navbar navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Artigo</h5>
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
                <div class="form-group mb-3">
                    <label for="">Conteúdo</label>
                    <textarea class="conteudo form-control" cols="30" rows="10"></textarea>
                </div>                
                <!--<div class="form-group mb-3">
                    <label for="">Slug</label>
                    <input type="text" class="slug form-control">
                </div> -->
                <div class="form-group mb-3">
                <label for="">Temas</label>
                <div class="form-group mb-3">
                        @foreach($temas as $t)                        
                        <label>
                                <input type="checkbox" name="temas[]" value="{{$t->id}}">{{$t->titulo}}                            
                        </label>                        
                        @endforeach
                </div>
            </div>           
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> Fechar</button>
                <button type="button" class="btn btn-primary add_artigo"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--End AddArtigoModal-->

<!--EditArtigoModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditArtigoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
           <div class="modal-header navbar navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Artigo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="editform" name="editform" class="form-horizontal" role="form">
                <ul id="updateform_errList"></ul>
                <input type="hidden" id="edit_artigo_id">
                <div class="form-group mb-3">
                    <label for="">Título</label>
                    <input type="text" id="edit_titulo" class="titulo form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Descrição</label>
                    <input type="text" id="edit_descricao" class="descricao form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Conteúdo</label>
                    <textarea id="edit_conteudo" class="conteudo form-control" cols="30" rows="10"></textarea>
                </div>                
                <!--<div class="form-group mb-3">
                    <label for="">Slug</label>
                    <input type="text" id="edit_slug" class="slug form-control">
                </div> -->
                <div class="form-group mb-3">
                    <label for="">Temas</label>
                    <div class="form-group mb-3">
                        @foreach($temas as $t)                        
                        <label>
                            <input type="checkbox" id="check{{$t->id}}" name="temas[]" value="{{$t->id}}">{{$t->titulo}}
                        </label>                        
                        @endforeach
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_artigo"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!--Fim EditArtigoModal-->

<!--EnviarCapaModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EnviarCapaModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Enviar Capa do Artigo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="enviarcapaform" name=" enviarcapaform" class="form-horizontal" role="form" enctype="multipart/form-data">
                <ul id="updateform_errList"></ul>   
                <!-- arquivo de imagem-->
                <div class="form-group mb-3">                                                
                       <label for="">Imagem da capa</label>                        
                       <span class="btn btn-default fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="imagem" type="file" name="imagem" accept="image/x-png,image/gif,image/jpeg" data-artigoid="">
                       </span>                       
                 </div>  
                <!-- arquivo de imagem-->                                    
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>                
            </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Fim EnviarCapaModal-->

<!--EnviarPDFModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EnviarPDFModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
           <div class="modal-header navbar navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Enviar PDFs do Artigo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">                  
            <form id="enviarpdfform" name="enviarpdfform" class="form-horizontal" role="form" enctype="multipart/form-data">
                <ul id="updateform_errList"></ul>   
                <!--arquivo pdf-->
                <div class="form-group mb-3">                                                
                       <label for="">Arquivo PDF</label>                        
                       <span class="btn btn-default fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="arquivo" type="file" name="arquivo[]" accept="application/pdf" data-artigoid="" multiple>
                       </span>                       
                 </div>  
                <!--fim arquivo pdf-->                                                 
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary fazer_upload_btn">Enviar</button>
            </div>                        
            </form>
            </div>            
        </div>
    </div>
</div>
<!--Fim EnviarPDFModal-->


<!--inicio index-->

<div class="container-fluid py-5"> 
    <div id="success_message"></div>        
    <section class="border p-4 mb-4 d-flex align-items-left">    
    <form action="{{route('admin.artigos.index')}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Busca" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                <i class="fas fa-search"></i>
            </button>        
            <button type="button" class="AddArtigoModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-plus"></i></button>
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="navbar-dark bg-primary" style="color: white">
                            <tr>                                
                                <th>#</th>
                                <th>TÍTULO</th>
                                <th>AUTOR</th>
                                <th>DETALHES</th>
                                <th>MODIFICADO EM</th>
                                <th>AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_artigo">  
                        @forelse($artigos as $artigo)   
                            <tr id="art{{$artigo->id}}" data-toggle="tooltip" title="{{$artigo->descricao}}">
                                <td>{{$artigo->id}}</td>                                
                                <td>{{$artigo->titulo}}</td>
                                <td>{{$artigo->user->name}}</td>
                                <td id="lista_arquivos{{$artigo->id}}">
                                @if($artigo->imagem)
                                <label id="capa{{$artigo->id}}">Capa: Sim <button type="button" data-artigoid="{{$artigo->id}}" 
                                       data-tituloartigo="{{$artigo->titulo}}" class="capa_exclui_btn fas fa-close"
                                       style="background: transparent;border: none;"></button></label>                                                                       
                                @else
                                <label id="capa{{$artigo->id}}">Capa: Não <button type="button" data-artigoid="{{$artigo->id}}" 
                                       class="capa_envia_btn fas fa-file-image"
                                       style="background: transparent;border: none;"></button></label>                                                                                                                                              
                                @endif
                                <!--início upload de arquivos -->    
                                <label id="arquivos{{$artigo->id}}">Files: {{$artigo->arquivos->count()}} <button type="button" data-artigoid="{{$artigo->id}}" class="files_enviar_btn fas fa-file-pdf" style="background: transparent; border: none;"></button></label>
                                <br>                                    
                                @if($artigo->arquivos->count())
                                @foreach($artigo->arquivos as $arquivo)
                                <li id="arq{{$arquivo->id}}"><button type="button" data-arquivoid="{{$arquivo->id}}" data-nomearquivo="{{$arquivo->rotulo}}" class="arq_exclui_btn fas fa-close" style="background: transparent; border: none;"></button> {{$arquivo->rotulo}}</li>
                                @endforeach
                                @endif     
                                <!--fim upload de arquivos -->  
                                </td>
                                @if(is_null($artigo->updated_at))
                                <td></td>
                                @else
                                <td>{{date('d/m/Y H:i:s', strtotime($artigo->updated_at))}}</td>
                                @endif
                                <td>                                                                      
                                        <div class="btn-group">                                           
                                            <button type="button" data-id="{{$artigo->id}}" class="edit_artigo_btn fas fa-edit" style="background:transparent;border:none;"></button>
                                            <button type="button" data-id="{{$artigo->id}}" data-tituloartigo="{{$artigo->titulo}}" class="delete_artigo_btn fas fa-trash" style="background:transparent;border:none;"></button>                                  
                                        </div>                                    
                                </td>
                            </tr>  
                            @empty
                            <tr>
                                <td colspan="4">Nada Encontrado!</td>
                            </tr>                      
                            @endforelse                                                    
                        </tbody>
                    </table> 
                    <div class="col-12">
                    {{$artigos->links("pagination::bootstrap-4")}}
                    </div>  
            </div>        
</div> 
<!--fim Index-->

@endsection

@section('scripts')

<script type="text/javascript">

$(document).ready(function(){  //INÍCIO                
        
    ///inicio delete artigo
    $(document).on('click','.delete_artigo_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="_token"]').getAttribute('content');
        var id = $(this).data("id");
        var tituloartigo = $(this).data("tituloartigo");
        var resposta = confirm(tituloartigo+". Deseja excluir?");
        
        if(resposta==true){
            $.ajax({
                url: 'delete/'+id,
                type: 'POST',
                dataType: 'json',
                data:{
                    "id": id,
                    "_method": 'DELETE',
                    "_token":CSRF_TOKEN,
                },
                success:function(response){
                    if(response.status==200){                        
                        //remove linha <tr> correspondente da tabela html da view index
                        $("#art"+id).remove();                           
                        $("#success_message").addClass("alert alert-success");
                        $("#success_message").text(response.message);                         
                    }
                }
            });
        }
    
    });  
    ///fim delete artigo

    //Inicio chamada EditArtigoModal
$("#EditArtigoModal").on('shown.bs.modal',function(){
        $(".titulo").focus();
        });

    $(document).on('click','.edit_artigo_btn',function(e){
        e.preventDefault();

        var id = $(this).data("id");
        $("#editform").trigger('reset');
        $("#EditArtigoModal").modal('show');

        $.ajaxSetup({
            headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url:'edit/'+id,
            success: function(response){
                if(response.status==200){
                    $("#edit_artigo_id").val(response.artigo.id);
                    $(".titulo").val(response.artigo.titulo);
                    $(".descricao").val(response.artigo.descricao);
                    $(".conteudo").val(response.artigo.conteudo);
                    //$('.slug').val(response.artigo.slug);   
                    //Atribuindo aos checkboxs
                    $("input[name='temas[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados ao artigo
                        $.each(response.temas,function(key,values){                                                        
                                $("#check"+values.id).attr('checked',true);  //faz a marcação seletiva                         
                        });
                    }                
            }
        });    
    });
    //Fim chamada EditArtigoModal
//Inicio processo update
$(document).on('click','.update_artigo',function(e){
e.preventDefault();

            var loading = $("#imgedit");
                loading.show();
            var id = $("#edit_artigo_id").val();
            //Array apenas com os checkboxs marcados 
            var temas = new Array;
                        $("input[name='temas[]']:checked").each(function(){                
                            temas.push($(this).val());
                        });                      

            var data = {
                'titulo': $("#edit_titulo").val(),
                'descricao': $("#edit_descricao").val(),
                'conteudo': $("#edit_conteudo").val(),
                //'slug': $('#edit_slug').val(),    
                'temas':temas,   //Array
            }

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',                
                dataType:'json',
                method: 'PUT',
                url: 'update/'+id,
                data: data,
                success:function(response){                    
                    if(response.status==400){                        
                        //erros na validação
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                        $("#updateform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#updateform_errList").append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    }else if(response.status==404){                         
                        //não localizado
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                        $("#success_message").addClass('alert alert-warning');
                        $("#success_message").text(response.message);
                        loading.hide();
                    }else{
                       //sucesso na operação
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);
                        loading.hide();                  

                        $("#editform").trigger('reset');
                        $("#EditArtigoModal").modal('hide');                                          
                                
                        //atualizando a <tr> identificada na tabela html                       
                        var dataatualizacao = new Date(response.artigo.updated_at);
                            dataatualizacao = dataatualizacao.toLocaleString('pt-BR');
                        if(dataatualizacao=="31/12/1969 21:00:00"){
                            dataatualizacao="";
                        }

                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";                     
                        var limita5 = "";                     

                        limita1 = '<tr id="art'+response.artigo.id+'" data-toggle="tooltip" title="'+response.artigo.descricao+'">\
                            <td>'+response.artigo.id+'</td>\
                            <td>'+response.artigo.titulo+'</td>\
                            <td>'+response.user.name+'</td>\
                            <td id="lista_arquivos'+response.artigo.id+'"> ';
                        if(response.artigo.imagem!=null){
                        limita2 = '<label id="capa'+response.artigo.id+'">Capa: Sim <button type="button"\
                            data-artigoid="'+response.artigo.id+'"\
                            data-tituloartigo="'+response.artigo.titulo+'"\
                            class="capa_exclui_btn fas fa-close" \
                            style="background: transparent; border: none;"></button></label>'; 
                        }else{
                        limita3 = '<label id="capa'+response.artigo.id+'">Capa: Não <button type="button" \
                            data-artigoid="'+response.artigo.id+'" class="capa_envia_btn fas fa-file-image" \
                            style="background: transparent; border: none;"></button></label>';
                                    }                                
                        limita4 = '<label id="arquivos'+response.artigo.id+'">\
                                Files: '+response.totalarqs+'<button type="button" \
                                data-artigoid="'+response.artigo.id+'"\
                                class="files_enviar_btn fas fa-file-pdf" \
                                style="background: transparent; border: none;">\
                                </button></label>';                                 
                        limita5 = '</td>\
                                <td>'+dataatualizacao+'</td>\
                                <td><div class="btn-group">\
                                <button type="button" data-id="'+response.artigo.id+'" \
                                class="edit_artigo_btn fas fa-edit" \
                                style="background:transparent;border:none;"></button>\
                                <button type="button" data-id="'+response.artigo.id+'" \
                            data-tituloartigo="'+response.artigo.titulo+'" \
                            class="delete_artigo_btn fas fa-trash" \
                            style="background:transparent;border:none;"></button>\
                            </div></td>\
                            </tr>';                                             
                        var linha = limita1+limita2+limita3+limita4+limita5;            
                                $("#art"+id).replaceWith(linha);
                        if(response.totalarqs>0){
                                    $.each(response.arquivos,function(key,arq){         
                        var liPDF = '<li id="arq'+arq.id+'">\
                                    <button type="button" data-arquivoid="'+arq.id+'"\
                                    data-nomearquivo="'+arq.rotulo+'"\
                                    class="arq_exclui_btn fas fa-close" \
                                    style="background: transparent; border: none;"></button> '+arq.rotulo+'</li>';                               
                                    $("#lista_arquivos"+id).append(liPDF);
                                    });
                        }                                    
                    }
                    }
      });
});
//Fim processo update

        //chamar o AddArtigoModal
        $("#AddArtigoModal").on('shown.bs.modal',function(){
                $(".titulo").focus();
        });

        $(document).on('click','.AddArtigoModal_btn',function(e){
                    e.preventDefault();
                    $("#addform").trigger('reset');
                    $("#AddArtigoModal").modal('show');
        });       
        //Fim da chamada ao AddArtigoModal
        //Inicio da criação do artigo
        $(document).on('click','.add_artigo',function(e){
            e.preventDefault();
            var loading = $("#imgadd");
                loading.show();
            //Array apenas com os checkboxs marcados

            var temas = new Array;
            $("input[name='temas[]']:checked").each(function(){                
                temas.push($(this).val());
            });              
                        
            var data = {
                'titulo': $(".titulo").val(),
                'descricao': $(".descricao").val(),
                'conteudo': $(".conteudo").val(),
                //'slug': $('.slug').val(),
                'temas':temas,   //Array
            }
            $.ajaxSetup({                
                headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url:'store',
                type:'POST',
                dataType: 'json',
                data:data,
                success:function(response){
                if(response.status==400){
                           //erros
                            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
                            $("#saveform_errList").addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $("#saveform_errList").append('<li>'+err_values+'</li>');
                            });
          
                }else{
                //Sucesso na operação
                $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
                $("#success_message").addClass("alert alert-success");
                $("#success_message").text(response.message);
                loading.hide();
                $("#addform").trigger('reset');
                $("#AddArtigoModal").modal('hide');
                //inclui uma linha nova na tabela html
                var dataatualizacao = new Date(response.artigo.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }      
                
                var limita1 = "";
                var limita2 = "";
                var limita3 = "";
                var limita4 = "";                     

                limita1 = '<tr id="art'+response.artigo.id+'" data-toggle="tooltip" title="'+response.artigo.descricao+'">\
                    <td>'+response.artigo.id+'</td>\
                    <td>'+response.artigo.titulo+'</td>\
                    <td>'+response.user.name+'</td>\
                    <td id="lista_arquivos'+response.artigo.id+'"> ';
                limita2 = '<label id="capa'+response.artigo.id+'">Capa: Não <button type="button" \
                    data-artigoid="'+response.artigo.id+'" class="capa_envia_btn fas fa-file-image" \
                    style="background: transparent; border: none;"></button></label>';                                        
                limita3 = '<label id="arquivos'+response.artigo.id+'"> \
                    Files: 0<button type="button" data-artigoid="'+response.artigo.id+'"\
                    class="files_enviar_btn fas fa-file-pdf" \
                    style="background: transparent; border: none;">\
                    </button></label>';                                    
                limita4 = '</td>\
                    <td>'+dataatualizacao+'</td>\
                    <td><div class="btn-group">\
                    <button type="button" data-id="'+response.artigo.id+'" \
                    class="edit_artigo_btn fas fa-edit" \
                    style="background:transparent;border:none;"></button>\
                    <button type="button" data-id="'+response.artigo.id+'" \
                    data-tituloartigo="'+response.artigo.titulo+'" \
                    class="delete_artigo_btn fas fa-trash" \
                    style="background:transparent;border:none;"></button>\
                    </div></td>\
                    </tr>';              
                var linha = limita1+limita2+limita3+limita4;
                if(!$("#nadaencontrado").html()=="")
                        {
                            $("#nadaencontrado").remove();
                        }
                        $("#lista_artigo").append(linha);
                    }
                }
         });
});
//Fim da criação do artigo


//inicio do upload de imagem de capa
$(document).on('click','.capa_envia_btn',function(e){
            e.preventDefault();
            var id = $(this).data("artigoid");

            $("#enviarcapaform").trigger('reset');
            $("#EnviarCapaModal").modal('show');

            $.ajaxSetup({
                headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
            });
    
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url:'edit-capa/'+id,
                success: function(response){
                    if(response.status==200){                                                       
                        $("#imagem").attr('data-artigoid',response.artigo.id);
                    }
                }
            });
    });       

    $(document).on('change','#imagem',function(){  
      var id = $(this).data("artigoid");
      var CSRF_TOKEN = document.querySelector('meta[name="_token"]').getAttribute("content");
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
        url:'upload-capa/'+id,                
        dataType: 'json',            
        data: fd,
        cache: false,
        processData: false,
        contentType: false,                                                                                     
        success: function(response){                              
              if(response.status==200){                                        
               //Sucesso na operação
                $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                $("#success_message").addClass("alert alert-success");
                $("#success_message").text(response.message);                
                $("#enviarcapaform").trigger('reset');
                $("#EnviarCapaModal").modal('hide');
                
                var labelCapa = '<label id="capa'+response.artigo.id+'">Capa: Sim\
                                 <button type="button" data-artigoid="'+response.artigo.id+'"\
                                 data-tituloartigo="'+response.artigo.titulo+'"\
                                 class="capa_exclui_btn fas fa-close" \
                                 style="background: transparent; border: none;"></button></label>';
                $("#capa"+id).replaceWith(labelCapa);
              }   
          }                                  
    });
  }
  });  
  //fim do upload de imagem de capa
///inicio exclui capa do artigo
$(document).on('click','.capa_exclui_btn',function(e){
            e.preventDefault();        
            
            var id = $(this).data("artigoid");
            var tituloartigo = $(this).data("tituloartigo");
    
            var resposta = confirm('Excluindo CAPA de '+tituloartigo+'. Deseja prosseguir?');
    
            if(resposta==true){
            
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });
                
                $.ajax({
                    url: 'delete-capa/'+id,
                    type: 'POST',
                    dataType: 'json',                    
                    success:function(response){
                    if(response.status==200){                                                      
                    $("#success_message").addClass("alert alert-success");
                    $("#success_message").text(response.message);

                    var labelCapa = '<label id="capa'+response.artigo.id+'">Capa: Não\
                    <button type="button" data-artigoid="'+response.artigo.id+'"\
                    class="capa_envia_btn fas fa-file-pdf" \
                    style="background: transparent; border: none;"></button></label>';                    
                    $("#capa"+id).replaceWith(labelCapa);                            
                }
               }
   });                        
}        
});  
///fim exclui capa

//inicio EnviarPDFModal
$(document).on('click','.files_enviar_btn',function(e){
            e.preventDefault();
            var id = $(this).data("artigoid");

            $("#enviarpdfform").trigger('reset');
            $("#EnviarPDFModal").modal('show');

            $.ajaxSetup({
                headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
            });
    
            $.ajax({
                type: 'get',
                dataType: 'json',
                url:'edit-arquivo/'+id,
                success: function(response){
                    if(response.status==200){                                                       
                        $("#arquivo").attr('data-artigoid',response.artigo.id);           
                    }
                }
            });
    });       
//Fim EnviarPDFModal

//inicio upload múltiplos arquivos
$(document).on('click','.fazer_upload_btn',function(e){             
        e.preventDefault();                  
      var CSRF_TOKEN = document.querySelector('meta[name="_token"]').getAttribute("content");
      var formData = new FormData();            
      var id = $("#arquivo").data("artigoid");       
      let TotalFiles = $("#arquivo")[0].files.length;
      let files = $("#arquivo")[0];    

      for(let i=0; i < TotalFiles; i++){
          formData.append('arquivo'+i, files.files[i]);                            
      }

      formData.append('TotalFiles',TotalFiles);                    
      formData.append('_token',CSRF_TOKEN);
      formData.append('_enctype','multipart/form-data');
      formData.append('_method','put');      
      
      $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
                });          

     $.ajax({                                             
        url: 'upload-arquivo/'+id,              
        type:'post',
        dataType: 'json',        
        data:formData,
        cache:false,        
        contentType: false,        
        processData: false, 
        async: true,       
        success: function(response){                              
        if(response.status==200){                                        
        //Sucesso na operação
        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
        $("#success_message").addClass("alert alert-success");
        $("#success_message").text(response.message);                
        $("#enviarpdfform").trigger('reset');
        $("#EnviarPDFModal").modal('hide');
            
var labelFiles = '<label id="arquivos'+response.artigoid+'">Files: \
'+response.totalarqs+' <button type="button" \
 data-artigoid="'+response.artigoid+'" class="files_enviar_btn fas fa-file-pdf" \
 style="background: transparent; border: none;"></button></label>';
                             
 $("#arquivos"+id).replaceWith(labelFiles);                            
 $.each(response.arquivos,function(key,arq){
        $("#arq"+arq.id).remove();    
         var liPDF = '<li id="arq'+arq.id+'">\
         <button type="button" data-arquivoid="'+arq.id+'"\
         data-nomearquivo="'+arq.rotulo+'"\
         class="arq_exclui_btn fas fa-close" \
        style="background: transparent; border: none;"></button> '+arq.rotulo+'</li>';                               
        $("#lista_arquivos"+id).append(liPDF);
  });
 }   
}                                  
});  
});  
//Fim upload multiplos arquivos

///inicio exclui arquivo PDF
$(document).on('click','.arq_exclui_btn',function(e){
  e.preventDefault();        
  var CSRF_TOKEN  = document.querySelector('meta[name="_token"]').getAttribute('content');            	
  var id = $(this).data("arquivoid");
  var nomearquivo = $(this).data("nomearquivo");
    
  var resposta = confirm('Excluindo o arquivo '+nomearquivo+'. Deseja prosseguir?');
    
  if(resposta==true){
            
        $.ajaxSetup({
             headers:{
             'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    }
        });
                
        $.ajax({
        url: 'delete-arquivo/'+id,
        type: 'POST',
        dataType: 'json',  
        data:{
        "id":id,
        "_method":'DELETE',
        "_token":CSRF_TOKEN,
        },                  
        success:function(response){
        if(response.status==200){                                                      
           $("#success_message").addClass("alert alert-success");
           $("#success_message").text(response.message);
           var labelFiles = '<label id="arquivos'+response.artigoid+'">Files: \
                '+response.totalarqs+' <button type="button" \
                data-artigoid="'+response.artigoid+'"\
                class="files_enviar_btn fas fa-file-pdf \
                style="background: transparent; border: none;"></button></label>';
                             
            $("#arquivos"+response.artigoid).replaceWith(labelFiles);                            
            $("#arq"+id).remove();
        }
        }
     });                        
}        
});  
///fim exclui arquivo PDF  


});  //FIM ready

</script>

@endsection
