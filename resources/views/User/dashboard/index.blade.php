@extends('layouts.dashboard')

@section('content')
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