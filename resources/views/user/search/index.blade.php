@extends('layouts.app')

@section('content')
<script type="text/javascript">
  var currentHistory;

  $(document).ready(function() {
    refresh_page();
  });

   jQuery(document).ready(function($) {
            $('.counter').counterUp();
        });

  $( "body" ).on( "click", ".btn-search", function(e) {
    <?php if(!Auth::check()) { ?>
      if(currentHistory>=3){
        e.preventDefault();
        $('#info-kuota').modal('show');
      } else {
        if($('#keywords').val()!=''){
          refresh_page();
        }
      }
    <?php } else { ?>
      if($('#keywords').val()!=''){
        refresh_page();
      }
    <?php } ?>
  });

  $( "body" ).on( "click", ".username-history", function(e) 
  {
    var id = $(this).attr('data-id');
    search_byid(id);
    
  });

  $( "body" ).on( "click", ".register-link", function(e) 
  {
    e.preventDefault();
    $('.signup-content').show();
    $('.login-content').hide();
  });

  $( "body" ).on( "click", ".loginhere-link", function(e)
  {
    e.preventDefault();
    $('.signup-content').hide();
    $('.login-content').show();
  });

  $( "body" ).on( "click", ".btn-delete", function() {
    $('#id_delete').val($(this).attr('data-id'));
  });

  $( "body" ).on( "click", "#btn-delete-ok", function() {
    delete_history();
  });

  $( "body" ).on( "click", ".btn-compare", function(e) {
    <?php if(!Auth::check()) { ?>
      e.preventDefault();
      $('#info-kuota').modal('show');
    <?php } else { ?>
      if(check_id()){
        check_compare();
      } else {
        $('#message').html('Pilih akun terlebih dahulu');
        $('#modal-pesan').modal('show');
      }
    <?php } ?>
  });

  function check_id(){
    if ($(".boxcompare:checked").length > 0){
      return true;
    } else {
      return false;
    }
  }

  function load_search(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/search/load-search') ?>",
      data: {
        keywords : $('#keywords').val(),
      },
      dataType: 'text',
      beforeSend: function()
      {
        $('#loader').show();
        $('.div-loading').addClass('background-load');
      },
      success: function(result) {
        $('#loader').hide();
        $('.div-loading').removeClass('background-load');

        var data = jQuery.parseJSON(result);

        if(data.status == 'success'){
          $('.content-akun').html(data.view);
          $('.counter').counterUp({
            delay: 10,
            time: 1000,
            formatter: function (n) {
              return Math.round(n * 100) / 100;
            }
          });

          /*$('.progress.blue .progress-left .progress-bar').waypoint(function() {
            // $('.progress.blue .progress-left .progress-bar').css({
              // animation: "loading-1 0.6s linear forwards 0.6s",
              // opacity: "1"
            // });
            console.log("asd");
            }, { offset: '100%' }
          );*/
          
          /*$('.progress .progress-right .progress-bar').waypoint(function() {
            // $('.progress .progress-right .progress-bar').css({
              // animation: "loading-1 0.5s linear forwards",
              // opacity: "1"
            // });
            console.log("www");
            }, { offset: '100%' }
          );*/

          load_history();
        } else {
          if(data.message=='kuota habis'){
            $('#info-kuota').modal('show');
          } else {
            $('#message').html(data.message);
            $('#modal-pesan').modal('show');
          }
        }
      }
    });
  }

  function search_byid(id){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/search/load-search-byid') ?>",
      data: {
        id : id,
      },
      dataType: 'text',
      beforeSend: function()
      {
        $('#loader').show();
        $('.div-loading').addClass('background-load');
      },
      success: function(result) {
        $('#loader').hide();
        $('.div-loading').removeClass('background-load');

        var data = jQuery.parseJSON(result);

        if(data.status == 'success'){
          $('.content-akun').html(data.view);
          $('.counter').counterUp({
            delay: 10,
            time: 1000,
            formatter: function (n) {
              return Math.round(n * 100) / 100;
            }
          });
        }
      }
    });
  }

  function load_history(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/search/load-history') ?>",
      data: {
        keywords : $('#keywords').val(),
      },
      dataType: 'text',
      beforeSend: function()
      {
        $('#loader').show();
        $('.div-loading').addClass('background-load');
      },
      success: function(result) {
        $('#loader').hide();
        $('.div-loading').removeClass('background-load');

        var data = jQuery.parseJSON(result);
        $('#content-history').html(data.view);
        currentHistory = data.count;
        
        if(data.count>=2){
          $('.boxcompare').show();
          $('.btn-compare').show();
        }

        if(data.count>5){
          $('#link-show').show();
        }
      }
    });
  }

  function refresh_page(){
    load_search();
  }

  function delete_history(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/search/delete-history') ?>",
      data: {
        id : $('#id_delete').val(),
      },
      dataType: 'text',
      beforeSend: function()
      {
        $('#loader').show();
        $('.div-loading').addClass('background-load');
      },
      success: function(result) {
        $('#loader').hide();
        $('.div-loading').removeClass('background-load');

        var data = jQuery.parseJSON(result);

        if(data.status=='success'){
          refresh_page();
        } else {
          if(data.message=='kuota habis'){
            $('#info-kuota').modal('show');
          }
        }
      }
    });
  }

  function check_compare(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/compare/check') ?>",
      data: $('.form-compare').serialize(),
      dataType: 'text',
      beforeSend: function()
      {
        $('#loader').show();
        $('.div-loading').addClass('background-load');
      },
      success: function(result) {
        $('#loader').hide();
        $('.div-loading').removeClass('background-load');

        var data = jQuery.parseJSON(result);

        if(data.status=='success'){
          // refresh_page();
          window.location.href = "<?php echo url('compare'); ?>/"+data.message;
        } else {
          $('#message').html(data.message);
          $('#modal-pesan').modal('show');
        }
      }
    });
  }

