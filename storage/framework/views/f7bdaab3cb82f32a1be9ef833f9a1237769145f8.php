

<?php $__env->startSection('title', 'Datacenter - Grupos'); ?>

<?php $__env->startSection('content'); ?>

<style>  

  .card {
    transition: transform 0.2s ease;
    box-shadow: 0 4px 6px 0 rgba(22, 22, 26, 0.18);
    border-radius: 0;
    border: 0;
    margin-bottom: 1.5em;
  }
  .card:hover {
    transform: scale(1.1);
  }

    .tooltip-inner {
    text-align: left;
    }
    div.halfOpacity{
        opacity: 0.6 !important;
    }
</style>

<!--inicio AddGrupoModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddGrupoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar GRUPO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_vlan_id">
                    <ul id="saveform_errList"></ul>
                    <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="addsigla">Sigla do GRUPO</label>
                        <input type="text" id="addsigla" class="form-control">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="adddescricao">Descrição</label>
                        <input type="text" id="adddescricao" class="form-control">
                    </div>
                    </div>                    
                    </div>         
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="<?php echo e($color); ?>" class="btn btn-<?php echo e($color); ?> add_grupo"><img id="imgadd" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim AddGrupoModal -->

<!--Inicio EditGrupoModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditGrupoModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar GRUPO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <ul id="updateform_errList"></ul>
                    <input type="hidden" id="edit_grupo_id">                    
                    <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Sigla do GRUPO</label>
                        <input type="text" id="editsigla" class="sigla form-control">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="editdescricao">Descrição</label>
                        <input type="text" id="editdescricao" class="descricao form-control">
                    </div>
                    </div>                    
                    </div>         
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="<?php echo e($color); ?>" class="btn btn-<?php echo e($color); ?> update_grupo"><img id="imgedit" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim EditGrupoModal -->

<div class="container-fluid py-5"> 

    <div id="success_message"></div>        
            <section class="border p-4 mb-4 d-flex align-items-left">
            <form action="<?php echo e(route('datacenteradmin.grupo.index',['color'=>$color])); ?>" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                        <nav class="navbar navbar-expand-md navbar-light bg-light">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do grupo" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background:transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                               <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="AddGrupo_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                               <i class="fas fa-plus"></i>
                            </button>
                            <button data-color="<?php echo e($color); ?>" type="button" class="voltarmenu_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-door-open"></i></button>
                        </nav>
                        </div>
                    </div>
            </form>    
            </section>      

<section class="border p-4 mb-4 d-flex align-items-left">  
<div class="row">
<?php if($grupos->count()): ?>
  <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
  <div class="p-2 mt-2">   
  <div class="card card-hover mb-3">
  <div class="row no-gutters">
    <div class="col-md-4">
      <a href="">
      <img src="<?php echo e(asset('storage/'.$grupo->ico)); ?>" class="card-img">
      </a>
    </div>
    <div class="col-md-8">
      <div class="card-body text-right">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0"><?php echo e($grupo->sigla); ?></h5>
        <div class="dropdown">
        <button type="button" class="btn btn_primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
         <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="" data-color="<?php echo e($color); ?>"> Editar</a></li>
            <li><a class="dropdown-item" href="" data-color="<?php echo e($color); ?>"> Excluir</a></li>
         </ul>   
        </div>
        </div>
        <p class="card-text"><?php echo e($grupo->descricao); ?></p>        
        <a href="" class="btn btn-<?php echo e($color); ?>">Executar</a>
      </div>
    </div>
  </div>
  </div>
  </div>  
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php else: ?>
<div class="p-2 mt-2">
<div class="card" style="width: 18rem;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="<?php echo e(asset('logoprodap.jpg')); ?>" class="card-img" alt="prodap">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title"><b><?php echo e(auth()->user()->name); ?></b>,</h5>
        <p class="card-text">Não há grupos cadastrados!</p>
        <p class="card-text"><small class="text-muted">Crie grupos e cadastre equipamentos.</small></p>
      </div>
    </div>
  </div>
</div>
</div>
<?php endif; ?>
</div>
</section>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script type="text/javascript">

$(document).ready(function(){

  //inicio exibição do form AddGrupoModal
        $('#AddGrupoModal').on('shown.bs.modal',function(){
            $("#addsigla").focus();
        });
        $(document).on('click','.AddGrupo_btn',function(e){
            e.preventDefault();            
            $("#addform").trigger('reset');
            $("#AddGrupoModal").modal('show');            
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>'); 
            
        });
        //fim exibição do form AddGrupoModal

         //inicio do envio do novo registro
        $(document).on('click','.add_grupo',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var loading = $("#imgadd");
                loading.show();            
            var strcolor = $(this).data("color");
            var data = new FormData();

            data.append('sigla',$('#addsigla').val());
            data.append('descricao',$('#adddescricao').val());
            data.append('ico','ico_modulo/icn-invisible-infrastructure-2.png');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');
             
            $.ajax({
                url: '/datacenteradmin/grupo/store',
                type: 'POST',
                dataType: 'json',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                async: true,
                success:function(response){
                    if(response.status==400){
                        //erros
                        $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');   
                        $("#saveform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#saveform_errList").append('<li>'+err_values+'</li>');
                        });              
                        loading.hide();
                    }else{
                        $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');        
                        $("#success_message").replaceWith('<div id="success_message"></div>');                
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);
                        loading.hide();
    
                        $("#addform").trigger('reset');
                        $("#AddGrupoModal").modal('hide');
                        
                        location.replace('/datacenteradmin/grupo/index/'+strcolor);
                     
                    }
                }
            });        
        });
        //fim do envio do novo registro


        $(document).on('click','.voltarmenu_btn',function(e){
        e.preventDefault();  
        var color = $(this).data("color");
        location.replace('/datacenteradmin/principal/operacoes/3/'+color);
        });



});

</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\php\datacenter\resources\views/datacenter/equipamentogrupo/index.blade.php ENDPATH**/ ?>