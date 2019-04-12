@extends('layouts.dashboard')

@section('content')
<link href="{{ asset('css/style-pricing.css') }}" rel="stylesheet">

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-11 col-12">
      <!-- Header -->
        <div class="row header-pricing d-lg-none d-md-none d-none text-center">
          <div class="col-md-6 col-6 pr-0 pl-0">
            <div class="card">
              <div class="card-body pricing">
                <h4 class="mb-0 green-color">
                  <b class="sbold">
                    PRO
                  </b>  
                </h4>
                <span class="harga harga-med pro">
                  <sup>Rp</sup> 59.000<sub> /bln</sub>
                </span><br>
                <a class="link-pro" href="{{url('checkout/2')}}">
                  <button class="btn btn-block btn-upgrade-big med pro">
                    BELI PAKET
                  </button>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-6 pr-0 pl-0">
            <div class="card">
              <div class="card-body pricing">
                <h4 class="mb-0 orange-color">
                  <b class="sbold">
                    PREMIUM
                  </b>    
                </h4>
                <span class="harga harga-med premium">
                  <sup>Rp</sup> 89.000<sub> /bln</sub>
                </span><br>
                <a class="link-premium" href="{{url('checkout/4')}}">
                  <button class="btn btn-block btn-upgrade-big med premium">
                    BELI PAKET
                  </button>  
                </a>
              </div>
            </div>
          </div>
        </div>

      <div class="col-md-12">

        <!--<div class="row">
          <form class="form-inline col-md-12 mb-2" action="{{url('search')}}" method="POST">
            @csrf
            
            <label class="mr-sm-2 pb-md-2 label-calculate" for="calculate">
              Calculate More
            </label>

            <input id="calculate" type="text" class="form-control form-control-sm mb-2 mr-sm-2 mr-2 col-md-3 col-9" name="keywords" placeholder="Enter Instagram Username">

            <button type="submit" class="btn btn-sm btn-primary mb-2">
              Calculate
            </button>
          </form>
        </div>

        <hr>-->

        <div class="row">
          <div class="col-md-6 col-12 order-md-1 order-1">
            <h2><b>Upgrade Account</b></h2>
          </div>
          <div class="col-md-6 col-12 order-md-2 order-3 text-md-right text-left" style="position: relative;">
            <h5 class="info-member">
              My membership : <b>{{ucfirst(Auth::user()->membership)}}</b>
            </h5>
          </div>

          <div class="col-md-6 col-12 order-md-3 order-2">
            <h5>
              Upgrade your account!
            </h5>
          </div>
          <div class="col-md-6 col-12 text-md-right text-left order-md-4 order-4">
            <h5>
              Expired by : {{date("d-m-Y",strtotime(Auth::user()->valid_until))}}  
            </h5>
          </div>
        </div>

        <hr>

      </div>

      <div class="col-md-12" align="center">
        <h4 class="pt-5 pb-3">
          <b>Pilih Paket Anda</b>
        </h4>

        <div class="pb-md-5 pb-3">
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

          <h5 class="mt-3">
            Hemat <b>Hingga 70%</b> Dengan Paket Tahunan
          </h5>
        </div>

        <div class="row mt-4 pricing-box">
          <div class="offset-lg-1 col-lg-5 col-md-12 col-12 pr-lg-0">
            <div class="card card-ribbon">

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
                    <div class="offset-md-1 offset-1 col-md-2 col-2 pl-0 pr-0 green-color">
                      <b>25</b>
                    </div>
                    <div class="col-md-9 col-9 text-left">
                      Show History
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 offset-1 col-md-2 col-2 pl-0 pr-0 green-color">
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

          <div class="col-lg-5 col-md-12 col-12 pl-lg-0">
            <div class="card card-ribbon">
              <div class="corner-ribbon top-right orange">
                LEBIH HEMAT
              </div>

              <div class="card-body upgrade-details">
                <div class="col-md-12" align="center">
                  <span class="orange-color">
                    <span class="icon-upgrade">
                      <i class="fas fa-crown"></i>  
                    </span>
                    <br>
                    <h3 class="pt-3">
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
                    Biaya Per Tahun @ Rp 1.068.000
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
    </div>
  </div>
</div>

<!-- Modal Confirm Delete -->
<div class="modal fade" id="confirm-delete" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Delete Confirmation
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Delete your profile picture?
      </div>
      <div class="modal-footer" id="foot">
        <button class="btn btn-danger" id="btn-delete-ok" data-dismiss="modal">
          Delete
        </button>
        <button class="btn" data-dismiss="modal">
          Cancel
        </button>
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

  $("body").on("click", ".view-more-pro", function(e) {
    $('.view-pro').toggleClass('d-none');
    $(this).html($(this).html() == 'View details' ? 'View less' : 'View details');
  });

  $("body").on("click", ".view-more-premium", function(e) {
    $('.view-premium').toggleClass('d-none');
    $(this).html($(this).html() == 'View details' ? 'View less' : 'View details');
  });
</script>
@endsection