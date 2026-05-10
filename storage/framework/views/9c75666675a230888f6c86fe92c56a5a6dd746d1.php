<?php $__env->startSection('title', 'Segurança'); ?>

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

<div class="container-fluid py-5"> 

            <div class="card p-3" style="background-image: url('/assets/img/home-bg.jpg')">
                <div class="d-flex align-items-center">
                <div class="image">
                <?php if(auth()->user()->avatar): ?>  
                <img src="<?php echo e(asset('storage/'.auth()->user()->avatar)); ?>" class="rounded-circle" width="100" >
                <?php else: ?>
                <img src="<?php echo e(asset('storage/user.png')); ?>" class="rounded-circle" width="100" >
                <?php endif; ?>
                </div>
                <div class="ml-3 w-100">                    
                   <h4 class="mb-0 mt-0" style="color: red" ><b><?php echo e(auth()->user()->name); ?></b></h4>                 
                </div>                    
                </div>              
            </div>         
<div class="container-fluid">
 <div class="row">
  <?php if(auth()->guard()->check()): ?>
  <?php if((auth()->user()->admin) && (auth()->user()->perfil_id==2)): ?>  
  <div class="p-2 mt-2">
    <div class="card" style="width: 10rem;">
      <div class="card-header">
        <b><i class="fas fa-desktop" style="background: transparent; color: red; border: none;"></i> Módulos</b>
      </div>
      <div class="card-body">                
        <p class="card-text">Cadastro básico.</p>        
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Menu<span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_modulo<?php echo e(auth()->user()->id); ?>">
                                            <li class="dropdown-item"><a href="<?php echo e(route('datacenteradmin.modulo.index')); ?>" class="dropdown-item listamodulo_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-list" style="background: transparent; color: red; border: none;"></i> Cadastro de módulos</a>
                                            </li> 
                                </ul>  
      </div>
    </div>
  </div>  

   <div class="p-2 mt-2">
    <div class="card" style="width: 10rem;">
      <div class="card-header">
        <b><i class="fas fa-desktop" style="background: transparent; color: red; border: none;"></i> Operações</b>
      </div>
      <div class="card-body">                
        <p class="card-text">Cadastro básico.</p>        
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Menu<span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_operacao<?php echo e(auth()->user()->id); ?>">
                                            <li class="dropdown-item"><a href="<?php echo e(route('datacenteradmin.operacao.index')); ?>" class="dropdown-item listaoperacao_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-list" style="background: transparent; color: red; border: none;"></i> Cadastro de operações</a>
                                            </li> 
                                </ul>  
      </div>
    </div>
  </div> 

  <div class="p-2 mt-2">
        <div class="card" style="width: 10rem;">
          <div class="card-header">
            <b><i class="fas fa-desktop" style="background: transparent; color: red; border: none;"></i> Permissões</b>
          </div>
          <div class="card-body">                
            <p class="card-text">Autorizações.</p>
            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Opções<span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_opcoes<?php echo e(auth()->user()->id); ?>">
                                            <li class="dropdown-item"><a href="<?php echo e(route('datacenteradmin.perfil.index')); ?>" class="dropdown-item listaperfil_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-folder" style="background: transparent; color: red; border: none;"></i> Cadastro de Perfis</a>
                                            </li> 
                                            <li class="dropdown-item"><a href="<?php echo e(route('datacenteradmin.funcao.index')); ?>" class="dropdown-item listafuncao_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-folder" style="background: transparent; color: red; border: none;"></i> Cadastro de Funções</a>
                                            </li>
                                            <li class="dropdown-item"><a href="<?php echo e(route('admin.user.index')); ?>" class="dropdown-item listaousuarios_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-user" style="background: transparent; color: red; border: none;"></i> Cadastro de Usuários</a>
                                            </li> 
                                </ul>
          </div>
        </div>
      </div>  

  <?php elseif((auth()->user()->admin) && (auth()->user()->perfil_id==3)): ?> 

        <div class="p-2 mt-2">
        <div class="card" style="width: 10rem;">
          <div class="card-header">
            <b><i class="fas fa-desktop" style="background: transparent; color: red; border: none;"></i> Permissões</b>
          </div>
          <div class="card-body">                
            <p class="card-text">Autorizações.</p>        
            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Opções<span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_opcoes<?php echo e(auth()->user()->id); ?>">
                                            <li class="dropdown-item"><a href="<?php echo e(route('datacenteradmin.perfil.index')); ?>" class="dropdown-item listaperfil_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-folder" style="background: transparent; color: red; border: none;"></i> Cadastro de Perfis</a>
                                            </li> 
                                            <li class="dropdown-item"><a href="<?php echo e(route('datacenteradmin.funcao.index')); ?>" class="dropdown-item listafuncao_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-folder" style="background: transparent; color: red; border: none;"></i> Cadastro de Funções</a>
                                            </li>                                             
                                            <li class="dropdown-item"><a href="<?php echo e(route('admin.user.index')); ?>" class="dropdown-item listaousuarios_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-user" style="background: transparent; color: red; border: none;"></i> Cadastro de Usuários</a>
                                            </li> 
                                </ul>
          </div>
        </div>
      </div>

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
        <p class="card-text">Você não tem acesso a esta área.</p>
        <p class="card-text"><small class="text-muted">Grato pela compreensão.</small></p>
      </div>
    </div>
  </div>
</div>
</div>
<?php endif; ?>
<?php endif; ?>
</div>
</div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/caos/seguranca/index.blade.php ENDPATH**/ ?>