</script>

<style type="text/css">
  .bigModal{
    height: 430px;
  }
</style>

@if (session('error') )
  <div class="col-md-12 alert alert-danger">
    <strong>Warning!</strong> {{session('error')}}
  </div>
@endif
@if (session('success') )
  <div class="col-md-12 alert alert-success">
    <strong>Success!</strong> {{session('success')}}
  </div>
@endif

<section class="page-title">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Influencer Engagement Rate</h1>
        <hr class="orn">
        <p class="pg-title">Dapatkan analisa akun Instagram Anda. Lengkap dengan Kalkulasi engagement, likes & komentar per post. </p>
      </div>
    </div>
  </div>
</section>

<hr class="wh">

<section class="content">
  <div class="container">
    
    <!--<div id="pesan" class="alert"></div>-->

    <div class="row">
      <div class="col-12 col-md-6">

        <div class="col-12">

          <div class="history justify-content-center">
            <h3>Enter Instagram username<br>and tap Enter!</h3>
            <form class="form-inline d-flex justify-content-center" action="/action_page.php">
              @csrf 
              <div class="form-group">
                <input type="text" class="form-control" id="keywords" placeholder="username" name="username" value="{{$keywords}}">
              </div>
              <button type="button" class="btn btn-default btn-sbmt grads btn-search">
                <span>Calculate</span>
              </button>
            </form>
          </div>
        </div>
          
        <div class="col-12" id="div-progress">
          <div class="history justify-content-center">

            <div class="col-12 col-md-6 d-sm-block d-md-none content-akun"></div>

            <div id="content-history"></div>
            
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 d-none d-sm-none d-md-block content-akun"></div>
    </div>
</section>

<hr class="wh">

