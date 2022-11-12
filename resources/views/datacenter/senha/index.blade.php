@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
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
                @if(auth()->user()->avatar)  
                <img src="{{asset('storage/'.auth()->user()->avatar)}}" class="rounded-circle" width="100" >
                @else
                <img src="{{asset('storage/user.png')}}" class="rounded-circle" width="100" >
                @endif
                </div>
                <div class="ml-3 w-100">                    
                   <h4 class="mb-0 mt-0"><b>{{auth()->user()->name}}</b></h4>
                   @if($totaluserapps || $totaluserhosts || $totaluservms || $totaluserbases || $totaluservlans)
                   <span>Minhas senhas</span>
                   <div class="container-fluid p-2 mt-2 bg-light d-flex rounded text-white stats halfOpacity">
                    <div class="row">
                    @if($totaluserapps)
                     <div class="p-2 mt-2">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                APP(s) <span class="badge badge-light">{{$totaluserapps}}</span><span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_app{{auth()->user()->id}}">
                                    @foreach($userapps as $u_app)                                                                                                            
                                    <li class="dropdown-item"><a href="#" class="dropdown-item userapp_item" data-id="{{$u_app->id}}" data-nomeapp="{{$u_app->nome_app}}" 
                                      data-dominio="{{$u_app->dominio}}">{{$u_app->nome_app}}</a></li>
                                    @endforeach
                                </ul>                                                                                                  
                    </div>
                    @endif                
                    @if($totaluserhosts)
                    <div class="p-2 mt-2">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                HOST(s) <span class="badge badge-light">{{$totaluserhosts}}</span><span class="caret"></span>
                                </button>                               
                                <ul class="dropdown-menu" id="dropdown_host{{auth()->user()->id}}">
                                    @foreach($userhosts as $u_host)                                                                                                            
                                    <li class="dropdown-item"><a href="#" class="dropdown-item userhost_item" data-id="{{$u_host->id}}" data-nomehost="{{$u_host->datacenter}}" data-clusterip="{{$u_host->cluster}}/{{$u_host->ip}}">{{$u_host->datacenter}}</a></li>
                                    @endforeach
                                </ul>                                                                                             
                    </div>
                    @endif  
                    @if($totaluservms)
                    <div class="p-2 mt-2">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                VM(s) <span class="badge badge-light">{{$totaluservms}}</span><span class="caret"></span>
                                </button>                               
                                <ul class="dropdown-menu" id="dropdown_vm{{auth()->user()->id}}">
                                    @foreach($uservms as $u_vm)                                                                                                            
                                    <li class="dropdown-item"><a href="#" class="dropdown-item uservm_item" data-id="{{$u_vm->id}}" data-nomevm="{{$u_vm->nome_vm}}" data-clusterip="{{$u_vm->cluster}}/{{$u_vm->ip}}">{{$u_vm->nome_vm}}</a></li>
                                    @endforeach
                                </ul>                                                                             
                    </div>
                    @endif              
                    @if($totaluserbases)
                    <div class="p-2 mt-2">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                BASE(s) <span class="badge badge-light">{{$totaluserbases}}</span><span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_base{{auth()->user()->id}}">
                                    @foreach($userbases as $u_base)                                                                                                            
                                    <li class="dropdown-item"><a href="#" class="dropdown-item userbase_item" data-id="{{$u_base->id}}" data-nomebase="{{$u_base->nome_base}}" data-ip="{{$u_base->ip}}">{{$u_base->nome_base}}</a></li>
                                    @endforeach
                                </ul>                                                                   
                    </div>
                    @endif  
                    @if($totaluservlans)
                    <div class="p-2 mt-2">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                VLAN(s) <span class="badge badge-light">{{$totaluservlans}}</span><span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_vlan{{auth()->user()->id}}">
                                    @foreach($uservlans as $u_vlan)                                                                                                            
                                    <li class="dropdown-item"><a href="#" class="dropdown-item uservlan_item" data-id="{{$u_vlan->id}}" data-nomevlan="{{$u_vlan->nome_vlan}}">{{$u_vlan->nome_vlan}}</a></li>
                                    @endforeach
                                </ul>                                             
                    </div>                        
                    @endif                   
                   </div>
                   </div>
                   @endif
                  </div>                    
                </div>              
            </div>         
