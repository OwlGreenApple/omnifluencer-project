@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-pricing.css') }}" rel="stylesheet">
<script src="{{ asset('js/custom.js') }}"></script>

<section class="page-title">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Omnifluencer Pricing Plans</h1>
        <hr class="orn">
        <p class="pg-title">
          Pilih paket aktivasi Omnifluencer bergantung pada kebutuhan media sosial Anda 
        </p>

        <div class="row mt-5" align="center">
          <div class="col-12">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
              <label class="btn btn-secondary btn-pricing year upgrade-radio active" style="outline: none;box-shadow: 0 1px 5px 0 rgba(183,183,183,0.50);">
                <input type="radio" name="options" id="option2" autocomplete="off"> 
                TAHUNAN
              </label>
              <label class="btn btn-secondary btn-pricing month upgrade-radio" style="outline: none; box-shadow: 0 1px 5px 0 rgba(183,183,183,0.50);">
                <input type="radio" name="options" id="option1" autocomplete="off" checked> 
                BULANAN
              </label>
            </div>

            <br>

            <p class="pg-title small pt-0 mt-3">
              Hemat <b>Hingga 70%</b> Dengan Paket Tahunan
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<div class="offset-md-1 col-md-10" align="center">
  <!-- Header 
  <div class="row header-pricing">
    <div class="col-md-4 col-4 pr-md-0">
      <div class="card">
        <div class="card-body">
          <span class="gray-color">
            <h5>
              <b class="sbold">
                FREE
              </b>  
            </h5>
          </span>
          <span class="harga harga-small free">
            <sup>Rp</sup> 0 <sub>/bln</sub>
          </span><br>
          <a class="link-free" href="{{url('register')}}">
            <button class="btn btn-block btn-upgrade-big free">
              DAFTAR SEKARANG
            </button>
          </a>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-4 pr-md-0 pl-md-0">
      <div class="card">
        <div class="card-body">
          <span class="green-color">  
            <h5>
              <b class="sbold">
                PRO
              </b>  
            </h5>
          </span>
          <span class="harga harga-small pro">
            <sup>Rp</sup> 59.000<sub> /bln</sub>
          </span><br>
          <a class="link-pro" href="{{url('checkout/2')}}">
            <button class="btn btn-block btn-upgrade-big pro">
              BELI PAKET
            </button>
          </a>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-4 pl-md-0">
      <div class="card">
        <div class="card-body">
          <span class="orange-color">
            <h3>
              <b class="sbold">
                PREMIUM
              </b>    
            </h3>
          </span>
          <span class="harga harga-small premium">
            <sup>Rp</sup> 89.000<sub> /bln</sub>
          </span><br>
          <a class="link-premium" href="{{url('checkout/4')}}">
            <button class="btn btn-block btn-upgrade-big premium">
              BELI PAKET
            </button>  
          </a>
        </div>
      </div>
    </div>
  </div>-->

  <!-- Header -->
  <div class="row header-pricing d-lg-none d-md-none d-none">
    <div class="col-md-4 col-4 pr-0 pl-0">
      <div class="card">
        <div class="card-body pricing">
          <h5 class="gray-color">
            <b class="sbold small">
              Basic Plus
            </b>  
          </h5>
          <span class="harga harga-small free">
            <sup>Rp</sup> 0 <sub>/bln</sub>
          </span><br>
          <a class="link-free" href="{{url('register')}}">
            <button class="btn btn-block btn-upgrade-big small free">
              DAFTAR
            </button>
          </a>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-4 pr-0 pl-0">
      <div class="card">
        <div class="card-body pricing">
          <h5 class="green-color">
            <b class="sbold small">
              PRO
            </b>  
          </h5>
          <span class="harga harga-small pro">
            <sup>Rp</sup> 59.000<sub> /bln</sub>
          </span><br>
          <a class="link-pro" href="{{url('checkout/2')}}">
            <button class="btn btn-block btn-upgrade-big small pro">
              BELI
            </button>
          </a>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-4 pr-0 pl-0">
      <div class="card">
        <div class="card-body pricing">
          <h5 class="orange-color">
            <b class="sbold small">
              PREMIUM
            </b>    
          </h5>
          <span class="harga harga-small premium">
            <sup>Rp</sup> 89.000<sub> /bln</sub>
          </span><br>
          <a class="link-premium" href="{{url('checkout/4')}}">
            <button class="btn btn-block btn-upgrade-big small premium">
              BELI
            </button>  
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-md-0 mb-5 pricing-box">
    <div class="col-lg-4 col-md-12 col-12 pl-md-0 pr-md-0">
      <div class="card secondary">
        <div class="card-body upgrade-details">
          <div class="col-md-12" align="center">
            <span class="gray-color">
              <h3>
                <b class="sbold">
                  Basic Plus
                </b>  
              </h3>
            </span>
          </div>

          <div class="col-md-12 pb-3">
            <span class="harga free">
              <sup>Rp</sup> 0 <sub>/bln</sub>
            </span><br>
            <span class="harga-real free">
              Gratis
            </span><br>
            <p class="hemat monthly mt-4">
              <i class="fas fa-redo-alt"></i>
              &nbsp;Harga Bulanan
            </p>
          </div>

          <a class="link-free" href="{{url('register')}}">
            <button class="btn btn-block btn-upgrade-big free">
              DAFTAR SEKARANG
            </button>
          </a>

          <div class="upgrade-details2">
            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2 green-color">
                 <b>1</b>
              </div>  
              <div class="col-md-9 col-9 text-left">
                Influencer Report (PDF)
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2 green-color">
                <b>5</b>
              </div>
              <div class="col-md-9 col-9 text-left">
                Show History
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Save Profile
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1  col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Compare
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Compare From History
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1  col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Grouping
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Group
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Delete 
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Save .PDF
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Save .XLS
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Agency Logo for Report (PDF)
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> 

    <div class="col-lg-4 col-md-12 col-12 pl-md-0 pr-md-0">
      <div class="card primary card-ribbon">

        <div class="corner-ribbon top-right green">
          FAVORITE
        </div>

        <div class="card-body upgrade-details">
          <div class="col-md-12" align="center green-color">
            <span class="green-color">
              <span class="icon-upgrade">
                <i class="fas fa-trophy"></i>
              </span>
              <h3 class="pt-3">
                <b class="sbold">
                  PRO
                </b>  
              </h3>
            </span>
          </div>

          <div class="col-md-12 pb-3">
            <span class="harga pro">
              <sup>Rp</sup> 59.000<sub> /bln</sub>
            </span><br>
            <span class="harga-real pro">
              Biaya Per Tahun @ Rp 708.000
            </span><br>
            <p class="hemat monthly mt-4">
              <i class="fas fa-redo-alt"></i>
              &nbsp;Harga Bulanan
            </p>
          </div>

          <a class="link-pro" href="{{url('checkout/2')}}">
            <button class="btn btn-block btn-upgrade-big pro">
              BELI PAKET
            </button>
          </a>

          <div class="upgrade-details2">
            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="green-color">
                  <i class="fas fa-check-circle"></i>
                </span>
              </div>  
              <div class="col-md-9 col-9 text-left">
                Influencer Report (PDF)
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2 pr-lg-0 pl-lg-0 green-color">
                <b>25</b>
              </div>
              <div class="col-md-9 col-9 text-left">
                Show History
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2 pr-lg-0 pl-lg-0 green-color">
                <b>25</b>
              </div>
              <div class="col-md-9 col-9 text-left">
                Save Profile
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2 green-color">
                <b>2</b>
              </div>
              <div class="col-md-9 col-9 text-left">
                Compare
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2 green-color">
                <b>2</b>
              </div>
              <div class="col-md-9 col-9 text-left">
                Compare From History
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="green-color">
                  <i class="fas fa-check-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Grouping
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="green-color">
                  <i class="fas fa-check-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Group
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="green-color">
                  <i class="fas fa-check-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Delete 
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Save .PDF
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1  col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Save .XLS
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="red-color">
                  <i class="fas fa-times-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Agency Logo for Report (PDF)
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-12 col-12 pl-md-0 pr-md-0">
      <div class="card secondary card-ribbon">
        <div class="card-body upgrade-details">
          <div class="col-md-12" align="center">
            <span class="orange-color">
              <h3>
                <b class="sbold">
                  PREMIUM
                </b>    
              </h3>
            </span>
          </div>
                
          <div class="col-md-12 pb-3">
            <span class="harga premium">
              <sup>Rp</sup> 89.000<sub> /bln</sub>
            </span><br>
            <span class="harga-real premium">
              Biaya Per Tahun @ 1.068.000
            </span><br>
            <p class="hemat monthly mt-4">
              <i class="fas fa-redo-alt"></i>
              &nbsp;Harga Bulanan
            </p>
          </div>

          <a class="link-premium" href="{{url('checkout/4')}}">
            <button class="btn btn-block btn-upgrade-big premium">
              BELI PAKET
            </button>  
          </a>

          <div class="upgrade-details2">
            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="green-color">
                  <i class="fas fa-check-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Influencer Report (PDF)
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2 green-color">
                <i class="fas fa-infinity"></i>
              </div>
              <div class="col-md-9 col-9 text-left">
                Show History
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2 green-color">
                <i class="fas fa-infinity"></i>
              </div>
              <div class="col-md-9 col-9 text-left">
                Save Profile
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2 green-color">
                <b>4</b>
              </div>
              <div class="col-md-9 col-9 text-left">
                Compare
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2 green-color">
                <b>4</b>
              </div>
              <div class="col-md-9 col-9 text-left">
                Compare From History
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="green-color">
                  <i class="fas fa-check-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Grouping
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="green-color">
                  <i class="fas fa-check-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Group
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="green-color">
                  <i class="fas fa-check-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Delete
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="green-color">
                  <i class="fas fa-check-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Save .PDF
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="green-color">
                  <i class="fas fa-check-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Bulk Save .XLS
              </div>
            </div>

            <div class="row mb-2">
              <div class="offset-md-1 offset-1 col-md-2 col-2">
                <span class="green-color">
                  <i class="fas fa-check-circle"></i>
                </span>
              </div>
              <div class="col-md-9 col-9 text-left">
                Agency Logo for Report (PDF)
              </div>
            </div>                    
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  // get initial position of the element
  var elm = $('.pricing-box');
  if (elm.length) {
    var fixmeTop = elm.offset().top;
  }

  $(window).scroll(function() {                  
    // get current position
    var currentScroll = $(window).scrollTop(); 

    // apply position: fixed if you
    if (currentScroll >= fixmeTop) {           
      $('.header-pricing').addClass('d-md-flex d-flex');
      $('.header-pricing').removeClass('d-md-none d-none');
    } else {
      $('.header-pricing').addClass('d-md-none d-none');
      $('.header-pricing').removeClass('d-md-flex d-flex');
    }
  });

  $("body").on("click", ".btn-pricing.month,.hemat.monthly", function(e) {
    $('.hemat').toggleClass('monthly');
    $('.hemat').toggleClass('yearly');

    $('.btn-pricing.month').addClass('active');
    $('.btn-pricing.year').removeClass('active');

    $('.harga.pro').html('<sup>Rp</sup> 197.000 <sub>/bln</sub>');
    $('.harga-real.pro').html('<b>Dibayar Per Bulan</b>');

    $('.harga.premium').html('<sup>Rp</sup> 297.000 <sub>/bln</sub>');
    $('.harga-real.premium').html('<b>Dibayar Per Bulan</b>');

    $('.hemat').html('<i class="fas fa-redo-alt"></i>&nbsp;Harga Tahunan');

    $('.link-pro').attr('href', "{{url('checkout/1')}}");
    $('.link-premium').attr('href', "{{url('checkout/3')}}");
  });

  $("body").on("click", ".btn-pricing.year,.hemat.yearly", function(e) {
    $('.hemat').toggleClass('monthly');
    $('.hemat').toggleClass('yearly');

    $('.btn-pricing.month').removeClass('active');
    $('.btn-pricing.year').addClass('active');

    $('.harga.pro').html('<sup>Rp</sup> 59.000 <sub>/bln</sub>');
    $('.harga-real.pro').html('<b>Biaya Per Tahun @ Rp 708.000</b>');

    $('.harga.premium').html('<sup>Rp</sup> 89.000 <sub>/bln</sub>');
    $('.harga-real.premium').html('<b>Biaya Per Tahun @ Rp 1.068.000</b>');

    $('.hemat').html('<i class="fas fa-redo-alt"></i>&nbsp;Harga Bulanan');

    $('.link-pro').attr('href', "{{url('checkout/2')}}");
    $('.link-premium').attr('href', "{{url('checkout/4')}}");
  });
</script>  

<?php if ( env('APP_ENV') !== "local" ) { ?>
  <!-- Facebook Pixel Code Activomni Initiate Checkout -->
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
    fbq('track', 'InitiateCheckout');
  </script>
  <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=181710632734846&ev=PageView&noscript=1"
  /></noscript>
  <!-- End Facebook Pixel Code -->
<?php } ?>
@endsection
