@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>
<div class="container py-5">
<div class="row">

  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">APPs</h5>
        <p class="card-text">Senhas vencidas por applicação. Total: {{$totalapps}}</p>
        @if($totalapps)
        <a href="#" class="btn btn-danger">Ver APPs</a>
        @else
        <a href="#" class="btn btn-primary">Ver APPs</a>
        @endif
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">BASEs</h5>
        <p class="card-text">Senha vencidas por base de dados. Total: {{$totalbases}}</p>
        @if($totalbases)
        <a href="#" class="btn btn-danger">Ver BASEs</a>
        @else
        <a href="#" class="btn btn-primary">Ver BASEs</a>
        @endif
      </div>
    </div>
  </div>

   <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">VIRTUAL MACHINEs</h5>
        <p class="card-text">Senhas vencidas por Virtual Machine. Total: {{$totalvirtualmachines}}</p>
        @if($totalvirtualmachines)
        <a href="#" class="btn btn-danger">Ver VIRTUAL MACHINEs</a>
        @else
        <a href="#" class="btn btn-primary">Ver VIRTUAL MACHINEs</a>
        @endif
      </div>
    </div>
  </div>

   <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">HOSTs</h5>
        <p class="card-text">Senhas vencidas por HOSTs. Total: {{$totalhosts}}</p>
        @if($totalhosts)
        <a href="#" class="btn btn-danger">Ver HOSTs</a>
        @else
        <a href="#" class="btn btn-primary">Ver HOSTs</a>
        @endif
      </div>
    </div>
  </div>

   <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">VLANs</h5>
        <p class="card-text">Senhas vencidas por Vlans. Total: {{$totalvlans}}</p>
        @if($totalvlans)
        <a href="#" class="btn btn-danger">Ver HOSTs</a>
        @else
        <a href="#" class="btn btn-primary">Ver HOSTs</a>
        @endif
      </div>
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

