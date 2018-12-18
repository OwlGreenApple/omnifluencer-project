@extends('layouts.app')

@section('content')
<script type="text/javascript">
  $(document).ready(function() {
    
  });

  $( "body" ).on( "click", "#btn-edit", function() {
    edit_profile();
  });

  $( "body" ).on( "click", "#btn-upload-profpic", function() {
    $('#fileprofpic').trigger('click');
  });

  $(document).on('change', "#fileprofpic", function (e) {
    readURL(this);
  });

  function edit_profile(){
    var form = $('#form-edit')[0];
    var formData = new FormData(form);

    $.ajax({
      type : 'POST',
      url : "<?php echo url('/edit-profile/edit') ?>",
      data: formData,
      //data: $('form').serialize(),
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function()
      {
        $('#loader').show();
        $('.div-loading').addClass('background-load');
      },
      success: function(result) {
        $('#loader').hide();
        $('.div-loading').removeClass('background-load');

        //var data = jQuery.parseJSON(result);
        
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

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
            
      reader.onload = function (e) {
        $('#profpic').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="alert" id="pesan"></div>

      <div class="card">
        <div class="card-header">Edit Profile</div>

        <div class="card-body">
          <?php if(is_null($user->profpic)) { 
                  $src = asset('/design/profpic-user.png');
                } else {
                  $src = $user->profpic;
                }
          ?>
          <img id="profpic" class="profpic img-img" src="<?php echo $src ?>" altSrc="{{asset('/design/profpic-user.png')}}" onerror="this.src = $(this).attr('altSrc')" style="cursor: pointer; max-width: 100px; border-radius: 50%;">  

          <button class="btn btn-primary" id="btn-upload-profpic">
            Upload new picture
          </button>
          <button class="btn btn-danger">
            Delete
          </button>

          <form enctype="multipart/form-data" id="form-edit">
            @csrf

            <input type="file" name="fileprofpic" id="fileprofpic" accept="image/*" style="display:none">

            <div class="form-group">
              <label class="col-sm-4 col-form-label">
                Full Name
              </label>

              <div class="col-md-6">
                <input id="fullname" type="text" class="form-control" name="fullname" value="{{$user->name}}">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 col-form-label">
                Username
              </label>

              <div class="col-md-6">
                <input id="username" type="text" class="form-control" name="username" value="{{$user->username}}">
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-4 col-form-label">
                Email
              </label>

              <div class="col-md-6">
                <input id="email" type="text" class="form-control" name="email" value="{{$user->email}}">
              </div>
            </div>
          </form>

          <button type="button" class="btn btn-primary" id="btn-edit">
            Update Profile
          </button>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection