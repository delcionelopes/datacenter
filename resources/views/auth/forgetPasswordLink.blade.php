@extends('layout')

  

@section('content')

<main class="login-form">

  <div class="container">

      <div class="row justify-content-center">

          <div class="col-md-8">

              <div class="card">

                  <div class="card-header">Redefinir a senha</div>

                  <div class="card-body">

  

                      <form action="{{ route('reset.password.post') }}" method="POST">

                          @csrf

                          <input type="hidden" name="token" value="{{ $token }}">

  

                          <div class="form-group row">

                              <label for="email_address" class="col-md-4 col-form-label text-md-right">Endereço de E-Mail</label>

                              <div class="col-md-6">

                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>

                                  @if ($errors->has('email'))

                                      <span class="text-danger">{{ $errors->first('email') }}</span>

                                  @endif

                              </div>

                          </div>

  

                          <div class="form-group row">

                              <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>

                              <div class="col-md-6">

                                  <input type="password" id="password" class="form-control" name="password" required autofocus>

                                  @if ($errors->has('password'))

                                      <span class="text-danger">{{ $errors->first('password') }}</span>

                                  @endif

                              </div>

                          </div>

  

                          <div class="form-group row">

                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar senha</label>

                              <div class="col-md-6">

                                  <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>

                                  @if ($errors->has('password_confirmation'))

                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>

                                  @endif

                              </div>

                          </div>

  

                          <div class="col-md-6 offset-md-4">

                              <button type="submit" class="btn btn-primary">

                                  Redefinir senha

                              </button>

                          </div>

                      </form>

                        

                  </div>

              </div>

          </div>

      </div>

  </div>

</main>

@endsection