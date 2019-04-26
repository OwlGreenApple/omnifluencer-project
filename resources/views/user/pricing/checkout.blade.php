@extends('layouts.app')

@section('content')
  <link href="{{ asset('css/style-payment.css') }}" rel="stylesheet">

  <script type="text/javascript">
    $(document).ready(function() {
      $( "#select-auto-manage" ).change(function() {
        var price = $(this).find("option:selected").attr("data-price");
        var namapaket = $(this).find("option:selected").attr("data-paket");

        $("#price").val(price);
        $("#namapaket").val(namapaket);
        check_kupon();
      });
      $( "#select-auto-manage" ).change();
    });

    $("body").on("click", ".btn-kupon", function() {
      check_kupon();
    });

    function check_kupon(){
      $.ajax({
        type: 'POST',
        url: "<?php echo url('/check-kupon') ?>",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          harga : $('#price').val(),
          kupon : $('#kupon').val(),
          idpaket : $( "#select-auto-manage" ).val(),
        },
        dataType: 'text',
        beforeSend: function() {
          $('#loader').show();
          $('.div-loading').addClass('background-load');
        },
        success: function(result) {
          $('#loader').hide();
          $('.div-loading').removeClass('background-load');

          var data = jQuery.parseJSON(result);

          if (data.status == 'success') {
            $('.total').html('Rp. ' + data.total);
            $('#pesan').hide();
          } else {
            $('#pesan').html(data.message);
            $('#pesan').removeClass('alert-success');
            $('#pesan').addClass('alert-danger');
            $('#pesan').show();
          }
        }
      });
    }
  </script>

  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="signup">
          <div class="signup-content">
            @if (session('error') )
              <div class="col-md-12 alert alert-danger">
                {{session('error')}}
              </div>
            @endif
            
            <div id="pesan" class="alert"></div>

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
                <select class="form-control form-control-lg" name="idpaket" id="select-auto-manage" style="width: 100%">
                  <option data-price="197000" data-paket="Pro Monthly" value="1" <?php if ($id==1) echo "selected"; ?>>
                    Pro Monthly - Rp 197.000/bln
                  </option>
                  <option data-price="297000" data-paket="Premium Monthly" value="3" <?php if ($id==3) echo "selected"; ?>>
                    Premium Monthly - Rp 297.000/bln
                  </option>
                  <option data-price="708000" data-paket="Pro Yearly" value="2" <?php if ($id==2) echo "selected"; ?>>
                    Pro Yearly - Rp 708.000/tahun
                  </option>
                  <option data-price="1068000" data-paket="Premium Yearly" value="4" <?php if ($id==4) echo "selected"; ?>>
                    Premium Yearly - Rp 1.068.000/tahun
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label class="label-title-test" for="formGroupExampleInput">
                  Masukkan Kode Kupon:
                </label>

                <div class="col-md-12 row">
                  <div class="col-md-11 pl-0">
                    <input type="text" class="form-control form-control-lg" name="kupon" id="kupon" placeholder="Masukkan Kode Kupon Disini" style="width:100%" />  
                  </div>
                  <div class="col-md-1 pl-0">
                    <button type="button" class="btn btn-primary btn-kupon">
                      Apply
                    </button>  
                  </div>  
                </div>
              </div>
              <div class="form-group">
                <label class="label-title-test" for="formGroupExampleInput">
                  Total: 
                </label>
                <div class="col-md-12 pl-0">
                  <span class="total" style="font-size:18px"></span>
                </div>
              </div>              
              <div class="form-group">
                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required/>
                <label for="agree-term" class="label-agree-term">
                  Menyetujui <a href="{{url('statics/terms-conditions')}}" class="term-service">Syarat dan Ketentuan</a>
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
