@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')
    <!--inicio AddBaseModal -->
<div class="modal fade" id="AddBaseModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Base de dados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_vm_id">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Virtual Machine:</label>
                        <label for="" id="nome_vm" style="font-style:italic;"></label>
                    </div> 
                    <div class="form-group mb-3">
                        <label for="">Projeto</label>
                        <select name="projeto_id" id="projeto_id" class="custom-select">
                            @foreach($projetos as $projeto)
                            <option value="{{$projeto->id}}">{{$projeto->nome_projeto}}</option>
                            @endforeach
                        </select>
                    </div>                    
                    <div class="form-group mb-3">
                        <label for="">Nome da base</label>
                        <input type="text" class="nome_base form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" class="ip form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Dono</label>
                        <input type="text" class="dono form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Encoding</label>
                        <input type="text" class="encoding form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_base_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- fim AddBaseModal -->

<!--inicio EditBaseModal -->
<div class="modal fade" id="EditBaseModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Base de dados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <input type="hidden" id="edit_vm_id">
                    <input type="hidden" id="edit_base_id">
                    <ul id="updateform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Virtual Machine:</label>
                        <label for="" id="edit_nome_vm" style="font-style:italic;"></label>
                    </div> 
                    <div class="form-group mb-3">                        
                        <label for="">Projeto</label>
                        <select name="projeto_id" id="projeto_id" class="custom-select">
                            @foreach($projetos as $projeto)
                            <option value="{{$projeto->id}}">{{$projeto->nome_projeto}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nome da base</label>
                        <input type="text" id="nome_base" class="edit_nome_base form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">IP</label>
                        <input type="text" id="ip" class="edit_ip form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Dono</label>
                        <input type="text" id="dono" class="edit_dono form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Encoding</label>
                        <input type="text" id="encoding" class="edit_encoding form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_base_btn">Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- fim EditBaseModal -->

<!-- início AddAppModal -->
<div class="modal fade" id="AddAppModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar APP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addappform" name="addappform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_base_id">
                    <ul id="saveform_errListApp"></ul>
                    <div class="form-group mb-3">
                        <label for="">VM:</label>
                        <label id="add_nome_vm" style="font-style: italic;"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Base:</label>
                        <label id="add_nome_base" style="font-style: italic;"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Base:</label>
                        <select name="add_selbase_id" id="add_selbase_id" class="custom-select">
                            @foreach($bds as $base)
                            <option value="{{$base->id}}">{{$base->nome_base}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Órgão:</label>
                        <select name="add_selorgao_id" id="add_selorgao_id" class="custom-select">
                            @foreach($orgaos as $orgao)
                            <option value="{{$orgao->id}}">{{$orgao->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Projeto:</label>
                        <select name="add_selprojeto_id" id="add_selprojeto_id" class="custom-select">
                            @foreach($projetos as $projeto)
                            <option value="{{$projeto->id}}">{{$projeto->nome_projeto}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nome APP:</label>
                        <input type="text" class="add_nome_app form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Domínio:</label>
                        <input type="text" class="add_dominio form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for=""> 
                        <input type="checkbox" name="add_https" id="add_https" value=""> HTTPS
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_app_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim AddAppModal -->

<!--index-->
<div class="container py-5">
    <div id="success_message"></div>        
            <section class="border p-4 mb-4 d-flex align-items-left">
            <form action="{{route('datacenter.base.index',['id'=>$id])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="hidden" id="vmid" value="{{$id}}">  
                            <input type="hidden" id="vmnome" value="{{$vm->nome_vm}}">                        
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome da base" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="input-group-text border-0" id="search-addon" style="background:transparent;border: none;">
                               <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-id="{{$id}}" data-nome_vm="{{$vm->nome_vm}}" class="AddBase_btn input-group-text border-0" style="background: transparent;border: none;">
                               <i class="fas fa-plus"></i>
                            </button>                              
                        </div>
                    </div>
            </form>    
            </section>
            <table class="table table-hover">
                <thead class="sidebar-dark-primary" style="color: white">
                    <tr>                        
                        <th scope="col">BASE(s)</th>
                        <th scope="col">IP</th>
                        <th scope="col">Dono</th>
                        <th scope="col">APP(s)</th>                        
                        <th scope="col">AÇÕES</th>                       
                    </tr>                    
                </thead>
                <tbody id="lista_bases">
                    <tr id="novo" style="display:none;"></tr>
                    @forelse($bases as $base)
                    <tr id="base{{$base->id}}">                        
                        <th scope="row">{{$base->nome_base}}</th>
                        <td>{{$base->ip}}</td>
                        <td>{{$base->dono}}</td>
                        <td>
                        <div class="btn-group">
                        @if($base->apps->count())
                        <form action="{{route('datacenter.app.index',['id'=>$base->id])}}" method="get">
                            <button type="submit" data-id="{{$base->id}}" class="list_app_btn fas fa-desktop" style="background: transparent;border:none;color: green;"> {{$base->apps->count()}}</button>
                        </form>
                        @else
                        <button type="button" data-id="{{$base->id}}" data-nome_base="{{$base->nome_base}}" class="novo_app_btn fas fa-folder" style="background: transparent;border:none;color: orange;"></button>
                        @endif
                        </div>
                        </td>                        
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$base->id}}" class="edit_base_btn fas fa-edit" style="background: transparent;border: none;"></button>
                                <button type="button" data-id="{{$base->id}}" data-nomebase="{{$base->nome_base}}" class="delete_base_btn fas fa-trash" style="background: transparent;border: none;"></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="nadaencontrado">
                        <td class="col-12">Nada Encontrado!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex hover justify-content-center">
                {{$bases->links()}}               
            </div>           
            <div>
                <button type="button" class="fas fa-arrow-left" style="background: transparent; border: none;" onclick="history.back()"></button>
            </div>
     
</div>
<!--Fim Index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){
    
        //inicio delete base
        $(document).on('click','.delete_base_btn',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");
            var nomebase = $(this).data("nomebase");
    
            swal({
                title: nomebase,
                text: "Deseja excluir?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(willDelete=>{
                if(willDelete){
                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/datacenter/delete-base/'+id,
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            "id":id,
                            "_method":'DELETE',
                        },
                        success:function(response){
                            if(response.status==200){
                                //remove a linha da table html
                                $('#base'+id).remove();
                                $('#success_message').addClass('alert alert-success');
                                $('#success_message').text(response.message);
                            }
                        }
                    });
                }
            });
        });
        //fim delete base
    
        //inicio exibe EditBaseModal
        $('#EditBaseModal').on('shown.bs.modal',function(){
            $('#nome_base').focus();
        });    
        $(document).on('click','.edit_base_btn',function(e){
            e.preventDefault();
    
            var id = $(this).data("id");
            $("#editform").trigger('reset');
            $("#EditBaseModal").modal('show');
    
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '/datacenter/edit-base/'+id,
                success:function(response){
                    if(response.status==200){
                        //seta projeto
                        var opcao = response.projeto.id;
                        $('#projeto_id option')
                        .removeAttr('selected')
                        .filter('[value='+opcao+']')
                        .attr('selected',true);
                        //fim seta projeto
                        $('#edit_nome_vm').html('<Label id="edit_nome_vm" style="font-style:italic;">'+response.vm.nome_vm+'</Label>');
                        $('#nome_base').val(response.base.nome_base);
                        $('#ip').val(response.base.ip);
                        $('#dono').val(response.base.dono);
                        $('#encoding').val(response.base.encoding);
                        $('#edit_vm_id').val(response.base.virtual_machine_id);
                        $('#edit_base_id').val(response.base.id);
                    }
                }
            });
        });
        //fim exibe EditBaseModal
        //reconfigura o option selected do select html
        $('select[name="projeto_id"]').on('change',function(){
            var opt = this.value;
            $('#projeto_id option')
            .removeAttr('selected')
            .filter('[value='+opt+']')
            .attr('selected',true);
        }); 
        //reconfigura o option selected do select html
    
        //inicio da atualização do registro
        $(document).on('click','.update_base_btn',function(e){
            e.preventDefault();
    
            $(this).text('Atualizando...');
    
            var optprojeto = $('#projeto_id').val();
            var id = $('#edit_base_id').val();
            var data = {
                'projeto_id': optprojeto,
                'virtual_machine_id': $('#edit_vm_id').val(),
                'nome_base': $('.edit_nome_base').val(),
                'ip': $('.edit_ip').val(),
                'dono': $('.edit_dono').val(),
                'encoding': $('.edit_encoding').val(),
            }
    
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
    
            $.ajax({
                type: 'POST',
                data: data,
                dataType: 'json',
                url: '/datacenter/update-base/'+id,
                success:function(response){
                    if(response.status==400){
                        //erros                  
                        $('#updateform_errList').html("");
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });
                        $(this).text('Atualizado');                    
                    }else if(response.status==404){                    
                        $('#updateform_errList').html("");
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        $(this).text('Atualizado');                    
                    }else{                    
                        $('#updateform_errList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $(this).text('Atualizado');
    
                        $("#editform").trigger('reset');
                        $("#EditBaseModal").modal('hide');
    
                        //atualizando a tr da table html                      
                        var tupla = "";                 
                        tupla = '<tr id="base'+response.base.id+'">\
                            <th scope="row">'+response.base.nome_base+'</th>\
                            <td>'+response.base.ip+'</td>\
                            <td>'+response.base.dono+'</td>\
                            <td>App</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.base.id+'" class="edit_base_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" class="delete_base_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';             
                        $('#base'+id).replaceWith(tupla);
                    }
                }
            });
    
        });
        //fim da atualização do registro
        //inicio exibição do form AddBaseModal
        $('#AddBaseModal').on('shown.bs.modal',function(){
            $('.nome_base').focus();
        });
        $(document).on('click','.AddBase_btn',function(e){
            e.preventDefault();
            var labelHtml = $(this).data("nome_vm");
            $('#addform').trigger('reset');
            $('#AddBaseModal').modal('show');
            $('#add_vm_id').val($(this).data("id"));
            $('#nome_vm').html('<Label id="nome_vm" style="font-style:italic;">'+labelHtml+'</Label>');
        });
        //fim exibição do form AddBaseModal
        
        //inicio do envio do novo registro
        $(document).on('click','.add_base_btn',function(e){
            e.preventDefault();
            var optprojeto = $('#projeto_id').val();        
            var data = {
                'projeto_id': optprojeto,
                'virtual_machine_id': $('#add_vm_id').val(),
                'nome_base': $('.nome_base').val(),
                'ip': $('.ip').val(),
                'dono': $('.dono').val(),
                'encoding': $('.encoding').val(),
            }
    
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
    
            $.ajax({
                type: 'POST',
                url: '/datacenter/adiciona-base',
                data: data,
                dataType: 'json',
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
    
                        $('#addform').trigger('reset');
                        $('#AddBaseModal').modal('hide');
    
                        //inserindo a tr na table html                             
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                       
                        linha0 = '<tr id="novo" style="display:none;"></tr>';
                        linha1 = '<tr id="base'+response.base.id+'">\
                            <th scope="row">'+response.base.nome_base+'</th>\
                            <td>'+response.base.ip+'</td>\
                            <td>'+response.base.dono+'</td>\
                            <td>App</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.base.id+'" class="edit_base_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" class="delete_base_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        if(!$('#nadaencontrado').html==""){
                            $('#nadaencontrado').remove();
                        }
                        tupla = linha0+linha1;                    
                        $('#novo').replaceWith(tupla);
                    }
                }
            });        
        });
        //fim do envio do novo registro
        ///Inicio configura os selects do AddAppModal
        $('select[name="add_selprojeto_id"]').on('change',function(){
            var optaddproj = this.value;
            $('#add_selprojeto_id option')
            .removeAttr('selected')
            .filter('[value='+optaddproj+']')
            .attr('selected',true);
        }); 
        $('select[name="add_selbase_id"]').on('change',function(){
            var optaddbase = this.value;
            $('#add_selbase_id option')
            .removeAttr('selected')
            .filter('[value='+optaddbase+']')
            .attr('selected',true);
        }); 
        $('select[name="add_selorgao_id"]').on('change',function(){
            var optaddorgao = this.value;
            $('#add_selorgao_id option')
            .removeAttr('selected')
            .filter('[value='+optaddorgao+']')
            .attr('selected',true);
        }); 
        //fim configura os selects do AddAppModal
        ///Inicio Novo App da base caso não possua nenhum
        $('#AddApptModal').on('shown.bs.modal',function(){
            $('#add_nome_app').focus();
        });
        $(document).on('click','.novo_app_btn',function(e){
            e.preventDefault();     
            var labelHtmlBase = $(this).data("nome_base");   
            var labelHtmlVm = $('#vmnome').val();   
            $('#addappform').trigger('reset');
            $('#AddAppModal').modal('show');                                       
            $('#add_base_id').val($(this).data("id"));
            $('#add_nome_base').html('<Label id="add_nome_base" style="font-style:italic;">'+labelHtmlBase+'</Label>');
            $('#add_nome_vm').html('<Label id="add_nome_vm" style="font-style:italic;">'+labelHtmlVm+'</Label>');
        });
        //Fim Novo App da base caso não possua nenhum
    
        ///Inicio Adiciona Novo App da Base
        $(document).on('click','.add_app_btn',function(e){                
            e.preventDefault();
           
            $(this).text('Salvando...');
            var CSRF_TOKEN = document.querySelector('meta[name="_token"]').getAttribute("content");
            var ins_projeto_id = $('#add_selprojeto_id').val();
            var ins_orgao_id = $('#add_selorgao_id').val();
            var ins_base_id = $('#add_selbase_id').val();
            var add_https = false;
            $("input[name='add_https']:checked").each(function(){
                add_https = true
            });
            var data = {            
                'orgao_id': ins_orgao_id,
                'projetos_id': ins_projeto_id,
                'bases_id': ins_base_id,
                'nome_app': $('.add_nome_app').val(),
                'dominio': $('.add_dominio').val(),
                'https': add_https,     
                '_token': CSRF_TOKEN,       
            };
            
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
    
            $.ajax({
                type: 'POST',
                url: '/datacenter/armazena-app',
                data: data,
                dataType: 'json',
                success:function(response){
                    //erros
                    if(response.status==400){
                        $('#saveform_errListApp').html("");
                        $('#saveform_errListApp').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errListApp').append('<li>'+err_values+'</li>');
                        });
                    }else{
                        $('#saveform_errListApp').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
    
                        $('#addappform').trigger('reset');
                        $('#AddAppModal').modal('hide');
    
                        
                        location.reload();
                                   
                    }
                
                    
                }
            });
        });    
        //Fim Adiciona Novo App da Base
    });
    
    </script>
@stop
