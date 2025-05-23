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
@if($autorizacao->count())

@foreach ($modulos as $mod)   
  @foreach($autorizacao as $aut)
  @if(($aut->modulo_has_operacao_modulo_id) == ($mod->id))
  <div class="p-2 mt-2">   
  <div class="card card-hover mb-3" style="max-width: 540px;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <a href="{{route('datacenteradmin.principal.operacoes',['id' => $mod->id,'color'=>$mod->color])}}">
      <img src="{{asset('storage/'.$mod->ico)}}" class="card-img" alt="Capa do módulo">
      </a>
    </div>
    <div class="col-md-8">
      <div class="card-body text-right">
        <h5 class="card-title">{{$mod->nome}}</h5>
        <p class="card-text">{{$mod->descricao}}</p>
        <p class="card-text"><small class="text-muted">Criado em {{ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($mod->created_at))))}}</small></p>
        <a href="{{route('datacenteradmin.principal.operacoes',['id' => $mod->id,'color'=>$mod->color])}}" class="btn btn-{{$mod->color}}">Executar</a>
      </div>
    </div>
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

@stop

