@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-login.css') }}" rel="stylesheet">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 col-12">

      <div class="signup">
        <div class="signup-content">
          <form method="POST" id="signup-form" class="signup-form" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="price" value="<?php if (isset ($price)) {echo $price;} ?>">
            <input type="hidden" name="namapaket" value="<?php if (isset($namapaket)) {echo $namapaket;} ?>">

            <h2 class="form-title">Masukkan<br>Email & Password</h2>

            @if (session('error') )
              <div class="col-md-12 alert alert-danger">
                <strong>Warning!</strong> {{session('error')}}
              </div>
            @endif
            @if (session('success') )
              <div class="col-md-12 alert alert-success">
                <strong>Success!</strong> {{session('success')}}
              </div>
            @endif
      
            <div class="form-group">
              <label for="email" class="label-title-test">  Masukkan Email:
              </label>
              <input id="email" type="email" class="form-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }} " name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

              @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label class="label-title-test" for="password">Masukkan Password:</label>

              <input id="password" type="password" class="form-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
              <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>

              @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group form-group-mob">
                <button type="submit" class="btn btn-primary form-submit pointer">
                  Sign In
                </button>

                @if (Route::has('password.request'))
                  <a class="btn btn-link btn-frgt" href="{{ route('password.request') }}">
                    Lupa Password?
                  </a>
                @endif
            </div>

            <p class="loginhere">
              Belum punya akun? klik <a href="{{url('register')}}" class="loginhere-link">Register disini</a>
            </p>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
