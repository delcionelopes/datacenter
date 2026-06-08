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
</style>

<!-- Cabeçalho-->
<header class="masthead" style="background-image: url('/assets/img/home-bg.jpg')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1 class="heading">DATACENTER</h1>
                            <span class="subheading">Inovação, Tecnologia e Suporte</span>
                        </div>
                    </div>
                </div>
            </div>
</header>
<div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                <!--pesquisa -->
                <form action="<?php echo e(route('page.master')); ?>" class="form-search" method="GET">                    
                    <div class="input-group">                                            
                        <input class="form-control rounded-pill py-2 pr-5 mr-1 bg-transparent" tabindex="1" type="text" name="pesquisa" autocomplete="off">                                                                        
                        <div class="input-group-text border-0 bg-transparent ml-n5"><i class="fas fa-search"></i> </div>                        
                    </div>                                    
                </form>
                <!--barra de informações-->
                <nav class="navbar navbar-expand-lg navbar-default bg-default justify-content-left">        
                <ul class="menu">                    
                    <li><a href="#!">Temas</a>
                        <ul>
                  <?php $__currentLoopData = $temas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tema): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><a href="<?php echo e(route('page.tema',['slug' => $tema->slug])); ?>"><?php echo e($tema->titulo); ?></a></li>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>      	                  
                        </ul>
                    </li>                           
                </ul>
                </nav>  
                    <!-- Artigos preview -->
                    <?php $__currentLoopData = $artigos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artigo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="post-preview">
                        <a href="<?php echo e(route('page.detail',['slug' => $artigo->slug])); ?>">
                            <h2 class="post-title"><?php echo e($artigo->titulo); ?></h2>
                            <h3 class="post-subtitle"><?php echo e($artigo->descricao); ?></h3>
                        </a>
                        <p class="post-meta">
                            Postado por
                            <?php if($artigo->user): ?>
                            <a href="#!"><?php echo e($artigo->user->name); ?></a>                            
                            <?php endif; ?>
                            <?php echo e(ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($artigo->created_at))))); ?>

                            <a href="<?php echo e(route('page.detail',['slug' => $artigo->slug])); ?>">
                                <i class="fas fa-comment-alt"></i> <?php echo e($artigo->comentarios()->count()); ?>

                            </a>
                        </p>
                    </div>
                    <!-- Linha divisória-->
                    <hr class="my-4" />                   
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <!-- Paginação-->
                    <div class="d-flex justify-content-center mb-4">
                    <?php echo e($artigos->links("pagination::bootstrap-4")); ?>

                    </div>
                    <!-- institucionais -->
                <div class="container-fluid">
                    <div class="row">
                    <div class="card-group">
                    <?php if($entidade->institucionais()->count()): ?> 
                    <?php $__currentLoopData = $institucionais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                      
                     <?php $__currentLoopData = $entidade->institucionais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $institucional): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if(($institucional->id)==($inst->id)): ?> 
                    <div class="p-2 mt-2">       
                    <div class="card card-hover" style="width: 5rem; height: 5rem;">
                          <a href="<?php echo e(asset($institucional->url_site)); ?>" target="_blank" target="_blank">
                               <img class="card-img-top" src="<?php echo e(asset('storage/'.$institucional->logo)); ?>" alt="<?php echo e($institucional->nome); ?>" width="100" height="100">
                           </a>
                     </div>
                    </div>
                    <?php break; ?>
                    <?php elseif($loop->last): ?>
                    
                    <?php endif; ?> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                    
                    <?php else: ?>
                    <div class="container-fluid">
                    <div class="row">
                    <div class="p-2 mt-2">
                       <div class="card" style="width: 18rem;">
                           <div class="row no-gutters">
                              <div class="col-md-4">
                                  <img src="<?php echo e(asset('logo_prodap.png')); ?>" class="card-img" alt="Amapá">
                              </div>
                       <div class="col-md-8">
                            <div class="card-body">
                                 <h5 class="card-title"><b>Seja bem vindo!</b></h5>
                                 <p class="card-text">Prodap!</p>
                                 <p class="card-text"><small class="text-muted">Tecnologia e transformação digital!</small></p>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    <?php endif; ?>
                    </div>
                    </div>
                    </div>
                <!-- fim institucionais -->
                </div>      
            </div>
</div>
        <!-- Rodapé-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">                        
                        <div class="small text-center text-muted fst-italic">copyright &copy; prodap</div>
                    </div>
                </div>
            </div>
        </footer>      
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/page/artigos/master.blade.php ENDPATH**/ ?>