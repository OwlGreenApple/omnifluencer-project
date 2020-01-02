@extends('layouts.app')

@section('content')
  <link href="{{ asset('css/style-payment.css') }}" rel="stylesheet">

  <script type="text/javascript">
    $(document).ready(function() {
      $( "#select-auto-manage" ).change(function() {
        $("#price").val($(this).find("option:selected").attr("data-price"));
        $("#namapaket").val($(this).find("option:selected").attr("data-paket"));
        $('#kupon').val("");
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

                <div class="col-md-12 row">
                    <div class="col-md-11 pl-0">
                       <input style="width : 100%" type="text" class="form-control form-control-lg" name="coupon_code" id="kupon" placeholder="Masukkan Kode Kupon Disini" />
                    </div>
                    <div class="col-md-1 pl-0">
                      <button type="button" class="btn btn-primary btn-kupon">
                        Apply
                      </button>  
                    </div>  
                </div>  
              </div>
                  
              <!--
              <div class="form-group">
                <label class="label-title-test" for="formGroupExampleInput">
                  Pilih Metode Pembayaran:
                </label>
                <select class="form-control form-control-lg col-lg-12" name="ordertype">
                  <option value="bt">Bank Transfer</option>
                </select>
              </div>
               -->

              <div class="form-group">
                 <label class="label-title-test" for="formGroupExampleInput">
                   <h5>Total :</h5>
                </label>
                <h4><span class="total"></span></h4>
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

  <script type="text/javascript">
    $(document).ready(function(){
        getDataValue();
        getCoupon();
    });

    function getCoupon()
    {
      $("body").on("click", ".btn-kupon", function() {
        check_kupon();
      });
    }

    function getDataValue()
    {
       $( "#select-auto-manage" ).change(function() {
        var price = $(this).find("option:selected").attr("data-price");
        var namapaket = $(this).find("option:selected").attr("data-paket");

        $("#price").val(price);
        $("#namapaket").val(namapaket);
        check_kupon();
        });
        $( "#select-auto-manage" ).change();
    }

    function check_kupon(){
      $.ajax({
        type: 'POST',
        url: "{{route('checkcoupon')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          harga : $('#price').val(),
          kupon : $('#kupon').val(),
          idpaket : $( "#select-auto-manage" ).val(),
        },
        dataType: 'json',
        beforeSend: function() {
          $('#loader').show();
          $('.div-loading').addClass('background-load');
        },
        success: function(data) {
          $('#loader').hide();
          $('.div-loading').removeClass('background-load');

          if (data.status == 'success') {
            $('.total').html('Rp. ' + data.total);
            $('#pesan').hide();
          } 
          else if (data.status == 'success-paket') {
            $('.total').html('Rp. ' + data.total);
            $('#pesan').removeClass('alert-danger');
            $('#pesan').addClass('alert-success');
            
            flagSelect = false;
            $("#select-auto-manage option").each(function() {
              console.log($(this).val());
              if ($(this).val() == data.paketid) {
                flagSelect = true;
              }
            });

            if (flagSelect == false) {
              $('#select-auto-manage').append('<option value="'+data.paketid+'" data-price="'+data.dataPrice+'" data-paket="'+data.dataPaket+'" selected="selected">'+data.paket+'</option>');
            }
            $('#select-auto-manage').val(data.paketid);
          }
          else {
            $('#pesan').html(data.message);
            $('#pesan').removeClass('alert-success');
            $('#pesan').addClass('alert-danger');
            $('#pesan').show();
          }
        }
      });
    }

  </script>
  
<?php if ( env('APP_ENV') !== "local" ) { ?>
  <!-- Facebook Pixel Code Activomni Add payment info -->
  <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '181710632734846');
    fbq('track', 'AddPaymentInfo');
  </script>
  <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=181710632734846&ev=PageView&noscript=1"
  /></noscript>  

  <script>
    fbq('track', 'StartTrial');
  </script>  
<?php } ?>
@endsection