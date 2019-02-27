@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-11">
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
        <div class="col-md-8 order-1 order-md-1 col-6">
          <h2><b>Dashboard</b></h2>    
        </div>  

        <div class="col-md-4 order-3 order-md-2 col-12 date-dashboard" align="right">
          {{ date("l, d F Y")  }}
        </div>

        <div class="col-md-8 order-2 order-md-3 col-12">
          <h5>
            Welcome to Omnifluencer!
          </h5>    
        </div>
      </div>
      
      <hr>
      
      <br>

      @if(Auth::user()->is_admin==0)
        <div class="row">
          <div class="col-md-3 col-6">
            <div class="card dashboard calc">
              <div class="card-body dashboard" align="center">
                <h1>
                  {{Auth::user()->count_calc}} 
                </h1> 

                <p>
                  <b>
                    Total <br class="mobile-break">
                    History Influencer
                  </b>
                </p>

                <hr>

                <a href="">
                  View Details &raquo;
                </a>
              </div>
            </div>
          </div>
          
          <div class="col-md-3 col-6">
            <a href="{{url('pricing')}}">
              <button class="btn btn-primary btn-upgrade <?php if(Auth::user()->membership=='free') echo 'd-block' ?>">
                Upgrade To Pro
              </button>
            </a>

            <div class="card dashboard <?php if(Auth::user()->membership=='free') echo 'forbid' ?> group">
              <div class="card-body dashboard" align="center">
                <h1>
                  {{Auth::user()->count_calc}} 
                </h1> 

                <p>
                  <b>
                    Total <br class="mobile-break">
                    Group
                  </b>
                </p>

                <hr>

                <a href="">
                  View Details &raquo;
                </a>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-6">
            <div class="card dashboard pdf">
              <div class="card-body dashboard" align="center">
                <h1>
                  {{Auth::user()->count_pdf}}
                </h1>

                <p>
                  <b>
                    Total <br class="mobile-break">
                    Save as PDF
                  </b>
                </p>

                <hr>

                <a href="">
                  View Details &raquo;
                </a>

              </div>
            </div>
          </div>

          <div class="col-md-3 col-6">

            <a href="{{url('pricing')}}">
              <button class="btn btn-primary btn-upgrade <?php if(Auth::user()->membership!='premium') echo 'd-block' ?>">
                <?php  
                  if(Auth::user()->membership=='free'){
                    echo 'Upgrade To Pro';
                  } else if(Auth::user()->membership=='pro'){
                    echo 'Upgrade To Premium';
                  }
                ?>
              </button>  
            </a>
            
            <div class="card dashboard <?php if(Auth::user()->membership!='premium') echo 'forbid' ?> csv">
              <div class="card-body dashboard" align="center">
                <h1>
                  {{Auth::user()->count_csv}}
                </h1>

                <p>
                  <b>
                    Total <br class="mobile-break">
                    Save As Excel
                  </b>
                </p>

                <hr>

                <a href="">
                  View Details &raquo;
                </a>

              </div>
            </div>
          </div>
        </div>
      @else 
        You are logged in!
      @endif
    </div>
  </div>
</div>
@endsection