@extends('adminlte::page')

@section('title', 'Edição de Entidade')

@section('content')

<form role="form" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PUT')
    <ul id="saveform_errList"></ul>
    <input type="hidden" id="edit_entidade_id" value="{{$entidade->id}}">
    <div class="container-fluid py-5">
        <div class="card">
            <div class="card-body">
              <div class="card p-3" style="background-image: url('/assets/img/home-bg.jpg')">
                <div class="d-flex align-items-center">
                    <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <div class="image">           
                        @if($entidade->logo)                 
                            <img src="{{asset('storage/'.$entidade->logo')}}" class="imgico rounded-circle" width="100" >
                        @else
                            <img src="{{asset('storage/user.png')}}" class="imgico rounded-circle" width="100" >
                        @end    
                        </div>
                       <label for="">Logo</label>                        
                       <span class="btn btn-none fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="upimagem" type="file" name="imagem" class="btn btn-{{$color}}" accept="image/x-png,image/gif,image/jpeg">
                       </span>                       
                     </div>  
                     <!--arquivo de imagem--> 
                </div>
              </div>
                  <fieldset>
                    <legend>Dados da Entidade</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" required class="nome form-control" name="nome" id="nome" placeholder="Nome da entidade" value="{{$entidade->nome}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="sigla">Sigla</label>
                                <input type="text" required class="sigla form-control" name="sigla" id="sigla" placeholder="Sigla da entidade" value="{{$entidade->sigla}}">
                            </div>
                        </div>
                    </div>                    
                </fieldset>
                <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Vínculos institucionais</legend>
                                <div class="form-check">                                                                        
                                    @foreach ($institucionais as $institucional)
                                    @if($entidade->institucionais->count())
                                        @foreach($entidade->institucionais as $institucionalentidade)
                                        @if(($institucional->id) == ($institucionalentidade->id))
                                        <label class="form-check-label" for="check{{$institucional->id}}">
                                            <input type="checkbox" id="check{{$institucional->id}}" name="institucionais[]" value="{{$institucional->id}}" class="form-check-input" checked> {{$institucional->sigla}}
                                        </label><br>
                                        @break
                                        @elseif ($loop->last)
                                        <label class="form-check-label" for="check{{$institucional->id}}">
                                            <input type="checkbox" id="check{{$institucional->id}}" name="institucionais[]" value="{{$institucional->id}}" class="form-check-input"> {{$institucional->sigla}}
                                        </label><br>
                                        @endif
                                        @endforeach
                                    @else
                                    <label class="form-check-label" for="check{{$institucional->id}}">
                                        <input type="checkbox" id="check{{$institucional->id}}" name="institucionais[]" value="{{$institucional->id}}" class="form-check-input"> {{$institucional->sigla}}
                                    </label><br>
                                    @endif
                                    @endforeach
                                </div>
                            </fieldset>   
                     </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button type="button" data-color="{{$color}}" class="cancelar_btn btn btn-default">Cancelar</button>
                            <button class="salvar_btn btn btn-{{$color}}" data-color="{{$color}}" type="button"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
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
        var color = $(this).data("color");
        
        var institucionais = new Array();
                $("input[name='institucionais[]']:checked").each(function(){
                    institucionais.push($(this).val());
                });        
        
        var id = $('#edit_entidade_id').val();

        var data = new FormData();        
            
            data.append('nome',$('#nome').val());
            data.append('sigla',$('#sigla').val());
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('institucionais',JSON.stringify(institucionais)); //array
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');              

        $.ajax({
            url: '/admin/entidades/update/'+id,
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
                } else{
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');  
                    loading.hide();
                     location.replace('/admin/entidades/index/'+color);
                }  
            }  
        });

    });

    //upload da imagem temporária
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
                url:'/admin/entidades/imagemtemp-upload',                
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
                        var linkimagem = "{{asset('')}}"+arq;
                        var imagemnova = '<img src="'+linkimagem+'" class="imgico rounded-circle" width="100" >';
                        $(".imgico").replaceWith(imagemnova);
                    }   
                }                                  
            });
        }
        });   
    //fim upload da imagem temporária
    ///excluir imagem temporária pelo cancelamento
    $(document).on('click','.cancelar_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var files = $('#upimagem')[0].files;
        var color = $(this).data("color");

        if(files.length > 0){
        var data = new FormData();
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('_token',CSRF_TOKEN);
            data.append('_enctype','multipart/form-data');
            data.append('_method','delete');   
             $.ajax({                      
                type: 'POST',                             
                url:'/admin/entidades/delete-imgtemp',                
                dataType: 'json',            
                data: data,
                cache: false,
                processData: false,
                contentType: false,                                                                                     
                success: function(response){                              
                    if(response.status==200){
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                    location.replace('/admin/entidades/index/'+color);
                } 
                }                                  
            });

        }else{
            location.replace('/admin/entidades/index/'+color);
        }

    });
    //fim excluir imagem temporária pelo cancelamento

});

</script>

@stop