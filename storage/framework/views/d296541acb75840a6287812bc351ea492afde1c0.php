<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">       
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <title>Relatório de Ambientes</title>  
    
    <style>
     .child  {
       display: inline-block;
       flex-wrap: wrap;
       justify-items: center;
       text-align: center;
       position: relative;
     }    
</style>

</head>

<body>   
    <div class="container-fluid py-5">
   <nav>
    <div class="container-fluid" style="align-content: center; padding-left: 7%">
    <div class="child">
        <img src="brazao_amapa.png" alt="" width="80" height="80">
    </div>
    <div class="child" style="font-style: bold">        
                    GOVERNO DO ESTADO DO AMAPÁ<br>
                    CENTRO DE GESTÃO DE TECNOLOGIA DA INFORMAÇÃO<br>                    
                    <?php echo e($setor); ?>

    </div>
    <div class="child">
        <img src="logo_prodap.png" alt="" width="80" height="80">
    </div>        
    </div>
    <h3 style="text-align: center; text-decoration-style: solid">RELATÓRIO DE AMBIENTES</h3>
    </nav>    
    <div>    
    </div>
    <?php for($pagina = 1; $pagina <= $num_paginas; $pagina++): ?>
    <table class="table table-sm">    
    <thead>        
        <tr>
            <th scope="row" style="text-align: justify">NOME</th>
            <th scope="row" style="text-align: justify">CRIAÇÃO</th>
            <th scope="row" style="text-align: justify">ALTERAÇÃO</th>
        </tr>       
    </thead>
    <tbody>
            <?php $__currentLoopData = $ambientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ambiente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($ambiente->nome_ambiente); ?></td> 
                <?php if($ambiente->created_at==null): ?>
                <td> </td>
                <?php else: ?>
                <td><?php echo e(date('d/m/Y H:i:s',strtotime($ambiente->created_at))); ?></td>
                <?php endif; ?>
                <?php if($ambiente->updated_at==null): ?>
                <td> </td>
                <?php else: ?>
                <td><?php echo e(date('d/m/Y H:i:s',strtotime($ambiente->updated_at))); ?></td>
                <?php endif; ?>
            </tr>               
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($num_linhas_impressas+1<$num_linhas_total): ?>
            <?php for($i = $num_linhas_impressas+1; $i <= $num_linhas_total; $i++): ?>            
            <tr>
                <td style="color: white">$i</td>
                <td> </td>
                <td> </td>
            </tr>            
            <?php endfor; ?>            
            <?php endif; ?>
    </tbody>
    </table>
     <!-- Rodapé-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">                        
                        <div class="small text-center text-muted fst-italic">Gerado em <?php echo e(date('d/m/Y H:i:s',strtotime($date))); ?> - Página <?php echo e($pagina); ?> de <?php echo e($num_paginas); ?></div>
                    </div>
                </div>
            </div>
        </footer>  
    <?php endfor; ?>                      
    </div>
            
</body>
</html><?php /**PATH C:\xampp\php\datacenter\resources\views/relatorios/datacenter/ambientes.blade.php ENDPATH**/ ?>