@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-login.css') }}" rel="stylesheet">

<script type="text/javascript">
  var delay = (function(){
    var timer = 0;
    return function(callback, ms){
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    };
  })();

  function cekemail(){
    $.ajax({
      type: 'POST',
      url: "<?php echo url('/register/cek-email') ?>",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: { 
        email:$('#email').val()
      },
      dataType: 'text',
      beforeSend: function() {
        $('#email').addClass('loading-form');
      },
      success: function(result) {
        $('#email').removeClass('loading-form');

        var data = jQuery.parseJSON(result);

        if (data.status == 'success') {
          $('#email').addClass('is-valid');
          $('#email').removeClass('is-invalid');
          $(".btn-register").attr("disabled", false);
        } else {
          $('.email-msg').html(data.message);
          $('#email').removeClass('is-valid');
          $('#email').addClass('is-invalid');
          $(".btn-register").attr("disabled", true);
        }
      }
    });
  }
  function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which :event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
  }
</script>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 col-12">

      <div class="signup">
        <div class="signup-content">
          <form method="POST" action="{{ route('register') }}" id="signup-form" class="signup-form">
            @csrf
            <input type="hidden" name="price" value="<?php if (isset ($price)) {echo $price;} ?>">
            <input type="hidden" name="namapaket" value="<?php if (isset($namapaket)) {echo $namapaket;} ?>">
            <input type="hidden" name="coupon_code" value="<?php if (isset($coupon_code)) {echo $coupon_code;} ?>"> 
            <input type="hidden" name="ordertype" value="<?php if (isset($order_type)) {echo $order_type;} ?>">

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

              <input id="email" type="email" class="form-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="off">

              @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @else 
                <span class="invalid-feedback" role="alert">
                  <strong class="email-msg"></strong>
                </span>
              @endif

              <div class="valid-feedback"></div>

            </div>

            <div class="form-group">
              <label class="label-title-test">
                Masukkan Password:
              </label>

              <div class="input-group" id="show_password">
                <input id="password" type="password" class="form-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required style="width: auto !important">

                <div class="input-group-append" for="password">
                  <label class="input-group-text">
                    <span class="icon-pass">
                      <i class="fas fa-eye-slash" aria-hidden="true"></i>
                    </span>
                  </label>
                </div>

                @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                    <strong>
                      {{ $errors->first('password') }}
                    </strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label class="label-title-test">
                Konfirmasi Password:
              </label>

              <div class="input-group" id="show_password_confirm">
                <input id="password-confirm" type="password" class="form-input form-control" name="password_confirmation" placeholder="Ketik ulang password Anda" required style="width: auto !important">

                <div class="input-group-append" for="password-confirm">
                  <label class="input-group-text">
                    <span class="icon-pass-confirm">
                      <i class="fas fa-eye-slash" aria-hidden="true"></i>
                    </span>    
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="label-title-test">
                Masukkan No WA
              </label>

              <div class="input-group" id="show_wa_number">
                <input id="wa-number" type="text" class="form-input form-control" name="wa_number" placeholder="No WA ex: 6281..." required style="width: auto !important" onkeypress="return hanyaAngka(event)">
              </div>
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
                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term mr-1" required/>
                Menyetujui
                <a href="{{url('about-us/terms-conditions')}}" target="_blank" class="term-service">
                  Syarat dan Ketentuan 
                </a>
              </label>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-block btn-primary form-submit pointer btn-register">
                REGISTER
              </button>
            </div>

            <!-- Keep session for total -->
            @php
              Session::reflash();
            @endphp

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
                <input type="hidden" name="coupon_code" value="<?php if (isset($coupon_code)) {echo $coupon_code;} ?>">
                <input type="hidden" name="ordertype" value="<?php if (isset($order_type)) {echo $order_type;} ?>">
                
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

          <!--
          <div align="center">
            <span class="loginhere">
              Sudah punya akun? klik
            </span>
            <php if(isset($price)) { ?>
              <form method="POST" class="d-inline-block" action="{{ url('login-payment') }}">
                @csrf
                <input type="hidden" name="price" value="<php if (isset ($price)) {echo $price;} ?>">
                <input type="hidden" name="namapaket" value="<php if (isset($namapaket)) {echo $namapaket;} ?>">
                <input type="hidden" name="coupon_code" value="<php if (isset($coupon_code)) {echo $coupon_code;} ?>">
                <input type="hidden" name="ordertype" value="<php if (isset($order_type)) {echo $order_type;} ?>">
                
                <a href="#" class="loginhere-link" onclick="$(this).closest('form').submit()">
                  Login disini
                </a>
              </form>
            <php } else { ?>
              <a href="{{url('login')}}" class="loginhere-link">
                Login disini
              </a>
            <php } ?>
          </div>
        -->
         
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  /*$(document).on( "submit", "#signup-form", function() {
    if($('#agree-term').prop("checked") == false){
      $('#message').html('Silakan centang syarat dan ketentuan terlebih dahulu.');
      $('#modal-pesan').modal('show');
      return false;
    } 
  });*/


  $(document).ready(function() {
    $('#email').keyup(function() {
      delay(function(){
        cekemail();
      }, 1000 );
    }); 

    $("#show_password .icon-pass").on('click', function(e) {
      if($('#show_password input').attr("type") == "text"){
        $('#show_password input').attr('type', 'password');
        $('#show_password .icon-pass').html('<i class="fas fa-eye-slash" aria-hidden="true"></i>');
      } else if($('#show_password input').attr("type") == "password"){
        $('#show_password input').attr('type', 'text');
        $('#show_password .icon-pass').html('<i class="fas fa-eye" aria-hidden="true"></i>');
      }
    });

    $("#show_password_confirm .icon-pass-confirm").on('click', function(e) {
      if($('#show_password_confirm input').attr("type") == "text"){
        $('#show_password_confirm input').attr('type', 'password');
        $('#show_password_confirm .icon-pass-confirm').html('<i class="fas fa-eye-slash" aria-hidden="true"></i>');
      } else if($('#show_password_confirm input').attr("type") == "password"){
        $('#show_password_confirm input').attr('type', 'text');
        $('#show_password_confirm .icon-pass-confirm').html('<i class="fas fa-eye" aria-hidden="true"></i>');
      }
    });
    $('#wa-number').keypress(function(e){
      if (this.value.length == 0 && e.which == 48 ){
        return false;
      }
    });
    $('#wa-number').on('input propertychange paste', function (e) {
        var reg = /^0+/gi;
        if (this.value.match(reg)) {
            this.value = this.value.replace(reg, '');
        }
    });
  });  
