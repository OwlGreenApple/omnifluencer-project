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
                  <option data-price="197000" data-paket="Pro Monthly" value="{{$id}}" <?php if ($id==1) echo "selected"; ?>>
                    Pro Monthly - Rp 197.000/bln
                  </option>
                  <option data-price="297000" data-paket="Premium Monthly" value="{{$id}}" <?php if ($id==3) echo "selected"; ?>>
                    Premium Monthly - Rp 297.000/bln
                  </option>
                  <option data-price="708000" data-paket="Pro Yearly" value="{{$id}}" <?php if ($id==2) echo "selected"; ?>>
                    Pro Yearly - Rp 708.000/tahun
                  </option>
                  <option data-price="1068000" data-paket="Premium Yearly" value="{{$id}}" <?php if ($id==4) echo "selected"; ?>>
                    Premium Yearly - Rp 1.068.000/tahun
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label class="label-title-test" for="formGroupExampleInput">
                  Masukkan Kode Kupon:
                </label>
                <input type="text" class="form-input" name="text" id="text" placeholder="Masukkan Kode Kupon Disini" />
              </div>
              <div class="form-group">
                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                <label for="agree-term" class="label-agree-term">
                  <span>
                    <span></span>
                  </span>
                  I agree all statements in <a href="#" class="term-service">Terms of service</a>
                </label>
              </div>
              <div class="form-group">
                <input type="submit" name="submit" id="submit" class="form-submit pointer" value="Confirm Your Payment" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