<section class="meter">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-sm-12 percent-title">
        <h1>
          Omnifluencer telah menganalisa 
          100.000+ Influencer
          di Instagram
        </h1>
      </div>
      <div class="col-lg-7 col-sm-12 percent">
        <div class="row d-flex flex-wrap justify-content-end">
          <div class="card w-20">
            <h5 class="card-header"><i class="fas fa-less-than fa-xs"></i>&nbsp;1.000 <p>followers</p>
            </h5>
            <div class="card-body">
              <h3 class="card-title">9%</h3>
            </div>
          </div>
          <div class="card w-20">
            <h5 class="card-header"><i class="fas fa-less-than fa-xs"></i>&nbsp;5.000 <p>followers</p>
            </h5>
            <div class="card-body">
              <h3 class="card-title">6,3%</h3>
            </div>
          </div>
          <div class="card w-20">
            <h5 class="card-header"><i class="fas fa-less-than fa-xs"></i>&nbsp;10.000 <p>followers</p>
            </h5>
            <div class="card-body">
              <h3 class="card-title">4,7%</h3>
            </div>
          </div>
          <div class="card w-20">
            <h5 class="card-header"><i class="fas fa-less-than fa-xs"></i>&nbsp;100.000 <p>followers</p>
            </h5>
            <div class="card-body">
              <h3 class="card-title">1,6%</h3>
            </div>
          </div>
          <div class="card w-20">
            <h5 class="card-header">100.000+ <p>followers</p>
            </h5>
            <div class="card-body">
              <h3 class="card-title">1,1%</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <p class="pg-title-btm">Penilaian di atas hanya berdasarkan perkiraan. Perkiraan ini dikompilasi setelah mengumpulkan data survei verbal, pendapat dari pakar industri dan data patokan dari Tim Omnifluencer. Tim Omnifluencer tidak memiliki preferensi atau pendapat kuat tentang topik khusus ini - melainkan menyediakan alat ukur untuk perbandingan yang adil.
        </p>
      </div>
    </div>
    <hr class="orn">
  </div>
</section>

<section class="join">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Join Our Community<br>Right Now!</h1>
        <p class="pg-title">Gabung bersama komunitas Omnifluencer</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="col d-flex justify-content-center imgthmb">
          <div class="photos-thumb">
            <img class="mx-auto d-block" src="{{asset('design/thumb-sm-btm-01.png')}}" />
          </div>
          <div class="photos-thumb">
            <img class="mx-auto d-block" src="{{asset('design/thumb-sm-btm-02.png')}}" />
          </div>
          <div class="photos-thumb">
            <img class="mx-auto d-block" src="{{asset('design/thumb-sm-btm-03.png')}}" />
          </div>
          <div class="photos-thumb">
            <img class="mx-auto d-block" src="{{asset('design/thumb-sm-btm-04.png')}}" />
            </div>
          <div class="photos-thumb">
            <img class="mx-auto d-block" src="{{asset('design/thumb-sm-btm-05.png')}}" />
          </div>
          <div class="photos-thumb">
            <img class="mx-auto d-block" src="{{asset('design/thumb-sm-btm-06.png')}}" />
          </div>
        </div>
      </div>
    </div>
    
    @guest
      <div class="row">
        <div class="col-12 d-flex justify-content-center">
          <button type="submit" class="btn btn-default btn-sbmt-btm grads" data-toggle="modal" data-target=".bd-example-modal-lg" data-whatever="join"><span>JOIN NOW!</span></button>
        </div>
      </div>
    @endguest

  </div>
</section>

