<?php $__env->startSection('title', 'Datacenter'); ?>

<?php $__env->startSection('content'); ?>

<form role="form" enctype="multipart/form-data" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <ul id="saveform_errList"></ul>
    <input type="hidden" id="edit_user_id" value="<?php echo e($user->id); ?>">
    <div class="container-fluid py-5">
        <div class="card">
            <div class="card-body">
              <div class="card p-3" style="background-image: url('/assets/img/home-bg.jpg')">
                <div class="d-flex align-items-center">
                    <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <div class="image">
                        <?php if($user->avatar): ?>
                            <img src="<?php echo e(asset('storage/'.$user->avatar)); ?>" class="imgfoto rounded-circle" width="100" >
                        <?php else: ?>
                            <img src="<?php echo e(asset('storage/user.png')); ?>" class="imgfoto rounded-circle" width="100">
                        <?php endif; ?>
                        </div>
                       <label for="">Foto</label>                        
                       <span class="btn btn-none fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="upimagem" type="file" name="imagem" class="btn btn-primary" accept="image/x-png,image/gif,image/jpeg">
                       </span>                       
                     </div>  
                     <!--arquivo de imagem--> 
                </div>
              </div>
                  <fieldset>
                    <legend>Dados de Identificação</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" required class="form-control" name="nome" id="nome" placeholder="Nome do usuário" value="<?php echo e($user->name); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="matricula">Matrícula</label>
                                <input type="text" required class="form-control" name="matricula" id="matricula" value="<?php echo e($user->matricula); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input type="text" required class="form-control" name="cpf" id="cpf" placeholder="000.000.000-00" data-mask="000.000.000-00" data-mask-reverse="true" value="<?php echo e($user->cpf); ?>">
                            </div>
                        </div>
                    </div>                                        
                </fieldset>               

                <fieldset>
                    <legend>Dados de Controle</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">e-Mail</label>
                                <input type="text" class="email form-control" name="email" id="email" placeholder="e-Mail do usuário" value="<?php echo e($user->email); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" class="password form-control" name="password" id="password">
                            </div>
                        </div>                    
                    </div>                    
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="idperfil">Perfil</label>
                                <select name="idperfil" id="idperfil" class="idperfil custom-select" aria-selected="<?php echo e($user->perfil->nome); ?>">
                                    <?php $__currentLoopData = $perfis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perfil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($perfil->id); ?>" <?php echo e(old('perfil_id',$user->perfil_id ?? '') === $perfil->id ? 'selected' : ''); ?>><?php echo e($perfil->nome); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="idfuncao">Função</label>
                                <select name="idfuncao" id="idfuncao" class="idfuncao custom-select" aria-selected="<?php echo e($user->funcao->nome); ?>">
                                    <?php $__currentLoopData = $funcoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funcao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($funcao->id); ?>" <?php echo e(old('funcao_id',$user->funcao_id ?? '') === $funcao->id ? 'selected' : ''); ?>><?php echo e($funcao->nome); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="orgaoid">Órgão</label>
                                <select name="orgaoid" id="orgaoid" class="orgaoid custom-select" aria-selected="<?php echo e($user->orgao->nome); ?>">
                                    <?php $__currentLoopData = $orgaos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orgao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($orgao->id); ?>" <?php echo e(old('orgao_id',$user->orgao_id ?? '') === $orgao->id ? 'selected' : ''); ?>><?php echo e($orgao->nome); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="idsetor">Setor</label>
                                <select name="idsetor" id="idsetor" class="idsetor custom-select" aria-selected="<?php echo e($user->setor->sigla); ?>">
                                    <?php $__currentLoopData = $setores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($setor->idsetor); ?>" <?php echo e(old('setor_id',$user->setor_id ?? '') === $setor->idsetor ? 'selected' : ''); ?>><?php echo e($setor->sigla); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">Acessos</label>
                            <div class="form-group">
                                <label for="sistema">
                                <?php if($user->sistema): ?>    
                                <input type="checkbox" class="sistema checkbox" name="sistema" id="sistema" checked> Sistema
                                <?php else: ?>
                                <input type="checkbox" class="sistema checkbox" name="sistema" id="sistema"> Sistema
                                <?php endif; ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">Privilégio</label>
                            <div class="form-group">
                                <label for="admin">
                                <?php if($user->admin): ?>
                                <input type="checkbox" class="admin checkbox" name="admin" id="admin" checked> ADMIN
                                <?php else: ?>
                                <input type="checkbox" class="admin checkbox" name="admin" id="admin"> ADMIN
                                <?php endif; ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">Status</label>
                            <div class="form-group">
                                <label for="inativo">
                                <?php if($user->inativo): ?>
                                <input type="checkbox" class="inativo checkbox" name="inativo" id="inativo" checked> Inativo
                                <?php else: ?>
                                <input type="checkbox" class="inativo checkbox" name="inativo" id="inativo"> Inativo
                                <?php endif; ?>
                                </label>
                            </div>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_instagram">URL Instagram</label>
                                <input type="text" class="link_instagram form-control" name="link_instagram" id="link_instagram" placeholder="https://..instagram" value="<?php echo e($user->link_instagram); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_facebook">URL Facebook</label>
                                <input type="text" class="link_facebook form-control" name="link_facebook" id="link_facebook" placeholder="https://..facebook" value="<?php echo e($user->link_facebook); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_site">URL Site</label>
                                <input type="text" class="link_site form-control" name="link_site" id="link_site" placeholder="https://..site" value="<?php echo e($user->link_site); ?>">
                            </div>
                        </div>                 
                    </div>                    
                </fieldset>               
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button type="button" class="cancelar_btn btn btn-default">Cancelar</button>
                            <button class="salvar_btn btn btn-primary" type="button"><img id="imgedit" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
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
        var loading = $('#imgedit');
            loading.show();

        var id = $('#edit_user_id').val();
        
        var data = new FormData();        

            data.append('perfil_id',$('#idperfil').val());
            data.append('funcao_id',$('#idfuncao').val());
            data.append('orgao_id',$('#orgaoid').val());
            data.append('setor_id',$('#idsetor').val());
            data.append('name',$('#nome').val());            
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('inativo', $('#inativo').is(":checked")?'true':'false');
            data.append('sistema',$('#sistema').is(":checked")?'true':'false');
            data.append('admin',$('#admin').is(":checked")?'true':'false');
            data.append('matricula',$('#matricula').val());
            data.append('cpf',$('#cpf').val());
            data.append('email',$('#email').val());
            data.append('password',$('#password').val());
            data.append('link_instagram',$('#link_instagram').val());
            data.append('link_facebook',$('#link_facebook').val());
            data.append('link_site',$('#link_site').val());           
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');              

        $.ajax({
            url: '/admin/user/update/'+id,
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
                    location.replace('/admin/user/index');
                }  
            }  
        });

    });

    //upload da foto temporária
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
                url:'/admin/user/armazenar-imgtemp',                
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
                        var imagemnova = '<img src="'+linkimagem+'" class="imgfoto rounded-circle" width="100" >';
                        $(".imgfoto").replaceWith(imagemnova);
                    }   
                }                                  
            });
        }
        });   
    //fim upload da foto temporária
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
                url:'/admin/user/delete-imgtemp',                
                dataType: 'json',            
                data: data,
                cache: false,
                processData: false,
                contentType: false,                                                                                     
                success: function(response){                              
                    if(response.status==200){
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                    location.replace('/admin/user/index');
                } 
                }                                  
            });

        }else{
            location.replace('/admin/user/index');
        }

    });
    //fim excluir imagem temporária pelo cancelamento

});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\php\datacenter\resources\views/caos/user/edit.blade.php ENDPATH**/ ?>