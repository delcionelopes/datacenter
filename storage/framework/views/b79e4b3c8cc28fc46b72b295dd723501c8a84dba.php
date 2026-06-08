<?php $__env->startSection('title', 'Cadastro de Entidade'); ?>

<?php $__env->startSection('content'); ?>

<form role="form" enctype="multipart/form-data" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <ul id="saveform_errList"></ul> 
    <div class="container-fluid py-5">
        <div class="card">
            <div class="card-body">
              <div class="card p-3" style="background-image: url('/assets/img/home-bg.jpg')">
                <div class="d-flex align-items-center">
                    <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <div class="image">                            
                            <img src="<?php echo e(asset('storage/user.png')); ?>" class="imgico rounded-circle" width="100" >
                        </div>
                       <label for="">Logo</label>                        
                       <span class="btn btn-none fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="upimagem" type="file" name="imagem" class="btn btn-<?php echo e($color); ?>" accept="image/x-png,image/gif,image/jpeg">
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
                                <input type="text" required class="form-control" name="nome" id="nome" placeholder="Nome da entidade">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="descricao">Sigla</label>
                                <input type="text" required class="form-control" name="sigla" id="sigla" placeholder="Sigla da entidade">
                            </div>
                        </div>                        
                    </div>
                </fieldset>
                <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Vinculos institucionais</legend>
                                <div class="form-check">                                                                        
                                    <?php $__currentLoopData = $institucionais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $institucional): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="form-check-label" for="check<?php echo e($institucional->id); ?>">
                                        <input type="checkbox" id="check<?php echo e($institucional->id); ?>" name="institucionais[]" value="<?php echo e($institucional->id); ?>" class="form-check-input"> <?php echo e($institucional->sigla); ?>

                                    </label><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                    
                                </div>
                            </fieldset>   
                     </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button type="button" data-color="<?php echo e($color); ?>" class="cancelar_btn btn btn-default">Cancelar</button>
                            <button class="salvar_btn btn btn-<?php echo e($color); ?>" data-color="<?php echo e($color); ?>" type="button"><img id="imgadd" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
                        </div>
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
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
        var loading = $('#imgadd');
            loading.show();
        var color = $(this).data("color");
        
        var institucionais = new Array();
                $("input[name='institucionais[]']:checked").each(function(){
                    institucionais.push($(this).val());
                });

        var data = new FormData();        
            
            data.append('nome',$('#nome').val());
            data.append('sigla',$('#sigla').val());
            data.append('imagem',$('#upimagem')[0].files[0]);            
            data.append('institucionais',JSON.stringify(institucionais)); //array
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');              

        $.ajax({
            url: '/admin/entidades/store',
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/datacenter/entidade/create.blade.php ENDPATH**/ ?>