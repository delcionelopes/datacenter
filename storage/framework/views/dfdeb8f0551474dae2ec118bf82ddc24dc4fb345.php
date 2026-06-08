<?php $__env->startSection('title', 'Módulos'); ?>

<?php $__env->startSection('content'); ?>

<!--index-->

<div class="container-fluid py-5">   
    <div id="success_message"></div>    

    <section class="border p-4 mb-4 d-flex align-items-left">
    
    <form action="<?php echo e(route('datacenteradmin.modulo.index')); ?>" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="nome do módulo" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>            
            
            <a href="<?php echo e(route('datacenteradmin.modulo.create')); ?>" type="button" class="AddModuloModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro"><i class="fas fa-plus"></i></a>
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
                                <th scope="col">MÓDULOS</th>
                                <th scope="col">ICO</th>
                                <th scope="col">OPERAÇÕES</th>
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_modulo">
                        <tr id="novo" style="display:none;"></tr>
                        <?php $__empty_1 = true; $__currentLoopData = $modulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>   
                            <tr id="modulo<?php echo e($modulo->id); ?>">                                
                                <th scope="row"><?php echo e($modulo->nome); ?></th>                                                  
                                <?php if($modulo->ico): ?>                 
                                <td>  
                                <img src="<?php echo e(asset('storage/'.$modulo->ico)); ?>" alt="Icone de <?php echo e($modulo->nome); ?>"
                                class="rounded-circle" width="100">                                
                                </td>                               
                                <?php else: ?>
                                <td><img src="<?php echo e(asset('storage/user.png')); ?>" alt="Sem imagem"
                                class="rounded-circle" width="100"></td>
                                <?php endif; ?>                                                               
                                <td>
                                <div class="btn-group">                                
                                        <?php if($modulo->operacoes->count()): ?>                                
                                        <button type="button" class="btn btn-<?php echo e($modulo->color); ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-tools"></i><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" id="dropdown<?php echo e($modulo->id); ?>">
                                            <?php $__currentLoopData = $modulo->operacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                                                            
                                            <li class="dropdown-item"><a href="<?php echo e(route('datacenteradmin.modulo.moduloxoperacao',['operacao_id'=>$operacao->id])); ?>" class="dropdown-item"><?php echo e($operacao->nome); ?></a></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>                                           
                                        <?php endif; ?>                               
                                </div>       
                                </td>
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <a href="<?php echo e(route('datacenteradmin.modulo.edit',['id'=>$modulo->id])); ?>" type="button" data-id="<?php echo e($modulo->id); ?>" class="edit_modulo fas fa-edit" style="color: black; background:transparent;border:none"></a>
                                            <button type="button" data-id="<?php echo e($modulo->id); ?>" data-nome="<?php echo e($modulo->nome); ?>" class="delete_modulo_btn fas fa-trash" style="background:transparent;border:none"></button>
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
                    <?php echo e($modulos->links()); ?>

                    </div>  
   
       </div>
        </div>
        </div>
    </section>          
    
</div>

<!--End Index-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

<link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet"/>  
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script type="text/javascript">

$(document).ready(function(){

     $(document).on('click','.delete_modulo_btn',function(e){   ///inicio delete 
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
                imageAlt: 'Brasão do GEA',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){             
                $.ajax({
                    url: '/datacenteradmin/modulo/delete-modulo/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{                        
                        'id': id,                                         
                        '_token':CSRF_TOKEN,                        
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente da tabela html
                            $('#modulo'+id).remove();     
                            $('#success_message').replaceWith('<div id="success_message"></div>');                       
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);         
                        }else{
                            //Não pôde excluir por causa dos relacionamentos    
                            $('#success_message').replaceWith('<div id="success_message"></div>');                                                    
                            $('#success_message').addClass('alert alert-danger');
                            s$('#success_message').text(response.errors);         
                        }
                    }
                }); 
            }  
        });        
       
      
    });  ///fim delete

     ///tooltip
    $(function(){             
        $(".AddModuloModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_modulo_btn").tooltip();
        $(".edit_modulo").tooltip();
        $(".voltarmenu_btn").tooltip();    
    });
    ///fim tooltip

    $(document).on('click','.voltarmenu_btn',function(e){
        e.preventDefault();
        location.replace('/datacenteradmin/seguranca/index-seguranca');       
    });


});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\php\datacenter\resources\views/caos/modulo/index_moduloXoperacoes.blade.php ENDPATH**/ ?>