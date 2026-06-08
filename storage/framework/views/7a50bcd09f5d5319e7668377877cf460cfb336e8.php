<?php $__env->startSection('title', 'Datacenter'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--AddSetorModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddSetorModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Setor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="addform" name="addform" class="form-horizontal" role="form">                 
                <ul id="saveform_errList"></ul>
                <div class="row">
                <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="">Sigla</label>
                    <input type="text" class="sigla_setor form-control">
                </div>           
                </div>
                </div>
                <div class="row">
                <div class="col-md-12">     
                <div class="form-group">
                    <label for="">Nome</label>
                    <input type="text" class="nome_setor form-control">
                </div>
                </div>
                </div>
            </form>            
            </div>
            <div class="modal-footer">
                <button type="button" data-color="<?php echo e($color); ?>" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="<?php echo e($color); ?>" class="btn btn-<?php echo e($color); ?> add_setor"><img id="imgadd" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddSetorModal-->

<!--EditSetorModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="editSetorModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Setor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="editform" name="editform" class="form-horizontal" role="form">                
                <ul id="updateform_errList"></ul>               
                <input type="hidden" id="edit_setor_id">
                <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                    <label for="edit_sigla_setor">Sigla</label>
                    <input type="text" id="edit_sigla_setor" class="sigla_setor form-control">
                </div>         
                </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                    <label for="edit_nome_setor">Nome</label>
                    <input type="text" id="edit_nome_setor" class="nome_setor form-control">
                </div>         
                </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-color="<?php echo e($color); ?>" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="<?php echo e($color); ?>" class="btn btn-<?php echo e($color); ?> update_setor"><img id="imgedit" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!--index-->
<div class="container-fluid py-5">   
    <div id="success_message"></div>    
    <section class="border p-4 mb-4 d-flex align-items-left">    
    <form action="<?php echo e(route('datacenteradmin.setor.index',['color' => $color])); ?>" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">
            <nav class="navbar navbar-expand-md navbar-light bg-light">
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="sigla do setor" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>        
            <button type="button" class="AddSetorModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                <i class="fas fa-plus"></i>
            </button>
            <button data-color="<?php echo e($color); ?>" type="button" class="voltarmenu_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-door-open"></i></button>
            </nav>
            </div>            
            </div>        
            </form>                     
  
    </section>    
      <section class="content border p-4 mb-4 d-flex">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
            
                    <table class="table table-hover">
                    <thead class="bg-<?php echo e($color); ?>" style="color: white">
                            <tr>                                
                                <th scope="col">SETORES</th>                    
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_setor">
                        <tr id="novo" style="display:none;"></tr>
                        <?php $__empty_1 = true; $__currentLoopData = $setores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>   
                            <tr id="setor<?php echo e($setor->idsetor); ?>">                                
                                <th scope="row"><?php echo e($setor->sigla); ?></th>                                
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <button type="button" data-id="<?php echo e($setor->idsetor); ?>" data-siglasetor="<?php echo e($setor->sigla); ?>" class="edit_setor fas fa-edit" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>
                                            <button type="button" data-id="<?php echo e($setor->idsetor); ?>" data-siglasetor="<?php echo e($setor->sigla); ?>" class="delete_setor_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
                    <div class="d-flex hover justify-content-center bg-<?php echo e($color); ?>">
                    <?php echo e($setores->links()); ?>

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
    
        $(document).on('click','.delete_setor_btn',function(e){   ///inicio delete
            e.preventDefault();          
            var linklogo = "<?php echo e(asset('storage')); ?>";
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var id = $(this).data("id");            
            var sigla = $(this).data("siglasetor");
            
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:sigla,
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
                    url: '/datacenteradmin/setor/delete-setor/'+id,
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
                            $("#setor"+id).remove();     
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
        //início da exibição do form EditSetorModal
        $("#editSetorModal").on('shown.bs.modal',function(){
            $("#edit_sigla_setor").focus();
        });
        $(document).on('click','.edit_setor',function(e){  
            e.preventDefault();
            var linklogo = "<?php echo e(asset('storage')); ?>";
            var id = $(this).data("id");            
            var nome = $(this).data("siglasetor");
            
            $("#editform").trigger('reset');
            $("#editSetorModal").modal('show');          
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');      
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/datacenteradmin/setor/edit-setor/'+id,                                
                success: function(response){           
                    if(response.status==200){                           
                        $(".sigla_setor").val(response.setor.sigla);
                        $(".nome_setor").val(response.setor.nome);
                        $("#edit_setor_id").val(response.setor.idsetor);                                                                                                       
                    }      
                }
            });        
    
        }); //fim da da exibição do form EditSetorModal
    
        $(document).on('click','.update_setor',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var loading = $("#imgedit");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');            
    
            var id = $("#edit_setor_id").val();        
    
            var data = {
                'sigla' : $("#edit_sigla_setor").val(),
                'nome': $("#edit_nome_setor").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }
            
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: '/datacenteradmin/setor/update-setor/'+id,         
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
                        $("#editSetorModal").modal('hide');                  
                        
                        //atualizando a linha na tabela html                      
    
                            var linha = '<tr id="setor'+response.setor.id+'">\
                                    <th scope="row">'+response.setor.sigla+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.setor.idsetor+'" data-siglasetor="'+response.setor.sigla+'" class="edit_setor fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.setor.idsetor+'" data-siglasetor="'+response.setor.nome+'" class="delete_setor_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';                             
                        $("#setor"+id).replaceWith(linha);                                                                                
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro
    
        //exibe form de adição de registro
        $("#AddSetorModal").on('shown.bs.modal',function(){
            $(".sigla_setor").focus();
        });
        $(document).on('click','.AddSetorModal_btn',function(e){  //início da exibição do form AddSetorModal
            e.preventDefault();     
            
            var link = "<?php echo e(asset('storage')); ?>";           
            
            $("#addform").trigger('reset');
            $("#AddSetorModal").modal('show'); 
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');    
        });
    
        //fim exibe form de adição de registro
    
        $(document).on('click','.add_setor',function(e){ //início da adição de Registro
            e.preventDefault();
            var loading = $("#imgadd");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var data = {
                'sigla': $(".sigla_setor").val(),
                'nome': $(".nome_setor").val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            } 
            
            $.ajax({
                type: 'POST',
                url: '/datacenteradmin/setor/store-setor',
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
                        $("#AddSetorModal").modal('hide');
    
                        //adiciona a linha na tabela html                      
                            
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="setor'+response.setor.idsetor+'">\
                                    <th scope="row">'+response.setor.sigla+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.setor.idsetor+'" data-siglasetor="'+response.setor.sigla+'" class="edit_setor fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.setor.idsetor+'" data-siglasetor="'+response.setor.sigla+'" class="delete_setor_btn fas fa-trash" style="background:transparent;border:none"></button>\
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
        $(".AddSetorModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_setor_btn").tooltip();
        $(".edit_setor").tooltip();    
    });
    ///fim tooltip

    $(document).on('click','.voltarmenu_btn',function(e){
        e.preventDefault();  
        var color = $(this).data("color");
        location.replace('/datacenteradmin/principal/operacoes/1/'+color);
    });

    
    }); ///Fim do escopo do script
    
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\php\datacenter\resources\views/caos/setor/index.blade.php ENDPATH**/ ?>