

<?php $__env->startSection('title', 'Cadastro de IP'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .tooltip-inner {
    text-align: left;
    }
</style>

<!--AddOrgaoModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddOrgaoModal" tabindex="-1" role="dialog" aria-labelledby="addtitleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="addtitleModalLabel" style="color: white;">Adicionar Órgão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="addform" name="addform" class="form-horizontal" role="form">                 
                <ul id="saveformadd_errList"></ul>
                <div class="row">
                <div class="col-md-8">
                <div class="form-group">
                    <label for="addnomeorgao">Nome do Órgão:</label>
                    <input type="text" id="addnomeorgao" class="form-control">
                </div>           
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="addtelefoneorgao">Telefone:</label>
                        <input type="text" id="addtelefoneorgao" class="form-control">
                    </div>
                </div>
                </div>     
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-<?php echo e($color); ?> add_orgao"><img id="imgadd" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddOrgaoModal-->

<!--EditOrgaoModal-->

<div class="modal fade animate__animated animate__bounce" id="EditOrgaoModal" tabindex="-1" role="dialog" aria-labelledby="edittitleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="edittitleModalLabel" style="color: white;">Editar e atualizar Órgão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="editform" name="editform" class="form-horizontal" role="form">                
                <ul id="updateform_errList"></ul>               
                <input type="hidden" id="edit_orgao_id">
                <div class="row">
                <div class="col-md-8">
                <div class="form-group">
                    <label for="editnomeorgao">Nome do Órgão:</label>
                    <input type="text" id="editnomeorgao" class="nomeorgao form-control">
                </div>           
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="edittelefoneorgao">Telefone:</label>
                        <input type="text" id="edittelefoneorgao" class="telefoneorgao form-control">
                    </div>
                </div>
                </div>                  
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-<?php echo e($color); ?> update_orgao"><img id="imgedit" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!--End EditOrgaoModal -->

<!--AddSetorModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddSetorModal" tabindex="-1" role="dialog" aria-labelledby="addsetortitleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="addsetortitleModalLabel" style="color: white;">Adicionar Setor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <input type="hidden" id="add_orgao_setor_id">            
            <form id="addsetorform" name="addsetorform" class="form-horizontal" role="form">                 
                <ul id="saveformaddsetor_errList"></ul>
                <div class="row">
                <div class="col-md-3">
                <div class="form-group">
                    <label for="addsiglasetor">Sigla:</label>
                    <input type="text" id="addsiglasetor" class="form-control">
                </div>           
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="adddescricaosetor">Nome:</label>
                        <input type="text" id="adddescricaosetor" class="form-control">
                    </div>
                </div>
                </div>     
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-<?php echo e($color); ?> add_setor"><img id="imgadd" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddSetorModal-->

<!--EditSetorModal-->

<div class="modal fade animate__animated animate__bounce" id="EditSetorModal" tabindex="-1" role="dialog" aria-labelledby="editsetortitleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="editsetortitleModalLabel" style="color: white;">Editar e atualizar Setor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="editsetorform" name="editsetorform" class="form-horizontal" role="form">                
                <ul id="updateformsetor_errList"></ul>               
                <input type="hidden" id="edit_orgao_setor_id">
                <input type="hidden" id="edit_setor_id">
                <div class="row">
                <div class="col-md-3">
                <div class="form-group">
                    <label for="editsiglasetor">Sigla:</label>
                    <input type="text" id="editsiglasetor" class="siglasetor form-control">
                </div>           
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="editdescricaosetor">Nome:</label>
                        <input type="text" id="editdescricaosetor" class="descricaosetor form-control">
                    </div>
                </div>
                </div>                  
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-<?php echo e($color); ?> update_setor"><img id="imgedit" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!--End EditOrgaoModal -->

<form role="form" enctype="multipart/form-data" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <ul id="saveform_errList"></ul>
    <input type="hidden" id="add_rede_id" value="<?php echo e($id); ?>"> 
    <header class="masthead" style="background-image: url('/assets/img/home-bg.jpg')">
         <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="post-heading">
                            <h1>Cadastro de IPs</h1>                            
                        </div>
                    </div>
                </div>
            </div>
    </header>              
    <div class="container-fluid py-5">                
        <div class="card">
        <div class="card-body">                          
                <fieldset>
                    <legend>Localização</legend>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="adorgao">Órgão</label>
                            <div class="form-group d-flex">
                            <select name="adorgao" id="adorgao" class="custom-select">
                                <option id="optnovoorgao" style="display: none;"></option>
                                <?php $__currentLoopData = $orgaos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orgao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option class="optorgao" id="optorgao<?php echo e($orgao->id); ?>" data-id="<?php echo e($orgao->id); ?>" data-nome="<?php echo e($orgao->nome); ?>" value="<?php echo e($orgao->id); ?>"><?php echo e($orgao->nome); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                                <button type="button" class="addorgao" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo<br>Órgão"><i class="fas fa-plus"></i></button>
                                <button type="button" class="remorgao" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Excluir<br>Órgão"><i class="fas fa-minus"></i></button>
                                <button type="button" class="editorgao" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Editar<br>Órgão"><i class="fas fa-edit"></i></button>
                            </div>
                        </div>       
                        </div>             
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="adsetor">Setor</label>
                            <div class="form-group d-flex">
                            <select name="adsetor" id="adsetor" class="custom-select">
                                <option id="optnovosetor" style="display: none;"></option>
                                <option value=""></option>
                            </select>
                                <button type="button" class="addsetor" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo<br>Setor"><i class="fas fa-plus"></i></button>
                                <button type="button" class="remsetor" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Excluir<br>Setor"><i class="fas fa-minus"></i></button>
                                <button type="button" class="editsetor" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Editar<br>Setor"><i class="fas fa-edit"></i></button>
                            </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Informações</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addip">IP</label>
                                <input type="text" id="addip" class="form-control" data-mask="099.099.099.099">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addstatus">Status</label><br>
                                <label for="" id="addstratus" style="color: green;"> LIVRE</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addmac">MAC</label>
                                <input type="text" id="addmac" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="adddescricao">Descrição</label>
                                <textarea name="descricao" id="adddescricao" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button data-color="<?php echo e($color); ?>" type="button" class="cancelar_btn btn btn-default">Cancelar</button>
                            <button data-color="<?php echo e($color); ?>" class="salvar_btn btn btn-<?php echo e($color); ?>" type="button"><img id="imgadd" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
                        </div>
                    </div>
                </div>

            </div> <!-- card-body -->       
        </div> <!-- card -->
    </div> <!-- card-fluid -->
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
        var id = $('#add_rede_id').val();
        var loading = $('#imgadd');
            loading.show();
        var color = $(this).data("color");
            
        var data = new FormData();         
                data.append('orgao',$('#addorgao').val());
                data.append('setor',$('#addsetor').val());
                data.append('rede',id);
                data.append('ip',$('#addip').val());
                data.append('status','LIVRE');
                data.append('mac',$('#addmac').val());
                data.append('descricao',$('#adddescricao').val());
                data.append('_method','PUT');
                data.append('_token',CSRF_TOKEN);            

        $.ajax({
            url: '/datacenteradmin/ip/adiciona-ip',
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
                    location.replace('/datacenteradmin/ip/index-ip/'+id+'/'+color);
                }  
            }  
        });

    });

    
    $(document).on('click','#adorgao',function(e){
        e.preventDefault();        
        var orgaoid = $(this).val();
                      $("#add_orgao_setor_id").val(orgaoid);
                      $("#edit_orgao_setor_id").val(orgaoid);
         $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'/datacenteradmin/ip/carregasetores/'+orgaoid,
                success:function(response){
                    if(response.status==200){
                        const meuSelect = document.getElementById("adsetor");
                              meuSelect.options.length = 0;
                        if(response.setores!=null){
                        $('#adsetor').append('<option class="optsetor" id="optnovosetor" style="display: none;"></option>');
                        $.each(response.setores,function(key,setor){
                            $('#adsetor').append('<option class="optsetor" id="optsetor'+setor.id+'" data-id="'+setor.id+'" data-descricao="'+setor.descricao+'" value="'+setor.id+'">'+setor.descricao+'</option>');
                        });
                        }
                    }
                }
            });

    });

    $(document).on('click','.cancelar_btn',function(e){
        e.preventDefault();
        var id = $('#add_rede_id').val();
        var color = $(this).data("color");
        location.replace('/datacenteradmin/ip/index-ip/'+id+'/'+color);
    });

      ///tooltip
    $(function(){             
        $(".addorgao").tooltip();
        $(".remorgao").tooltip();        
        $(".editorgao").tooltip();
        $(".addsetor").tooltip();
        $(".remsetor").tooltip();        
        $(".editsetor").tooltip();        
    });
    ///fim tooltip

    window.onload = function(){
        const selectorgao = document.getElementById("adorgao");
        var orgaoid = selectorgao.value;
                      $("#add_orgao_setor_id").val(orgaoid);
                      $("#edit_orgao_setor_id").val(orgaoid);
         $.ajaxSetup({
                headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'/datacenteradmin/ip/carregasetores/'+orgaoid,
                success:function(response){
                    if(response.status==200){
                        const meuSelect = document.getElementById("adsetor");
                              meuSelect.options.length = 0;
                        $('#adsetor').append('<option class="optsetor" id="optnovosetor" style="display: none;"></option>');
                        if(response.setores!=null){                        
                        $.each(response.setores,function(key,setor){
                            $('#adsetor').append('<option class="optsetor" id="optsetor'+setor.id+'" data-id="'+setor.id+'" data-descricao="'+setor.descricao+'" value="'+setor.id+'">'+setor.descricao+'</option>');
                        });
                        }
                    }
                }
            });
    };

    $(document).on('click','.remorgao',function(e){   ///inicio delete orgao
            e.preventDefault();           
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var selectorgao = document.getElementById('adorgao');            
            var id = selectorgao.options[selectorgao.selectedIndex].value;
            var linklogo = "<?php echo e(asset('storage')); ?>";
            var titulo = $('#optorgao'+id).data("nome");

            if(id==null || id==0){
                Swal.fire({
                          position: "top-end",
                          icon: "error",
                          title: "Selecione um item de Órgãos!",
                          showConfirmButton: false,
                          timer: 1500
                          });
            }else{
            
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
                    url: '/datacenteradmin/orgao/delete-orgao/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,
                        '_method': 'DELETE',                    
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente
                            $("#optorgao"+id).remove();     
                            $('#success_message').replaceWith('<div id="success_message"></div>');                       
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);         
                        }else{
                            //Não pôde excluir por causa dos relacionamentos
                            $('#success_message').replaceWith('<div id="success_message"></div>');                        
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        }
                    }
                });            
            }  
        });

        }
      
        });  ///fim delete

        //exibe form de adição de orgão
        $('#AddOrgaoModal').on('shown.bs.modal',function(){
            $('#addnomeorgao').focus();
        });
        $(document).on('click','.addorgao',function(e){  //início da exibição do form
            e.preventDefault();
            $('#addform').trigger('reset');
            $('#AddOrgaoModal').modal('show'); 
            $('#saveformadd_errList').replaceWith('<ul id="saveformadd_errList"></ul>');
        });
        //fim exibe form de adição de orgão

        $(document).on('click','.add_orgao',function(e){ //início da adição de orgão
            e.preventDefault();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');  
            
            var loading = $('#imgadd');
                loading.show();

            var data = new FormData();
                data.append('nome', $('#addnomeorgao').val());
                data.append('telefone', $('#addtelefoneorgao').val());
                data.append('_method','PUT');
                data.append('_token',CSRF_TOKEN);            
            
            $.ajax({
                type: 'POST',
                url: '/datacenteradmin/orgao/adiciona-orgao',
                data: data,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,    
                success: function(response){
                    if(response.status==400){
                        $('#saveformadd_errList').replaceWith('<ul id="saveformadd_errList"></ul>');
                        $('#saveformadd_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveformadd_errList').append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    } else {
                        $('#saveformadd_errList').replaceWith('<ul id="saveformadd_errList"></ul>');     
                        $('#success_message').replaceWith('<div id="success_message"></div>');              
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);     
                        
                        loading.hide();
                        $('#addform').trigger('reset');                    
                        $('#AddOrgaoModal').modal('hide');
    
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<option id="optnovoorgao" style="display: none;"></option>';
                            linha1 = '<option class="optorgao" id="optorgao'+response.orgao.id+'" data-id="'+response.orgao.id+'" data-nome="'+response.orgao.nome+'" value="'+response.orgao.id+'">'+response.orgao.nome+'</option>';
                        tupla = linha0+linha1;                             
                        $("#optnovoorgao").replaceWith(tupla);
                    }
                }
            });
    
        }); //Fim da adição de registro

        //início da exibição do form
        $('#EditOrgaoModal').on('shown.bs.modal',function(){
            $('#editnomeorgao').focus();
        });
        $(document).on('click','.editorgao',function(e){  
            e.preventDefault();            
            var selectorgao = document.getElementById('adorgao');            
            var id = selectorgao.options[selectorgao.selectedIndex].value;
            if(id==null || id==0){
                Swal.fire({
                          position: "top-end",
                          icon: "error",
                          title: "Selecione um item de órgãos!",
                          showConfirmButton: false,
                          timer: 1500
                          });
            }else{
            $('#editform').trigger('reset');
            $('#EditOrgaoModal').modal('show');          
            $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/datacenteradmin/orgao/edit-orgao/'+id,                                
                success: function(response){           
                    if(response.status==200){
                        $('.nomeorgao').val(response.orgao.nome);
                        $('.telefoneorgao').val(response.orgao.telefone);
                        $('#edit_orgao_id').val(response.orgao.id);
                    }      
                }
            });

        }
    
        }); //fim da da exibição do form
    
        $(document).on('click','.update_orgao',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            var loading = $('#imgedit');
                loading.show();
    
            var id = $('#edit_orgao_id').val();        
    
            var data = new FormData();                
                data.append('nome', $('#editnomeorgao').val());
                data.append('telefone', $('#edittelefoneorgao').val());
                data.append('_method','PUT');
                data.append('_token',CSRF_TOKEN);
            
            
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: '/datacenteradmin/orgao/update-orgao/'+id,       
                cache: false,
                processData: false,
                contentType: false,      
                success: function(response){                                                    
                    if(response.status==400){
                        //erros
                        $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });    
                       loading.hide();
    
                    } else if(response.status==404){
                        $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');    
                        $('#success_message').replaceWith('<div id="success_message"></div>');             
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        loading.hide();
                    } else {
                        $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');      
                        $('#success_message').replaceWith('<div id="success_message"></div>');                 
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);                             
                        
                        loading.hide();
                        $('#editform').trigger('reset');
                        $('#EditOrgaoModal').modal('hide');
                        var linha = "";
                            linha = '<option class="optorgao" id="optorgao'+response.orgao.id+'" data-id="'+response.orgao.id+'" data-nome="'+response.orgao.nome+'" value="'+response.orgao.id+'">'+response.orgao.nome+'</option>';
                        $("#optorgao"+id).replaceWith(linha);
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro do orgão 

        /////operação com o setor limitado do órgão

        $(document).on('click','.remsetor',function(e){   ///inicio delete setor
            e.preventDefault();           
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var selectsetor = document.getElementById('adsetor');            
            var id = selectsetor.options[selectsetor.selectedIndex].value;
            var linklogo = "<?php echo e(asset('storage')); ?>";
            var titulo = $('#optsetor'+id).data("descricao");

            if(id==null || id==0){
                Swal.fire({
                          position: "top-end",
                          icon: "error",
                          title: "Selecione um item de Setores!",
                          showConfirmButton: false,
                          timer: 1500
                          });
            }else{
            
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
                    url: '/datacenteradmin/setorvinc/delete-setorvinc/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,
                        '_method': 'DELETE',                    
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente
                            $("#optsetor"+id).remove();     
                            $('#success_message').replaceWith('<div id="success_message"></div>');                       
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);         
                        }else{
                            //Não pôde excluir por causa dos relacionamentos
                            $('#success_message').replaceWith('<div id="success_message"></div>');                        
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        }
                    }
                });            
            }  
        });

        }
      
        });  ///fim delete

        //exibe form de adição de orgão
        $('#AddSetorModal').on('shown.bs.modal',function(){
            $('#addsiglasetor').focus();
        });
        $(document).on('click','.addsetor',function(e){  //início da exibição do form
            e.preventDefault();
            var selectorgao = document.getElementById('adorgao');            
            var id = selectorgao.options[selectorgao.selectedIndex].value;
            if(id==null || id==0){
                   Swal.fire({
                          position: "top-end",
                          icon: "error",
                          title: "Selecione um item de órgãos!",
                          showConfirmButton: false,
                          timer: 1500
                          });
            }else{
            $('#addsetorform').trigger('reset');
            $('#AddSetorModal').modal('show'); 
            $('#saveformaddsetor_errList').replaceWith('<ul id="saveformaddsetor_errList"></ul>');
            }
        });
        //fim exibe form de adição de setor

        $(document).on('click','.add_setor',function(e){ //início da adição de setor
            e.preventDefault();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var orgaoid = $("#add_orgao_setor_id").val();
            
            var loading = $('#imgadd');
                loading.show();

            var data = new FormData();
                data.append('orgao',orgaoid);
                data.append('sigla', $('#addsiglasetor').val());
                data.append('descricao', $('#adddescricaosetor').val());
                data.append('_method','PUT');
                data.append('_token',CSRF_TOKEN);            
            
            $.ajax({
                type: 'POST',
                url: '/datacenteradmin/setorvinc/adiciona-setorvinc',
                data: data,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,    
                success: function(response){
                    if(response.status==400){
                        $('#saveformaddsetor_errList').replaceWith('<ul id="saveformaddsetor_errList"></ul>');
                        $('#saveformaddsetor_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveformaddsetor_errList').append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    } else {
                        $('#saveformaddsetor_errList').replaceWith('<ul id="saveformaddsetor_errList"></ul>');     
                        $('#success_message').replaceWith('<div id="success_message"></div>');              
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);     
                        
                        loading.hide();
                        $('#addsetorform').trigger('reset');                    
                        $('#AddSetorModal').modal('hide');
    
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<option id="optnovosetor" style="display: none;"></option>';
                            linha1 = '<option class="optsetor" id="optsetor'+response.setor.id+'" data-id="'+response.setor.id+'" data-descricao="'+response.setor.descricao+'" value="'+response.setor.id+'">'+response.setor.descricao+'</option>';
                        tupla = linha0+linha1;                             
                        $("#optnovosetor").replaceWith(tupla);
                    }
                }
            });
    
        }); //Fim da adição de registro

        //início da exibição do form
        $('#EditSetorModal').on('shown.bs.modal',function(){
            $('#editsiglasetor').focus();
        });
        $(document).on('click','.editsetor',function(e){  
            e.preventDefault();
            var selectorgao = document.getElementById('adorgao');            
            var orgaoid = selectorgao.options[selectorgao.selectedIndex].value;
            if(orgaoid==null || orgaoid==0){
                   Swal.fire({
                          position: "top-end",
                          icon: "error",
                          title: "Selecione um item de órgãos!",
                          showConfirmButton: false,
                          timer: 1500
                          });
            }else{
            var selectsetor = document.getElementById('adsetor');            
            var id = selectsetor.options[selectsetor.selectedIndex].value;
            if(id==null || id==0){
                Swal.fire({
                          position: "top-end",
                          icon: "error",
                          title: "Selecione um item de setores!",
                          showConfirmButton: false,
                          timer: 1500
                          });
            }else{
            $('#editsetorform').trigger('reset');
            $('#EditSetorModal').modal('show');          
            $('#updateformsetor_errList').replaceWith('<ul id="updateformsetor_errList"></ul>');
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/datacenteradmin/setorvinc/edit-setorvinc/'+id,                                
                success: function(response){           
                    if(response.status==200){
                        $('.siglasetor').val(response.setor.sigla);
                        $('.descricaosetor').val(response.setor.descricao);                        
                        $('#edit_setor_id').val(response.setor.id);
                    }      
                }
            });

        }
        }
    
        }); //fim da da exibição do form
    
        $(document).on('click','.update_setor',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            var loading = $('#imgedit');
                loading.show();
            var orgaoid = $("#edit_orgao_setor_id").val();
            var id = $('#edit_setor_id').val();        
    
            var data = new FormData();                
                data.append('orgao',orgaoid);
                data.append('sigla', $('#editsiglasetor').val());
                data.append('descricao', $('#editdescricaosetor').val());
                data.append('_method','PUT');
                data.append('_token',CSRF_TOKEN);
            
            
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: '/datacenteradmin/setorvinc/update-setorvinc/'+id,
                cache: false,
                processData: false,
                contentType: false,      
                success: function(response){                                                    
                    if(response.status==400){
                        //erros
                        $('#updateformsetor_errList').replaceWith('<ul id="updateformsetor_errList"></ul>');
                        $('#updateformsetor_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateformsetor_errList').append('<li>'+err_values+'</li>');
                        });    
                       loading.hide();
    
                    } else if(response.status==404){
                        $('#updateformsetor_errList').replaceWith('<ul id="updateformsetor_errList"></ul>');    
                        $('#success_message').replaceWith('<div id="success_message"></div>');             
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        loading.hide();
                    } else {
                        $('#updateformsetor_errList').replaceWith('<ul id="updateformsetor_errList"></ul>');      
                        $('#success_message').replaceWith('<div id="success_message"></div>');                 
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);                             
                        
                        loading.hide();
                        $('#editsetorform').trigger('reset');
                        $('#EditSetorModal').modal('hide');
                        var linha = "";
                            linha = '<option class="optsetor" id="optsetor'+response.setor.id+'" data-id="'+response.setor.id+'" data-descricao="'+response.setor.descricao+'" value="'+response.setor.id+'">'+response.setor.descricao+'</option>';
                        $("#optsetor"+id).replaceWith(linha);
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro do setor vinculado
    

});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\php\datacenter\resources\views/datacenter/ip/create.blade.php ENDPATH**/ ?>