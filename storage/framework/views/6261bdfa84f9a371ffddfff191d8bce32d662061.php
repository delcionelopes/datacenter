<?php $__env->startSection('title', 'PRODAP - Datacenter'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!-- início AddAppModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="AddAppModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar APP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addform" name="addform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_base_id">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">VM:</label>
                        <label id="add_nome_vm" style="font-style: italic;"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Base:</label>
                        <label id="add_nome_base" style="font-style: italic;"></label>
                    </div>

                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Base:</label>
                        <select name="add_selbase_id" id="add_selbase_id" class="custom-select">
                            <?php $__currentLoopData = $bases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $base): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($base->id); ?>"><?php echo e($base->nome_base); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Órgão:</label>
                        <select name="add_selorgao_id" id="add_selorgao_id" class="custom-select">
                            <?php $__currentLoopData = $orgaos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orgao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($orgao->id); ?>"><?php echo e($orgao->nome); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Projeto:</label>
                        <select name="add_selprojeto_id" id="add_selprojeto_id" class="custom-select">
                            <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projeto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($projeto->id); ?>"><?php echo e($projeto->nome_projeto); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nome APP:</label>
                        <input type="text" class="add_nome_app form-control">
                    </div>
                    </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Domínio:</label>
                        <input type="text" class="add_dominio form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for=""> 
                        <input type="checkbox" name="add_https" id="add_https"> HTTPS
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="<?php echo e($color); ?>" class="btn btn-<?php echo e($color); ?> add_app_btn"><img id="imgadd" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim AddAppModal -->

<!-- início EditAppModal -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditAppModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar APP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close"> 
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editform" name="editform" class="form-horizontal" role="form">
                    <input type="hidden" id="edit_base_id">
                    <input type="hidden" id="edit_app_id">
                    <ul id="updateform_errList"></ul>
                    <div class="form-group mb-3">
                        <label for="">VM:</label>
                        <label id="edit_nome_vm" style="font-style: italic;"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Base:</label>
                        <label id="edit_nome_base" style="font-style: italic;"></label>                    
                    </div>

                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Base:</label>
                        <select name="edit_selbase_id" id="edit_selbase_id" class="custom-select">
                            <?php $__currentLoopData = $bases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $base): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($base->id); ?>"><?php echo e($base->nome_base); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Órgão:</label>
                        <select name="edit_selorgao_id" id="edit_selorgao_id" class="custom-select">
                            <?php $__currentLoopData = $orgaos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orgao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($orgao->id); ?>"><?php echo e($orgao->nome); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Projeto:</label>
                        <select name="edit_selprojeto_id" id="edit_selprojeto_id" class="custom-select">
                            <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projeto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($projeto->id); ?>"><?php echo e($projeto->nome_projeto); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nome APP:</label>
                        <input type="text" id="edit_nome_app" class="edit_nome_app form-control">
                    </div>
                    </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Domínio:</label>
                        <input type="text" id="edit_dominio" class="edit_dominio form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for=""> 
                        <input type="checkbox" name="edit_https" id="edit_https" value=""> HTTPS
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="<?php echo e($color); ?>" class="btn btn-<?php echo e($color); ?> update_app_btn"><img id="imgedit" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!-- início EditAppModal -->

<!-- início AddSenhaApp -->
   <div class="modal fade animate__animated animate__bounce animate__faster" id="AddSenhaApp" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="addformsenha" name="addformsenha" class="form-horizontal" role="form">
                    <input type="hidden" id="add_appsenha_id">
                    <ul id="saveformsenha_errList"></ul>   
                    <div class="card">
                    <div class="card-body">         
                     <fieldset>
                    <legend>Dados da Senha</legend>                    
                    <div class="form-group mb-3">
                        <label  for="">Nome APP:</label>
                        <label  id="nomeapp"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Domínio:</label>
                        <label  id="dominioapp"></label>
                    </div>

                    <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Senha</label>
                        <input type="text" class="add_senha form-control">
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Validade</label>
                        <input type="text" class="add_validade form-control" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-check">
                        <label class="form-check-label" for="flexCheck"> 
                        <input type="checkbox" class="add_val_indefinida form-check-input" name="add_val_indefinida" id="flexCheck"> Validade indeterminada
                        </label>
                    </div>
                    </div>
                    </div>

                     </fieldset>
                    </div>
                    </div>
                     <div class="card">
                        <div class="card-body">                        
                            <fieldset>
                                <legend>Quem tem acesso a esta informação?</legend>
                                <div class="form-check">
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="form-check-label" for="CheckUser<?php echo e($user->id); ?>">
                                        <input type="checkbox" id="CheckUser<?php echo e($user->id); ?>" name="users[]" value="<?php echo e($user->id); ?>" class="form-check-input">
                                        <?php if($user->admin): ?> 
                                            <i class="fas fa-user" style="color: green "></i> 
                                        <?php else: ?> 
                                            <i class="fas fa-user" style="color: gray"></i> 
                                        <?php endif; ?> 
                                            <?php echo e($user->name); ?>

                                    </label><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </fieldset>  
                            </div>
                     </div>                             
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="<?php echo e($color); ?>" class="btn btn-<?php echo e($color); ?> add_senhaapp_btn"><img id="imgaddsenha" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim AddSenhaApp -->

