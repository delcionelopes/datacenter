<?php $__env->startSection('title', 'Datacenter'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--AddFuncaoModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddFuncaoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Função</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="addform" name="addform" class="form-horizontal" role="form">                 
                <ul id="saveform_errList"></ul>                   
                <div class="form-group mb-3">
                    <label for="">Nome</label>
                    <input type="text" class="nome_funcao form-control">
                </div>                
                    <div class="form-group mb-3">
                    <label for="">Descrição</label>
                    <input type="text" class="descricao_funcao form-control">
                </div>
            </form>            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_funcao"><img id="imgadd" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddFuncaoModal-->

<!--EditFuncaoModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="editFuncaoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Função</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="editform" name="editform" class="form-horizontal" role="form">                
                <ul id="updateform_errList"></ul>               
                <input type="hidden" id="edit_funcao_id">
                <div class="form-group mb-3">
                    <label for="edit_nome_funcao">Nome</label>
                    <input type="text" id="edit_nome_funcao" class="nome_funcao form-control">
                </div>         
                <div class="form-group mb-3">
                    <label for="edit_descricao_funcao">Decrição</label>
                    <input type="text" id="edit_descricao_funcao" class="descricao_funcao form-control">
                </div>         
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_funcao"><img id="imgedit" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!--index-->
<div class="container-fluid py-5">   
    <div id="success_message"></div>    
    <section class="border p-4 mb-4 d-flex align-items-left">    
    <form action="<?php echo e(route('datacenteradmin.funcao.index')); ?>" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="nome da função" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>        
            <button type="button" class="AddFuncaoModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                <i class="fas fa-plus"></i>
            </button>          
            <button type="button" class="voltarmenu_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Sair"><i class="fas fa-door-open"></i></button>      
            </div>            
            </div>        
            </form>                     
  
    </section>    
    <section class="content border p-4 mb-4 d-flex">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
            
                    <table class="table table-hover">
                        <thead class="sidebar-dark-primary" style="color: white">
                            <tr>                                
                                <th scope="col">FUNÇÕES</th>                    
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_funcao">
                        <tr id="novo" style="display:none;"></tr>
                        <?php $__empty_1 = true; $__currentLoopData = $funcoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funcao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>   
                            <tr id="funcao<?php echo e($funcao->id); ?>">                                
                                <th scope="row"><?php echo e($funcao->nome); ?></th>                                
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <button type="button" data-id="<?php echo e($funcao->id); ?>" data-nomefuncao="<?php echo e($funcao->nome); ?>" class="edit_funcao fas fa-edit" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>
                                            <button type="button" data-id="<?php echo e($funcao->id); ?>" data-nomefuncao="<?php echo e($funcao->nome); ?>" class="delete_funcao_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
                                        </div>                                    
                                </td>
                            </tr>  
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr id="nadaencontrado">
                                <td colspan="4">Nada Encontrado!</td>
                            </tr>                      
                            <?php endif; ?>                                                    
                        </tbody>
                    </table> 
                    <div class="d-flex hover justify-content-center">
                    <?php echo e($funcoes->links()); ?>

                    </div>  
   
       </div>
        </div>
        </div>
    </section>      
    
</div>

<!--End Index-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
    <link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet"/>  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script type="text/javascript">

$(document).ready(function(){        
    
        $(document).on('click','.delete_funcao_btn',function(e){   ///inicio delete
            e.preventDefault();          
            var linklogo = "<?php echo e(asset('storage')); ?>";
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var id = $(this).data("id");            
            var nome = $(this).data("nomefuncao");
            
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nome,
                text: "Deseja excluir?",
                imageUrl: linklogo+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do sistema',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){             
                $.ajax({
                    url: '/datacenteradmin/funcao/delete-funcao/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,
                        '_method': 'DELETE',                    
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente da tabela html
                            $("#funcao"+id).remove();     
                            $("#success_message").replaceWith('<div id="success_message"></div>');                       
                            $("#success_message").addClass('alert alert-success');
                            $("#success_message").text(response.message);         
                        }else{
                            //Não pôde excluir por causa dos relacionamentos    
                            $("#success_message").replaceWith('<div id="success_message"></div>');                        
                            $("#success_message").addClass('alert alert-danger');
                            $("#success_message").text(response.errors);
                        }
                    }
                }); 
            } 
        });   
      
        });  ///fim delete
        //início da exibição do form EditFuncaoModal
        $("#editFuncaoModal").on('shown.bs.modal',function(){
            $("#edit_nome_funcao").focus();
        });
        $(document).on('click','.edit_funcao',function(e){  
            e.preventDefault();
            var linklogo = "<?php echo e(asset('storage')); ?>";
            var id = $(this).data("id");            
            var nome = $(this).data("nomefuncao");
            
            $("#editform").trigger('reset');
            $("#editFuncaoModal").modal('show');          
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');      
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/datacenteradmin/funcao/edit-funcao/'+id,                                
                success: function(response){           
                    if(response.status==200){                           
                        $(".nome_funcao").val(response.funcao.nome);
                        $(".descricao_funcao").val(response.funcao.descricao);
                        $("#edit_funcao_id").val(response.funcao.id);                                                                                                       
                    }      
                }
            });        
    
        }); //fim da da exibição do form EditFuncaoModal
    
        $(document).on('click','.update_funcao',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var loading = $("#imgedit");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');            
    
            var id = $("#edit_funcao_id").val();        
    
            var data = {
                'nome' : $("#edit_nome_funcao").val(),
                'descricao': $("#edit_descricao_funcao").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }
            
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: '/datacenteradmin/funcao/update-funcao/'+id,         
                success: function(response){                                                    
                    if(response.status==400){
                        //erros
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                        $("#updateform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#updateform_errList").append('<li>'+err_values+'</li>');
                        });
    
                        loading.hide();
    
                    } else if(response.status==404){
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');    
                        $("#success_message").replaceWith('<div id="success_message"></div>');             
                        $("#success_message").addClass('alert alert-warning');
                        $("#success_message").text(response.message);
                        loading.hide();
    
                    } else {
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');      
                        $("#success_message").replaceWith('<div id="success_message"></div>');                 
                        $("#success_message").addClass("alert alert-success");
                        $("#success_message").text(response.message);
                        loading.hide();
    
                        $("#editform").trigger('reset');
                        $("#editFuncaoModal").modal('hide');                  
                        
                        //atualizando a linha na tabela html                      
    
                            var linha = '<tr id="funcao'+response.funcao.id+'">\
                                    <th scope="row">'+response.funcao.nome+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.funcao.id+'" data-nomefuncao="'+response.funcao.nome+'" class="edit_funcao fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.funcao.id+'" data-nomefuncao="'+response.funcao.nome+'" class="delete_funcao_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';                             
                        $("#funcao"+id).replaceWith(linha);                                                                                
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro
    
        //exibe form de adição de registro
        $("#AddFuncaoModal").on('shown.bs.modal',function(){
            $(".nome_funcao").focus();
        });
        $(document).on('click','.AddFuncaoModal_btn',function(e){  //início da exibição do form AddFuncaoModal
            e.preventDefault();     
            
            var link = "<?php echo e(asset('storage')); ?>";           
            
            $("#addform").trigger('reset');
            $("#AddFuncaoModal").modal('show'); 
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');    
        });
    
        //fim exibe form de adição de registro
    
        $(document).on('click','.add_funcao',function(e){ //início da adição de Registro
            e.preventDefault();
            var loading = $("#imgadd");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var data = {
                'nome': $(".nome_funcao").val(),
                'descricao': $(".descricao_funcao").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            } 
            
            $.ajax({
                type: 'POST',
                url: '/datacenteradmin/funcao/store-funcao',
                data: data,
                dataType: 'json',
                success: function(response){
                    if(response.status==400){
                        $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
                        $("#saveform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#saveform_errList").append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    } else {
                        $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');     
                        $("#success_message").replaceWith('<div id="success_message"></div>');              
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);                                        
                        loading.hide();
                        $("#addform").trigger('reset');                    
                        $("#AddFuncaoModal").modal('hide');
    
                        //adiciona a linha na tabela html                      
                            
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="funcao'+response.funcao.id+'">\
                                    <th scope="row">'+response.funcao.nome+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.funcao.id+'" data-nomefuncao="'+response.funcao.nome+'" class="edit_funcao fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.funcao.id+'" data-nomefuncao="'+response.funcao.nome+'" class="delete_funcao_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';
                        if(!$("#nadaencontrado").html==""){
                            $("#nadaencontrado").remove();
                        }
                        tupla = linha0+linha1;                             
                        $("#novo").replaceWith(tupla);                                                     
                        
                    }
                    
                }
            });
    
        }); //Fim da adição de registro
    ///tooltip
    $(function(){             
        $(".AddFuncaoModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_funcao_btn").tooltip();
        $(".edit_funcao").tooltip();    
        $(".voltarmenu_btn").tooltip();    
    });
    ///fim tooltip
    $(document).on('click','.voltarmenu_btn',function(e){
        e.preventDefault();
        location.replace('/datacenteradmin/seguranca/index-seguranca');       
    });

    
    }); ///Fim do escopo do script
    
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\php\datacenter\resources\views/caos/funcao/index.blade.php ENDPATH**/ ?>