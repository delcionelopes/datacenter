@extends('adminlte::page')

@section('title', 'Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<div class="container py-5"> 
  

            <div class="card p-3">

                <div class="d-flex align-items-center">

                <div class="image">
                @if(auth()->user()->avatar)  
                <img src="{{asset('storage/'.auth()->user()->avatar)}}" class="rounded" width="155" >
                @else
                <img src="{{asset('storage/user.png')}}" class="rounded" width="155" >
                @endif
                </div>

                <div class="ml-3 w-100">
                    
                   <h4 class="mb-0 mt-0">{{$user->name}}</h4>
                   <span>Minhas senhas</span>

                   <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">

                    <div class="d-flex flex-column">

                        <span class="articles">APPs</span>
                        <span class="number1">38</span>
                        
                    </div>

                    <div class="d-flex flex-column">

                        <span class="followers">HOSTs</span>
                        <span class="number2">980</span>
                        
                    </div>


                    <div class="d-flex flex-column">

                        <span class="rating">VMs</span>
                        <span class="number3">8.9</span>
                        
                    </div>

                    <div class="d-flex flex-column">

                        <span class="rating">BASEs</span>
                        <span class="number3">10</span>
                        
                    </div>

                    <div class="d-flex flex-column">

                        <span class="rating">VLANs</span>
                        <span class="number3">12</span>
                        
                    </div>
                       
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
        <a href="#" class="btn btn-primary">Ver APPs</a>        
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

