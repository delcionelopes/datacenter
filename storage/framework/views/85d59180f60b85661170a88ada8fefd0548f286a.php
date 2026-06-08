<?php $__env->startSection('title', 'Edição do cadastro de Módulos'); ?>

<?php $__env->startSection('content'); ?>
<form role="form" enctype="multipart/form-data" method="POST">
    <?php echo csrf_field(); ?>    
    <?php echo method_field('PUT'); ?>
    <ul id="saveform_errList"></ul> 
    <input type="hidden" id="editmodulo_id" value="<?php echo e($modulo->id); ?>">
        <div class="card">
            <div class="card-body">
              <div class="card p-3" style="background-image: url('/assets/img/home-bg.jpg')">
                <div class="d-flex align-items-center">
                    <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <div class="image">
                        <?php if($modulo->ico): ?>
                            <img src="<?php echo e(asset('storage/'.$modulo->ico)); ?>" class="imgico rounded-circle" width="100" >
                        <?php else: ?>
                            <img src="<?php echo e(asset('storage/user.png')); ?>" class="imgico rounded-circle" width="100" >
                        <?php endif; ?>
                        </div>
                       <label for="upimagem">Ícone</label>                        
                       <span class="btn btn-none fileinput-button"><i class="fas fa-plus"></i>
                          <input id="upimagem" type="file" name="imagem" class="btn btn-primary" accept="image/x-png,image/gif,image/jpeg">
                       </span>                       
                     </div>  
                     <!--arquivo de imagem--> 
                  </div>
              </div>
                <fieldset>
                    <legend>Dados do Módulo</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" required class="form-control" name="nome" id="nome" placeholder="Nome do módulo" value="<?php echo e($modulo->nome); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                              <div class="form-group">
                                <label for="descricao">Descricao</label>
                                <input type="text" required class="form-control" name="descricao" id="descricao" placeholder="Descrição do módulo" value="<?php echo e($modulo->descricao); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <input type="hidden" id="color" value="<?php echo e($modulo->color); ?>"> 
                               <label for="color">Esquema de cores</label>
                               <div class="btn-group">
                                <button type="button" id="corbtn" class="btn btn-<?php echo e($modulo->color); ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item cores" data-color="primary"><span class="btn btn-primary"></span> primary</li>
                                    <li class="dropdown-item cores" data-color="secondary"><span class="btn btn-secondary"></span> secondary</li>
                                    <li class="dropdown-item cores" data-color="success"><span class="btn btn-success"></span> success</li>
                                    <li class="dropdown-item cores" data-color="danger"><span class="btn btn-danger"></span> danger</li>
                                    <li class="dropdown-item cores" data-color="warning"><span class="btn btn-warning"></span> warning</li>
                                    <li class="dropdown-item cores" data-color="info"><span class="btn btn-info"></span> info</li>                                    
                                </ul>                             
                            </div>
                        </div>    
                        </div>                                                  
                    </div>                    
                   
                </fieldset>
                
                <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Operações do Módulo</legend>                                
                                <div class="form-check">                                                                        
                                    <?php $__currentLoopData = $operacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>               
                                    <?php if($modulo->operacoes->count()): ?>                                                                     
                                        <?php $__currentLoopData = $modulo->operacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ope): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                        
                                        <?php if(($operacao->id)==($ope->id)): ?>
                                            <label class="form-check-label" for="check<?php echo e($operacao->id); ?>">
                                                <input type="checkbox" id="check<?php echo e($operacao->id); ?>" name="operacoes[]" value="<?php echo e($operacao->id); ?>" class="form-check-input" checked> <?php echo e($operacao->nome); ?>

                                            </label><br>                                       
                                        <?php break; ?>
                                        <?php elseif($loop->last): ?>
                                         <label class="form-check-label" for="check<?php echo e($operacao->id); ?>">
                                                <input type="checkbox" id="check<?php echo e($operacao->id); ?>" name="operacoes[]" value="<?php echo e($operacao->id); ?>" class="form-check-input"> <?php echo e($operacao->nome); ?>

                                            </label><br>   
                                        <?php endif; ?>                                        
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                   
                                    <?php else: ?>
                                            <label class="form-check-label" for="check<?php echo e($operacao->id); ?>">
                                                <input type="checkbox" id="check<?php echo e($operacao->id); ?>" name="operacoes[]" value="<?php echo e($operacao->id); ?>" class="form-check-input"> <?php echo e($operacao->nome); ?>

                                            </label><br>   
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </fieldset>   
                     </div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button type="button" class="cancelar_btn btn btn-default">Cancelar</button>
                            <button type="button" class="salvar_btn btn btn-primary"><img id="imgedit" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

<link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet"/>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script type="text/javascript">

$(document).ready(function(){

    $(document).on('click','.salvar_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");       
        var id = $('#editmodulo_id').val();

        var loading = $('#imgedit');
            loading.show();

         //Array apenas com os checkboxes marcados
            var operacoes = new Array;
                $("input[name='operacoes[]']:checked").each(function(){
                    operacoes.push($(this).val());
                });
                          
       
           var data = new FormData();        
            
            data.append('nome',$('#nome').val());
            data.append('descricao',$('#descricao').val());
            data.append('color',$('#color').val());            
            data.append('imagem',$('#upimagem')[0].files[0]);            
            data.append('operacoes',JSON.stringify(operacoes)); //array
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');   
      
        $.ajax({
            url: '/datacenteradmin/modulo/update-modulo/'+id,
            type: 'POST',           
            dataType: 'json',
            data: data,
            cache: false,
            processData: false,            
            contentType:false,            
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
                    location.replace('/datacenteradmin/modulo/index-modulo');
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
                url:'/datacenteraadmin/modulo/moduloimagemtemp-upload',
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
                        var linkimagem = "<?php echo e(asset('')); ?>"+arq;                        
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

        if(files.length > 0){
        var data = new FormData();
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('_token',CSRF_TOKEN);
            data.append('_enctype','multipart/form-data');
            data.append('_method','delete');   
             $.ajax({                      
                type: 'POST',                             
                url:'/datacenteradmin/modulo/delete-imgmodulo',                
                dataType: 'json',            
                data: data,
                cache: false,
                processData: false,
                contentType: false,                                                                                     
                success: function(response){                              
                    if(response.status==200){
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');                         
                    location.replace('/datacenteradmin/modulo/index-modulo');
                } 
                }                                  
            });

        }else{
            location.replace('/datacenteradmin/modulo/index-modulo');
        }

    });
    //fim excluir imagem temporária pelo cancelamento

    //atribuição de cores
    $(document).on('click','.cores',function(e){
        e.preventDefault();
        var color = $(this).data("color");
        var id = $(this).data("id");
            $('#corbtn').replaceWith('<button type="button" id="corbtn" class="btn btn-'+color+' dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
                                      <span class="caret"></span>\
                                      </button>');            
            $('#color').val(color);
    });
    //fim atribuição de cores

});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/caos/modulo/edit.blade.php ENDPATH**/ ?>