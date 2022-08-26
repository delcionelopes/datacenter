@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')
   <!--AddManualForm-->
 <div class="modal fade" id="AddManualForm" tabindex="-1" role="dialog" aria-labelledby="titleModaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Manual</h5>
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
                    <div class="form-group mb-3">
                        <label for="">Área de Conhecimento</label>
                        <select name="area_id" id="area_id" class="custom-select">
                            @foreach($areas_conhecimento as $area)
                            <option value="{{$area->id}}">{{$area->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Objetivo</label>
                        <textarea name="objetivo" id="objetivo" cols="30" rows="10" class="objetivo form-control"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Manual</label>
                        <textarea name="manual" id="manual" cols="30" rows="10" class="manual form-control"></textarea>
                    </div>                                        
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" >Fechar</button>
                    <button type="button" class="btn btn-primary add_manual_btn">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div> 
<!--fim AddManualForm-->

<!--EditManualForm-->
<div class="modal fade" id="EditManualForm" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Manual</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editmyform" name="editmyform" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_manual_id">
                    <div class="form-group mb-3">
                        <label for="">Descrição</label>
                        <input type="text" id="edit_descricao" class="descricao form-control">
                    </div>
                    <div class="form-group bm-3">
                        <select name="area_id" id="area_id" class="custom-select">
                            @foreach($areas_conhecimento as $area)
                            <option value="{{$area->id}}">{{$area->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Objetivo</label>
                        <textarea name="edit_objetivo" id="edit_objetivo" cols="30" rows="10" class="objetivo form-control"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Manual</label>
                        <textarea name="edit_manual" id="edit_manual" cols="30" rows="10" class="manual form-control"></textarea>
                    </div>                    
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary update_manual">Atualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>  
<!--fim EditManualForm-->

<!--inicio upload multiplo de arquivos manuais-->
<div class="modal fade" id="uploadPDFModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Upload de Manual PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="uploadmyform" name="uploadmyform" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <ul id="updateform_errList"></ul>                    
                   <!--arquivo pdf-->
                   <div class="form-group mb-3">                                                
                       <label for="">Arquivo PDF</label>                        
                       <span class="btn btn-default fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="arquivo" type="file" name="arquivo[]" accept="application/pdf" data-manualid="" multiple>
                       </span>                       
                   </div>  
                   <!--fim arquivo pdf-->                                     
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary upload_manual">Enviar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>  
<!--fim upload multiplo de arquivos manuais-->

<!--index-->
<div class="container py-5">
    <div id="success_message"></div>
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('admin.manual.index')}}" class="form-search" method="GET">                                      
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Descrição do manual" aria-label="Search" aria-labelledby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                            <i class="fas fa-search"></i>
                            </button>                
                            <button class="Add_Manual_btn input-group-text border-0" style="background: transparent;border: none;">
                            <i class="fas fa-plus"></i>
                            </button>            
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>MANUAIS</th>
                        <th>AREAS REF</th>
                        <th>ARQUIVO</th>
                        <th>CRIADO EM</th>
                        <th>MODIFICADO EM</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_manual">  
                <tr id="novo" style="display:none;"></tr>                  
                    @forelse($manuais as $manual)
                    <tr id="man{{$manual->id}}">                       
                        <td>{{$manual->descricao}}</td>
                        <td>{{$manual->area_conhecimento->descricao}}</td>
                        <td id="uploads{{$manual->id}}">
                        <label id="files{{$manual->id}}">Files: {{$manual->uploads->count()}} </label><button type="button" id="upload_files_btn" data-manualid="{{$manual->id}}" class="fas fa-file-pdf" style="background: transparent;border: none;"></button>    
                        @if($manual->uploads->count())    
                            @foreach($manual->uploads as $upload)                                                        
                            <li id="up{{$upload->id}}">
                                <i data-filename="{{$upload->nome_arquivo}}" data-id="{{$upload->id}}" class="download_file_btn fas fa-download"></i>
                                <i data-filename="{{$upload->nome_arquivo}}" data-id="{{$upload->id}}" class="delete_file_btn fas fa-trash"></i> 
                                {{$upload->nome_arquivo}}</li>
                            <br>
                            @endforeach
                        @endif    
                        </td>
                        @if(is_null($manual->created_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($manual->created_at))}}</td>
                        @endif
                        @if(is_null($manual->updated_at))
                        <td></td>
                        @else
                        <td>{{date('d/m/Y H:i:s', strtotime($manual->updated_at))}}</td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button data-id="{{$manual->id}}" class="edit_manual_btn fas fa-edit" style="background: transparent;border: none;"></button>
                                <button data-id="{{$manual->id}}" data-descricao="{{$manual->descricao}}" class="delete_manual_btn fas fa-trash" style="background: transparent;border: none;"></button>
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
            {{$manuais->links()}}   
    </div>
</div>

<!--fim index-->
@stop

@section('css')
    <link rel="stylesheet" href="vendor/adminlte/dist/css/adminlte.min.css">
@stop

@section('js')
<script type="text/javascript">

    //inicio do escopo geral
    $(document).ready(function(){
        
        //inicio delete registro
        $(document).on('click','.delete_manual_btn',function(e){
            e.preventDefault();
            var id = $(this).data("id");
            var descricao = $(this).data("descricao");        
            swal({
                title: "Exclusão!",
                text: "Deseja excluir "+descricao+"?",
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
                        url:'delete-manual/'+id,                    
                        type: 'POST',
                        dataType:'json',
                        data:{
                            "id":id,
                            "_method":'DELETE',
                        },
                        success:function(response){
                            if(response.status==200){
                                //remove tr correspondente na tabela html
                                $('#man'+id).remove();
                                $('#success_message').addClass('alert alert-success');
                                $('#success_message').text(response.message);         
                            }
                        }
                    });
                }        
            });    
        });//fim delete registro
        //inicio exibe EditManualForm
        $('#EditManualForm').on('shown.bs.modal',function(){
            $('#edit_descricao').focus();
        });
        $(document).on('click','.edit_manual_btn',function(e){
            e.preventDefault();
            var id = $(this).data("id");
            $('#editmyform').trigger('reset');
            $('#EditManualForm').modal('show');
    
            $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                        }
                    });
    
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'edit-manual/'+id,
                success:function(response){
                    if(response.status==200){
                        $('.descricao').val(response.manual.descricao);
                        //seta a area de conhecimento no select html
                        var opcao = response.area_conhecimento.id;
                        $('#area_id option')
                        .removeAttr('selected')
                        .filter('[value='+opcao+']')
                        .attr('selected',true);
                        //fim seta area_conhecimento
                        $('.objetivo').text(response.manual.objetivo);
                        $('.manual').text(response.manual.manual);
                        $('#edit_manual_id').val(response.manual.id);                          
                        $('#fileupload').attr('data-manualid',response.manual.id);
                    }
                }
            });
        });//fim EditManualForm
    
        //inicio reconfigura o option selected do select html
        $('select[name="area_id"]').on('change',function(){
            var opt = this.value;
                      $('#area_id option')
                      .removeAttr('selected')
                      .filter('[value='+opt+']')
                      .attr('selected',true);
        });
        //fim reconfigura o option selected do select html
    
        //inicio da atualização do registro
        $(document).on('click','.update_manual',function(e){
            e.preventDefault();                
    
            $(this).text("Atualizando...");
            
            var opt = $('#area_id').val();        
            var id = $('#edit_manual_id').val();        
            var data = {
                'area_conhecimento_id' : opt,
                'descricao' : $('#edit_descricao').val(),
                'objetivo' : $('#edit_objetivo').text(),
                'manual' : $('#edit_manual').text(),
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
                url:'update-manual/'+id,
                success:function(response){            
                    if(response.status==400){
                    //erros
                        $('#updateform_errList').html("");
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key, err_values){
                        $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });  
                        $('.update_manual').text("Atualizado");
                    }else if(response.status==404){
                        $('#updateform_errList').html("");
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        $('.update_manual').text("Atualizado");
                    }else{
                        $('#updateform_errList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.update_manual').text("Atualizado");
    
                        $('#editmyform').trigger('reset');
                        $('#EditManualForm').modal('hide');
    
                        //atualizando a tr da tabela html
                        var datacriacao = new Date(response.manual.created_at);
                            datacriacao = datacriacao.toLocaleString("pt-BR");
                            if(datacriacao=="31/12/1969 21:00:00"){
                                datacriacao = "";                            
                            }
                            var dataatualizacao = new Date(response.manual.updated_at);
                                dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                            if(dataatualizacao=="31/12/1969 21:00:00"){
                                dataatualizacao = "";                            
                            }
                        var linha = '<tr id="man'+response.manual.id+'">\
                                    <td>'+response.manual.descricao+'</td>\
                                    <td>'+response.area_conhecimento.descricao+'</td>\
                                    <td id="uploads'+response.manual.id+'"></td>\
                                    <td>'+datacriacao+'</td>\
                                    <td>'+dataatualizacao+'</td>\
                                    <td>\
                                    <div class="btn-group">\
                                    <button type="button" data-id="'+response.manual.id+'" class="edit_manual_btn fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.manual.id+'" data-descricao="'+response.manual.descricao+'" class="delete_manual_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div>\
                                    </td>\
                                    </tr>';                             
                         $("#man"+id).replaceWith(linha);                                          
                    }
                }           
            
            });
        });//fim atualização do registro
    
        //inicio exibição do form AddManualForm
        $('#AddManualForm').on('shown.bs.modal',function(){
            $('.descricao').focus();
        });
        $(document).on('click','.Add_Manual_btn',function(e){
            e.preventDefault();
            $('#myform').trigger('reset');
            $('#AddManualForm').modal('show');
        });//fim exibição do form AddManualForm
    
        //inicio do envio do novo registro para o controller
        $(document).on('click','.add_manual_btn',function(e){
            e.preventDefault();       
                  
            var dataAdd = {
                'area_conhecimento_id' : $('#area_id').val(),
                'descricao' : $('.descricao').val(),
                'objetivo' : $('.objetivo').val(),
                'manual' : $('.manual').val(),
                //'arquivo' : $(':file').val('content'),
            }
    
            $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                        }
                    });
    
            $.ajax({
                type:'POST',
                url:'adiciona-manual',
                data:dataAdd,
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
                        $('#AddManualForm').modal('hide');
    
                        //atualizando a tr da tabela html
                        var datacriacao = new Date(response.manual.created_at);
                            datacriacao = datacriacao.toLocaleString("pt-BR");
                            if(datacriacao=="31/12/1969 21:00:00"){
                                datacriacao = "";                            
                            }                        
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="man'+response.manual.id+'">\
                                    <td>'+response.manual.descricao+'</td>\
                                    <td>'+response.area_conhecimento.descricao+'</td>\
                                    <td id="uploads'+response.manual.id+'"></td>\
                                    <td>'+datacriacao+'</td>\
                                    <td></td>\
                                    <td>\
                                    <div class="btn-group">\
                                    <button type="button" data-id="'+response.manual.id+'" class="edit_manual_btn fas fa-edit" style="background:transparent;border:none;"></button>\
                                    <button type="button" data-id="'+response.manual.id+'" data-descricao="'+response.manual.descricao+'" class="delete_manual_btn fas fa-trash" style="background:transparent;border:none;"></button>\
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
        });
        //fim do envio do novo registro para o controller 
    
    ///tratamento dos uploads e downloads
    
    $(document).on('click','.delete_file_btn',function(e){                                                   
        e.preventDefault();
    
        var id = $(this).data("id");        
        var filename = $(this).data("filename");  
    
        swal({
                title: filename,
                text: "Deseja excluir?",
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
                        url:'delete-file/'+id,                    
                        type: 'POST',
                        dataType:'json',
                        data:{
                            "id":id,
                            "_method":'DELETE',
                        },
                        success:function(response){
                            if(response.status==200){                            
                                //atualiza qtd arquivos
                                var labelhtml = '<label id="files'+response.manualid+'">Files: '+response.totalfiles+' </label>';
                                $("#files"+response.manualid).replaceWith(labelhtml);                            
                                //remove li correspondente na td da tabela html
                                $('#up'+id).remove();                            
                            }
                        }
                    });
                }else{
                    swal(filename,"O seu registro não foi deletado!","error");
                }        
        });   
    }); 
           
        
    
        $(document).on('click','.download_file_btn',function(e){                                                                       
            e.preventDefault();
    
            var id = $(this).data("id");                                              
            var filename = $(this).data("filename");       
            
           $.ajax({
               type: 'GET',
               url: 'download-file/'+id,
               cache: false,  
               data: '',                                           
               xhrFields: {
               responseType: 'blob'
              },
              success: function(response){   
                console.log(response);
                     var blob = new Blob([response]);
                          
                     var link = document.createElement('a');
                         link.href = URL.createObjectURL(blob);
                         link.download = filename;
                         link.click();                           
                    },            
                    
                    error: function(blob){
                    console.log(blob);
                }
            }); 
        }); 
    
        });         
    
    
        //inicio exibição do form uploadPDFModal       
        $(document).on('click','#upload_files_btn',function(e){
            e.preventDefault();
            
            var id = $(this).data("manualid");        
    
            $('#uploadmyform').trigger('reset');
            $('#uploadPDFModal').modal('show');                        
            $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                        }
                    });                
            $.ajax({
                url:'edit-uploadfile/'+id,
                type:'get',
                dataType:'json',            
                success:function(response){
                    if(response.status==200){                                          
                        $('#arquivo').attr('data-manualid',response.manual.id);                                                            
                    }
                }            
            });
        });//fim exibição do form uploadPDFModal
    
    
        $(document).on('change','#arquivo',function(){  
          //e.preventDefault();
          var CSRF_TOKEN = document.querySelector('meta[name="_token"]').getAttribute("content");      
          var formData = new FormData();
          var id = $('#arquivo').data("manualid");            
          let TotalFiles = $('#arquivo')[0].files.length;                        
          let files = $('#arquivo')[0];      
          
          if(TotalFiles > 0){
          // Append data       
          for(let i = 0; i < TotalFiles; i++) {
              formData.append('arquivo'+i,files.files[i]);          
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
            url:'upload-file/'+id,  
            type: 'post',              
            dataType: 'json',            
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            async:true,                                                                                   
            success: function(response){                              
                  if(response.status==200){     
                      $('#updateform_errList').html("");
                      $('#success_message').addClass('alert alert-success');
                      $('#success_message').text(response.message);           
                      $('#uploadmyform').trigger('reset');
                      $('#uploadPDFModal').modal('hide');
                      var labelhtml = '<label id="files'+response.manualid+'">Files: '+response.totalfiles+' </label>';
                     $('#files'+response.manualid).replaceWith(labelhtml);                    
                      $.each(response.arquivos,function(key,arq){
                      $('#up'+arq.id).remove();
                     var item = '<li id="up'+arq.id+'">'+arq.nome_arquivo+
                                '<i data-filename="'+arq.nome_arquivo+'" data-id="'+arq.id+'" class="download_file_btn fas fa-download"></i>'+
                                '<i data-filename="'+arq.nome_arquivo+'" data-id="'+arq.id+'" class="delete_file_btn fas fa-trash"></i>'+
                                '</li><br>';
                       $('#uploads'+response.manualid).append(item);                
                       });                                                                                                                                       
              } 
            }
                                     
        });
       }
      
      });  
    
    
    ///fim tratamento dos uploads e downloads
    
    });//fim do escopo geral
    
    </script>
@stop