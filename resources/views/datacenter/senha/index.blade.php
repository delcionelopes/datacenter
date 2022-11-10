@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<div class="container py-5">
  
        <div class="card mb-3 justify-content-center">
          <div class="rounded-top text-white d-flex flex-row" style="background-image: url('/assets/img/home-bg.jpg')">
            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
            @if(auth()->user()->avatar)
              <img src="{{asset('storage/'.auth()->user()->avatar)}}"
                alt="{{auth()->user()->name}}" class="img-fluid img-thumbnail mt-4 mb-2"
                style="width: 150px; z-index: 1">
                @else
                <img src="{{asset('storage/user.png')}}"
                alt="avatar genérico" class="img-fluid img-thumbnail mt-4 mb-2"
                style="width: 150px; z-index: 1">
              @endif              
            </div>
            <div class="ms-3" style="margin-top: 130px;">
              <h5>{{auth()->user()->name}}</h5>
              <p>{{auth()->user()->email}}</p>
            </div>
          </div>
          <div class="p-4 text-black" style="background-color: #f8f9fa;">
            <div class="d-flex justify-content-end text-center py-1">
              <div class="px-3">
                <p class="mb-1 h5">253</p>
                <p class="small text-muted mb-0">APPs</p>
              </div>
              <div class="px-3">
                <p class="mb-1 h5">1026</p>
                <p class="small text-muted mb-0">BASEs</p>
              </div>
              <div class="px-3">
                <p class="mb-1 h5">478</p>
                <p class="small text-muted mb-0">VLANs</p>
              </div>
              <div class="px-3">
                <p class="mb-1 h5">500</p>
                <p class="small text-muted mb-0">VMs</p>
              </div>
            </div>
          </div>            
          </div>       


 <div class="row">
  @if($totalgeral)
  @if($totalapps)
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">APPs</h5>
        <p class="card-text">Senhas vencidas por applicação. Total: {{$totalapps}}</p>
        <a href="#" class="btn btn-danger">Ver APPs</a>        
      </div>
    </div>
  </div>
  @endif
  @if($totalbases)
  <div class="col-sm-6">
    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">BASEs</h5>        
        <p class="card-text">Senha vencidas por base de dados. Total: {{$totalbases}}</p>        
        <a href="#" class="btn btn-danger">Ver BASEs</a>        
      </div>
    </div>
  </div>
  @endif
  @if($totalvirtualmachines)
   <div class="col-sm-6">
    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">VIRTUAL MACHINEs</h5>        
        <p class="card-text">Senhas vencidas por Virtual Machine. Total: {{$totalvirtualmachines}}</p>        
        <a href="#" class="btn btn-danger">Ver VIRTUAL MACHINEs</a>        
      </div>
    </div>
  </div>
  @endif
  @if($totalhosts)
   <div class="col-sm-6">
    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">HOSTs</h5>        
        <p class="card-text">Senhas vencidas por HOSTs. Total: {{$totalhosts}}</p>        
        <a href="#" class="btn btn-danger">Ver HOSTs</a>        
      </div>
    </div>
  </div>
  @endif
  @if($totalvlans)
   <div class="col-sm-6">
    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">VLANs</h5>        
        <p class="card-text">Senhas vencidas por Vlans. Total: {{$totalvlans}}</p>        
        <a href="#" class="btn btn-danger">Ver HOSTs</a>                
      </div>
    </div>
  </div>
  @endif
  @else
  <div class="col-sm-6">
<div class="card" style="width: 18rem;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="{{asset('logoprodap.jpg')}}" class="card-img" alt="prodap">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title"><b>{{$user->name}}</b>,</h5>
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


@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

@stop