<div class="container-fluid">
 <div class="row">
  @if($totalgeral)
  @if($totalapps)
  <div class="p-2 mt-2">
    <div class="card" style="width: 10rem;">
      <div class="card-header">
        <b><i class="fas fa-desktop" style="background: transparent; color: red; border: none;"></i> Alerta APPs!</b>
      </div>
      <div class="card-body">                
        <p class="card-text">Senhas vencidas por APP.</p>        
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                APP(s) <span class="badge badge-light">{{$totalapps}}</span><span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_app{{auth()->user()->id}}">
                                    @foreach($apps as $app)                                         
                                        @foreach($app->users as $user)
                                            @if(($user->id) == (auth()->user()->id))                                  
                                            <li class="dropdown-item"><a href="#" class="dropdown-item senhabloqueadaapp_btn" data-id="{{$app->id}}" data-nomeapp="{{$app->nome_app}}" 
                                                data-dominio="{{$app->dominio}}" data-opt="1" style="white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="{{$app->users->implode('name','<br>')}}"><i class="fas fa-lock-open" style="background: transparent; color: green; border: none;"></i> {{$app->nome_app}}</a></li>                                                                              @break
                                            @elseif ($loop->last)                                  
                                            <li class="dropdown-item"><a href="#" class="dropdown-item senhabloqueadaapp_btn" data-id="{{$app->id}}" data-nomeapp="{{$app->nome_app}}" 
                                                data-dominio="{{$app->dominio}}" data-opt="0" style="white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="{{$app->users->implode('name','<br>')}}"><i class="fas fa-lock" style="background: transparent; color: red; border: none;"></i> {{$app->nome_app}}</a></li>
                                            @endif               
                                        @endforeach                                         
                                    @endforeach                                            
                                </ul>  
      </div>
    </div>
  </div>
  @endif
  @if($totalbases)
  <div class="p-2 mt-2">
    <div class="card" style="width: 10rem;">
        <div class="card-header">
        <b><i class="fas fa-database" style="background: transparent; color: red; border: none;"></i> Alerta BASEs!</b>
      </div>
      <div class="card-body">        
        <p class="card-text">Senha vencidas por BASE.</p>        
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                BASE(s) <span class="badge badge-light">{{$totalbases}}</span><span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_base{{auth()->user()->id}}">
                                    @foreach($bases as $base)                                         
                                        @foreach($base->users as $user)
                                            @if(($user->id) == (auth()->user()->id))                                  
                                            <li class="dropdown-item"><a href="#" class="dropdown-item senhabloqueadabase_btn" data-id="{{$base->id}}" data-nomebase="{{$base->nome_base}}" data-ip="{{$base->ip}}" data-opt="1" class="fas fa-lock-open" style="white-space: nowrap;" 
                                                data-html="true" data-placement="left" data-toggle="popover" title="{{$base->users->implode('name','<br>')}}"><i class="fas fa-lock-open" style="background: transparent; color: green; border: none;"></i> {{$base->nome_base}}</a></li>
                                                @break
                                            @elseif ($loop->last)                                  
                                            <li class="dropdown-item"><a href="#" class="dropdown-item senhabloqueadabase_btn" data-id="{{$base->id}}" data-nomebase="{{$base->nome_base}}" data-ip="{{$base->ip}}" data-opt="0" class="fas fa-lock-open" style="white-space: nowrap;" 
                                                data-html="true" data-placement="left" data-toggle="popover" title="{{$base->users->implode('name','<br>')}}"><i class="fas fa-lock" style="background: transparent; color: red; border: none;"></i> {{$base->nome_base}}</a></li>
                                            @endif               
                                        @endforeach                                         
                                    @endforeach                                            
                                </ul>  
      </div>
    </div>
  </div>
  @endif
  @if($totalvirtualmachines)
  <div class="p-2 mt-2">
    <div class="card" style="width: 10rem;">
        <div class="card-header">
        <b><i class="fas fa-network-wired" style="background: transparent; color: red; border: none;"></i> Alerta VMs!</b>
      </div>
      <div class="card-body">        
        <p class="card-text">Senhas vencidas por VM.</p>        
         <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                VM(s) <span class="badge badge-light">{{$totalvirtualmachines}}</span><span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_vm{{auth()->user()->id}}">
                                    @foreach($virtualmachines as $vm)                                         
                                        @foreach($vm->users as $user)
                                            @if(($user->id) == (auth()->user()->id))                                  
                                            <li class="dropdown-item"><a href="#" class="dropdown-item senhabloqueadavm_btn" data-id="{{$vm->id}}" data-nomevm="{{$vm->nome_vm}}" data-clusterip="{{$vm->cluster}}/{{$vm->ip}}" data-opt="1" class="fas fa-lock-open" style="white-space: nowrap;" 
                                                data-html="true" data-placement="left" data-toggle="popover" title="{{$vm->users->implode('name','<br>')}}"><i class="fas fa-lock-open" style="background: transparent; color: green; border: none;"></i> {{$vm->nome_vm}}</a></li>
                                                @break
                                            @elseif ($loop->last)                                  
                                            <li class="dropdown-item"><a href="#" class="dropdown-item senhabloqueadavm_btn" data-id="{{$vm->id}}" data-nomevm="{{$vm->nome_vm}}" data-clusterip="{{$vm->cluster}}/{{$vm->ip}}" data-opt="0" class="fas fa-lock-open" style="white-space: nowrap;" 
                                                data-html="true" data-placement="left" data-toggle="popover" title="{{$vm->users->implode('name','<br>')}}"><i class="fas fa-lock" style="background: transparent; color: red; border: none;"></i> {{$vm->nome_vm}}</a></li>
                                            @endif               
                                        @endforeach                                         
                                    @endforeach                                            
                                </ul>        
      </div>
    </div>
  </div>
  @endif
  @if($totalhosts)
  <div class="p-2 mt-2">
    <div class="card" style="width: 10rem;">
        <div class="card-header">
        <b><i class="fas fa-server" style="background: transparent; color: red; border: none;"></i> Alerta HOSTs!</b>
      </div>
      <div class="card-body">        
        <p class="card-text">Senhas vencidas por HOST.</p>        
         <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                HOST(s) <span class="badge badge-light">{{$totalhosts}}</span><span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_host{{auth()->user()->id}}">
                                    @foreach($hosts as $host)                                         
                                        @foreach($host->users as $user)
                                            @if(($user->id) == (auth()->user()->id))                                  
                                            <li class="dropdown-item"><a href="#" class="dropdown-item senhabloqueadahost_btn" data-id="{{$host->id}}" data-nomehost="{{$host->datacenter}}" data-clusterip="{{$host->cluster}}/{{$host->ip}}" data-opt="1" class="fas fa-lock-open" style="white-space: nowrap;" 
                                                data-html="true" data-placement="left" data-toggle="popover" title="{{$host->users->implode('name','<br>')}}"><i class="fas fa-lock-open" style="background: transparent; color: green; border: none;"></i> {{$host->datacenter}}</a></li>
                                                @break
                                            @elseif ($loop->last)                                  
                                            <li class="dropdown-item"><a href="#" class="dropdown-item senhabloqueadahost_btn" data-id="{{$host->id}}" data-nomehost="{{$host->datacenter}}" data-clusterip="{{$host->cluster}}/{{$host->ip}}" data-opt="0" class="fas fa-lock-open" style="white-space: nowrap;" 
                                                data-html="true" data-placement="left" data-toggle="popover" title="{{$host->users->implode('name','<br>')}}"><i class="fas fa-lock" style="background: transparent; color: red; border: none;"></i> {{$host->datacenter}}</a></li>
                                            @endif               
                                        @endforeach                                         
                                    @endforeach                                            
                                </ul>        
      </div>
    </div>
  </div>
  @endif
  @if($totalvlans)
  <div class="p-2 mt-2">
    <div class="card" style="width: 10rem;">
        <div class="card-header">
        <b><i class="fas fa-network-wired" style="background: transparent; color: red; border: none;"></i> Alerta VLANs!</b>
      </div>
      <div class="card-body">        
        <p class="card-text">Senhas vencidas por VLAN.</p>        
       <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                VLAN(s) <span class="badge badge-light">{{$totalvlans}}</span><span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_vlan{{auth()->user()->id}}">
                                    @foreach($vlans as $vlan)                                         
                                        @foreach($vlan->users as $user)
                                            @if(($user->id) == (auth()->user()->id))                                  
                                            <li class="dropdown-item"><a href="#" class="dropdown-item senhabloqueadavlan_btn" data-id="{{$vlan->id}}" data-nomevlan="{{$vlan->nome_vlan}}" data-opt="1" class="fas fa-lock-open" style="white-space: nowrap;" 
                                                data-html="true" data-placement="left" data-toggle="popover" title="{{$vlan->users->implode('name','<br>')}}"><i class="fas fa-lock-open" style="background: transparent; color: green; border: none;"></i> {{$vlan->nome_vlan}}</a></li>
                                                @break
                                            @elseif ($loop->last)                                  
                                            <li class="dropdown-item"><a href="#" class="dropdown-item senhabloqueadavlan_btn" data-id="{{$vlan->id}}" data-nomevlan="{{$vlan->nome_vlan}}" data-opt="0" class="fas fa-lock" style="white-space: nowrap;" 
                                                data-html="true" data-placement="left" data-toggle="popover" title="{{$vlan->users->implode('name','<br>')}}"><i class="fas fa-lock" style="background: transparent; color: red; border: none;"></i> {{$vlan->nome_vlan}}</a></li>
                                            @endif               
                                        @endforeach                                         
                                    @endforeach                                            
                                </ul>                     
      </div>
    </div>
  </div>
  @endif

  @else
  <div class="p-2 mt-2">
