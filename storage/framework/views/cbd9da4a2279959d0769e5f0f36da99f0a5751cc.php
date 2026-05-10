<?php $__env->startSection('title', 'Datacenter - Área de navegação'); ?>

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
<?php if($autorizacao->count()): ?>

<?php $__currentLoopData = $modulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
  <?php $__currentLoopData = $autorizacao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aut): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php if(($aut->modulo_has_operacao_modulo_id) == ($mod->id)): ?>
  <div class="p-2 mt-2">   
  <div class="card card-hover mb-3" style="max-width: 540px;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <a href="<?php echo e(route('datacenteradmin.principal.operacoes',['id' => $mod->id,'color'=>$mod->color])); ?>">
      <img src="<?php echo e(asset('storage/'.$mod->ico)); ?>" class="card-img" alt="<?php echo e($mod->nome); ?>">
      </a>
    </div>
    <div class="col-md-8">
      <div class="card-body text-right">
        <h5 class="card-title"><?php echo e($mod->nome); ?></h5>
        <p class="card-text"><?php echo e($mod->descricao); ?></p>
        <p class="card-text"><small class="text-muted">Criado em <?php echo e(ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($mod->created_at))))); ?></small></p>
        <a href="<?php echo e(route('datacenteradmin.principal.operacoes',['id' => $mod->id,'color'=>$mod->color])); ?>" class="btn btn-<?php echo e($mod->color); ?>">Executar</a>
      </div>
    </div>
  </div>
</div>
  </div>
  <?php break; ?>
  <?php elseif($loop->last): ?>
  
  <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <p class="card-text">Você não tem acesso a esta área.</p>
        <p class="card-text"><small class="text-muted">Grato pela compreensão.</small></p>
      </div>
    </div>
  </div>
</div>
</div>
<?php endif; ?>
</div>
</div>
</div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/caos/principal/index.blade.php ENDPATH**/ ?>