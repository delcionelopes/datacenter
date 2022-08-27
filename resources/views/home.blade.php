@extends('adminlte::page',['iFrameEnabled' => true])

@section('title', 'Datacenter')

@section('content_header')
    <h1>OLÁ!</h1>
@stop

@section('content')
    <p>Seja bem-vindo ao <b>Datacenter PRODAP</b>!</p>
@stop

@section('css')
    <link rel="stylesheet" href="vendor/adminlte/dist/css/adminlte.min.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop