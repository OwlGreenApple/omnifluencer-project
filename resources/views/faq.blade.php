@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-faq.css') }}" rel="stylesheet">

  <section class="page-title">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1>Omnifluencer FAQ Page</h1>
          <hr class="orn">
          <p class="pg-title">Berikut ini serangkaian pertanyaan umum terkait Omnifluencer. Mohon baca di sini sebelum menghubungi customer service dan Anda akan menghemat banyak waktu </p>
        </div>
      </div>
    </div>
  </section>

  <div class="container bg-gray" id="accordion-style-1">
    <div class="container">
      <section>
        <div class="row">
          <div class="col-lg-6 col-md-12 col-sm-12 mx-auto">
            <div class="accordion" id="accordionExample">
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <span class="main">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="overflow-wrap">Apa itu Omnifluencer?</span>
                    </button>
                  </h5>
                </div>

                <div id="collapseOne" class="collapse show fade" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <p>
                      Omnifluencer adalah tools untuk mengukur engagement rate akun Instagram. Dengan begitu Anda akan membantu memilih influencer yang akan diajak kerjasama.
                      <!--<a href="#" class="ml-3" target="_blank"><strong>View More designs <i class="fa fa-angle-double-right"></i></strong></a>-->
                    </p>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      <span class="main">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="overflow-wrap">Siapa Pengguna Omnifluencer?</span>
                    </button>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse fade" aria-labelledby="headingTwo" data-parent="#accordionExample">
                  <div class="card-body">
                    <p>
                      Omnifluencer cocok untuk siapapun Anda yang menekuni dunia periklanan, endorse, dan Instagram.
                    </p>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingThree">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      <span class="main">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="overflow-wrap">Bagaimana Jika Ingin Bekerjasama dengan Omnifluencer? </span>
                    </button>
                  </h5>
                </div>
                <div id="collapseThree" class="collapse fade" aria-labelledby="headingThree" data-parent="#accordionExample">
                  <div class="card-body">
                    <p>
                      Hubungi support@omnifluencer.com untuk informasi lebih lanjut
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 col-sm-12 mx-auto">
            <div class="accordion" id="accordionExample2">
              <div class="card">
                <div class="card-header" id="headingFive">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                      <span class="main">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="overflow-wrap">Bagaimana cara menggunakan Omnifluencer?</span>
                    </button>
                  </h5>
                </div>

                <div id="collapseFive" class="collapse fade" aria-labelledby="headingFive" data-parent="#accordionExample2">
                  <div class="card-body">
                    <p>
                      - Ketik username influencer, klik kalkulasi <br>
                      - Anda bisa membandingkan 4 akun username <br>
                      - Lakukan Sign Up untuk bisa mengeksplor Omnifluencer
                    </p>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingSix">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                      <span class="main">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="overflow-wrap">Apa saja yang bisa dilakukan di Omnifluencer?</span>
                    </button>
                  </h5>
                </div>
                <div id="collapseSix" class="collapse fade" aria-labelledby="headingSix" data-parent="#accordionExample2">
                  <div class="card-body">
                    <p>
                      - Anda bisa melakukan analisa influencer seperti memonitor post following follower, dan engagement ratenya. <br>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
@endsection