<!-- início EditSenhaApp -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSenhaApp" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-<?php echo e($color); ?>">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editformsenha" name="editformsenha" class="form-horizontal" role="form">
                    <input type="hidden" id="edit_appsenha_id">
                    <ul id="updateformsenha_errList"></ul>  
                    <div class="card">
                    <div class="card-body"> 
                    <fieldset>
                    <legend>Dados da Senha</legend>                 
                    <div class="form-group mb-3">
                        <label  for="">Nome APP:</label>
                        <label  id="editnomeapp"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Domínio:</label>
                        <label  id="editdominioapp"></label>
                    </div>
                     <div class="form-group mb-3">
                        <label  for="">Criação:</label>
                        <label  id="editdatacriacao"></label><br>
                        <label  for="">Modificação:</label>
                        <label  id="editdatamodificacao"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Criador:</label>
                        <label  id="editcriador"></label><br>
                        <label  for="">Modificador:</label>
                        <label  id="editmodificador"></label>
                    </div>

                    <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Senha</label>
                        <input type="text" id="edit_senha" class="senha form-control">
                     
                    <label for=""><small id="senhavencida" style="color: red">Senha vencida!</small></label>                    
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Validade</label>
                        <input type="text" id="edit_validade" class="validade form-control" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-check">
                        <label class="form-check-label" for="edit_val_indefinida"> 
                        <input type="checkbox" class="val_indefinida form-check-input" name="edit_val_indefinida" id="edit_val_indefinida"> Validade indeterminada
                        </label>
                    </div>           
                    </div>
                    </div>

                    </fieldset>    
                    </div>
                    </div>
                     <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Quem tem acesso a esta informação?</legend>
                                <div class="form-check">
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="form-check-label" for="check<?php echo e($user->id); ?>">
                                        <input type="checkbox" id="check<?php echo e($user->id); ?>" name="users[]" value="<?php echo e($user->id); ?>" class="form-check-input">
                                         <?php if($user->admin): ?> 
                                            <i class="fas fa-user" style="color: green "></i> 
                                        <?php else: ?> 
                                            <i class="fas fa-user" style="color: gray"></i> 
                                        <?php endif; ?> 
                                            <?php echo e($user->name); ?>

                                    </label><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </fieldset>   
                     </div>
                     </div>                  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" data-color="<?php echo e($color); ?>" class="btn btn-<?php echo e($color); ?> update_senhaapp_btn"><img id="imgeditsenha" src="<?php echo e(asset('storage/ajax-loader.gif')); ?>" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim EditSenhaApp -->