<div class="card" style="width: 18rem;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="{{asset('logoprodap.jpg')}}" class="card-img" alt="prodap">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title"><b>{{auth()->user()->name}}</b>,</h5>
        <p class="card-text">Todas as senhas estão em dia.</p>
        <p class="card-text"><small class="text-muted">Obrigado.</small></p>
      </div>
    </div>
  </div>
</div>
</div>
@endif
</div>
</div>
</div>

<!--inicio edit senha app usu -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSenhaApp" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">APP - Editar e atualizar Senha</h5>
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
                    <div class="form-group mb-3">
                        <label for="">Senha</label>
                        <input type="text" id="edit_senha" class="senha form-control">
                        <label><small id="senhavencida" style="color: red">Senha vencida!</small></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Validade</label>
                        <input type="text" id="edit_validade" class="validade form-control" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">                        
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="edit_val_indefinida"> 
                        <input type="checkbox" class="val_indefinida form-check-input" name="edit_val_indefinida" id="edit_val_indefinida"> Validade indeterminada
                        </label>
                    </div>                
                    </fieldset>    
                    </div>
                    </div>
                     <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Quem tem acesso a esta informação?</legend>
                                <div class="form-check">
                                    @foreach ($users as $user)
                                    <label class="form-check-label" for="check{{$user->id}}">
                                        <input type="checkbox" id="checkapp{{$user->id}}" name="users[]" value="{{$user->id}}" class="form-check-input"> {{$user->name}}
                                    </label><br>
                                    @endforeach
                                </div>
                            </fieldset>   
                     </div>
                     </div>                  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_senhaapp_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--fim edit senha app usu -->

<!-- início EditSenhaHost usu -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSenhaHost" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">HOST - Editar e atualizar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editformsenhahost" name="editformsenhahost" class="form-horizontal" role="form">
                    <input type="hidden" id="edit_hostsenha_id">
                    <ul id="updateformsenha_errListhost"></ul>  
                    <div class="card">
                    <div class="card-body"> 
                    <fieldset>
                    <legend>Dados da Senha</legend>                 
                    <div class="form-group mb-3">
                        <label  for="">Nome HOST:</label>
                        <label  id="editnomehost"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Cluster/IP:</label>
                        <label  id="editclusteriphost"></label>
                    </div>
                     <div class="form-group mb-3">
                        <label  for="">Criação:</label>
                        <label  id="editdatacriacaohost"></label><br>
                        <label  for="">Modificação:</label>
                        <label  id="editdatamodificacaohost"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Criador:</label>
                        <label  id="editcriadorhost"></label><br>
                        <label  for="">Modificador:</label>
                        <label  id="editmodificadorhost"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Senha</label>
                        <input type="text" id="edit_senhahost" class="senhahost form-control">
                        <label for=""><small id="senhavencidahost" style="color: red">Senha vencida!</small></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Validade</label>
                        <input type="text" id="edit_validadehost" class="validadehost form-control" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="edit_val_indefinida"> 
                        <input type="checkbox" class="val_indefinidahost form-check-input" name="edit_val_indefinidahost" id="edit_val_indefinidahost"> Validade indeterminada
                        </label>
                    </div>                
                    </fieldset>    
                    </div>
                    </div>
                     <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Quem tem acesso a esta informação?</legend>
                                <div class="form-check">
                                    @foreach ($users as $user)
                                    <label class="form-check-label" for="check{{$user->id}}">
                                        <input type="checkbox" id="checkhost{{$user->id}}" name="users[]" value="{{$user->id}}" class="form-check-input"> {{$user->name}}
                                    </label><br>
                                    @endforeach
                                </div>
                            </fieldset>   
                     </div>
                     </div>                  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_senhahost_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim EditSenhahost usu -->

<!-- início EditSenhaVM usu -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSenhaVM" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">VM - Editar e atualizar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editformsenhavm" name="editformsenhavm" class="form-horizontal" role="form">
                    <input type="hidden" id="edit_VMsenha_id">
                    <ul id="updateformsenha_errListvm"></ul>  
                    <div class="card">
                    <div class="card-body"> 
                    <fieldset>
                    <legend>Dados da Senha</legend>                 
                    <div class="form-group mb-3">
                        <label  for="">Nome VM:</label>
                        <label  id="editnomeVM"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Cluster/IP:</label>
                        <label  id="editclusteripvm"></label>
                    </div>
                     <div class="form-group mb-3">
                        <label  for="">Criação:</label>
                        <label  id="editdatacriacaovm"></label><br>
                        <label  for="">Modificação:</label>
                        <label  id="editdatamodificacaovm"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Criador:</label>
                        <label  id="editcriadorvm"></label><br>
                        <label  for="">Modificador:</label>
                        <label  id="editmodificadorvm"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Senha</label>
                        <input type="text" id="edit_senhavm" class="senhavm form-control">
                        <label for=""><small id="senhavencidavm" style="color: red">Senha vencida!</small></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Validade</label>
                        <input type="text" id="edit_validadevm" class="validadevm form-control" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="edit_val_indefinida"> 
                        <input type="checkbox" class="val_indefinidavm form-check-input" name="edit_val_indefinidavm" id="edit_val_indefinidavm"> Validade indeterminada
                        </label>
                    </div>                
                    </fieldset>    
                    </div>
                    </div>
                     <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Quem tem acesso a esta informação?</legend>
                                <div class="form-check">
                                    @foreach ($users as $user)
                                    <label class="form-check-label" for="check{{$user->id}}">
                                        <input type="checkbox" id="checkvm{{$user->id}}" name="users[]" value="{{$user->id}}" class="form-check-input"> {{$user->name}}
                                    </label><br>
                                    @endforeach
                                </div>
                            </fieldset>   
                     </div>
                     </div>                  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_senhaVM_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim EditSenhaVM usu -->

