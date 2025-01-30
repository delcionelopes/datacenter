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

  

                    @if (Session::has('message'))

                         <div class="alert alert-success" role="alert">

                            {{ Session::get('message') }}

                        </div>

                    @endif

  
<<<<<<< HEAD

=======
>>>>>>> 29a04d6d95313463a3e449ba2703c7a815878796
                      <form action="{{ route('forget.password.post') }}" method="POST">

                          @csrf

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

                          <div class="col-md-6 offset-md-4">

                              <button type="submit" class="btn btn-primary">

<<<<<<< HEAD
                                  Send Password Reset Link
=======
                                  Enviar link de redefinição de senha
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