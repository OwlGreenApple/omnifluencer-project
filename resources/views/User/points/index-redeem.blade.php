@extends('layouts.dashboard')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body card-point">
          <img src="https://via.placeholder.com/350x50">
          
          <div class="info-point">
            <h4><b>Nama Paket</b></h4> 
            Ketentuan
            <hr>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <h4><b>Detail Kupon</b></h4>

      <div class="card">
        <div class="card-body">
          Point saya : {{Auth::user()->point}}
          <br>
          <button class="btn btn-primary btn-block">
            Redeem
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection