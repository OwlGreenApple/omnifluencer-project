@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-login.css') }}" rel="stylesheet">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 col-12">

      <div class="signup">
        <div class="signup-content">
          <form method="POST" id="signup-form" class="signup-form" action="{{route('password.email')}}">
            @csrf

            <h2 class="form-title">
              Reset Password
            </h2>

            @if (session('status'))
              <div class="col-md-12 alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif
      
            <div class="form-group">
              <label for="email" class="label-title-test">  Email Address :
              </label>

              <input id="email" type="email" class="form-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Your Email" required autofocus>

              @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group form-group-mob">
              <button type="submit" class="btn btn-primary form-submit pointer">
                Send Password Reset Link
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!--<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">

      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      <div class="card">
        <div class="card-header">{{ __('Reset Password') }}</div>

          <div class="card-body">
            <form method="POST" action="{{ route('password.email') }}">
              @csrf

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                  @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Send Password Reset Link') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
</div>-->
@endsection