<!-- início EditSenhaBase usu-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSenhaBase" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">BASE - Editar e atualizar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editformsenhabase" name="editformsenhabase" class="form-horizontal" role="form">
                    <input type="hidden" id="edit_basesenha_id">
                    <ul id="updateformsenha_errListbase"></ul>  
                    <div class="card">
                    <div class="card-body"> 
                    <fieldset>
                    <legend>Dados da Senha</legend>                 
                    <div class="form-group mb-3">
                        <label  for="">Nome Base:</label>
                        <label  id="editnomebase"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">IP Base:</label>
                        <label  id="editipbase"></label>
                    </div>                    
                     <div class="form-group mb-3">
                        <label  for="">Criação:</label>
                        <label  id="editdatacriacaobase"></label><br>
                        <label  for="">Modificação:</label>
                        <label  id="editdatamodificacaobase"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Criador:</label>
                        <label  id="editcriadorbase"></label><br>
                        <label  for="">Modificador:</label>
                        <label  id="editmodificadorbase"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Senha</label>
                        <input type="text" id="edit_senhabase" class="senhabase form-control">
                        <label for=""><small id="senhavencidabase" style="color: red">Senha vencida!</small></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Validade</label>
                        <input type="text" id="edit_validadebase" class="validadebase form-control" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="edit_val_indefinidabase"> 
                        <input type="checkbox" class="val_indefinidabase form-check-input" name="edit_val_indefinidabase" id="edit_val_indefinidabase"> Validade indeterminada
                        </label>
                    </div>                
                    </fieldset>    
                    </div>
                    </div>
                     <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Quem tem acesso a esta informação?</legend>
                                <div class="form-check">
                                    @foreach ($users as $user)
                                    <label class="form-check-label" for="check{{$user->id}}">
                                        <input type="checkbox" id="checkbase{{$user->id}}" name="users[]" value="{{$user->id}}" class="form-check-input"> {{$user->name}}
                                    </label><br>
                                    @endforeach
                                </div>
                            </fieldset>   
                     </div>
                     </div>                  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_senhabase_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim EditSenhaBase usu-->

<!-- início EditSenhaVLAN usu-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="EditSenhaVLAN" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">VLAN - Editar e atualizar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="editformsenhavlan" name="editformsenhavlan" class="form-horizontal" role="form">
                    <input type="hidden" id="edit_vlansenha_id">
                    <ul id="updateformsenha_errListvlan"></ul>  
                    <div class="card">
                    <div class="card-body"> 
                    <fieldset>
                    <legend>Dados da Senha</legend>                 
                    <div class="form-group mb-3">
                        <label  for="">Nome da VLAN:</label>
                        <label  id="editnomevlan"></label>
                    </div>                    
                     <div class="form-group mb-3">
                        <label  for="">Criação:</label>
                        <label  id="editdatacriacaovlan"></label><br>
                        <label  for="">Modificação:</label>
                        <label  id="editdatamodificacaovlan"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label  for="">Criador:</label>
                        <label  id="editcriadorvlan"></label><br>
                        <label  for="">Modificador:</label>
                        <label  id="editmodificadorvlan"></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Senha</label>
                        <input type="text" id="edit_senhavlan" class="senhavlan form-control">
                        <label for=""><small id="senhavencidavlan" style="color: red">Senha vencida!</small></label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Validade</label>
                        <input type="text" id="edit_validadevlan" class="validadevlan form-control" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="edit_val_indefinidavlan"> 
                        <input type="checkbox" class="val_indefinidavlan form-check-input" name="edit_val_indefinidavlan" id="edit_val_indefinidavlan"> Validade indeterminada
                        </label>
                    </div>                
                    </fieldset>    
                    </div>
                    </div>
                     <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Quem tem acesso a esta informação?</legend>
                                <div class="form-check">
                                    @foreach ($users as $user)
                                    <label class="form-check-label" for="check{{$user->id}}">
                                        <input type="checkbox" id="checkvlan{{$user->id}}" name="users[]" value="{{$user->id}}" class="form-check-input"> {{$user->name}}
                                    </label><br>
                                    @endforeach
                                </div>
                            </fieldset>   
                     </div>
                     </div>                  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_senhavlan_btn">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim EditSenhaVLAN usu-->