<!-- início index -->
<div class="container-fluid py-5">
    <div id="success_message"></div>    
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="<?php echo e(route('datacenteradmin.app.app.index',['id'=>$id,'color'=>$color])); ?>" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                        <nav class="navbar navbar-expand-md navbar-light bg-light">
                            <input type="hidden" id="baseid" value="<?php echo e($id); ?>">
                            <input type="hidden" id="vmnome" value="<?php echo e($vm->nome_vm); ?>"> 
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="Nome do APP" aria-label="Search" aria-describedby="search-addon">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent; border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                            <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-id="<?php echo e($id); ?>" data-nome_base="<?php echo e($bd->nome_base); ?>" class="AddApp_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent; border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                            <i class="fas fa-plus"></i>
                            </button>
                            <button data-color="<?php echo e($color); ?>" type="button" class="voltarmenu_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;" onclick="history.back()"><i class="fas fa-door-open"></i></button>
                        </nav>
                        </div>
                    </div>
                </form>
            </section>
            <table class="table table-hover">
            <thead class="bg-<?php echo e($color); ?>" style="color: white">
                    <tr>
                        <th scope="col">APP</th>
                        <th scope="col"><i class="fas fa-key"></i> PASS</th>
                        <th scope="col">HTTPS</th>                       
                        <th scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="lista_app">
                    <tr id="novo" style="display: none;"></tr>
                    <?php $__empty_1 = true; $__currentLoopData = $apps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr id="app<?php echo e($app->id); ?>" data-toggle="tooltip" title="<?php echo e($app->dominio); ?>">
                        <th scope="row"><?php echo e($app->nome_app); ?></th>                        
                        <td id="senha<?php echo e($app->id); ?>">
                            <?php if(!$app->senha): ?>
                            <button id="botaosenha<?php echo e($app->id); ?>" type="button" data-id="<?php echo e($app->id); ?>" data-setoradmin="<?php echo e(auth()->user()->setor_idsetor); ?>" data-nomeapp="<?php echo e($app->nome_app); ?>" data-dominio="<?php echo e($app->dominio); ?>" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Registrar senha e dar<br>permissões de visualização"></button>
                            <?php else: ?>
                            <?php if($app->users()->count()): ?>                           
                            <?php $__currentLoopData = $app->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php if(($user->id) == (auth()->user()->id)): ?>                                  
                                  <button id="botaosenha<?php echo e($app->id); ?>" type="button" data-id="<?php echo e($app->id); ?>" data-setoradmin="<?php echo e(auth()->user()->setor_idsetor); ?>" data-nomeapp="<?php echo e($app->nome_app); ?>" data-dominio="<?php echo e($app->dominio); ?>" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="<?php echo e($app->users->implode('name','<br>')); ?>"></button>
                                  <?php break; ?>
                                  <?php elseif($loop->last): ?>
                                  <button id="botaosenha<?php echo e($app->id); ?>" type="button" data-id="<?php echo e($app->id); ?>" data-setoradmin="<?php echo e(auth()->user()->setor_idsetor); ?>" data-nomeapp="<?php echo e($app->nome_app); ?>" data-dominio="<?php echo e($app->dominio); ?>" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="<?php echo e($app->users->implode('name','<br>')); ?>"></button>
                                  <?php endif; ?>                                                        
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                            
                            <?php endif; ?>
                            <?php endif; ?>                                                        
                        </td>
                        <?php if($app->https): ?>
                        <td id="st_https<?php echo e($app->id); ?>"><button type="button" data-id="<?php echo e($app->id); ?>" data-setoradmin="<?php echo e(auth()->user()->setor_idsetor); ?>" data-https="0" class="https_btn fas fa-lock" style="background: transparent; color: green; border: none;white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="<?php echo e($app->nome_app); ?> COM certificação HTTPS"></button></td>
                        <?php else: ?>
                        <td id="st_https<?php echo e($app->id); ?>"><button type="button" data-id="<?php echo e($app->id); ?>" data-setoradmin="<?php echo e(auth()->user()->setor_idsetor); ?>" data-https="1" class="https_btn fas fa-lock-open" style="background: transparent; color: red; border: none;white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="<?php echo e($app->nome_app); ?> SEM certificação HTTPS"></button></td>
                        <?php endif; ?>                       
                        <td>
                            <div class="btn-group">
                                <button type="button" data-id="<?php echo e($app->id); ?>" data-admin="<?php echo e(auth()->user()->admin); ?>" data-setoradmin="<?php echo e(auth()->user()->setor_idsetor); ?>" data-nomeapp="<?php echo e($app->nome_app); ?>" class="edit_app_btn fas fa-edit" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar <?php echo e($app->nome_app); ?>"></button>
                                <button type="button" data-id="<?php echo e($app->id); ?>" data-admin="<?php echo e(auth()->user()->admin); ?>" data-setoradmin="<?php echo e(auth()->user()->setor_idsetor); ?>" data-nomeapp="<?php echo e($app->nome_app); ?>" class="delete_app_btn fas fa-trash" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir <?php echo e($app->nome_app); ?>"></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr id="nadaencontrado">
                        <td class="col-12">Nada Encontrado!</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="d-flex hover justify-content-center bg-<?php echo e($color); ?>">
                <?php echo e($apps->links()); ?>                
            </div>
            <div>
                <button type="button" class="voltar_btn fas fa-arrow-left" style="background: transparent; border: none; white-space: nowrap;" onclick="history.back()" data-html="true" data-placement="right" data-toggle="popover" title="Voltar para BASE(s)"></button>
            </div>    
