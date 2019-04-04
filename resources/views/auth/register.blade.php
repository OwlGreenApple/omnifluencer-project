@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-login.css') }}" rel="stylesheet">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 col-12">

      <div class="signup">
        <div class="signup-content">
          <form method="POST" action="{{ route('register') }}" id="signup-form" class="signup-form">
            @csrf
            <input type="hidden" name="price" value="<?php if (isset ($price)) {echo $price;} ?>">
            <input type="hidden" name="namapaket" value="<?php if (isset($namapaket)) {echo $namapaket;} ?>">

            <h2 class="form-title">Buat Akun Baru Omnifluencer</h2>

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
              <label class="label-title-test" for="name">Masukkan Nama Lengkap:</label>

              <input id="name" type="text" class="form-input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap"  required autofocus>

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

              <input id="email" type="email" class="form-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>

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

              <input id="password" type="password" class="form-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

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

              <input id="password-confirm" type="password" class="form-input form-control" name="password_confirmation" placeholder="Ketik ulang password Anda" required>
            </div>

            <div class="form-group">
              <label class="label-title-test" for="gender">
                Gender:
              </label>

              <label class="radio-inline col-md-3">
                <input type="radio" name="gender" value="1" checked> Pria
              </label>

              <label class="radio-inline col-md-4">
                <input type="radio" name="gender" value="0"> Wanita
              </label>
            </div>

            <div class="form-group">
              <label for="agree-term" class="label-agree-term">
                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term mr-1" />
                Menyetujui
                <a href="{{url('statics/terms-conditions')}}" class="term-service">
                  Syarat dan Ketentuan 
                </a>
              </label>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-block btn-primary form-submit pointer">
                REGISTER
              </button>
            </div>
          </form>

          <div align="center">
            <span class="loginhere">
              Sudah punya akun? klik
            </span>
            <?php if(isset($price)) { ?>
              <form method="POST" class="d-inline-block" action="{{ url('login-payment') }}">
                @csrf
                <input type="hidden" name="price" value="<?php if (isset ($price)) {echo $price;} ?>">
                <input type="hidden" name="namapaket" value="<?php if (isset($namapaket)) {echo $namapaket;} ?>">

                <a href="#" class="loginhere-link" onclick="$(this).closest('form').submit()">
                  Login disini
                </a>
              </form>
            <?php } else { ?>
              <a href="{{url('login')}}" class="loginhere-link">
                Login disini
              </a>
            <?php } ?>
          </div>
         
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
