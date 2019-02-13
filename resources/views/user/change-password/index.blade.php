@extends('layouts.dashboard')

@section('content')
<script type="text/javascript">
  $(document).ready(function() {
    
  });

  $( "body" ).on( "click", "#btn-edit", function() {
    change_password();
  });

  function change_password(){
    $.ajax({
      type : 'POST',
      url : "<?php echo url('/change-password/change') ?>",
      data: $('form').serialize(),
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
          $('#pesan').html(data.message);
          $('#pesan').removeClass('alert-warning');
          $('#pesan').addClass('alert-success');
          $('#pesan').show();
        } else {
          $('#pesan').html(data.message);
          $('#pesan').removeClass('alert-success');
          $('#pesan').addClass('alert-warning');
          $('#pesan').show();
        }
      }
    });  
  }

</script>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <div class="col-md-12">

        <div class="row">
          <div class="col-md-8 col-6">
            <h2><b>Change Password</b></h2>
          </div>  

          <div class="col-md-4 col-6" align="right">
            <a href="{{url('/')}}">
              <button class="btn btn-sm btn-primary btn-search-more">
                Search More &raquo;
              </button>
            </a>
          </div>
        </div>

        <h5>
          Change your old password to the new password
        </h5>
        
        <hr>
      </div>

      <div class="alert" id="pesan"></div>

      <form enctype="multipart/form-data" id="form-edit">
        @csrf

        <div class="form-group">
          <label class="col-sm-4 col-form-label">
            Enter new password
          </label>

          <div class="col-md-6">
            <input id="password" type="password" class="form-control" name="password">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4 col-form-label">
            Confirm new password
          </label>

          <div class="col-md-6">
            <input id="confirm" type="password" class="form-control" name="confirm">
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-md-12">
            <button type="button" class="btn btn-primary" id="btn-edit">
              Update Password
            </button>      
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection