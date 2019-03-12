@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <div class="col-md-12">

        <div class="row">
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

        <hr>

        <div class="row">
          <div class="col-md-8 col-12">
            <h2><b>Upgrade Account</b></h2>
          </div>  
        </div>
          
        <h5>
          Upgrade your account!
        </h5>
        <hr>  
      </div>

      <div class="col-md-12" align="center">
        <h4 style="padding-top: 20px;padding-bottom: 20px;">
          <b>Our Pricing Plans</b>
        </h4>

        <div style="padding-bottom: 20px">
          Monthly
          <div class="btn-group btn-group-toggle" data-toggle="buttons" style="padding-left: 20px;padding-right: 20px;">
            <label class="btn btn-secondary btn-pricing month active">
              <input type="radio" name="options" id="option1" autocomplete="off" checked> Monthly
            </label>
            <label class="btn btn-secondary btn-pricing year">
              <input type="radio" name="options" id="option2" autocomplete="off"> Yearly
            </label>
          </div>
          Yearly
        </div>

        <div class="row mt-4">
          <div class="col-md-6 col-6">
            <div class="card">
              <div class="card-header upgrade-pro">
                <div class="row">
                  <div class="col-md-6 text-md-left text-sm-center">
                    <span class="header-1">
                      UPGRADE TO PRO
                    </span> <br>
                    <span class="header-2">
                      <b>Monthly</b>
                    </span>
                  </div>  

                  <div class="col-md-6 d-none d-md-block" align="right">
                    <a class="link-pro" href="{{url('checkout/1')}}">
                      <button class="btn btn-sm btn-upgrade-sm">
                        UPGRADE
                      </button>
                    </a>
                  </div>
                </div>

                <div class="col-md-12">
                  <span class="harga pro">
                    IDR 197.000,-
                  </span>
                </div>
              </div>
              <div class="card-body">
                <div class="d-none d-md-block view-pro">
                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      <span class="tickblue">&check;</span>
                    </div>  
                    <div class="col-md-6 text-md-left">
                      Influencer Report (PDF)
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      25
                    </div>
                    <div class="col-md-6 text-md-left">
                      Show History
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      25
                    </div>
                    <div class="col-md-6 text-md-left">
                      Save Profile
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      Yes - 2
                    </div>
                    <div class="col-md-6 text-md-left">
                      Compare
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      Yes - 2
                    </div>
                    <div class="col-md-6 text-md-left">
                      Compare From History
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      <span class="tickblue">&check;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Grouping
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      <span class="tickblue">&check;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Multi Group
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      <span class="tickblue">&check;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Multi Delete 
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3">
                      <span class="cross">&#10060;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Multi Influencers Report (PDF)
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3">
                      <span class="cross">&#10060;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Multi Influencers List (Excel)
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3">
                      <span class="cross">&#10060;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Agency Logo for Report (PDF)
                    </div>
                  </div>
                </div>

                <div class="d-block d-md-none view-more-pro">View details</div>

                <a class="link-pro" href="{{url('checkout/1')}}">
                  <button class="btn btn-upgrade-big">
                    UPGRADE
                  </button>
                </a>
              </div>
            </div>      
          </div>
          <div class="col-md-6 col-6">
            <div class="card">
              <div class="card-header upgrade-premium">
                <div class="row">
                  <div class="col-md-6 text-md-left text-sm-center">
                    <span class="header-1">
                      UPGRADE TO PREMIUM
                    </span> <br>
                    <span class="header-2">
                      <b>Monthly</b>
                    </span>
                  </div>  

                  <div class="col-md-6 d-none d-md-block" align="right">
                    <a class="link-premium" href="{{url('checkout/3')}}">
                      <button class="btn btn-sm btn-upgrade-sm">
                        UPGRADE
                      </button>
                    </a>
                  </div>
                </div>

                <div class="col-md-12">
                  <span class="harga premium">
                    IDR 297.000,-
                  </span>
                </div>
              </div>
              <div class="card-body">

                <div class="d-none d-md-block view-premium">
                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      <span class="tickblue">&check;</span>
                    </div>  
                    <div class="col-md-6 text-md-left">
                      Influencer Report (PDF)
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      Unlimited
                    </div>
                    <div class="col-md-6 text-md-left">
                      Show History
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      Unlimited
                    </div>
                    <div class="col-md-6 text-md-left">
                      Save Profile
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      Yes - 4
                    </div>
                    <div class="col-md-6 text-md-left">
                      Compare
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      Yes - 4
                    </div>
                    <div class="col-md-6 text-md-left">
                      Compare From History
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      <span class="tickblue">&check;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Grouping
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      <span class="tickblue">&check;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Multi Group
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      <span class="tickblue">&check;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Multi Delete 
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      <span class="tickblue">&check;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Multi Influencers Report (PDF)
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      <span class="tickblue">&check;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Multi Influencers List (Excel)
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="offset-md-1 col-md-3 blue">
                      <span class="tickblue">&check;</span>
                    </div>
                    <div class="col-md-6 text-md-left">
                      Agency Logo for Report (PDF)
                    </div>
                  </div>  
                </div>
                
                <div class="d-block d-md-none view-more-premium">View details</div>

                <a class="link-premium" href="{{url('checkout/3')}}">
                  <button class="btn btn-upgrade-big">
                    UPGRADE
                  </button>  
                </a>
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
  $( "body" ).on( "click", ".btn-pricing.month", function(e) 
  {
    $('.header-2').html('<b>Monthly</b>');
    $('.harga.pro').html('IDR 197.000,-');
    $('.harga.premium').html('IDR 297.000,-');
    $('.link-pro').attr('href',"{{url('checkout/1')}}");
    $('.link-premium').attr('href',"{{url('checkout/3')}}");
  });

  $( "body" ).on( "click", ".btn-pricing.year", function(e) 
  {
    $('.header-2').html('<b>Yearly</b>');
    $('.harga.pro').html('IDR 699.000,-');
    $('.harga.premium').html('IDR 999.000,-');
    $('.link-pro').attr('href',"{{url('checkout/2')}}");
    $('.link-premium').attr('href',"{{url('checkout/4')}}");
  });

  $( "body" ).on( "click", ".view-more-pro", function(e) 
  {
    $('.view-pro').toggleClass('d-none');
    $(this).html($(this).html() == 'View details' ? 'View less' : 'View details');
  });

  $( "body" ).on( "click", ".view-more-premium", function(e) 
  {
    $('.view-premium').toggleClass('d-none');
    $(this).html($(this).html() == 'View details' ? 'View less' : 'View details');
  });
</script>
@endsection