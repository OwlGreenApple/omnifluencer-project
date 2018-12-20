@extends('layouts.dashboard')

@section('content')
<style type="text/css">
  .card {
    box-shadow: 0 1px 5px 0 rgba(183,183,183,0.50);
    height: 220px;
  }

  .card-body {
    padding-top: 35px;
  }

  .card-header > h5 {
    padding-top: 10px; 
    font-size: 20px;
    font-weight: 600;
  }

  .calc{
    background-image: linear-gradient(-135deg, #8688EA 0%, #686BE1 100%);
    color: #fff;
  }

  .pdf {
    background-image: linear-gradient(-135deg, #EF6363 0%, #F72D37 100%);
    color: #fff;
  }

  .csv {
    background-image: linear-gradient(-140deg, #25B7B2 0%, #3B9893 100%);
    color: #fff;
  }

  h1 {
    font-size: 60px;
    font-weight: 700;
  }
  sub {
    top: -0.1em;
    font-size: 18px;
    font-weight: 300;
  }
</style>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <div class="row">
        <div class="col-md-9">
          <h2><b>Dashboard</b></h2>
          <h5>
            Welcome to Omnifluencer!
          </h5>    
        </div>  

        <div class="col-md-3" align="right">
          <h5>
            {{ date("l, d F Y")  }}
          </h5>
        </div>
      </div>
      
      <hr>
      
      <br>

      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header calc">
              <h5>Total Calculates</h5>
            </div>
            <div class="card-body" align="center">
              <h1>
                {{Auth::user()->count_calc}} 
                <sub>times</sub>
              </h1> 
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="card">
            <div class="card-header pdf">
              <h5>Total Save As PDF</h5>
            </div>
            <div class="card-body" align="center">
              <h1>
                {{Auth::user()->count_pdf}}
                <sub>times</sub>
              </h1>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-header csv">
              <h5>Total Save As CSV</h5> 
            </div>
            <div class="card-body" align="center">
              <h1>
                {{Auth::user()->count_csv}}
                <sub>times</sub>
              </h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection