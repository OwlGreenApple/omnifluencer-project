@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <div class="row">
        <div class="col-md-8">
          <h2><b>Dashboard</b></h2>
          <h5>
            Welcome to Omnifluencer!
          </h5>    
        </div>  

        <div class="col-md-4" align="right">
          <h5>
            {{ date("l, d F Y")  }}
          </h5>
        </div>
      </div>
      
      <hr>
      
      <br>

      @if(Auth::user()->is_admin==0)
        <div class="row">
          <div class="col-md-4">
            <div class="card dashboard">
              <div class="card-header calc">
                <h5>Total Calculates</h5>
              </div>
              <div class="card-body dashboard" align="center">
                <h1>
                  {{Auth::user()->count_calc}} 
                  <sub>times</sub>
                </h1> 
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <a href="{{url('pricing')}}">
              <button class="btn btn-primary btn-upgrade <?php if(Auth::user()->membership=='free') echo 'd-block' ?>">
                Upgrade To Pro
              </button>
            </a>

            <div class="card dashboard <?php if(Auth::user()->membership=='free') echo 'save-pdf' ?>">
              <div class="card-header pdf">
                <h5>Total Save As PDF</h5>
              </div>
              <div class="card-body dashboard" align="center">
                <h1>
                  {{Auth::user()->count_pdf}}
                  <sub>times</sub>
                </h1>
              </div>
            </div>
          </div>

          <div class="col-md-4">

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
            
            <div class="card dashboard <?php if(Auth::user()->membership!='premium') echo 'save-csv' ?>">
              <div class="card-header csv">
                <h5>Total Save As Excel</h5> 
              </div>
              <div class="card-body dashboard" align="center">
                <h1>
                  {{Auth::user()->count_csv}}
                  <sub>times</sub>
                </h1>
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