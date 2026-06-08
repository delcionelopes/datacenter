<?php $__env->startSection('title', 'Operações'); ?>

<?php $__env->startSection('content'); ?>

<!--index-->
<?php if(auth()->guard()->check()): ?>
<div class="container-fluid py-5">   
    <div id="success_message"></div>    

    <section class="border p-4 mb-4 d-flex align-items-left">
    
    <form action="<?php echo e(route('datacenteradmin.operacao.index')); ?>" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="nome da operação" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                <i class="fas fa-search"></i>
            </button>            
            
            <a href="<?php echo e(route('datacenteradmin.operacao.create')); ?>" type="button" class="AddModuloModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-plus"></i></a>
            
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="sidebar-dark-primary" style="color: white">
                            <tr>                                
                                <th scope="col">OPERAÇÕES</th>
                                <th scope="col">ICO</th>
                                <th scope="col">MÓDULOS</th>
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_operacao">
                        <tr id="novo" style="display:none;"></tr>
                        <?php $__empty_1 = true; $__currentLoopData = $operacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>   
                            <tr id="operacao<?php echo e($operacao->id); ?>">                                
                                <th scope="row"><?php echo e($operacao->nome); ?></th>
                                <?php if($operacao->ico): ?>                 
                                <td>  
                                <img src="<?php echo e(asset('storage/'.$operacao->ico)); ?>" alt="Icone de <?php echo e($operacao->nome); ?>"
                                class="rounded-circle" width="100">                                
                                </td>                               
                                <?php else: ?>
                                <td><img src="<?php echo e(asset('storage/user.png')); ?>" alt="Sem imagem"
                                class="rounded-circle" width="100"></td>
                                <?php endif; ?>                                                               
                                <td>
                                <div class="btn-group">                                
                                        <?php if($operacao->modulos->count()): ?>                                
                                        <button type="button" class="btn btn-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-tools"></i><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" id="dropdown<?php echo e($operacao->id); ?>">
                                            <?php $__currentLoopData = $operacao->modulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                                                            
                                            <li class="dropdown-item"><a href="<?php echo e(route('datacenteradmin.operacao.operacaoxmodulo',['modulo_id'=>$modulo->id])); ?>" class="dropdown-item"><?php echo e($modulo->nome); ?></a></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>                                           
                                        <?php endif; ?>                               
                                </div>       
                                </td>
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <a href="<?php echo e(route('datacenteradmin.operacao.edit',['id'=>$operacao->id])); ?>" type="button" data-id="<?php echo e($operacao->id); ?>" class="edit_operacao fas fa-edit" style="color: black; background:transparent;border:none"></a>
                                            <button type="button" data-id="<?php echo e($operacao->id); ?>" data-nome="<?php echo e($operacao->nome); ?>" class="delete_operacao_btn fas fa-trash" style="background:transparent;border:none"></button>
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
                    <?php echo e($operacoes->links()); ?>

                    </div>  
   
    </div>        
    
</div>
<?php endif; ?>
<!--End Index-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

<link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet"/>  
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script type="text/javascript">

$(document).ready(function(){

     $(document).on('click','.delete_operacao_btn',function(e){   ///inicio delete 
            e.preventDefault();           
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var id = $(this).data("id");
            var linklogo = "<?php echo e(asset('storage')); ?>";

            var nome = $(this).data("nome");
            
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
                imageAlt: 'logo do sistema',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){                             
                $.ajax({
                    url: '/datacenteradmin/operacao/delete-operacao/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,
                        '_method':'DELETE',
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente da tabela html
                            $('#operacao'+id).remove();     
                            $('#success_message').replaceWith('<div id="success_message"></div>');                       
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);         
                        }else{
                            //Não pôde excluir por causa dos relacionamentos    
                            $('#success_message').replaceWith('<div id="success_message"></div>');                                                    
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.errors);         
                        }
                    }
                }); 
            }  
        });        
       
      
    });  ///fim delete


});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/caos/operacao/index.blade.php ENDPATH**/ ?>