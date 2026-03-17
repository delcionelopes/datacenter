<?php $__env->startSection('content'); ?>

<!-- Cabeçalho-->
<header class="masthead" style="background-image: url('/assets/img/home-bg.jpg')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1><?php echo e($tema->titulo); ?></h1>
          <span class="subheading"><?php echo e($tema->artigos->count()); ?> artigo(s) relacionado(s)</span>
                        </div>
                    </div>
                </div>
            </div>
</header>
<div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
 
                    <!-- Artigos preview-->
                    <?php $__empty_1 = true; $__currentLoopData = $artigos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artigo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="post-preview">
                        <a href="<?php echo e(route('page.detail',['slug' => $artigo->slug])); ?>">
                            <h2 class="post-title"><?php echo e($artigo->titulo); ?></h2>
                            <h3 class="post-subtitle"><?php echo e($artigo->descricao); ?></h3>
                        </a>
                        <p class="post-meta">
                            Postado por
                            <a href="#!"><?php echo e($artigo->user->name); ?></a>                            
                            <?php echo e(ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($artigo->created_at))))); ?>

                            <a href="<?php echo e(route('page.detail',['slug' => $artigo->slug])); ?>">
                                <i class="fas fa-comment"></i> <?php echo e($artigo->comentarios()->count()); ?>

                            </a>
                        </p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="alert alert-warning">Não encontramos artigo(s) para este tema!</div>
                    <!-- Divisor-->
                    <hr class="my-4" />                   
                    <?php endif; ?>
                    <!-- Paginação-->
                    <div class="d-flex justify-content-center mb-4">
                    <?php echo e($artigos->links()); ?>

                    </div>
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

<?php echo $__env->make('layouts.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/page/temas.blade.php ENDPATH**/ ?>