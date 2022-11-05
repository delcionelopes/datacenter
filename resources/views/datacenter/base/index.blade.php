@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--inicio AddBaseModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddBaseModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
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
                        <input type="text" class="ip form-control" data-mask="099.099.099.099">
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
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditBaseModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
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
                        <input type="text" id="ip" class="edit_ip form-control" data-mask="099.099.099.099">
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
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddAppModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
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

<!-- início AddSenhaBase -->
   <div class="modal fade animate__animated animate__bounce animate__faster" id="AddSenhaBase" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addformsenha" name="addformsenha" class="form-horizontal" role="form">
                    <input type="hidden" id="add_basesenha_id">
                    <ul id="saveformsenha_errList"></ul>   
                    <div class="card">
                    <div class="card-body">         
                     <fieldset>
                    <legend>Dados da Senha</legend>                    
                    <div class="form-group mb-3">
                        <label  for="">Nome Base:</label>
                        <label  id="nomebase"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">IP:</label>
                        <label  id="ipbase"></label>
                    </div>                  
                    <div class="form-group mb-3">
                        <label for="">Senha</label>
                        <input type="text" class="add_senha form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Validade</label>
                        <input type="text" class="add_validade form-control" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="flexCheck"> 
                        <input type="checkbox" class="add_val_indefinida form-check-input" name="add_val_indefinida" id="flexCheck"> Validade indeterminada
                        </label>
                    </div>         
                     </fieldset>
                    </div>
                    </div>
                     <div class="card">
                        <div class="card-body">                        
                            <fieldset>
                                <legend>Quem tem acesso a esta informação?</legend>
                                <div class="form-check">
                                    @foreach ($users as $user)
                                    <label class="form-check-label" for="CheckUser{{$user->id}}">
                                        <input type="checkbox" id="CheckUser{{$user->id}}" name="users[]" value="{{$user->id}}" class="form-check-input"> {{$user->name}}
                                    </label><br>
                                    @endforeach
                                </div>
                            </fieldset>  
                            </div>
                     </div>                             
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_senhabase_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim AddSenhaApp -->

<!-- início EditSenhaApp -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSenhaBase" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editformsenha" name="editformsenha" class="form-horizontal" role="form">
                    <input type="hidden" id="edit_basesenha_id">
                    <ul id="updateformsenha_errList"></ul>  
                    <div class="card">
                    <div class="card-body"> 
                    <fieldset>
                    <legend>Dados da Senha</legend>                 
                    <div class="form-group mb-3">
                        <label  for="">Nome Base:</label>
                        <label  id="editnomebase"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">IP Base:</label>
                        <label  id="editipbase"></label>
                    </div>                    
                     <div class="form-group mb-3">
                        <label  for="">Criação:</label>
                        <label  id="editdatacriacao"></label><br>
                        <label  for="">Modificação:</label>
                        <label  id="editdatamodificacao"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Criador:</label>
                        <label  id="editcriador"></label><br>
                        <label  for="">Modificador:</label>
                        <label  id="editmodificador"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Senha</label>
                        <input type="text" id="edit_senha" class="senha form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Validade</label>
                        <input type="text" id="edit_validade" class="validade form-control" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="edit_val_indefinida"> 
                        <input type="checkbox" class="val_indefinida form-check-input" name="edit_val_indefinida" id="edit_val_indefinida"> Validade indeterminada
                        </label>
                    </div>                
                    </fieldset>    
                    </div>
                    </div>
                     <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Quem tem acesso a esta informação?</legend>
                                <div class="form-check">
                                    @foreach ($users as $user)
                                    <label class="form-check-label" for="check{{$user->id}}">
                                        <input type="checkbox" id="check{{$user->id}}" name="users[]" value="{{$user->id}}" class="form-check-input"> {{$user->name}}
                                    </label><br>
                                    @endforeach
                                </div>
                            </fieldset>   
                     </div>
                     </div>                  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_senhabase_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim EditSenhaApp -->

