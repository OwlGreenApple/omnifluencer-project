@extends('layouts.app')

@section('content')
  <link href="{{ asset('css/style-payment.css') }}" rel="stylesheet">

  <script type="text/javascript">
    $(document).ready(function() {
      $( "#select-auto-manage" ).change(function() {
        $("#price").val($(this).find("option:selected").attr("data-price"));
        $("#namapaket").val($(this).find("option:selected").attr("data-paket"));
      });
      $( "#select-auto-manage" ).change();
    });
  </script>

  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="signup">
          <div class="signup-content">
            @if (session('error') )
              <div class="col-md-12 alert alert-danger">
                <strong>Warning!</strong> {{session('error')}}
              </div>
            @endif
            
            <?php if (Auth::check()) {?>
              <!-- ditaruh di session -->
              <form method="POST" action="{{url('confirm-payment')}}" id="signup-form" class="signup-form">
            <?php } else {?>
              <form method="POST" action="{{url('register-payment')}}" id="signup-form" class="signup-form">
            <?php }?>
              {{ csrf_field() }}
              <input type="hidden" id="price" name="price">
              <input type="hidden" id="namapaket" name="namapaket">

              <h2 class="form-title">Choose Your Packages</h2>

              <div class="form-group">
                <label class="label-title-test" for="formGroupExampleInput">
                  Pilih Paket:
                </label>
                <select class="form-control form-control-lg" name="select-auto-manage" id="select-auto-manage" style="width: 100%">
                  <option data-price="98500" data-paket="Pro 15 hari" value="5">
                    Pro 15 hari
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label class="label-title-test" for="formGroupExampleInput">
                  Masukkan Kode Kupon:
                </label>
                <input type="text" class="form-input" name="coupon_code" id="text" placeholder="Masukkan Kode Kupon Disini" />
              </div>
              <div class="form-group">
                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required/>
                <label for="agree-term" class="label-agree-term">
                  Menyetujui <a href="{{url('about-us/terms-conditions')}}" class="term-service">Syarat dan Ketentuan</a>
                </label>
              </div>
              <div class="form-group">
                <input type="submit" name="submit" id="submit" class="btn btn-primary form-submit pointer" value="Confirm Your Payment" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
