<?php $__env->startSection('title', 'Edição do cadastro de Operações'); ?>

<?php $__env->startSection('content'); ?>
<form role="form" enctype="multipart/form-data" method="POST">
    <?php echo csrf_field(); ?>    
    <?php echo method_field('PUT'); ?>
    <ul id="saveform_errList"></ul> 
    <input type="hidden" id="editoperacao_id" value="<?php echo e($operacao->id); ?>">
        <div class="card">
            <div class="card-body">
              <div class="card p-3" style="background-image: url('/assets/img/home-bg.jpg')">
                <div class="d-flex align-items-center">
                    <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <div class="image">
                        <?php if($operacao->ico): ?>
                            <img src="<?php echo e(asset('storage/'.$operacao->ico)); ?>" class="imgico rounded-circle" width="100" >
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
                    <legend>Dados da Operação</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" required class="form-control" name="nome" id="nome" placeholder="Nome da operação" value="<?php echo e($operacao->nome); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                              <div class="form-group">
                                <label for="descricao">Descricao</label>
                                <input type="text" required class="form-control" name="descricao" id="descricao" placeholder="Descrição da operacao" value="<?php echo e($operacao->descricao); ?>">
                            </div>
                        </div>                        
                    </div>                    
                   
                </fieldset>                
               
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
        var id = $('#editoperacao_id').val();

        var loading = $('#imgedit');
            loading.show();                          
       
           var data = new FormData();        
            
            data.append('nome',$('#nome').val());
            data.append('descricao',$('#descricao').val());               
            data.append('imagem',$('#upimagem')[0].files[0]);                        
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');   
      
        $.ajax({
            url: '/datacenteradmin/operacao/update-operacao/'+id,
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
                    location.replace('/datacenteradmin/operacao/index-operacao');
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
                url:'/datacenteradmin/operacao/operacaoimagemtemp-upload',
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
                url:'/datacenteradmin/operacao/delete-imgoperacao',
                dataType: 'json',            
                data: data,
                cache: false,
                processData: false,
                contentType: false,                                                                                     
                success: function(response){                              
                    if(response.status==200){
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');                         
                    location.replace('/datacenteradmin/operacao/index-operacao');
                } 
                }                                  
            });

        }else{
            location.replace('/datacenteradmin/operacao/index-operacao');
        }

    });
    //fim excluir imagem temporária pelo cancelamento
});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\php\datacenter\resources\views/caos/operacao/edit.blade.php ENDPATH**/ ?>