</script>
<?php if ( env('APP_ENV') !== "local" ) { ?>
<!-- Provely Conversions App Data Code -->
<script>(function(w,n) {
if (typeof(w[n]) == 'undefined'){ob=n+'Obj';w[ob]=[];w[n]=function(){w[ob].push(arguments);};
d=document.createElement('script');d.type = 'text/javascript';d.async=1;
d.src='https://s3.amazonaws.com/provely-public/w/provely-2.0.js';x=document.getElementsByTagName('script')[0];x.parentNode.insertBefore(d,x);}
})(window, 'provelys', '');
provelys('config', 'baseUrl', 'app.provely.io');
provelys('config', 'https', 1);
provelys('data', 'campaignId', '16163');
provelys('config', 'track', 1);
</script>
<!-- End Provely Conversions App Data Code -->

<!-- Provely Conversions App Display Code -->
<script>(function(w,n) {
if (typeof(w[n]) == 'undefined'){ob=n+'Obj';w[ob]=[];w[n]=function(){w[ob].push(arguments);};
d=document.createElement('script');d.type = 'text/javascript';d.async=1;
d.src='https://s3.amazonaws.com/provely-public/w/provely-2.0.js';x=document.getElementsByTagName('script')[0];x.parentNode.insertBefore(d,x);}
})(window, 'provelys', '');
provelys('config', 'baseUrl', 'app.provely.io');
provelys('config', 'https', 1);
provelys('data', 'campaignId', '16163');
provelys('config', 'widget', 1);
</script>
<!-- End Provely Conversions App Display Code -->
<?php } ?>
@endsection