</div>
<!-- fim index -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
    //inicio escopo geral
    $(document).ready(function(){
    
    //início exclui app
    $(document).on('click','.delete_app_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var link = "<?php echo e(asset('storage')); ?>";
        var admin = $(this).data("admin");
        var id = $(this).data("id");
        var nomeapp = $(this).data("nomeapp");
        if(admin){
        Swal.fire({
            showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomeapp,
                text: "Deseja excluir?",
                imageUrl: link+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){               
                $.ajax({
                    url: '/datacenteradmin/app/delete-app/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'id':id,
                        '_method': 'DELETE',
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){
                            //remove a tr da table html
                            $("#app"+id).remove();
                            $("#success_message").replaceWith('<div id="success_message"></div>');
                            $("#success_message").addClass('alert alert-success');
                            $("#success_message").text(response.message);
                        }
                    } 
                });
            }                                       
        
        });                 
    }else{
        Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nomeapp,
                text: "Você não pode excluir este registro. Procure um administrador do setor INFRA !",
                imageUrl: link+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'OK!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){  
             }
            })
    }       
        
        });
    ///fim delete app
    
    //inicio exibe EditAppModal
    $('#EditAppModal').on('shown.bs.modal',function(){
        $("#nome_app").focus();
    });
    $(document).on('click','.edit_app_btn',function(e){
        e.preventDefault();
        var link = "<?php echo e(asset('storage')); ?>";
        var admin = $(this).data("admin");
        var nome = $(this).data("nomeapp");
        var id = $(this).data("id");
        if(admin){
        $("#editform").trigger('reset');
        $("#EditAppModal").modal('show');    
        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenteradmin/app/edit-app/'+id,
            success: function(response){
                if(response.status==200){ 
                    $("#edit_app_id").val(id);               
                    //seta a base
                    var vnomebase = response.base.nome_base;
                    $("#edit_nome_base").replaceWith('<label id="edit_nome_base" style="font-style: italic;">'+vnomebase+'</label>');
                    var vnomevm = response.vm.nome_vm;
                    $("#edit_nome_vm").replaceWith('<label id="edit_nome_vm" style="font-style: italic;">'+vnomevm+'</label>');
                    var opcaobase = response.base.id;
                    $("#edit_selbase_id option")
                    .removeAttr('selected')
                    .filter('[value='+opcaobase+']')
                    .attr('selected',true);
                    //fim seta a base
                    //seta o orgão
                    var opcaoorgao = response.orgao.id;
                    $("#edit_selorgao_id option")
                    .removeAttr('selected')
                    .filter('[value='+opcaoorgao+']')
                    .attr('selected',true);
                    //fim seta o orgao
                    //seta o projeto
                    var opcaoprojeto = response.projeto.id;
                    $("#edit_selprojeto_id option")
                    .removeAttr('selected')
                    .filter('[value='+opcaoprojeto+']')
                    .attr('selected',true);
                    //fim seta o projeto
                    var vnomeapp = response.app.nome_app;
                    $("#edit_nome_app").val(vnomeapp);
                    var vdominio = response.app.dominio;
                    $("#edit_dominio").val(vdominio);                               
                    if(response.app.https){
                        $("#edit_https").attr('checked',true);                
                    }else{
                        $("#edit_https").attr('checked',false); 
                    }
                }
            }
        });
    }else{
        Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nome,
                text: "Você não pode alterar este registro. Procure um administrador do setor INFRA !",
                imageUrl: link+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'OK!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){  
             }
            })
    
    }
    });
    //fim exibe EditAppModal
      //reconfigura o option selected do select html
      $('select[name="edit_selprojeto_id"]').on('change',function(){
            var opteditproj = this.value;
            $("#edit_selprojeto_id option")
            .removeAttr('selected')
            .filter('[value='+opteditproj+']')
            .attr('selected',true);
        }); 
        $('select[name="edit_selbase_id"]').on('change',function(){
            var opteditbase = this.value;
            $("#edit_selbase_id option")
            .removeAttr('selected')
            .filter('[value='+opteditbase+']')
            .attr('selected',true);
        }); 
        $('select[name="edit_selorgao_id"]').on('change',function(){
            var opteditorgao = this.value;
            $("#edit_selorgao_id option")
            .removeAttr('selected')
            .filter('[value='+opteditorgao+']')
            .attr('selected',true);
        }); 
        $('select[name="add_selprojeto_id"]').on('change',function(){
            var optaddproj = this.value;
            $("#add_selprojeto_id option")
            .removeAttr('selected')
            .filter('[value='+optaddproj+']')
            .attr('selected',true);
        }); 
        $('select[name="add_selbase_id"]').on('change',function(){
            var optaddbase = this.value;
            $("#add_selbase_id option")
            .removeAttr('selected')
            .filter('[value='+optaddbase+']')
            .attr('selected',true);
        }); 
        $('select[name="add_selorgao_id"]').on('change',function(){
            var optaddorgao = this.value;
            $("#add_selorgao_id option")
            .removeAttr('selected')
            .filter('[value='+optaddorgao+']')
            .attr('selected',true);
        }); 
        //fim reconfigura o option selected do select html
        //inicio da atualização do registro
        $(document).on('click','.update_app_btn',function(e){
            e.preventDefault();
            var loading = $("#imgedit");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $("#edit_app_id").val();
            var upd_projeto_id = $("#edit_selprojeto_id").val();
            var upd_orgao_id = $("#edit_selorgao_id").val();
            var upd_base_id = $("#edit_selbase_id").val();
            var edit_https = false;
            var strcolor = $(this).data("color");
            $("input[name='edit_https']:checked").each(function(){
                edit_https = true
            });
            var data = {
                'id':id,
                'orgao_id': upd_orgao_id,
                'projetos_id': upd_projeto_id,
                'bases_id': upd_base_id,
                'nome_app': $(".edit_nome_app").val(),
                'dominio': $(".edit_dominio").val(),
                'https': edit_https,
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            };    
            $.ajax({
                type: 'POST',
                data: data,
                dataType: 'json',
                url: '/datacenteradmin/app/update-app/'+id,
                success:function(response){
                    if(response.status==400){
                        //erros
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                        $("#updateform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#updateform_errList").append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    }else if(response.status==404){
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');  
                        $("#success_message").replaceWith('<div id="success_message"></div>');                      
                        $("#success_message").addClass('alert alert-warning');
                        $("#success_message").text(response.message);
                        loading.hide();
                    }else{
                        //atualizando a tr da table html
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');         
                        $("#success_message").replaceWith('<div id="success_message"></div>');               
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);
                        loading.hide();
                        $("#editform").trigger('reset');
                        $("#EditAppModal").modal('hide');
    
                       
                        var tupla = ""; 
                        var limita1 = "";                    
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";
                        var limita5 = "";
                        var limita6 = "";
                        var limita7 = "";
                        limita1 = '<tr id="app'+response.app.id+'">\
                            <th scope="row">'+response.app.nome_app+'</th>';
                        var bloqueia = true;                        
                        if((response.app.senha)==""){
                        limita2 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita3 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita4 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }                   
                            if(response.app.https){
                               limita5 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-https="0" class="https_btn fas fa-lock" style="background: transparent; color: green; border: none;"></button></td>';
                            }else{
                               limita6 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-https="1" class="https_btn fas fa-lock-open" style="background: transparent; color: red; border: none;"></button></td>';
                            }
                            limita7 = '<td>\
                                <div class="btn-group">\
                                    <button type="button" data-color="'+strcolor+'" data-id="'+response.app.id+'" data-admin="'+response.user.admin+'" data-nomeapp="'+response.app.nome_app+'" class="edit_app_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.app.id+'" data-admin="'+response.user.admin+'" data-nomeapp="'+response.app.nome_app+'" class="delete_app_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';   
                        tupla = limita1+limita2+limita3+limita4+limita5+limita6+limita7;          
                        $("#app"+id).replaceWith(tupla);
                    }
                }
            });            
        });
        //fim da atualização do registro
        //inicio exibição do form AddAppModal
        $('#AddAppModal').on('shown.bs.modal',function(){
            $(".add_nome_app").focus();
        });
        $(document).on('click','.AddApp_btn',function(e){
            e.preventDefault();
            var labelHtml = $(this).data("nome_base");
            var labelHtmlVm = $("#vmnome").val();
            var link = "<?php echo e(asset('storage')); ?>";            
            
            $("#addform").trigger('reset');
            $("#AddAppModal").modal('show');
            $("#add_base_id").val($(this).data("id"));
            $("#add_nome_base").replaceWith('<Label id="add_nome_base" style="font-style:italic;">'+labelHtml+'</Label>');
            $("#add_nome_vm").replaceWith('<Label id="add_nome_vm" style="font-style:italic;">'+labelHtmlVm+'</Label>');
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>'); 
           
        });
        //fim exibição do form AddAppModal
        //inicio do envio novo registro
        $(document).on('click','.add_app_btn',function(e){
            e.preventDefault();
    
            var loading = $("#imgadd");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var ins_projeto_id = $("#add_selprojeto_id").val();
            var ins_orgao_id = $("#add_selorgao_id").val();
            var ins_base_id = $("#add_selbase_id").val();
            var strcolor = $(this).data("color");
            var add_https = false;
            $("input[name='add_https']:checked").each(function(){
                add_https = true
            });
           
            var data = {            
                'orgao_id': ins_orgao_id,
                'projetos_id': ins_projeto_id,
                'bases_id': ins_base_id,
                'nome_app': $(".add_nome_app").val(),
                'dominio': $(".add_dominio").val(),
                'https': add_https,     
                '_method':'PUT',
                '_token': CSRF_TOKEN,       
            };            
    
            $.ajax({
                type: 'POST',
                url: '/datacenteradmin/app/adiciona-app',
                data: data,
                dataType: 'json',
                success:function(response){
                    //erros
                    if(response.status==400){
                        $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
                        $("#saveform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#saveform_errList").append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    }else{
                        $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');     
                        $("#success_message").replaceWith('<div id="success_message"></div>');                   
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);
                        loading.hide();
    
                        $("#addform").trigger('reset');
                        $("#AddAppModal").modal('hide');
    
                        //inserindo a tr na table html                       
                        var tupla = "";
                        var limita0 = "";
                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var limita4 = "";
                        var limita5 = "";
                        var limita6 = "";
                        var limita7 = "";
                       
                        limita0 = '<tr id="novo" style="display:none;"></tr>';
                        limita1 = '<tr id="app'+response.app.id+'">\
                            <th scope="row">'+response.app.nome_app+'</th>';
                        var bloqueia = true;                        
                        if((response.app.senha)==""){
                        limita2 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita3 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita4 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }            
                            if(response.app.https){
                            limita5 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-https="0" class="https_btn fas fa-lock" style="background: transparent; color: green; border: none;"></button></td>';
                             }else{
                            limita6 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-https="1" class="https_btn fas fa-lock-open" style="background: transparent; color: red; border: none;"></button></td>';
                            }
                            limita7 = '<td>\
                                <div class="btn-group">\
                                    <button type="button" data-color="'+strcolor+'" data-id="'+response.app.id+'" data-admin="'+response.user.admin+'" data-nomeapp="'+response.app.nome_app+'" class="edit_app_btn fas fa-edit" style="background: transparent;border: none;"></button>\
                                    <button type="button" data-id="'+response.app.id+'" data-admin="'+response.user.admin+'" data-nomeapp="'+response.app.nome_app+'" class="delete_app_btn fas fa-trash" style="background: transparent;border: none;"></button>\
                                </div>\
                            </td>\
                        </tr>';
                        if(!$("#nadaencontrado").html==""){
                            $("#nadaencontrado").remove();
                        }
                        tupla = limita0+limita1+limita2+limita3+limita4+limita5+limita6+limita7;                           
                        $("#novo").replaceWith(tupla);
                    }
                }
            });        
        });
        //fim do envio novo registro
        //inicio muda o https na lista index
        $(document).on('click','.https_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $(this).data("id");        
            var vhttps = false;
            var link = "<?php echo e(asset('storage')); ?>";

            if($(this).data("https")=="1"){
                vhttps = true;
            }else{
                vhttps = false;
            }
            var data = {
                'https': vhttps,
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }
            $.ajax({
                type:'POST',
                dataType:'json',
                data:data,            
                url:'/datacenteradmin/app/https-app/'+id,
                success:function(response){
                    if(response.status==200){
                        var limita1 = "";
                        var limita2 = "";
                        if(response.app.https){
                            limita1 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-https="0" class="https_btn fas fa-lock" style="background: transparent; color: green; border: none;"></button></td>';
                        }else{
                            limita2 = '<td id="st_https'+response.app.id+'"><button type="button" data-id="'+response.app.id+'" data-setoradmin="'+response.user.setor_idsetor+'" data-https="1" class="https_btn fas fa-lock-open" style="background: transparent; color: red; border: none;"></button></td>';
                        }
                        var celula = limita1+limita2;
                        $("#st_https"+id).replaceWith(celula);
                    }
                }
            });
            
        });
        //fim muda o https na lista index

        //cadastro de senha
        $('#AddSenhaApp').on('shown.bs.modal',function(){
            $(".add_senha").focus();
        });


        $(document).on('click','.cadsenha_btn',function(e){
            e.preventDefault();
            var link = "<?php echo e(asset('storage')); ?>";            
            var labelHtml = $(this).data("nomeapp");
            var labelDominio = $(this).data("dominio");
            
            $("#addformsenha").trigger('reset');
            $("#AddSenhaApp").modal('show');
            $("#add_appsenha_id").val($(this).data("id"));
            $("#nomeapp").replaceWith('<Label id="nomeapp" style="font-style:italic;">'+labelHtml+'</Label>');            
            $("#dominioapp").replaceWith('<Label id="dominioapp" style="font-style:italic;">'+labelDominio+'</Label>');            
            $("#saveformsenha_errList").replaceWith('<ul id="saveformsenha_errList"></ul>'); 
           
        });

         $(document).on('click','.add_senhaapp_btn',function(e){
            e.preventDefault();
            var loading = $("#imgaddsenha");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $("#add_appsenha_id").val();
            var val_indefinida = 0;
            $("input[name='add_val_indefinida']:checked").each(function(){
                val_indefinida = 1;
            });         

            //array apenas com os checkboxes marcados
            var users = new Array;
            $("input[name='users[]']:checked").each(function(){
                users.push($(this).val());
            });            
            
            var data = {
                'senha':$(".add_senha").val(),
                'validade':formatDate($(".add_validade").val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenteradmin/app/storesenhaapp/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $("#saveformsenha_errList").replaceWith("");
                            $("#saveformsenha_errList").addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $("#saveformsenha_errList").append('<li>'+err_values+'</li>');
                            });
                            loading.hide();
                }else{
                        $("#saveformsenha_errList").replaceWith('<ul id="saveformsenha_errList"></ul>');     
                        $("#success_message").replaceWith('<div id="success_message"></div>');              
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);                                        
                        loading.hide();
    
                        $("#addformsenha").trigger('reset');                    
                        $("#AddSenhaApp").modal('hide');

                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var bloqueia = true;                        
                        if((response.app.senha)==""){
                        limita1 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita2 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita3 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }                       

                        var elemento = limita1+limita2+limita3;
                        $("#botaosenha"+id).replaceWith(elemento);

                } 
                }   
            });
    }); 
        //fim cadastro de senha
    ////inicio alteração de senha
    $('#EditSenhaApp').on('shown.bs.modal',function(){
        $("#edit_senha").focus();
    });
    $(document).on('click','.senhabloqueada_btn',function(e){
        e.preventDefault();

        var opcaosenha = $(this).data("opt");
        var link = "<?php echo e(asset('storage')); ?>";        

        if(opcaosenha){
    
        var id = $(this).data("id");
        var labelHtml = $(this).data("nomeapp");
        var labelDominio = $(this).data("dominio");
        $("#editformsenha").trigger('reset');
        $("#EditSenhaApp").modal('show');  
        $("#editnomeapp").replaceWith('<Label id="editnomeapp" style="font-style:italic;">'+labelHtml+'</Label>');            
        $("#editdominioapp").replaceWith('<Label id="editdominioapp" style="font-style:italic;">'+labelDominio+'</Label>');     
        $("#edit_appsenha_id").val(id);  
        $("#updateformsenha_errList").replaceWith('<ul id="updateformsenha_errList"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenteradmin/app/editsenhaapp/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.app.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.app.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.app.validade);
                    datavalidade = datavalidade.toLocaleDateString("pt-BR");
                     if(datavalidade=="31/12/1969 21:00:00"){
                        datavalidade = "";
                        }  
                    var criador = response.criador;
                        if(!response.criador){
                            criador = "";
                        }
                    var alterador = response.alterador;
                        if(!response.alterador){
                            alterador = "";
                        }                  
                    if(new Date(response.app.validade)<new Date()){
                    $("#senhavencida").replaceWith('<small id="senhavencida" style="color: red">Senha vencida!</small>');
                    }else{
                    $("#senhavencida").replaceWith('<small id="senhavencida" style="color: green">Senha na validade. OK!</small>');  
                    } 
                    $("#edit_validade").val(datavalidade);
                    $("#editdatacriacao").replaceWith('<label  id="editdatacriacao">'+datacriacao+'</label>');
                    $("#editdatamodificacao").replaceWith('<label  id="editdatamodificacao">'+dataatualizacao+'</label>');
                    $("#editcriador").replaceWith('<label  id="editcriador">'+criador+'</label>');
                    $("#editmodificador").replaceWith('<label  id="editmodificador">'+alterador+'</label>');                         
                    $("#edit_senha").val(response.senha);
                    if(response.app.val_indefinida){
                      $("input[name='edit_val_indefinida']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinida']").attr('checked',false);  
                    }

                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados ao artigo
                        $.each(response.users,function(key,values){                                                        
                                $("#check"+values.id).attr('checked',true);  //faz a marcação seletiva                         
                        });
                }
            }
        });

    }else{
        Swal.fire({
             showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:"Você não tem acesso a esta informação!",
                text: "Peça sua inclusão a um dos usuários sugeridos na dica!",
                imageUrl: link+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'Ok!',                
                cancelButtonText: 'Não necessito, obrigado!',
            });      
    }

             
    });
    //fim exibe EditAppModal
    ///inicio alterar senha
    $(document).on('click','.update_senhaapp_btn',function(e){
            e.preventDefault();
            var loading = $("#imgeditsenha");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $("#edit_appsenha_id").val();
            var val_indefinida = 0;
            $("input[name='edit_val_indefinida']:checked").each(function(){
                val_indefinida = 1;
            });         

            //array apenas com os checkboxes marcados
            var users = new Array;
            $("input[name='users[]']:checked").each(function(){
                users.push($(this).val());
            });            
            
            var data = {
                'senha':$(".senha").val(),
                'validade':formatDate($(".validade").val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenteradmin/app/updatesenhaapp/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $("#updateformsenha_errList").replaceWith('<ul id="updateformsenha_errList"></ul>');
                            $("#updateformsenha_errList").addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $("#updateformsenha_errList").append('<li>'+err_values+'</li>');
                            });
                            loading.hide();
                }else{
                        $("#updateformsenha_errList").replaceWith('<ul id="updateformsenha_errList"></ul>');     
                        $("#success_message").replaceWith('<div id="success_message"></div>');              
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);                                        
                        loading.hide();
    
                        $("#editformsenha").trigger('reset');                    
                        $("#EditSenhaApp").modal('hide');

                        var limita1 = "";
                        var limita2 = "";
                        var limita3 = "";
                        var bloqueia = true;                        
                        if((response.app.senha)==""){
                        limita1 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" class="cadsenha_btn fas fa-folder" style="background: transparent; color: orange; border: none;"></button>';
                        }else{
                            $.each(response.users,function(key,user_values){
                                if(user_values.id == response.user.id){                                    
                                    limita2 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" data-opt="1" class="senhabloqueada_btn fas fa-lock-open" style="background: transparent; color: green; border: none;"></button>';
                                    bloqueia = false;                              
                                }
                            });                            
                            if(bloqueia){
                            limita3 = '<button id="botaosenha'+response.app.id+'" type="button" data-id="'+response.app.id+'" data-nomeapp="'+response.app.nome_app+'" data-dominio="'+response.app.dominio+'" data-opt="0" class="senhabloqueada_btn fas fa-lock" style="background: transparent; color: red; border: none;"></button>';
                            }
                        }                       

                        var elemento = limita1+limita2+limita3;
                        $("#botaosenha"+id).replaceWith(elemento);

                } 
                }   
            });
    });         

    ////fim alteração de senha

    //formatação str para date
    function formatDate(data, formato) {
        if (formato == 'pt-br') {
            return (data.substr(0, 10).split('-').reverse().join('/'));
        } else {
            return (data.substr(0, 10).split('/').reverse().join('-'));
        }
        }
        //fim formatDate

        ///tooltip
    $(function(){      
        $(".senhabloqueada_btn").tooltip();       
        $(".cadsenha_btn").tooltip();        
        $(".https_btn").tooltip();
        $(".AddApp_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_app_btn").tooltip();
        $(".edit_app_btn").tooltip();
        $(".voltar_btn").tooltip();
    });
    ///fim tooltip

    });
    //fim escopo geral

    
    
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/datacenter/app/index.blade.php ENDPATH**/ ?>