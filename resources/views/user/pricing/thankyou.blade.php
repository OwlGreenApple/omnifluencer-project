@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-thankyou.css') }}" rel="stylesheet">

<section class="page-title">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1>Thank You For Your Purchasing</h1>
          <hr class="orn">
          <p class="pg-title">
          Setelah Anda menyelesaikan langkah-langkah konfirmasi ini, segera lakukan pembayaran untuk mendapatkan akses langsung ke akun Omnifluencer Anda!
          </p>
        </div>
      </div>
    </div>
  </section>

  <div class="container konten text-center">
    <div class="offset-sm-2 col-sm-8">
      <div class="card h-80 card-payment">
        <div class="card-body">
          <p class="card-text">
            Silahkan melakukan Transfer Bank ke
          </p> 
          <h2>8290981477</h2>
          <p class="card-text">
            BCA <b>Rizky Redjosoewignjo</b>
          </p>
          <p class="card-text">
            Setelah Transfer, silahkan Klik tombol konfirmasi di bawah ini <br> atau Email bukti Transfer anda ke <b>omnifluencer@gmail.com</b> <br>
            Admin kami akan membantu anda max 1x24 jam
          </p>

          <a href="{{url('billing')}}">
            <button class="btn btn-success" style="font-size: 19px;padding: 10px 30px;">
              KONFIRMASI TRANSFER BANK
            </button>
          </a>
        </div>
      </div>  
    </div>
  
    <br>

    <div class="row">
      <div class="col-sm-4">
        <div class="card h-80">
          <div class="card-body">
            <span style="font-size: 48px; color: Dodgerblue;"><i class="fas fa-envelope-open-text"></i></span>
            <h5 class="card-title">Check Your Email</h5>
            <p class="card-text">Terima Kasih telah memilih Omnifluencer. Cek pesan di inbox email yang telah anda daftarkan.</p>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card h-80">
          <div class="card-body">
            <span style="font-size: 48px; color: Dodgerblue;"><i class="fas fa-search"></i></span>
            <h5 class="card-title">Find Our Email</h5>
            <p class="card-text">Temukan email yang dikirim oleh Omnifluencer mengenai konfirmasi pembayaran.</p>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card h-80">
          <div class="card-body">
            <span style="font-size: 48px; color: Dodgerblue;"><i class="far fa-credit-card"></i></span>
            <h5 class="card-title">Payment</h5>
            <p class="card-text">Buka email tersebut dan lakukan pembayaran. Klik link di dalamnya untuk konfirmasi pembayaran anda. Selesai!</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
