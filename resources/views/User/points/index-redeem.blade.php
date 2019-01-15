@extends('layouts.dashboard')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body card-point">
          <img src="https://via.placeholder.com/350x50">
          
          <div class="info-point">
            <h4><b>{{$namapaket}}</b></h4> 
            Ketentuan
            <hr>

            @switch($idpoint)
              @case(1)
                1. Berlaku satu bulan terhitung sekarang<br>
                2. Medapatkan benefit

              @break
              @case(2)
                1. Berlaku satu bulan terhitung sekarang<br>
                2. Medapatkan benefit
              @break
              @case(3)
                1. Berlaku satu bulan terhitung sekarang<br>
                2. Medapatkan benefit
              @break
              @case(4)
                1. Berlaku satu bulan terhitung sekarang<br>
                2. Medapatkan benefit
              @break
            @endswitch

          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <h4><b>Detail Kupon</b></h4>

      <div class="card">
        <div class="card-body">
          <h5><b>{{$point}} Points</b></h5>
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