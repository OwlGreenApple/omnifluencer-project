@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-login.css') }}" rel="stylesheet">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 col-12">

      <div class="signup">
        <div class="signup-content">
          <form method="POST" id="signup-form" class="signup-form" action="{{route('password.update')}}">
            @csrf

            <h2 class="form-title">
              Reset Password
            </h2>

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
              <label for="email" class="label-title-test"> Email Address:
              </label>

              <input id="email" type="email" class="form-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" placeholder="Your email" required autofocus>

              @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                  <strong>
                    {{ $errors->first('email') }}
                  </strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label class="label-title-test" for="password">Password:</label>

              <input id="password" type="password" class="form-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Your new password" required>

              @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                  <strong>
                    {{ $errors->first('password') }}
                  </strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label class="label-title-test" for="password-confirm">Confirm Password:</label>

              <input id="password-confirm" type="password" class="form-input form-control" name="password_confirmation" placeholder="Confirm your new password" required>
            </div>

            <div class="form-group form-group-mob">
              <button type="submit" class="btn btn-primary form-submit pointer">
                Reset Password
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
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
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
