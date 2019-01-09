@extends('layouts.app')

@section('content')
<script type="text/javascript">
  $(document).ready(function() {
    refresh_page();
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });
  });

  $( "body" ).on( "click", ".btn-search", function() {
    refresh_page();
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
    <?php } ?>
  });

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
          $('#pesan').hide();
          $('.content-akun').html(data.view);
          load_history();
        } else {
          if(data.message=='kuota habis'){
            $('#info-kuota').modal('show');
          } else {
            $('#pesan').html(data.message);
            $('#pesan').removeClass('alert-success');
            $('#pesan').addClass('alert-warning');
            $('#pesan').show();
          }
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
        console.log(data.count);
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

</script>

<style type="text/css">
  
</style>

<section class="page-title">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Influencer Engagement Rate</h1>
        <hr class="orn">
        <p class="pg-title">If you are in the market for a computer, there are a number of factors to consider. Will it be used for your home, your office or perhaps even your home office combo? </p>
      </div>
    </div>
  </div>
</section>

<hr class="wh">

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="col-12">
          <div class="history justify-content-center">
            <h3>Enter Instagram username<br>and tap Enter!</h3>
            <form class="form-inline d-flex justify-content-center" action="/action_page.php">
              @csrf 
              <div class="form-group">
                <input type="text" class="form-control" id="keywords" placeholder="@username" name="username">
              </div>
              <button type="button" class="btn btn-default btn-sbmt grads btn-search">
                <span>Calculate</span>
              </button>
            </form>
          </div>
        </div>
          
        <div class="col-12">
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
          We analysed 100,000+<br>influencer profiles<br>on Instagram
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
        <p class="pg-title-btm">As soon as Computerized Tomography or CT scans became accessible in the 1970s, they reformed the practice of neurology. They did the scans by transmitting x-ray streams all the way through the head at different positions and accumulating the x-ray streams on the other side that was not absorbed by the head.</p>
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
        <p class="pg-title">If you are in the market for a computer, there are a number of factors to consider.</p>
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
  
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <button type="submit" class="btn btn-default btn-sbmt-btm grads" data-toggle="modal" data-target=".bd-example-modal-lg" data-whatever="join"><span>JOIN NOW!</span></button>
      </div>
    </div>
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
              <form method="POST" id="signup-form" class="signup-form">
                <h2 class="form-title">Create an Omnifluencer<br>account within a minutes</h2>
                <div class="form-group form-group-mob">
                  <label class="label-title-test" for="formGroupExampleInput">
                    Masukkan Nama Lengkap:
                  </label>
                  <input type="text" class="form-input" name="name" id="name" placeholder="Your Full Name" />
                </div>
                <div class="form-group form-group-mob">
                  <label class="label-title-test" for="formGroupExampleInput">
                    Masukkan Email:
                  </label>
                  <input type="email" class="form-input" name="email" placeholder="Your Email" />
                </div>
                <div class="form-group form-group-mob">
                  <label class="label-title-test" for="formGroupExampleInput">
                    Masukkan Password:
                  </label>
                  <input type="password" class="form-input" name="password" id="password" placeholder="Password" />
                  <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                </div>
                <div class="form-group form-group-mob">
                  <label class="label-title-test" for="formGroupExampleInput">
                    Konfirmasi Password:
                  </label>
                  <input type="password" class="form-input" name="re_password" id="re_password" placeholder="Confirm your password" />
                </div>
                <div class="form-group form-group-mob">
                  <label for="agree-term" class="label-agree-term"><span><span></span></span>Dengan mendaftar, saya setuju dengan <a href="#" class="term-service">Terms of service</a></label>
                </div>
                <div class="form-group form-group-mob">
                  <input type="submit" name="submit" id="submit" class="form-submit pointer" value="Sign up" />
                </div>
              </form>
              <p class="loginhere">
                Have already an account ? <a href="#" class="loginhere-link">Sign In Here</a>
              </p>
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
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body bg-kuota">
        Kuota telah habis. <br>
        Silahkan Sign up untuk melanjutkan.
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

          <!-- Modal Delete -->
          <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalTitle">Delete Confirmation</h5>
                  <button type="button" class="btn btn-link close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                  <button type="button" class="btn btn-danger dangcust" data-dismiss="modal">Delete</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End Modal Delete -->
@endsection