<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container py-5">
    <div id="success_message"></div>        
            <section class="border p-4 mb-4 d-flex align-items-left">
            <form action="{{route('datacenter.base.index',['id'=>$id])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                            <input type="hidden" id="vmid" value="{{$id}}">  
                            <input type="hidden" id="vmnome" value="{{$vm->nome_vm}}">                        
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome da base" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background:transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                               <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-id="{{$id}}" data-nome_vm="{{$vm->nome_vm}}" class="AddBase_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
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
                        <th scope="col"><i class="fas fa-key"></i> PASS</th>
                        <th scope="col">APP(s)</th>                        
                        <th scope="col">AÇÕES</th>                       
                    </tr>                    
                </thead>
                <tbody id="lista_bases">
                    <tr id="novo" style="display:none;"></tr>
                    @forelse($bases as $base)
                    <tr id="base{{$base->id}}" data-toggle="tooltip" title="{{$base->ip}}">                        
                        <th scope="row">{{$base->nome_base}}</th>
                        <td id="senha{{$base->id}}">
                            @if(!$base->senha)
                            <button id="botaosenha{{$base->id}}" type="button" data-id="{{$base->id}}" data-nomebase="{{$base->nome_base}}" data-ip="{{$base->ip}}" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Registrar senha e dar<br>permissões de visualização"></button>
                            @else
                            @if($base->users()->count())                           
                            @foreach($base->users as $user)
                                  @if(($user->id) == (auth()->user()->id))                                  
                                  <button id="botaosenha{{$base->id}}" type="button" data-id="{{$base->id}}" data-nomebase="{{$base->nome_base}}" data-ip="{{$base->ip}}" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="{{$base->users->implode('name','<br>')}}"></button>
                                  @break
                                  @elseif ($loop->last)
                                  <button id="botaosenha{{$base->id}}" type="button" data-id="{{$base->id}}" data-nomebase="{{$base->nome_base}}" data-ip="{{$base->ip}}" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="{{$base->users->implode('name','<br>')}}"></button>
                                  @endif                                                        
                            @endforeach                            
                            @endif
                            @endif                                                        
                        </td>
                        <td>
                        <div class="btn-group">
                        @if($base->apps->count())
                        <form action="{{route('datacenter.app.index',['id'=>$base->id])}}" method="get">
                            <button type="submit" data-id="{{$base->id}}" class="list_app_btn fas fa-desktop" style="background: transparent;border:none;color: green; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Menu de APPs para {{$base->nome_base}}"> {{$base->apps->count()}}</button>
                        </form>
                        @else
                        <button type="button" data-id="{{$base->id}}" data-nome_base="{{$base->nome_base}}" class="novo_app_btn fas fa-folder" style="background: transparent;border:none;color: orange; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Cadastro de APPs"></button>
                        @endif
                        </div>
                        </td>                        
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="{{$base->id}}" class="edit_base_btn fas fa-edit" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar {{$base->nome_base}}"></button>
                                <button type="button" data-id="{{$base->id}}" data-nomebase="{{$base->nome_base}}" class="delete_base_btn fas fa-trash" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir {{$base->nome_base}}"></button>
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
                <button type="button" class="voltar_btn fas fa-arrow-left" style="background: transparent; border: none;" onclick="history.back()" style="white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Voltar para VM(s)"></button>
            </div>
     
