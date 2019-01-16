@extends('layouts.dashboard')

@section('content')
<script type="text/javascript">
  $( "body" ).on( "click", "#btn-edit", function() {
    edit_profile();
  });

  $( "body" ).on( "click", "#btn-upload-profpic", function() {
    $('#fileprofpic').trigger('click');
  });

  $( "body" ).on( "click", "#btn-delete-ok", function() {
    delete_photo();
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
      success: function(data) {
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

  function delete_photo(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/edit-profile/delete-photo') ?>",
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

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">

      <h2><b>Edit Profile</b></h2>
      <h5>
        Edit your personal data
      </h5>
      <hr>

      <div class="alert" id="pesan"></div>

      <?php 
        if(is_null($user->profpic)) { 
          $src = asset('/design/profpic-user.png');
        } else {
          $src = $user->profpic;
        }

        $profpic = null;

        if(Auth::user()->prof_pic!=null){
          $profpic = Storage::url(Auth::user()->prof_pic);
        }
      ?>

      <div class="row">
        <div class="col-md-2 col-12 mb-20" align="center">
          <img id="profpic" class="profpic img-img" src="<?php echo $profpic ?>" altSrc="{{asset('/design/profpic-user.png')}}" onerror="this.src = $(this).attr('altSrc')" style="cursor: pointer; max-width: 100px; border-radius: 50%;">  
        </div>

        <div class="col-md-9 col-12 center-mobile mb-20">
          <button class="btn btn-primary" id="btn-upload-profpic" style="margin-right: 5px;">
            Upload new picture
          </button>
          <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete">
            Delete
          </button>          
        </div>
      </div>

      <form enctype="multipart/form-data" id="form-edit">
        @csrf

        <input type="file" name="fileprofpic" id="fileprofpic" accept="image/*" style="display:none">

        <div class="form-group">
          <label class="col-sm-4 col-form-label">
            Full Name
          </label>

          <div class="col-md-11">
            <input id="fullname" type="text" class="form-control" name="fullname" value="{{$user->name}}">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4 col-form-label">
            Username
          </label>

          <div class="col-md-11">
            <input id="username" type="text" class="form-control" name="username" value="{{$user->username}}">
          </div>
        </div>
            
        <div class="form-group">
          <label class="col-sm-4 col-form-label">
            Email
          </label>

          <div class="col-md-11">
            <input id="email" type="text" class="form-control" name="email" value="{{$user->email}}">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4 col-form-label">
            Logo
          </label>

          <div class="col-md-11">
            <input type="file" class="form-control" name="filelogo" id="filelogo" accept="image/*">
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-12">
            <button type="button" class="btn btn-primary" id="btn-edit">
              Update Profile
            </button>
          </div>
        </div>
      </form>
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
        Delete your profile picture?
      </div>
      <div class="modal-footer" id="foot">
        <button class="btn btn-danger" id="btn-delete-ok" data-dismiss="modal">
          Delete
        </button>
        <button class="btn" data-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
      
  </div>
</div>
@endsection