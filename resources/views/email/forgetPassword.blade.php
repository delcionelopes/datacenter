@extends('layout')

@section('content')

<h1>Esqueci o e-mail da senha</h1>

   

Você pode redefinir a senha no link abaixo:

<a href="{{ route('reset.password.get', $token) }}">Redefinir senha</a>

@endsection