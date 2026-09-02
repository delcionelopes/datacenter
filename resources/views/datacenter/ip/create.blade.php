@extends('adminlte::page')

@section('title', 'Cadastro de IP')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
    }
</style>

<form role="form" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PUT')
    <ul id="saveform_errList"></ul>
    <input type="hidden" id="add_rede_id" value="{{$id}}"> 
    <header class="masthead" style="background-image: url('/assets/img/home-bg.jpg')">
         <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="post-heading">
                            <h1>Cadastro de IPs</h1>                            
                        </div>
                    </div>
                </div>
            </div>
    </header>              
    <div class="container-fluid py-5">                
        <div class="card">
        <div class="card-body">                          
                <fieldset>
                    <legend>Localização</legend>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="addorgao">Órgão</label>
                            <div class="form-group d-flex">
                            <select name="addorgao" id="addorgao" class="custom-select">
                                @foreach($orgaos as $orgao)
                                <option value="{{$orgao->id}}">{{$orgao->nome}}</option>
                                @endforeach
                            </select>
                                <button type="button" class="addorgao" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo<br>Órgão"><i class="fas fa-plus"></i></button>
                                <button type="button" class="remorgao" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Excluir<br>Órgão"><i class="fas fa-minus"></i></button>
                                <button type="button" class="editorgao" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Editar<br>Órgão"><i class="fas fa-edit"></i></button>
                            </div>
                        </div>       
                        </div>             
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="addsetor">Setor</label>
                            <div class="form-group d-flex">
                            <select name="addsetor" id="addsetor" class="custom-select">
                                <option value=""></option>
                            </select>
                                <button type="button" class="addsetor" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo<br>Setor"><i class="fas fa-plus"></i></button>
                                <button type="button" class="remsetor" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Excluir<br>Setor"><i class="fas fa-minus"></i></button>
                                <button type="button" class="editsetor" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Editar<br>Setor"><i class="fas fa-edit"></i></button>
                            </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Informações</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addip">IP</label>
                                <input type="text" id="addip" class="form-control" data-mask="099.099.099.099">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addstatus">Status</label><br>
                                <label for="" id="addstratus" style="color: green;"> LIVRE</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addmac">MAC</label>
                                <input type="text" id="addmac" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="adddescricao">Descrição</label>
                                <textarea name="descricao" id="adddescricao" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button data-color="{{$color}}" type="button" class="cancelar_btn btn btn-default">Cancelar</button>
                            <button data-color="{{$color}}" class="salvar_btn btn btn-{{$color}}" type="button"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
                        </div>
                    </div>
                </div>

            </div> <!-- card-body -->       
        </div> <!-- card -->
    </div> <!-- card-fluid -->
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
        var id = $('#add_rede_id').val();
        var loading = $('#imgadd');
            loading.show();
        var color = $(this).data("color");
            
        var data = new FormData();         
                data.append('orgao',$('#addorgao').val());
                data.append('setor',$('#addsetor').val());
                data.append('rede',id);
                data.append('ip',$('#addip').val());
                data.append('status','LIVRE');
                data.append('mac',$('#addmac').val());
                data.append('descricao',$('#adddescricao').val());
                data.append('_method','PUT');
                data.append('_token',CSRF_TOKEN);            

        $.ajax({
            url: '/datacenteradmin/ip/adiciona-ip',
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
                        loading.hide();
                } else{
                    loading.hide();
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                    loading.hide();
                    location.replace('/datacenteradmin/ip/index-ip/'+id+'/'+color);
                }  
            }  
        });

    });

    
    $(document).on('click','#addorgao',function(e){
        e.preventDefault();        
        var orgaoid = $(this).val();
         $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'/datacenteradmin/ip/carregasetores/'+orgaoid,
                success:function(response){
                    if(response.status==200){
                        const meuSelect = document.getElementById("addsetor");
                              meuSelect.options.length = 0;
                        if(response.setores!=null){                        
                        $.each(response.setores,function(key,setor){
                            $('#addsetor').append('<option value="'+setor.id+'">'+setor.sigla+'</option>');
                        });
                        }
                    }
                }
            });

    });

    $(document).on('click','.cancelar_btn',function(e){
        e.preventDefault();
        var id = $('#add_rede_id').val();
        var color = $(this).data("color");
        location.replace('/datacenteradmin/ip/index-ip/'+id+'/'+color);
    });

      ///tooltip
    $(function(){             
        $(".addorgao").tooltip();
        $(".remorgao").tooltip();        
        $(".editorgao").tooltip();
        $(".addsetor").tooltip();
        $(".remsetor").tooltip();        
        $(".editsetor").tooltip();        
    });
    ///fim tooltip
    
    

});

</script>

@stop