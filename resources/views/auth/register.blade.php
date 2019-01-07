@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-login.css') }}" rel="stylesheet">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 col-12">

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

      <div class="signup">
        <div class="signup-content">
          <form method="POST" action="{{ route('register') }}" id="signup-form" class="signup-form">
            @csrf

            <h2 class="form-title">Create an Omnifluencer<br>account within a minutes</h2>

            <div class="form-group">
              <label class="label-title-test" for="name">Masukkan Nama Lengkap:</label>

              <input id="name" type="text" class="form-input{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Your Full Name"  required autofocus>

              @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label class="label-title-test" for="email">
                Masukkan Email:
              </label>

              <input id="email" type="email" class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Your Email" required>

              @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label class="label-title-test" for="password">
                Masukkan Password:
              </label>

              <input id="password" type="password" class="form-input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

              @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label class="label-title-test" for="password-confirm">
                Konfirmasi Password:
              </label>

              <input id="password-confirm" type="password" class="form-input" name="password_confirmation" placeholder="Confirm your password" required>
            </div>

            <div class="form-group">
              <label class="label-title-test" for="gender">
                Gender:
              </label>

              <label class="radio-inline col-md-3">
                <input type="radio" name="gender" value="1" checked> Male
              </label>

              <label class="radio-inline col-md-4">
                <input type="radio" name="gender" value="0"> Female
              </label>
            </div>

            <div class="form-group">
              <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
              <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in <a href="#" class="term-service">Terms of service</a></label>
            </div>

            <div class="form-group">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary form-submit pointer">
                  Sign up
                </button>
              </div>
            </div>

            <p class="loginhere">
              Have already an account ? <a href="{{url('login')}}" class="loginhere-link">Sign In Here</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