<!-- Modal Join -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content modal-content-join">
      <div class="row">
        <div class="col-lg-5 d-none d-sm-none d-md-block">
        </div>
        <div class="col-lg-7 col-md-12 col-sm-12">
          <div class="modal-body modal-body-form">
            <div class="signup-content">
              <form method="POST" action="{{url('post-register')}}" class="signup-form">
                @csrf
                <h2 class="form-title">Create an Omnifluencer<br>account within a minutes</h2>

                <input type="hidden" name="price" value="<?php if (isset ($price)) {echo $price;} ?>">
                <input type="hidden" name="namapaket" value="<?php if (isset($namapaket)) {echo $namapaket;} ?>">

                <div class="form-group form-group-mob">
                  <label class="label-title-test" for="name">
                    Masukkan Nama Lengkap:
                  </label>
                  <input type="text" class="form-input{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" name="name" id="name" placeholder="Your Full Name" required autofocus />

                  @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group form-group-mob">
                  <label class="label-title-test" for="email">
                    Masukkan Email:
                  </label>
                  <input type="email" class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" name="email" placeholder="Your Email" required/>

                  @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group form-group-mob">
                  <label class="label-title-test" for="password">
                    Masukkan Password:
                  </label>

                  <input type="password" class="form-input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required />
                  <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>

                  @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group form-group-mob">
                  <label class="label-title-test" for="password-confirm">
                    Konfirmasi Password:
                  </label>
                  <input type="password" class="form-input" name="password_confirmation" id="password-confirm" placeholder="Confirm your password" required/>
                </div>

                <div class="form-group">
                  <label class="label-title-test" for="gender">
                    Gender:
                  </label>

                  <label class="radio-inline col-md-3">
                    <input type="radio" name="gender" value="1" checked> Male
                  </label>

                  <label class="radio-inline col-md-4">
                    <input type="radio" name="gender" value="0"> Female
                  </label>
                </div>

                <div class="form-group form-group-mob">
                  <label for="agree-term" class="label-agree-term"><span><span></span></span>Dengan mendaftar, saya setuju dengan <a href="#" class="term-service">Terms of service</a></label>
                </div>
                <div class="form-group form-group-mob">
                  <input type="submit" name="submit" id="submit" class="form-submit pointer" value="Sign up" />
                </div>
              </form>
              <p class="loginhere">
                Have already an account ? <a href="{{url('login')}}" class="loginhere-link">Sign In Here</a>
              </p>
            </div>

            <div class="login-content">
              <form method="POST" class="signup-form" action="{{ route('login') }}">
                @csrf

                <h2 class="form-title">Please input your<br>Email & Password</h2>

                <div class="form-group">
                  <label for="email" class="label-title-test">  Masukkan Email:
                  </label>
                  <input type="email" class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }} " name="email" value="{{ old('email') }}" placeholder="Your Email" required autofocus>

                  @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label class="label-title-test" for="password">Masukkan Password:</label>

                  <input type="password" class="form-input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                  <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>

                  @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group form-group-mob">
                    <button type="submit" class="btn btn-primary form-submit pointer">
                      Sign In
                    </button>

                    @if (Route::has('password.request'))
                      <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                      </a>
                    @endif
                </div>

                <p class="loginhere">
                  Don't have an account ? <a href="#" class="register-link">Sign Up here</a>
                </p>
              </form>
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
        Are you sure you want to delete?
        <input type="hidden" name="id_delete" id="id_delete">
      </div>
      <div class="modal-footer" id="foot">
        <button class="btn btn-primary" id="btn-delete-ok" data-dismiss="modal">
          Yes
        </button>
        <button class="btn" data-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
      
  </div>
</div>

<!-- Modal Info Kuota -->
<div class="modal fade" id="info-kuota" role="dialog" >
  <div class="modal-dialog modal-lg">
    
    <!-- Modal content-->
    <div class="modal-content bigModal">
      <div class="modal-body bg-kuota" align="left">
        <span class="kuota-txt mr-auto">
          Kuota telah habis. <br>
          Silahkan Sign up untuk <br> melanjutkan.
        </span>
      </div>
      <div class="modal-footer" id="foot">
        <a class="mr-auto" href="{{url('login')}}">
          <button class="btn btn-primary">
            LOG IN
          </button>
        </a>
  
        <a href="{{url('register')}}">
          <button class="btn btn-primary">
            SIGN UP
          </button>
        </a>
      </div>
    </div>
      
  </div>
</div>
@endsection