@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){ //início do bloco principal

////inicio alteração de senha
    $('#EditSenhaApp').on('shown.bs.modal',function(){
        $('#edit_senha').focus();
    });
    $(document).on('click','.userapp_item',function(e){
        e.preventDefault();      
    
        var id = $(this).data("id");
        var labelHtml = ($(this).data("nomeapp")).trim();            
        var labelDominio = ($(this).data("dominio")).trim(); 
        $('#editformsenha').trigger('reset');
        $('#EditSenhaApp').modal('show');  
        $('#editnomeapp').html('<Label id="editnomeapp" style="font-style:italic;">'+labelHtml+'</Label>');            
        $('#editdominioapp').html('<Label id="editdominioapp" style="font-style:italic;">'+labelDominio+'</Label>');     
        $('#edit_appsenha_id').val(id);  
        $('#updateformsenha_errList').html('<ul id="updateformsenha_errList"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editusersenhaapp/'+id,
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
                    $('#senhavencida').html('<small id="senhavencida" style="color: red">Senha vencida!</small>');
                    }else{
                    $('#senhavencida').html('<small id="senhavencida" style="color: green">Senha na validade. OK!</small>');  
                    } 
                    $('#edit_validade').val(datavalidade);
                    $('#editdatacriacao').html('<label  id="editdatacriacao">'+datacriacao+'</label>');
                    $('#editdatamodificacao').html('<label  id="editdatamodificacao">'+dataatualizacao+'</label>');
                    $('#editcriador').html('<label  id="editcriador">'+criador+'</label>');
                    $('#editmodificador').html('<label  id="editmodificador">'+alterador+'</label>');                         
                    $('#edit_senha').val(response.senha);
                    if(response.app.val_indefinida){
                      $("input[name='edit_val_indefinida']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinida']").attr('checked',false);  
                    }

                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados ao artigo
                        $.each(response.users,function(key,values){                                                        
                                $("#checkapp"+values.id).attr('checked',true);  //faz a marcação seletiva                         
                        });
                }
            }
        });
  
             
    });
    //fim exibe EditAppModal
    ///inicio alterar senha
    $(document).on('click','.update_senhaapp_btn',function(e){
            e.preventDefault();
            $(this).text('Salvando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $('#edit_appsenha_id').val();
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
                'senha':$('.senha').val(),
                'validade':formatDate($('.validade').val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/updateusersenhaapp/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $('#updateformsenha_errList').html("");
                            $('#updateformsenha_errList').addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $('#updateformsenha_errList').append('<li>'+err_values+'</li>');
                            });
          
                }else{
                        $('#updateformsenha_errList').html('<ul id="updateformsenha_errList"></ul>');     
                        $('#editformsenha').trigger('reset');                    
                        $('#EditSenhaApp').modal('hide');
                                               
                        location.reload();
                } 
                }   
            });
    });         

    ////fim alteração de senha APP

   ////inicio alteração de senha USER HOST
    $('#EditSenhaHost').on('shown.bs.modal',function(){
        $('#edit_senhahost').focus();
    });
    $(document).on('click','.userhost_item',function(e){
        e.preventDefault();
        
        var id = $(this).data("id");
        var labelHtml = ($(this).data("nomehost")).trim();            
        var labelclusterip = ($(this).data("clusterip")).trim(); 
        $('#editformsenhahost').trigger('reset');
        $('#EditSenhaHost').modal('show');  
        $('#editnomehost').html('<Label id="editnomehost" style="font-style:italic;">'+labelHtml+'</Label>');            
        $('#editclusteriphost').html('<Label id="editclusteriphost" style="font-style:italic;">'+labelclusterip+'</Label>');     
        $('#edit_hostsenha_id').val(id);  
        $('#updateformsenha_errListhost').html('<ul id="updateformsenha_errListhost"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editusersenhahost/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.host.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.host.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.host.validade);
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
                    if(new Date(response.host.validade)<new Date()){
                    $('#senhavencidahost').html('<small id="senhavencidahost" style="color: red">Senha vencida!</small>');
                    }else{
                    $('#senhavencidahost').html('<small id="senhavencidahost" style="color: green">Senha na validade. OK!</small>');  
                    }                
                    $('#edit_validadehost').val(datavalidade);
                    $('#editdatacriacaohost').html('<label  id="editdatacriacaohost">'+datacriacao+'</label>');
                    $('#editdatamodificacaohost').html('<label  id="editdatamodificacaohost">'+dataatualizacao+'</label>');
                    $('#editcriadorhost').html('<label  id="editcriadorhost">'+criador+'</label>');
                    $('#editmodificadorhost').html('<label  id="editmodificadorhost">'+alterador+'</label>');                         
                    $('#edit_senhahost').val(response.senha);
                    if(response.host.val_indefinida){
                      $("input[name='edit_val_indefinidahost']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinidahost']").attr('checked',false);  
                    }

                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados ao artigo
                        $.each(response.users,function(key,values){                                                        
                                $("#checkhost"+values.id).attr('checked',true);  //faz a marcação seletiva                         
                        });
                }
            }
        });
    
             
    });
    //fim exibe 
    ///inicio alterar senha HOST
    $(document).on('click','.update_senhahost_btn',function(e){
            e.preventDefault();
            $(this).text('Salvando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $('#edit_hostsenha_id').val();
            var val_indefinida = 0;
            $("input[name='edit_val_indefinidahost']:checked").each(function(){
                val_indefinida = 1;
            });         

            //array apenas com os checkboxes marcados
            var users = new Array;
            $("input[name='users[]']:checked").each(function(){
                users.push($(this).val());
            });            
            
            var data = {
                'senha':$('.senhahost').val(),
                'validade':formatDate($('.validadehost').val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/updateusersenhahost/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $('#updateformsenha_errListhost').html("");
                            $('#updateformsenha_errListhost').addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $('#updateformsenha_errListhost').append('<li>'+err_values+'</li>');
                            });
          
                }else{
                        $('#updateformsenha_errListhost').html('<ul id="updateformsenha_errListhost"></ul>');                                                              
    
                        $('#editformsenhahost').trigger('reset');                    
                        $('#EditSenhaHost').modal('hide');

                        location.reload();
                } 
                }   
            });
    });         

    ////fim alteração de senha USER HOST

     ////inicio alteração de senha USER VM
    $('#EditSenhaVM').on('shown.bs.modal',function(){
        $('#edit_senhavm').focus();
    });
    $(document).on('click','.uservm_item',function(e){
        e.preventDefault();
        
        var id = $(this).data("id");
        var labelHtml = ($(this).data("nomevm")).trim();            
        var labelclusterip = ($(this).data("clusterip")).trim(); 
        $('#editformsenhavm').trigger('reset');
        $('#EditSenhaVM').modal('show');  
        $('#editnomeVM').html('<Label id="editnomeVM" style="font-style:italic;">'+labelHtml+'</Label>');            
        $('#editclusteripvm').html('<Label id="editclusteripvm" style="font-style:italic;">'+labelclusterip+'</Label>');     
        $('#edit_VMsenha_id').val(id);  
        $('#updateformsenha_errListvm').html('<ul id="updateformsenha_errListvm"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editusersenhavm/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.virtualmachine.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.virtualmachine.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.virtualmachine.validade);
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
                    if(new Date(response.virtualmachine.validade)<new Date()){
                    $('#senhavencidavm').html('<small id="senhavencidavm" style="color: red">Senha vencida!</small>');
                    }else{
                    $('#senhavencidavm').html('<small id="senhavencidavm" style="color: green">Senha na validade. OK!</small>');  
                    }                    
                    $('#edit_validadevm').val(datavalidade);
                    $('#editdatacriacaovm').html('<label  id="editdatacriacaovm">'+datacriacao+'</label>');
                    $('#editdatamodificacaovm').html('<label  id="editdatamodificacaovm">'+dataatualizacao+'</label>');
                    $('#editcriadorvm').html('<label  id="editcriadorvm">'+criador+'</label>');
                    $('#editmodificadorvm').html('<label  id="editmodificadorvm">'+alterador+'</label>');                         
                    $('#edit_senhavm').val(response.senha);
                    if(response.virtualmachine.val_indefinida){
                      $("input[name='edit_val_indefinidavm']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinidavm']").attr('checked',false);  
                    }
                      
                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados 
                        $.each(response.users,function(key,values){                                                                           
                                $("#checkvm"+values.id).attr('checked',true);  //faz a marcação seletiva                         
                        });
                }
            }
        });   
             
    });
    //fim exibe 
    ///inicio alterar senha VM
    $(document).on('click','.update_senhaVM_btn',function(e){
            e.preventDefault();
            $(this).text('Salvando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $('#edit_VMsenha_id').val();
            var val_indefinida = 0;
            $("input[name='edit_val_indefinidavm']:checked").each(function(){
                val_indefinida = 1;
            });         

            //array apenas com os checkboxes marcados
            var users = new Array;
            $("input[name='users[]']:checked").each(function(){
                users.push($(this).val());
            });            
            
            var data = {
                'senha':$('.senhavm').val(),
                'validade':formatDate($('.validadevm').val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/updateusersenhavm/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $('#updateformsenha_errListvm').html("");
                            $('#updateformsenha_errListvm').addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $('#updateformsenha_errListvm').append('<li>'+err_values+'</li>');
                            });
          
                }else{
                        $('#updateformsenha_errListvm').html('<ul id="updateformsenha_errListvm"></ul>');     
                        $('#success_message').html('<div id="success_message"></div>');              
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
    
                        $('#editformsenhavm').trigger('reset');                    
                        $('#EditSenhaVM').modal('hide');

                      location.reload();
                } 
                }   
            });
    });         

    ////fim alteração de senha USER VM

  ////inicio alteração de senha USER BASE
    $('#EditSenhaBase').on('shown.bs.modal',function(){
        $('#edit_senhabase').focus();
    });
    $(document).on('click','.userbase_item',function(e){
        e.preventDefault();

        var id = $(this).data("id");
        var labelHtml = ($(this).data("nomebase")).trim();            
        var labelip = ($(this).data("ip")).trim(); 
        $('#editformsenhabase').trigger('reset');
        $('#EditSenhaBase').modal('show');  
        $('#editnomebase').html('<Label id="editnomebase" style="font-style:italic;">'+labelHtml+'</Label>');            
        $('#editipbase').html('<Label id="editipbase" style="font-style:italic;">'+labelip+'</Label>');     
        $('#edit_basesenha_id').val(id);  
        $('#updateformsenha_errListbase').html('<ul id="updateformsenha_errListbase"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editusersenhabase/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.base.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.base.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.base.validade);
                    datavalidade = datavalidade.toLocaleDateString("pt-BR");
                     if(datavalidade=="31/12/1969"){
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
                    if(new Date(response.base.validade)<new Date()){
                    $('#senhavencidabase').html('<small id="senhavencidabase" style="color: red">Senha vencida!</small>');
                    }else{
                    $('#senhavencidabase').html('<small id="senhavencidabase" style="color: green">Senha na validade. OK!</small>');  
                    }          
                    $('#edit_validadebase').val(datavalidade);
                    $('#editdatacriacaobase').html('<label  id="editdatacriacaobase">'+datacriacao+'</label>');
                    $('#editdatamodificacaobase').html('<label  id="editdatamodificacaobase">'+dataatualizacao+'</label>');
                    $('#editcriadorbase').html('<label  id="editcriadorbase">'+criador+'</label>');
                    $('#editmodificadorbase').html('<label  id="editmodificadorbase">'+alterador+'</label>');                         
                    $('#edit_senhabase').val(response.senha);
                    if(response.base.val_indefinida){
                      $("input[name='edit_val_indefinidabase']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinidabase']").attr('checked',false);  
                    }

                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados ao artigo
                        $.each(response.users,function(key,values){                                                        
                                $("#checkbase"+values.id).attr('checked',true);  //faz a marcação seletiva                         
                        });
                }
            }
        });

                
    });
    //fim exibe EditBaseModal
    ///inicio alterar senha base
    $(document).on('click','.update_senhabase_btn',function(e){
            e.preventDefault();
            $(this).text('Salvando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $('#edit_basesenha_id').val();
            var val_indefinida = 0;
            $("input[name='edit_val_indefinidabase']:checked").each(function(){
                val_indefinida = 1;
            });         

            //array apenas com os checkboxes marcados
            var users = new Array;
            $("input[name='users[]']:checked").each(function(){
                users.push($(this).val());
            });            
            
            var data = {
                'senha':$('.senhabase').val(),
                'validade':formatDate($('.validadebase').val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/updateusersenhabase/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $('#updateformsenha_errListbase').html("");
                            $('#updateformsenha_errListbase').addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $('#updateformsenha_errListbase').append('<li>'+err_values+'</li>');
                            });
          
                }else{
                        $('#updateformsenha_errListbase').html('<ul id="updateformsenha_errListbase"></ul>');                                                    
    
                        $('#editformsenhabase').trigger('reset');                    
                        $('#EditSenhaBase').modal('hide');

                        location.reload();

                } 
                }   
            });
    });         

    ////fim alteração de senha BASE USER

 ////inicio alteração de senha VLAN USER
    $('#EditSenhaVLAN').on('shown.bs.modal',function(){
        $('#edit_senha').focus();
    });
    $(document).on('click','.uservlan_item',function(e){
        e.preventDefault();

        var id = $(this).data("id");
        var labelHtml = ($(this).data("nomevlan")).trim();                   
        $('#editformsenhavlan').trigger('reset');
        $('#EditSenhaVLAN').modal('show');  
        $('#editnomevlan').html('<Label id="editnomevlan" style="font-style:italic;">'+labelHtml+'</Label>');                    
        $('#edit_vlansenha_id').val(id);  
        $('#updateformsenha_errListvlan').html('<ul id="updateformsenha_errListvlan"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editusersenhavlan/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.vlan.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.vlan.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.vlan.validade);
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
                    if(new Date(response.vlan.validade)<new Date()){
                    $('#senhavencidavlan').html('<small id="senhavencidavlan" style="color: red">Senha vencida!</small>');
                    }else{
                    $('#senhavencidavlan').html('<small id="senhavencidavlan" style="color: green">Senha na validade. OK!</small>');  
                    }         
                    $('#edit_validadevlan').val(datavalidade);
                    $('#editdatacriacaovlan').html('<label  id="editdatacriacaovlan">'+datacriacao+'</label>');
                    $('#editdatamodificacaovlan').html('<label  id="editdatamodificacaovlan">'+dataatualizacao+'</label>');
                    $('#editcriadorvlan').html('<label  id="editcriadorvlan">'+criador+'</label>');
                    $('#editmodificadorvlan').html('<label  id="editmodificadorvlan">'+alterador+'</label>');                         
                    $('#edit_senhavlan').val(response.senha);
                    if(response.vlan.val_indefinida){
                      $("input[name='edit_val_indefinidavlan']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinidavlan']").attr('checked',false);  
                    }
                      
                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados 
                        $.each(response.users,function(key,values){                                                                           
                                $("#checkvlan"+values.id).attr('checked',true);  //faz a marcação seletiva                         
                        });
                }
            }
        });
             
    });
    //fim exibe 
    ///inicio alterar senha
    $(document).on('click','.update_senhavlan_btn',function(e){
            e.preventDefault();
            $(this).text('Salvando...');
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //validade indeterminada
            var id = $('#edit_vlansenha_id').val();
            var val_indefinida = 0;
            $("input[name='edit_val_indefinidavlan']:checked").each(function(){
                val_indefinida = 1;
            });         

            //array apenas com os checkboxes marcados
            var users = new Array;
            $("input[name='users[]']:checked").each(function(){
                users.push($(this).val());
            });            
            
            var data = {
                'senha':$('.senhavlan').val(),
                'validade':formatDate($('.validadevlan').val()),
                'val_indefinida':val_indefinida,                
                'users':users,
                '_method':'PATCH',
                '_token': CSRF_TOKEN,       
            };            
            
            $.ajax({                
                type:'POST',                                
                data:data,
                dataType: 'json',
                url:'/datacenter/updateusersenhavlan/'+id,
                success:function(response){
                      if(response.status==400){
                           //erros
                            $('#updateformsenha_errListvlan').html("");
                            $('#updateformsenha_errListvlan').addClass("alert alert-danger");
                            $.each(response.errors,function(key,err_values){
                                    $('#updateformsenha_errListvlan').append('<li>'+err_values+'</li>');
                            });
          
                }else{
                        $('#updateformsenha_errListvlan').html('<ul id="updateformsenha_errListvlan"></ul>');     
                            
                        $('#editformsenhavlan').trigger('reset');                    
                        $('#EditSenhaVLAN').modal('hide');

                        location.reload();

                } 
                }   
            });
    });         

    ////fim alteração de senha VLAN USER    
   
    //Listagem de APPs com senha vencida do alerta          
   
    $(document).on('click','.senhabloqueadaapp_btn',function(e){
        e.preventDefault();

        var opcaosenha = $(this).data("opt");

        if(opcaosenha){
    
        var id = $(this).data("id");
        var labelHtml = ($(this).data("nomeapp")).trim();            
        var labelDominio = ($(this).data("dominio")).trim(); 
        $('#editformsenha').trigger('reset');
        $('#EditSenhaApp').modal('show');  
        $('#editnomeapp').html('<Label id="editnomeapp" style="font-style:italic;">'+labelHtml+'</Label>');            
        $('#editdominioapp').html('<Label id="editdominioapp" style="font-style:italic;">'+labelDominio+'</Label>');     
        $('#edit_appsenha_id').val(id);  
        $('#updateformsenha_errList').html('<ul id="updateformsenha_errList"></ul>');

        $('#listaformsenhaapp').trigger('reset');
        $('#ListaAPPsModal').modal('hide'); 
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editusersenhaapp/'+id,
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
                    $('#senhavencida').html('<small id="senhavencida" style="color: red">Senha vencida!</small>');
                    }else{
                    $('#senhavencida').html('<small id="senhavencida" style="color: green">Senha na validade. OK!</small>');  
                    } 
                    $('#edit_validade').val(datavalidade);
                    $('#editdatacriacao').html('<label  id="editdatacriacao">'+datacriacao+'</label>');
                    $('#editdatamodificacao').html('<label  id="editdatamodificacao">'+dataatualizacao+'</label>');
                    $('#editcriador').html('<label  id="editcriador">'+criador+'</label>');
                    $('#editmodificador').html('<label  id="editmodificador">'+alterador+'</label>');                         
                    $('#edit_senha').val(response.senha);
                    if(response.app.val_indefinida){
                      $("input[name='edit_val_indefinida']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinida']").attr('checked',false);  
                    }

                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados ao artigo
                        $.each(response.users,function(key,values){                                                        
                                $("#checkapp"+values.id).attr('checked',true);  //faz a marcação seletiva                         
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
                imageUrl: '../../logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'Ok, obrigado!',                
                cancelButtonText: 'Não necessito, obrigado!',
            });      
    }
             
    });
    //fim exibe EditAppModal
    ///a parte do update_senhaapp_btn já foi feita 
    ///para o usuário logado realizar se tiver permissão 
    
 ///fim Listagem de APPs com senha vencida

 ////inicio alteração de senha vencida BASES   
    $(document).on('click','.senhabloqueadabase_btn',function(e){
        e.preventDefault();

        var opcaosenha = $(this).data("opt");

        if(opcaosenha){
    
        var id = $(this).data("id");
        var labelHtml = ($(this).data("nomebase")).trim();            
        var labelip = ($(this).data("ip")).trim(); 
        $('#editformsenhabase').trigger('reset');
        $('#EditSenhaBase').modal('show');  
        $('#editnomebase').html('<Label id="editnomebase" style="font-style:italic;">'+labelHtml+'</Label>');            
        $('#editipbase').html('<Label id="editipbase" style="font-style:italic;">'+labelip+'</Label>');     
        $('#edit_basesenha_id').val(id);  
        $('#updateformsenha_errListbase').html('<ul id="updateformsenha_errListbase"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editusersenhabase/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.base.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.base.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.base.validade);
                    datavalidade = datavalidade.toLocaleDateString("pt-BR");
                     if(datavalidade=="31/12/1969"){
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
                    if(new Date(response.base.validade)<new Date()){
                    $('#senhavencidabase').html('<small id="senhavencidabase" style="color: red">Senha vencida!</small>');
                    }else{
                    $('#senhavencidabase').html('<small id="senhavencidabase" style="color: green">Senha na validade. OK!</small>');  
                    }          
                    $('#edit_validadebase').val(datavalidade);
                    $('#editdatacriacaobase').html('<label  id="editdatacriacaobase">'+datacriacao+'</label>');
                    $('#editdatamodificacaobase').html('<label  id="editdatamodificacaobase">'+dataatualizacao+'</label>');
                    $('#editcriadorbase').html('<label  id="editcriadorbase">'+criador+'</label>');
                    $('#editmodificadorbase').html('<label  id="editmodificadorbase">'+alterador+'</label>');                         
                    $('#edit_senhabase').val(response.senha);
                    if(response.base.val_indefinida){
                      $("input[name='edit_val_indefinidabase']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinidabase']").attr('checked',false);  
                    }

                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados ao artigo
                        $.each(response.users,function(key,values){                                                        
                                $("#checkbase"+values.id).attr('checked',true);  //faz a marcação seletiva                         
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
                imageUrl: '../../logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'Ok, obrigado!',                
                cancelButtonText: 'Não necessito, obrigado!',
            });      
    }
             
    });   

    ////fim alteração de senha vencida BASES

     ////inicio alteração de senha VM do alerta   
    $(document).on('click','.senhabloqueadavm_btn',function(e){
        e.preventDefault();

        var opcaosenha = $(this).data("opt");

        if(opcaosenha){
    
        var id = $(this).data("id");
        var labelHtml = ($(this).data("nomevm")).trim();            
        var labelclusterip = ($(this).data("clusterip")).trim(); 
        $('#editformsenhavm').trigger('reset');
        $('#EditSenhaVM').modal('show');  
        $('#editnomeVM').html('<Label id="editnomeVM" style="font-style:italic;">'+labelHtml+'</Label>');            
        $('#editclusteripvm').html('<Label id="editclusteripvm" style="font-style:italic;">'+labelclusterip+'</Label>');     
        $('#edit_VMsenha_id').val(id);  
        $('#updateformsenha_errListvm').html('<ul id="updateformsenha_errListvm"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editusersenhavm/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.virtualmachine.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.virtualmachine.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.virtualmachine.validade);
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
                    if(new Date(response.virtualmachine.validade)<new Date()){
                    $('#senhavencidavm').html('<small id="senhavencidavm" style="color: red">Senha vencida!</small>');
                    }else{
                    $('#senhavencidavm').html('<small id="senhavencidavm" style="color: green">Senha na validade. OK!</small>');  
                    }                    
                    $('#edit_validadevm').val(datavalidade);
                    $('#editdatacriacaovm').html('<label  id="editdatacriacaovm">'+datacriacao+'</label>');
                    $('#editdatamodificacaovm').html('<label  id="editdatamodificacaovm">'+dataatualizacao+'</label>');
                    $('#editcriadorvm').html('<label  id="editcriadorvm">'+criador+'</label>');
                    $('#editmodificadorvm').html('<label  id="editmodificadorvm">'+alterador+'</label>');                         
                    $('#edit_senhavm').val(response.senha);
                    if(response.virtualmachine.val_indefinida){
                      $("input[name='edit_val_indefinidavm']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinidavm']").attr('checked',false);  
                    }
                      
                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados 
                        $.each(response.users,function(key,values){                                                                           
                                $("#checkvm"+values.id).attr('checked',true);  //faz a marcação seletiva                         
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
                imageUrl: '../../logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'Ok, obrigado!',                
                cancelButtonText: 'Não necessito, obrigado!',
            });      
    }
             
    });
    //fim edit senhas VM do alerta

     ////inicio alteração de senhas vencidas dos HOSTS do alerta
    
    $(document).on('click','.senhabloqueadahost_btn',function(e){
        e.preventDefault();

        var opcaosenha = $(this).data("opt");

        if(opcaosenha){
    
       var id = $(this).data("id");
        var labelHtml = ($(this).data("nomehost")).trim();            
        var labelclusterip = ($(this).data("clusterip")).trim(); 
        $('#editformsenhahost').trigger('reset');
        $('#EditSenhaHost').modal('show');  
        $('#editnomehost').html('<Label id="editnomehost" style="font-style:italic;">'+labelHtml+'</Label>');            
        $('#editclusteriphost').html('<Label id="editclusteriphost" style="font-style:italic;">'+labelclusterip+'</Label>');     
        $('#edit_hostsenha_id').val(id);  
        $('#updateformsenha_errListhost').html('<ul id="updateformsenha_errListhost"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editusersenhahost/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.host.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.host.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.host.validade);
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
                    if(new Date(response.host.validade)<new Date()){
                    $('#senhavencidahost').html('<small id="senhavencidahost" style="color: red">Senha vencida!</small>');
                    }else{
                    $('#senhavencidahost').html('<small id="senhavencidahost" style="color: green">Senha na validade. OK!</small>');  
                    }                
                    $('#edit_validadehost').val(datavalidade);
                    $('#editdatacriacaohost').html('<label  id="editdatacriacaohost">'+datacriacao+'</label>');
                    $('#editdatamodificacaohost').html('<label  id="editdatamodificacaohost">'+dataatualizacao+'</label>');
                    $('#editcriadorhost').html('<label  id="editcriadorhost">'+criador+'</label>');
                    $('#editmodificadorhost').html('<label  id="editmodificadorhost">'+alterador+'</label>');                         
                    $('#edit_senhahost').val(response.senha);
                    if(response.host.val_indefinida){
                      $("input[name='edit_val_indefinidahost']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinidahost']").attr('checked',false);  
                    }

                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados ao artigo
                        $.each(response.users,function(key,values){                                                        
                                $("#checkhost"+values.id).attr('checked',true);  //faz a marcação seletiva                         
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
                imageUrl: '../../logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'Ok, obrigado!',                
                cancelButtonText: 'Não necessito, obrigado!',
            });      
    }
             
    });
    //fim exibe senhas vencidas de HOSTS do alerta

      ////inicio alteração de senha das VLANS do alerta    
    $(document).on('click','.senhabloqueadavlan_btn',function(e){
        e.preventDefault();

        var opcaosenha = $(this).data("opt");

        if(opcaosenha){
    
       var id = $(this).data("id");
        var labelHtml = ($(this).data("nomevlan")).trim();                   
        $('#editformsenhavlan').trigger('reset');
        $('#EditSenhaVLAN').modal('show');  
        $('#editnomevlan').html('<Label id="editnomevlan" style="font-style:italic;">'+labelHtml+'</Label>');                    
        $('#edit_vlansenha_id').val(id);  
        $('#updateformsenha_errListvlan').html('<ul id="updateformsenha_errListvlan"></ul>');
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/datacenter/editusersenhavlan/'+id,
            success: function(response){
                if(response.status==200){                                                       
                    var datacriacao = new Date(response.vlan.created_at);
                    datacriacao = datacriacao.toLocaleString("pt-BR");
                     if(datacriacao=="31/12/1969 21:00:00"){
                        datacriacao = "";
                        }                      
                    var dataatualizacao = new Date(response.vlan.updated_at);
                    dataatualizacao = dataatualizacao.toLocaleString("pt-BR");
                     if(dataatualizacao=="31/12/1969 21:00:00"){
                        dataatualizacao = "";
                        }  
                    var datavalidade = new Date(response.vlan.validade);
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
                    if(new Date(response.vlan.validade)<new Date()){
                    $('#senhavencidavlan').html('<small id="senhavencidavlan" style="color: red">Senha vencida!</small>');
                    }else{
                    $('#senhavencidavlan').html('<small id="senhavencidavlan" style="color: green">Senha na validade. OK!</small>');  
                    }         
                    $('#edit_validadevlan').val(datavalidade);
                    $('#editdatacriacaovlan').html('<label  id="editdatacriacaovlan">'+datacriacao+'</label>');
                    $('#editdatamodificacaovlan').html('<label  id="editdatamodificacaovlan">'+dataatualizacao+'</label>');
                    $('#editcriadorvlan').html('<label  id="editcriadorvlan">'+criador+'</label>');
                    $('#editmodificadorvlan').html('<label  id="editmodificadorvlan">'+alterador+'</label>');                         
                    $('#edit_senhavlan').val(response.senha);
                    if(response.vlan.val_indefinida){
                      $("input[name='edit_val_indefinidavlan']").attr('checked',true);  
                    }else{
                      $("input[name='edit_val_indefinidavlan']").attr('checked',false);  
                    }
                      
                     //Atribuindo aos checkboxs
                    $("input[name='users[]']").attr('checked',false); //desmarca todos
                        //apenas os temas relacionados 
                        $.each(response.users,function(key,values){                                                                           
                                $("#checkvlan"+values.id).attr('checked',true);  //faz a marcação seletiva                         
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
                imageUrl: '../../logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: false,
                confirmButtonText: 'Ok, obrigado!',                
                cancelButtonText: 'Não necessito, obrigado!',
            });      
    }
             
    });
    //fim exibe alteração de senhas VLANS do alerta

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
        $('.senhabloqueadaapp_btn').tooltip();
        $('.senhabloqueadabase_btn').tooltip();
        $('.senhabloqueadavm_btn').tooltip();
        $('.senhabloqueadahost_btn').tooltip();
        $('.senhabloqueadavlan_btn').tooltip();
    });
    ///fim tooltip

}); //fim do bloco principal
 
</script>

@stop

