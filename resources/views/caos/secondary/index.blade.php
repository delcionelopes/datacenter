@extends('adminlte::page')

@section('title', 'Datacenter - Área de navegação')

@section('content')

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

<!--inicio SelUsuario -->
<div class="modal fade animate__animated animate__bounce animate__faster" id="SelUserModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}" id="titulo_selusermodal">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Selecione o usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body form-horizontal">
                <form id="seluserform" name="seluserform" class="form-horizontal" role="form">
                    <input type="hidden" id="add_cluster_id">
                    <ul id="selusuario_errList"></ul>                    
                    <div class="form-group mb-3">
                        <label for="">Usuários</label>
                        <select name="selusuario_id" id="selusuario_id" class="custom-select">
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-{{$color}} btnselusuario"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim SelUsuario -->

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
                   <h4 class="mb-0 mt-0" style="color: red" ><b>{{auth()->user()->name}}</b></h4>                 
                </div>                    
                </div>              
            </div>         
<div class="container-fluid">
<div class="row">
@if($autorizacao)

@foreach ($operacoes as $ope)   
  @foreach($autorizacao as $aut)
  @if(($aut->modulo_has_operacao_operacao_id) == ($ope->id))
    <div class="p-2 mt-2">
    <div class="card card-hover" style="width: 14rem;">
      <div class="card-header">
        <b style="background: transparent; color: black; border: none;"><i class="fas fa-desktop"></i> {{$ope->nome}}</b>
      </div>
      <a href="" data-id="{{$ope->id}}" data-color="{{$aut->modulo->color}}" id="link" class="abrir">
      <img class="card-img-top" src="{{asset('storage/'.$ope->ico)}}" alt="Imagem de capa do módulo" width="286" height="180">
      </a>
      <div class="card-body">                
        <p class="card-text">{{$ope->descricao}}</p>        
        <button type="button" id="abrir_btn" data-id="{{$ope->id}}" data-color="{{$aut->modulo->color}}" class="abrir btn btn-{{$aut->modulo->color}}">Abrir</button>
      </div>
    </div>
  </div>
  @break
  @elseif ($loop->last)
  {{-- cessa a construção de cards --}}
  @endif
  @endforeach
@endforeach

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
        <p class="card-text">Você não tem acesso a esta área.</p>
        <p class="card-text"><small class="text-muted">Grato pela compreensão.</small></p>
      </div>
    </div>
  </div>
</div>
</div>
@endif
</div>
</div>
</div>
</div>


@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){

  $(document).on('click','.abrir',function(e){    //aciona pelos elementos img pelo link e pelo button abrir_btn através do atributo comum class .abrir
    e.preventDefault();
    var codoperacao = $(this).data("id");
    var color = $(this).data("color");
    var linkgif = "{{asset('storage/ajax-loader.gif')}}";
        
      switch (codoperacao) {
      case 1: location.replace('/datacenteradmin/orgao/index-orgao/'+color); ///cadastro de orgãos
      break;
      case 2: location.replace('/datacenteradmin/setor/index-setor/'+color); ///cadastro de setores
      break;
      case 3: location.replace('/datacenteradmin/ambiente/index-ambientes/'+color); ///cadastro de ambientes
      break;
      case 4: location.replace('/datacenteradmin/plataforma/index-plataforma/'+color); ///cadastro de plataformas
      break;
      case 5: location.replace('/datacenteradmin/projeto/index-projeto/'+color); ///cadastro de projetos
      break;
      case 6: location.replace('/datacenteradmin/areaconhecimento/index-areaconhecimento/'+color); ///cadastro de areas conhecimento
      break;
      case 7: location.replace('/datacenteradmin/subareaconhecimento/index-subareaconhecimento/'+color); ///cadastro de sub-areas conhecimento
      break;
      case 8: location.replace('/datacenteradmin/manual/index-manual/'+color); ///cadastro de manuais
      break;
      case 9: location.replace('/datacenteradmin/cluster/index-cluster/'+color); ///Gestão de Datacenter
      break;
      case 10: location.replace('/datacenteradmin/vlan/index-vlan/'+color); ///Gestão de Redes
      break;
      case 11: location.replace('/datacenteradmin/senhas/index-senhas/'+color); ///Gestão de senhas
      break;
      case 12: location.replace('/datacenteradmin/equipamento/index-equipamento/'+color); ///Gestão de senhas
      break;
      case 13: location.replace('/datacenteradmin/relatorios/relatorio-ambientes'); ///Relatorio de ambientes
      break;
      case 14: location.replace('/datacenteradmin/relatorios/relatorio-orgaos'); ///Relatorio de orgãos
      break;
      case 16: location.replace('/datacenteradmin/relatorios/relatorio-plataformas'); ///Relatorio de plataformas
      break;
      case 17: location.replace('/datacenteradmin/relatorios/relatorio-bases'); ///Relatorio de bases de dados
      break;
      case 18: location.replace('/datacenteradmin/relatorios/relatorio-maquinasvirtuais'); ///Relatorio de máquinas virtuais
      break; 
      case 19: location.replace('/datacenteradmin/relatorios/relatorio-redes'); ///Relatorio de redes
      break; 
      case 20: location.replace('/datacenteradmin/relatorios/relatorio-setores'); ///Relatorio de setores
      break; 
      case 21: location.replace('/datacenteradmin/relatorios/relatorio-hosts'); ///Relatorio de hosts
      break; 
      case 22: location.replace('/datacenteradmin/relatorios/relatorio-clusters'); ///Relatorio de clusters
      break; 
      case 23: location.replace('/datacenteradmin/relatorios/relatorio-areas'); ///Relatorio de areas
      break; 
      case 24: location.replace('/datacenteradmin/relatorios/relatorio-modope'); ///Relatorio de módulos X operações
      break; 
      case 25: location.replace('/datacenteradmin/relatorios/relatorio-usuarios'); ///Relatorio de usuários
      break;
      case 26: { //exibir o form modal para selecionar o usuário
            $("#seluserform").trigger('reset');
            $("#SelUserModal").modal('show');
            $("#selusuario_errList").replaceWith('<ul id="selusuario_errList"></ul>');
      }
      break;
      default:
        break;
    }  

  });  

   //reconfigura o option selected do select do usuário html
   $('select[name="selusuario_id"]').on('change',function(){
            var opt = this.value;
            $("#selusuario_id option")
            .removeAttr('selected')
            .filter('[value='+opt+']')
            .attr('selected',true);
        }); 
        //reconfigura o option selected do usuário

    //inicio exibição do form SelUserModal
    $('#SelUserModal').on('shown.bs.modal',function(){
            $("#selusuario_id").focus();
       });
     //fim exibição do form SelUserModal      
    
    $(document).on('click','.btnselusuario',function(){
      var id = $('#selusuario_id').val();
      location.replace('/datacenteradmin/relatorios/relatorio-permissoes/'+id);
    });

});

</script>

@stop

