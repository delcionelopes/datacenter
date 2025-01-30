@extends('layout')

  

@section('content')

<main class="login-form">

<<<<<<< HEAD
  <div class="cotainer">
=======
  <div class="container">
>>>>>>> 29a04d6d95313463a3e449ba2703c7a815878796

      <div class="row justify-content-center">

          <div class="col-md-8">

              <div class="card">

<<<<<<< HEAD
                  <div class="card-header">Reset Password</div>
=======
                  <div class="card-header">Redefinir a senha</div>
>>>>>>> 29a04d6d95313463a3e449ba2703c7a815878796

                  <div class="card-body">

  

                      <form action="{{ route('reset.password.post') }}" method="POST">

                          @csrf

                          <input type="hidden" name="token" value="{{ $token }}">

  

                          <div class="form-group row">

<<<<<<< HEAD
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
=======
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">Endereço de E-Mail</label>
>>>>>>> 29a04d6d95313463a3e449ba2703c7a815878796

                              <div class="col-md-6">

                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>

                                  @if ($errors->has('email'))

                                      <span class="text-danger">{{ $errors->first('email') }}</span>

                                  @endif

                              </div>

                          </div>

  

                          <div class="form-group row">

<<<<<<< HEAD
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
=======
                              <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>
>>>>>>> 29a04d6d95313463a3e449ba2703c7a815878796

                              <div class="col-md-6">

                                  <input type="password" id="password" class="form-control" name="password" required autofocus>

                                  @if ($errors->has('password'))

                                      <span class="text-danger">{{ $errors->first('password') }}</span>

                                  @endif

                              </div>

                          </div>

  

                          <div class="form-group row">

<<<<<<< HEAD
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
=======
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar senha</label>
>>>>>>> 29a04d6d95313463a3e449ba2703c7a815878796

                              <div class="col-md-6">

                                  <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>

                                  @if ($errors->has('password_confirmation'))

                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>

                                  @endif

                              </div>

                          </div>

  

                          <div class="col-md-6 offset-md-4">

                              <button type="submit" class="btn btn-primary">

<<<<<<< HEAD
                                  Reset Password
=======
                                  Redefinir senha
>>>>>>> 29a04d6d95313463a3e449ba2703c7a815878796

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