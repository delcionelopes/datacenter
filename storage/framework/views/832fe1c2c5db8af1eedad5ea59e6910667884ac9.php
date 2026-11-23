

<?php $__env->startSection('title', 'Setores'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .tooltip-inner {
        text-align: left;
    }
</style>

<!--AddGrupoModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddGrupoModal" tabindex="-1" role="dialog" aria-labelledby="addtitleModalGrupoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="addtitleModalGrupoLabel" style="color: white;">Gerenciar Pastas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addformGrupo" name="addformGrupo" class="form-horizontal" role="form">
                    <input type="hidden" id="editsetor_id">
                    <ul id="saveformGrupo_errList"></ul>
                    <div class="form-group mb-3">
                        <fieldset id="radiogrupo_add">
                            <legend>Pastas:</legend>
                        </fieldset>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="<?php echo e($color); ?>" class="btn btn-<?php echo e($color); ?> add_Grupo"><img id="imgaddGrupo" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddGrupoModal-->

<!--index-->

<div class="container-fluid py-5">
    <div id="success_message"></div>

    <section class="border p-4 mb-4 d-flex align-items-left">

        <form action="<?php echo e(route('datacenteradmin.sistemadearquivos.indexsetores',['color'=>$color])); ?>" class="form-search" method="GET">
            <div class="col-sm-12">
                <div class="input-group rounded">
                    <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do setor" aria-label="Search"
                        aria-describedby="search-addon">
                    <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                        <i class="fas fa-search"></i>
                    </button>
                    <button data-color="<?php echo e($color); ?>" type="button" class="voltarmenu_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Sair"><i class="fas fa-door-open"></i></button>
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
                                <th scope="col">SETOR(ES)</th>
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_artigos">
                            <tr id="novo" style="display:none;"></tr>
                            <?php $__empty_1 = true; $__currentLoopData = $setores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr id="setor<?php echo e($setor->idsetor); ?>">
                                <th scope="row"><?php echo e($setor->sigla); ?> - <?php echo e($setor->nome); ?></th>
                                <td>
                                    <div class="btn-group">
                                        <button data-color="<?php echo e($color); ?>" data-id="<?php echo e($setor->idsetor); ?>" type="button" class="criarpastas_btn fas fa-folder" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Criar e gerenciar <br> pastas"></button>
                                    </div>
                                    <div class="btn-group">
                                        <a href="<?php echo e(route('datacenteradmin.sistemadearquivos.indexareasrelacionadas',['id'=>$setor->idsetor,'color'=>$color])); ?>" type="button" data-id="<?php echo e($setor->idsetor); ?>" class="list_setores_grupos fas fa-list" style="background:transparent;border:none; color:black; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Listar pastas <br> relacionadas"></a>
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
                        <?php echo e($setores->links("pagination::bootstrap-4")); ?>

                    </div>

                </div>
            </div>
        </div>
    </section>

</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
<link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', '.criarpastas_btn', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $("#editsetor_id").val(id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '/datacenteradmin/sistemadearquivos/indexalfa/' + id,
                success: function(response) {
                    if (response.status == 200) {
                        $('#radiogrupo_add').replaceWith('<fieldset id="radiogrupo_add">\
                                                                   <legend>Pastas:</legend>\
                                                                   <div class="form-group d-flex" id="grupopastas">\
                                                                   <label for="adddescricaoGrupo">Nome:</label>\
                                                                   <input type="text" id="adddescricaoGrupo" class="descricaoGrupo form-control">\
                                                                   <button type="button" class="addgrupo" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo"><i class="fas fa-plus"></i></button>\
                                                                   <button type="button" data-id="0" data-descricao="" class="remgrupo" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Excluir"><i class="fas fa-minus"></i></button>\
                                                                   </div>\
                                                                   <div class="form-check" id="radiogrupo">\
                                                                   </div>\
                                                                   </fieldset>');
                        
                        $.each(response.grupos, function(key, grupo) {                           
                           $('#radiogrupo').append('<label class="form-check-label" id="label' + grupo.id + '" for="grupo' + grupo.id + '" data-id="' + grupo.id + '" data-descricao="' + grupo.descricao + '"><input type="checkbox" id="grupo' + grupo.id + '" name="grupos[]" value="' + grupo.id + '" class="form-check-input" data-descricao="' + grupo.descricao + '" '+(response.gruposrelacionados.includes(grupo.id) ? 'checked disabled' : '')+'> ' + grupo.descricao + '</label><br>');
                        });
                    }
                }
            });
            $('#addformGrupo').trigger('reset');
            $('#AddGrupoModal').modal('show');
            $('#saveformGrupo_errList').replaceWith('<ul id="saveformGrupo_errList"></ul>');
        });

        $(document).on('click', '.addgrupo', function(e) {
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            var data = new FormData();
            data.append('descricao', $('#adddescricaoGrupo').val());
            data.append('_method', 'PUT');
            data.append('_token', CSRF_TOKEN);

            $.ajax({
                type: 'POST',
                url: '/datacenteradmin/sistemadearquivos/storearea',
                data: data,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#saveformGrupo_errList').replaceWith('<ul id="saveformGrupo_errList"></ul>');
                        $('#saveformGrupo_errList').addClass('alert alert-danger');
                        $.each(response.errors, function(key, err_values) {
                            $('#saveformGrupo_errList').append('<li>' + err_values + '</li>');
                        });
                    } else {
                        $('#saveformGrupo_errList').replaceWith('<ul id="saveformGrupo_errList"></ul>');                        
                        $('#saveformGrupo_errList').addClass('alert alert-success');
                        $('#saveformGrupo_errList').append(response.message);

                        $('#radiogrupo').append('<label class="form-check-label" id="label' + response.grupo.id + '" for="grupo' + response.grupo.id + '" data-id="' + response.grupo.id + '" data-descricao="' + response.grupo.descricao + '"><input type="checkbox" id="grupo' + response.grupo.id + '" name="grupos[]" value="' + response.grupo.id + '" class="form-check-input" data-descricao="' + response.grupo.descricao + '"> ' + response.grupo.descricao + '</label><br>');
                        //depois que insere, limpa o input
                        document.getElementById('adddescricaoGrupo').value = '';
                    }
                }
            });
        });


        $(document).on('click', '.remgrupo', function(e) { ///inicio delete grupo
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var titulo = $(this).data("descricao");
            var id = $(this).data("id");

            var linklogo = "<?php echo e(asset('storage')); ?>";

            if (id == null || id == 0) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Selecione um item!",
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                    title: titulo,
                    text: "Deseja excluir?",
                    imageUrl: linklogo + '/logoprodap.jpg',
                    imageWidth: 400,
                    imageHeight: 200,
                    imageAlt: 'imagem do sistema',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, prossiga!',
                    cancelButtonText: 'Não, cancelar!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/datacenteradmin/sistemadearquivos/deletearea/' + id,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                'id': id,
                                '_method': 'DELETE',
                                '_token': CSRF_TOKEN,
                            },
                            success: function(response) {
                                if (response.status == 200) {
                                    //remove linha correspondente da tabela html
                                    $("#grupo" + id).remove();
                                    $("#label" + id).remove();
                                    $('#saveformGrupo_errList').replaceWith('<ul id="saveformGrupo_errList"></ul>');
                                    $('#saveformGrupo_errList').addClass('alert alert-success');
                                    $('#saveformGrupo_errList').append(response.message);
                                } else {
                                    //Não pôde excluir por causa dos relacionamentos
                                    $('#saveformGrupo_errList').replaceWith('<ul id="saveformGrupo_errList"></ul>');
                                    $('#saveformGrupo_errList').addClass('alert alert-danger');
                                    $('#saveformGrupo_errList').text(response.message);
                                }
                            }
                        });
                    }
                });

            }

        }); ///fim delete grupo

        $(document).on('click', '.form-check-label', function() {

            var id = $(this).data("id");
            var descricao = $(this).data("descricao");

            $("#grupopastas").replaceWith('<div class="form-group d-flex" id="grupopastas">\
                                                                   <label for="adddescricaoGrupo">Nome:</label>\
                                                                   <input type="text" id="adddescricaoGrupo" class="descricaoGrupo form-control">\
                                                                   <button type="button" class="addgrupo" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo"><i class="fas fa-plus"></i></button>\
                                                                   <button type="button" data-id="' + id + '" data-descricao="' + descricao + '" class="remgrupo" style="background-color: white; border: 1; border-color: white; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Excluir"><i class="fas fa-minus"></i></button>\
                                                                   </div>');

            $('#adddescricaoGrupo').val(descricao);
        });

        $(document).on('click', '.add_Grupo', function(e) {
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $('#editsetor_id').val();
            var color = $(this).data("color");
            var loading = $("#imgaddGrupo");
                loading.show();

            //Array apenas com os checkboxes marcados identificados pelo name
            var grupos = new Array();
            $("input[name='grupos[]']:checked").each(function() {
                grupos.push($(this).val());
            });

            var data = new FormData();

            data.append('grupos',JSON.stringify(grupos)); //array
            data.append('_token', CSRF_TOKEN);
            data.append('_method', 'PUT');

            $.ajax({
                url: '/datacenteradmin/sistemadearquivos/vinculargruposarquivos/' + id,
                type: 'POST',
                dataType: 'json',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                async: true,
                success: function(response) {
                    if (response.status == 400) {
                        $('#saveformGrupo_errList').replaceWith('<ul id="saveformGrupo_errList"></ul>');
                        $('#saveformGrupo_errList').addClass('alert alert-danger');                        
                            $('#saveformGrupo_errList').append('<li>' + response.message + '</li>');
                        
                        loading.hide();
                    } else {
                        $('#saveformGrupo_errList').replaceWith('<ul id="saveformGrupo_errList"></ul>');
                        loading.hide();
                        location.replace('/datacenteradmin/sistemadearquivos/indexsetores/'+color);
                    }
                }
            });

        });



        ///tooltip
        $(function() {
            $(".pesquisa_btn").tooltip();
            $(".list_setores_grupos").tooltip();
            $(".criarpastas_btn").tooltip();
            $(".voltarmenu_btn").tooltip();
            $(".addgrupo").tooltip();
            $(".remgrupo").tooltip();
        });
        ///fim tooltip

        $(document).on('click', '.voltarmenu_btn', function(e) {
            e.preventDefault();
            var color = $(this).data("color");
            location.replace('/datacenteradmin/principal/operacoes/1/'+color);
        });


    }); ///Fim do escopo do script
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\php\datacenter\resources\views/area_conhecimento/indexsetores.blade.php ENDPATH**/ ?>