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
      <a href="" data-id="{{$ope->id}}" data-color="{{$aut->modulos->color}}" id="link1" class="abrir">
      <img class="card-img-top" src="{{asset('storage/'.$ope->ico)}}" alt="Imagem de capa do módulo" width="286" height="180">
      </a>
      <div class="card-body">                
        <p class="card-text">{{$ope->descricao}}</p>        
        <button type="button" id="abrir_btn" data-id="{{$ope->id}}" data-color="{{$aut->modulos->color}}" class="abrir btn btn-{{$aut->modulos->color}}">Abrir</button>
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
      default:
        break;
    }  

  });  

});

</script>

@stop