</div>
@else 
<i class="fas fa-lock"></i><b class="title"> USUÁRIO INATIVO OU NÃO LIBERADO! CONTACTE O ADMINISTRADOR.</b>
@endif
@endauth
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
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var id = $(this).data("id");
            var nomebase = ($(this).data("nomebase")).trim();
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomebase,
                text: "Deseja excluir?",
                imageUrl: '../../logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){                 
                    $.ajax({
                        url: '/datacenter/delete-base/'+id,
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            'id':id,
                            '_method':'DELETE',
                            '_token':CSRF_TOKEN,
                        },
                        success:function(response){
                            if(response.status==200){
                                //remove a linha da table html
                                $('#base'+id).remove();
                                $('#success_message').html('<div id="success_message"></div>');
                                $('#success_message').addClass('alert alert-success');
                                $('#success_message').text(response.message);
                            }else{      
                                $('#success_message').html('<div id="success_message"></div>');                          
                                $('#success_message').addClass('alert alert-danger');
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
            $('#updateform_errList').html('<ul id="updateform_errList"></ul>');
    
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
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
                        var vnomevm = (response.vm.nome_vm).trim();
                        $('#edit_nome_vm').html('<Label id="edit_nome_vm" style="font-style:italic;">'+vnomevm+'</Label>');
                        var vnomebase = (response.base.nome_base).trim();
                        $('#nome_base').val(vnomebase);
                        var vip = (response.base.ip).trim();
                        $('#ip').val(vip);
                        var vbasedono = (response.base.dono).trim();
                        $('#dono').val(vbasedono);
                        var vencoding = (response.base.encoding).trim();
                        $('#encoding').val(vencoding);
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
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            $(this).text('Atualizando...');
    
            var optprojeto = $('#projeto_id').val();
            var id = $('#edit_base_id').val();
            var data = {
                'projeto_id': optprojeto,
                'virtual_machine_id': ($('#edit_vm_id').val()).trim(),
                'nome_base': ($('.edit_nome_base').val()).trim(),
                'ip': ($('.edit_ip').val()).trim(),
                'dono': ($('.edit_dono').val()).trim(),
                'encoding': ($('.edit_encoding').val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }            
    
            $.ajax({
                type: 'POST',
                data: data,
                dataType: 'json',
                url: '/datacenter/update-base/'+id,
                success:function(response){
                    if(response.status==400){
                        //erros                  
                        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });
                        $(this).text('Atualizado');                    
                    }else if(response.status==404){                    
                        $('#updateform_errList').html('<ul id="updateform_errList"></ul>'); 
                        $('#success_message').html('<div id="success_message"></div>');                      
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        $(this).text('Atualizado');                    
                    }else{                    
                        $('#updateform_errList').html('<ul id="updateform_errList"></ul>');
                        $('#success_message').html('<div id="success_message"></div>');
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $(this).text('Atualizado');
    
                        $("#editform").trigger('reset');
                        $("#EditBaseModal").modal('hide');
    
                        //atualizando a tr da table html                      
                        var tupla = "";                 
                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";
                        var limita5 = "";
                        limita1 = '<tr id="base'+response.base.id+'">\
                            <th scope="row">'+response.base.nome_base+'</th>';
                        var bloqueia = true;
                        if((response.base.senha)==""){
                        limita2 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita3 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita4 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomeapp="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        } 
                        limita5 = '<td>APPs</td>\
                            <td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.base.id+'" class="edit_base_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" class="delete_base_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';    
                        tupla = limita1+limita2+limita3+limita4+limita5;         
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
            var labelHtml = ($(this).data("nome_vm")).trim();
            $('#addform').trigger('reset');
            $('#AddBaseModal').modal('show');
            $('#add_vm_id').val($(this).data("id"));
            $('#nome_vm').html('<Label id="nome_vm" style="font-style:italic;">'+labelHtml+'</Label>');
            $('#saveform_errList').html('<ul id="saveform_errList"></ul>'); 
        });
        //fim exibição do form AddBaseModal
        
        //inicio do envio do novo registro
        $(document).on('click','.add_base_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var optprojeto = $('#projeto_id').val();        
            var data = {
                'projeto_id': optprojeto,
                'virtual_machine_id': ($('#add_vm_id').val()).trim(),
                'nome_base': ($('.nome_base').val()).trim(),
                'ip': ($('.ip').val()).trim(),
                'dono': ($('.dono').val()).trim(),
                'encoding': ($('.encoding').val()).trim(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }    
    
            $.ajax({
                type: 'POST',
                url: '/datacenter/adiciona-base',
                data: data,
                dataType: 'json',
                success:function(response){
                    if(response.status==400){
                        //erros
                        $('#saveform_errList').html('<ul id="saveform_errList"></ul>');   
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });                    
                    }else{
                        $('#saveform_errList').html('<ul id="saveform_errList"></ul>');        
                        $('#success_message').html('<div id="success_message"></div>');                
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
    
                        $('#addform').trigger('reset');
                        $('#AddBaseModal').modal('hide');
    
                        //inserindo a tr na table html                             
                        var tupla = "";
                        var limita0 = "";
                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";
                        var limita5 = "";
                        var limita6 = "";
                       
                        limita0 = '<tr id="novo" style="display:none;"></tr>';
                        limita1 = '<tr id="base'+response.base.id+'">\
                            <th scope="row">'+response.base.nome_base+'</th>';
                        var bloqueia = true;
                        if((response.base.senha)==""){
                        limita2 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita3 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita4 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomeapp="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        } 
                        limita5 = '<td><button type="button" data-id="'+response.base.id+'" data-nome_base="'+response.base.nome_base+'" class="novo_app_btn fas fa-folder" style="background: transparent;border:none;color: orange; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Cadastro de APPs"></button></td>';
                        limita6 = '<td>\
                                <div class="btn-group">\
                                    <button type="button" data-id="'+response.base.id+'" class="edit_base_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" class="delete_base_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        if(!$('#nadaencontrado').html==""){
                            $('#nadaencontrado').remove();
                        }
                        tupla = limita0+limita1+limita2+limita3+limita4+limita5+limita6;                    
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
        $('#AddAppModal').on('shown.bs.modal',function(){
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
            $('#saveform_errListApp').html('<ul id="saveform_errListApp"></ul>');  
        });
        //Fim Novo App da base caso não possua nenhum
    
        ///Inicio Adiciona Novo App da Base
        $(document).on('click','.add_app_btn',function(e){                
            e.preventDefault();
           
            $(this).text('Salvando...');
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
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
                '_method':'PUT',
                'https': add_https,     
                '_token': CSRF_TOKEN,       
            };           
          
            $.ajax({
                type: 'POST',
                url: '/datacenter/armazena-app',
                data: data,
                dataType: 'json',
                success:function(response){
                    //erros
                    if(response.status==400){
                        $('#saveform_errListApp').html('<ul id="saveform_errListApp"></ul>');   
                        $('#saveform_errListApp').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errListApp').append('<li>'+err_values+'</li>');
                        });
                    }else{
                        $('#saveform_errListApp').html('<ul id="saveform_errListApp"></ul>');   
                        $('#success_message').html('<div id="success_message"></div>');
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

         //cadastro de senha
        $('#AddSenhaBase').on('shown.bs.modal',function(){
            $('.add_senha').focus();
        });


        $(document).on('click','.cadsenha_btn',function(e){
            e.preventDefault();
            var labelHtml = ($(this).data("nomebase")).trim();            
            var labelip = ($(this).data("ip")).trim();            
            $('#addformsenha').trigger('reset');
            $('#AddSenhaBase').modal('show');
            $('#add_basesenha_id').val($(this).data("id"));
            $('#nomebase').html('<Label id="nomebase" style="font-style:italic;">'+labelHtml+'</Label>');            
            $('#ipbase').html('<Label id="ipbase" style="font-style:italic;">'+labelip+'</Label>');            
            $('#saveformsenha_errList').html('<ul id="saveformsenha_errList"></ul>'); 
        });

         $(document).on('click','.add_senhabase_btn',function(e){
            e.preventDefault();
            $(this).text('Salvando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $('#add_basesenha_id').val();
            var val_indefinida = 0;
            $("input[name='add_val_indefinida']:checked").each(function(){
                val_indefinida = 1;
            });         

            //array apenas com os checkboxes marcados
            var users = new Array;
            $("input[name='users[]']:checked").each(function(){
                users.push($(this).val());
            });            
            
            var data = {
                'senha':$('.add_senha').val(),
                'validade':formatDate($('.add_validade').val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/storesenhabase/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $('#saveformsenha_errList').html("");
                            $('#saveformsenha_errList').addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $('#saveformsenha_errList').append('<li>'+err_values+'</li>');
                            });
          
                }else{
                        $('#saveformsenha_errList').html('<ul id="saveformsenha_errList"></ul>');     
                        $('#success_message').html('<div id="success_message"></div>');              
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
    
                        $('#addformsenha').trigger('reset');                    
                        $('#AddSenhaBase').modal('hide');

                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var bloqueia = true;                        
                        if((response.base.senha)==""){
                        limita1 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita2 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita3 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }                       

                        var elemento = limita1+limita2+limita3;
                        $('#botaosenha'+id).replaceWith(elemento);

                } 
                }   
            });
    }); 
        //fim cadastro de senha
    ////inicio alteração de senha
    $('#EditSenhaBase').on('shown.bs.modal',function(){
        $('#edit_senha').focus();
    });
    $(document).on('click','.senhabloqueada_btn',function(e){
        e.preventDefault();

        var opcaosenha = $(this).data("opt");

        if(opcaosenha){
    
        var id = $(this).data("id");
        var labelHtml = ($(this).data("nomebase")).trim();            
        var labelip = ($(this).data("ip")).trim(); 
        $('#editformsenha').trigger('reset');
        $('#EditSenhaBase').modal('show');  
        $('#editnomebase').html('<Label id="editnomebase" style="font-style:italic;">'+labelHtml+'</Label>');            
        $('#editipbase').html('<Label id="editipbase" style="font-style:italic;">'+labelip+'</Label>');     
        $('#edit_basesenha_id').val(id);  
        $('#updateformsenha_errList').html('<ul id="updateformsenha_errList"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editsenhabase/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.base.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.base.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.base.validade);
                    datavalidade = datavalidade.toLocaleDateString("pt-BR");
                     if(datavalidade=="31/12/1969"){
                        datavalidade = "";
                        }  
                    var criador = response.criador;
                        if(!response.criador){
                            criador = "";
                        }
                    var alterador = response.alterador;
                        if(!response.alterador){
                            alterador = "";
                        }                   
                    $('#edit_validade').val(datavalidade);
                    $('#editdatacriacao').html('<label  id="editdatacriacao">'+datacriacao+'</label>');
                    $('#editdatamodificacao').html('<label  id="editdatamodificacao">'+dataatualizacao+'</label>');
                    $('#editcriador').html('<label  id="editcriador">'+criador+'</label>');
                    $('#editmodificador').html('<label  id="editmodificador">'+alterador+'</label>');                         
                    $('#edit_senha').val(response.senha);
                    if(response.base.val_indefinida){
                      $("input[name='edit_val_indefinida']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinida']").attr('checked',false);  
                    }

                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados ao artigo
                        $.each(response.users,function(key,values){                                                        
                                $("#check"+values.id).attr('checked',true);  //faz a marcação seletiva                         
                        });
                }
            }
        });

    }else{
        Swal.fire({
             showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:"Você não tem acesso a esta informação!",
                text: "Peça sua inclusão a um dos usuários sugeridos na dica!",
                imageUrl: '../../logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'Ok, obrigado!',                
                cancelButtonText: 'Não necessito, obrigado!',
            });      
    }
             
    });
    //fim exibe EditAppModal
    ///inicio alterar senha
    $(document).on('click','.update_senhabase_btn',function(e){
            e.preventDefault();
            $(this).text('Salvando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $('#edit_basesenha_id').val();
            var val_indefinida = 0;
            $("input[name='edit_val_indefinida']:checked").each(function(){
                val_indefinida = 1;
            });         

            //array apenas com os checkboxes marcados
            var users = new Array;
            $("input[name='users[]']:checked").each(function(){
                users.push($(this).val());
            });            
            
            var data = {
                'senha':$('.senha').val(),
                'validade':formatDate($('.validade').val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/updatesenhabase/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $('#updateformsenha_errList').html("");
                            $('#updateformsenha_errList').addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $('#updateformsenha_errList').append('<li>'+err_values+'</li>');
                            });
          
                }else{
                        $('#updateformsenha_errList').html('<ul id="updateformsenha_errList"></ul>');     
                        $('#success_message').html('<div id="success_message"></div>');              
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
    
                        $('#editformsenha').trigger('reset');                    
                        $('#EditSenhaBase').modal('hide');

                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var bloqueia = true;                        
                        if((response.base.senha)==""){
                        limita1 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita2 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita3 = '<button id="botaosenha'+response.base.id+'" type="button" data-id="'+response.base.id+'" data-nomebase="'+response.base.nome_base+'" data-ip="'+response.base.ip+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }                       

                        var elemento = limita1+limita2+limita3;
                        $('#botaosenha'+id).replaceWith(elemento);

                } 
                }   
            });
    });         

    ////fim alteração de senha

            //formatação str para date
    function formatDate(data, formato) {
        if (formato == 'pt-br') {
            return (data.substr(0, 10).split('-').reverse().join('/'));
        } else {
            return (data.substr(0, 10).split('/').reverse().join('-'));
        }
        }
        //fim formatDate

        ///tooltip
    $(function(){      
        $('.senhabloqueada_btn').tooltip();       
        $('.cadsenha_btn').tooltip();        
        $('.list_app_btn').tooltip();
        $('.novo_app_btn').tooltip();
        $('.AddBase_btn').tooltip();
        $('.pesquisa_btn').tooltip();        
        $('.delete_base_btn').tooltip();
        $('.edit_base_btn').tooltip();
        $('.voltar_btn').tooltip();
    });
    ///fim tooltip

    });
    
    </script>
@stop
