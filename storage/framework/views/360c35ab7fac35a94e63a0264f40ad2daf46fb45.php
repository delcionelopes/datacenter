<?php $__env->startSection('title', 'Artigos'); ?>

<?php $__env->startSection('content'); ?>

<!--index-->
<div class="container-fluid py-5">   
    <div id="success_message"></div>    

    <section class="border p-4 mb-4 d-flex align-items-left">
    
    <form action="<?php echo e(route('admin.artigos.index',['color'=>$color])); ?>" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">
            <nav class="navbar navbar-expand-md navbar-light bg-light">
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="título" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="input-group-text border-0" id="search-addon" style="background: transparent;border: none;">
                <i class="fas fa-search"></i>
            </button>        
            <a href="<?php echo e(route('admin.artigos.create',['color'=>$color])); ?>" type="button" class="AddArtigo_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-plus"></i></a>
            <button data-color="<?php echo e($color); ?>" type="button" class="voltarmenu_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-door-open"></i></button>
            </nav>
            </div>            
            </div>        
            </form>                     
  
    </section>    

     <section class="content border p-4 mb-4 d-flex">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
            
                    <table class="table table-hover">
                        <thead class="bg-<?php echo e($color); ?>" style="color: white">
                            <tr>                                
                                <th scope="col">ARTIGOS</th>                                
                                <th scope="col">DOC(s)</th>                                
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_artigos">
                        <tr id="novo" style="display:none;"></tr>
                        <?php $__empty_1 = true; $__currentLoopData = $artigos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artigo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>   
                            <tr id="artigo<?php echo e($artigo->id); ?>">                                
                                <th scope="row"><?php echo e($artigo->titulo); ?></th>                                
                                <td>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="btn-group" id="docs<?php echo e($artigo->id); ?>">                                                                        
                                        <button type="button" class="btn btn-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-file-pdf"></i><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" id="listdocs<?php echo e($artigo->id); ?>">
                                        <li class="dropdown-item files_enviar_btn" data-id="<?php echo e($artigo->id); ?>">
                                             <span class="btn btn-<?php echo e($color); ?> fileinput-button"><i class="fas fa-folder-open" style="color: red"></i>
                                                <input data-id="<?php echo e($artigo->id); ?>" id="arquivo<?php echo e($artigo->id); ?>" class="arquivo" type="file" name="arquivo[]" accept="application/pdf" multiple>
                                             </span>  
                                        </li>
                                            <?php $__currentLoopData = $artigo->arquivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li id="doc<?php echo e($doc->id); ?>" class="dropdown-item">                                                 
                                                    <a href="#!" id="btn_excluir_doc" data-id="<?php echo e($doc->id); ?>" data-filename="<?php echo e($doc->rotulo); ?>" class="fas fa-trash" style="color: red"></a>
                                                    <a href="#!" id="btn_abrir_doc" data-id="<?php echo e($doc->id); ?>" type="button" class="btn btn-none" style="color: blue"><?php echo e($doc->rotulo); ?></a>
                                            </li>                                            
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                        
                                        </ul>                                        
                                    </div>     
                                    </form>
                                </td>                                
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <a href="<?php echo e(route('admin.artigos.edit',['id'=>$artigo->id,'color'=>$color])); ?>" type="button" data-id="<?php echo e($artigo->id); ?>" class="edit_artigo fas fa-edit" style="background:transparent;border:none"></a>
                                            <button type="button" data-id="<?php echo e($artigo->id); ?>" data-titulo="<?php echo e($artigo->titulo); ?>" class="delete_artigo_btn fas fa-trash" style="background:transparent;border:none"></button>
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
                    <?php echo e($artigos->links()); ?>

                    </div>  
   
          </div>
        </div>
        </div>
    </section>      
    
</div> 
<!--End Index-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
    <link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet"/>  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script type="text/javascript">

$(document).ready(function(){        
    
        $(document).on('click','.delete_artigo_btn',function(e){   ///inicio delete 
            e.preventDefault();           
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var id = $(this).data("id");    
            var linklogo = "<?php echo e(asset('storage')); ?>";        
            var titulo = $(this).data("titulo");
            
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:titulo,
                text: "Deseja excluir?",
                imageUrl: linklogo+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do sistema',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){             
                $.ajax({
                    url: '/admin/artigos/delete/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,
                        '_method': 'DELETE',                    
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente da tabela html
                            $("#artigo"+id).remove();     
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

    //inicio enviar docs
    $(document).on('change','.arquivo',function(){
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var formData = new FormData();            
            let id = $(this).data('id');      
            let TotalFiles = $('#arquivo'+id)[0].files.length;
            let files = $('#arquivo'+id)[0];    

            for(let i=0; i < TotalFiles; i++){
                formData.append('arquivo'+i, files.files[i]);                            
            }

            formData.append('TotalFiles',TotalFiles);                    
            formData.append('_token',CSRF_TOKEN);
            formData.append('_enctype','multipart/form-data');
            formData.append('_method','PUT'); 
            
            $('.arquivo').val(""); ///limpa o input
                                
            $.ajax({                                             
                url: '/admin/artigos/upload-docs/'+id,              
                type:'POST',
                dataType: 'json',        
                data:formData,
                cache:false,        
                contentType: false,        
                processData: false, 
                async: true,       
                success: function(response){                              
                if(response.status==200){                      
                      $.each(response.arquivos,function(key,docs){  
                        $('#doc'+docs.id).remove();                                                                                                         
                        $('#listdocs'+id).append('<li id="doc'+docs.id+'" class="dropdown-item">\
                                                    <a href="#!" id="btn_excluir_doc" data-id="'+docs.id+'" data-filename="'+docs.rotulo+'" class="fas fa-trash" style="color: red"></a>\
                                                    <a href="#!" id="btn_abrir_doc" data-id="'+docs.id+'" type="button" class="btn btn-none" style="color: blue">'+docs.rotulo+'</a>\
                                                  </li>');
                      });       
                }   
                }                                  
        });  
    });
    ////fim enviar docs
    ///delete doc
     $(document).on('click','#btn_excluir_doc',function(e){ 
            e.preventDefault();           
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $(this).data("id");            
            var nome = $(this).data("filename");
            
                      
                $.ajax({
                    url: '/admin/artigos/delete-docs/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,
                        '_method': 'DELETE',                    
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){                        
                            $('#doc'+id).remove();
                        }
                    }
                });            
      
      
        }); 
    ///fim delete doc
    ////Abrir doc
    $(document).on('click','#btn_abrir_doc',function(e){
        e.preventDefault();            
            var id = $(this).data("id"); 

               $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/admin/artigos/abrir-doc/'+id,                                
                success: function(response){ 
                    if(response.status==200){
                      var link = "<?php echo e(asset('')); ?>"+'storage/'+response.arquivo.path;
                      //visualizar o pdf no browser                
                          window.open(link);                    
                    }
                }
            });

    });
    ///fim abrir doc   

    $(document).on('click','.voltarmenu_btn',function(e){
        e.preventDefault();  
        var color = $(this).data("color");
        location.replace('/datacenteradmin/principal/operacoes/2/'+color);
    });
    
    
    }); ///Fim do escopo do script
    
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\php\datacenter\resources\views/artigos/index.blade.php ENDPATH**/ ?>