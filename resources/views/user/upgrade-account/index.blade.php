@extends('layouts.dashboard')

@section('content')
<script type="text/javascript">
  
</script>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <div class="col-md-12">

        <div class="row">
          <form class="form-inline col-md-12 mb-2" action="{{url('search')}}" method="POST">
            @csrf
            
            <label class="mr-sm-2 pb-md-2 label-calculate" for="calculate">
              Calculate More
            </label>

            <input id="calculate" type="text" class="form-control form-control-sm mb-2 mr-sm-2 mr-2 col-md-3 col-9" name="keywords" placeholder="Enter Instagram Username">

            <button type="submit" class="btn btn-sm btn-primary mb-2">
              Calculate
            </button>
          </form>
        </div>

        <hr>

        <div class="row">
          <div class="col-md-8 col-6">
            <h2><b>Upgrade Account</b></h2>
          </div>  
        </div>
          
        <h5>
          Upgrade your account!
        </h5>
        <hr>  
      </div>

      <div class="col-md-12" align="center">
        <h4>
          <b>Our Pricing Plans</b>
        </h4>

        Monthly
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <label class="btn btn-secondary btn-pricing active">
            <input type="radio" name="options" id="option1" autocomplete="off" checked> Monthly
          </label>
          <label class="btn btn-secondary btn-pricing">
            <input type="radio" name="options" id="option2" autocomplete="off"> Yearly
          </label>
        </div>
        Yearly
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