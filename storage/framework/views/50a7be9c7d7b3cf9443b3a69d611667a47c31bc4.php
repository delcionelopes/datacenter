<?php $__env->startSection('title', 'PRODAP - Datacenter'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>OLÁ!</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>Seja bem-vindo ao <b>PRODAP - Datacenter</b>!</p>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>    
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>  

<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page',['iFrameEnabled' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/home.blade.php ENDPATH**/ ?>