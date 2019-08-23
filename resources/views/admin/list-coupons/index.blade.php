@extends('layouts.dashboard')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <h2><b>Coupons</b></h2>  
      <h5>Show and add new coupon</h5>
        
      <hr>

      <p><a class="btn btn-warning" data-toggle="modal" data-target="#add-coupon">Add Coupon</a></p>

      <form>
        <table class="table table-responsive" id="coupon_table">
          <thead align="center">
            <th>No</th>
            <th>Coupon Code</th>
            <th>Discount (%)</th>
            <th>Value</th>
            <th>Valid Until</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Coupon Description</th>
            <th>Edit</th>
            <th>Delete</th>
          </thead>
          <tbody>
            @include('admin.list-coupons.content')
          </tbody>
        </table>
      </form>
    </div>
  </div>

<!-- end container -->  
</div>

<!-- Modal Add Coupons -->
<div class="modal fade" id="add-coupon" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Create Coupon
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">

         <form role="form" id="add_coupon">
             <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Kode Kupon:</label>
                <input type="text" class="form-control" name="coupon_code"/>
                <span class="error coupon_code"></span>
              </div>
            </div> 

            <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Pilih Tipe Diskon:</label>
               <div class="radio">
                 <label><input type="radio" name="discount" value="0" /> Diskon %</label>
               </div>
               <div class="radio">
                 <label><input type="radio" name="discount" value="1" /> Diskon Harga</label>
               </div>
              </div>
            </div> 

            <div class="row discount-percent">
              <div class="form-group col-md-12">
                <label for="Name">Kupon Diskon:</label>
                <select class="form-control" name="coupon_discount">
                   <option value="0">Pilih Diskon</option>
                   @php
                   for($x=1;$x<=100;$x++)
                   {
                   @endphp
                      <option value="{{$x}}">{{$x}}%</option>
                   @php
                   }
                   @endphp
                </select>
                <span class="error coupon_discount"></span>
              </div>
            </div> 
            <div class="row discount-cash">
              <div class="form-group col-md-12">
                <label for="Name">Kupon Harga:</label>
                <input type="text" class="form-control" name="coupon_value" />
                <span class="error coupon_value"></span>
              </div>
            </div>  
            <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Tanggal Berlaku:</label>
                <input type="text" autocomplete="off" class="form-control datepicker" name="valid_until" />
                <span class="error valid_until"></span>
              </div>
            </div>  
            <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Kupon Deskripsi:</label>
                <textarea class="form-control" name="coupon_description"></textarea>
                <span class="error coupon_description"></span>
              </div>
            </div> 
      <!-- end modal body -->      
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Confirm</button>
        <button class="btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>

    </form>
      
  </div>
</div>

<!-- Modal Edit Coupons -->
<div class="modal fade" id="edit-coupon" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Edit Coupon
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">

         <form role="form" id="edit_coupon">
             <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Kode Kupon:</label>
                <input type="text" class="form-control" name="edit_coupon_code"/>
                <span class="error er_edit_coupon_code"></span>
              </div>
            </div> 

            <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Pilih Tipe Diskon:</label>
               <div class="radio">
                 <label><input type="radio" name="edit_discount" value="0" /> Diskon %</label>
               </div>
               <div class="radio">
                 <label><input type="radio" name="edit_discount" value="1" /> Diskon Harga</label>
               </div>
              </div>
            </div> 

            <div class="row discount-percent">
              <div class="form-group col-md-12">
                <label for="Name">Kupon Diskon:</label>
                <select class="form-control" name="edit_coupon_discount">
                   <option value="0">Pilih Diskon</option>
                   @php
                   for($x=1;$x<=100;$x++)
                   {
                   @endphp
                      <option value="{{$x}}">{{$x}}%</option>
                   @php
                   }
                   @endphp
                </select>
                <span class="error err_edit_coupon_discount"></span>
              </div>
            </div> 
            <div class="row discount-cash">
              <div class="form-group col-md-12">
                <label for="Name">Kupon Harga:</label>
                <input type="text" class="form-control" name="edit_coupon_value" />
                <span class="error err_edit_coupon_value"></span>
              </div>
            </div>  
            <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Tanggal Berlaku:</label>
                <input type="text" autocomplete="off" class="form-control datepicker" name="edit_valid_until" />
                <span class="error err_edit_valid_until"></span>
              </div>
            </div>  
            <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Kupon Deskripsi:</label>
                <textarea class="form-control" name="edit_coupon_description"></textarea>
                <span class="error err_edit_coupon_description"></span>
              </div>
            </div> 
            <input type="hidden" name="edit_id" />
      <!-- end modal body -->      
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Edit</button>
        <button class="btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    </form>
      
  </div>
</div>

<script type="text/javascript">

  /*var table =  $('#coupon_table').DataTable({
      "pageLength":5,
      "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    });*/

  $(document).ready(function() {
    datePicker();
    addCoupon();
    getDiscount();
    editCoupon();
    updateCoupon();
    getData();
  });

 /* Convert regular table to dataTable */
 function getData()
  {
    $('#coupon_table').DataTable({
      "pageLength":5,
      "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    });
  }

  /* Display calendar */
  function datePicker(){
     $(".datepicker").datepicker({
       dateFormat : 'yy-mm-dd',
    })
  }

  /* function getData()
  {
    $('#coupon_table').DataTable({
      "processing": true,
      "serverSide": true,
      "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
      "ajax": "route('couponTable')",
      "columns": [
            { "data": "no" },
            { "data": "coupon_code" },
            { "data": "percent" },
            { "data": "value" },
            { "data": "valid" },
            { "data": "created" },
            { "data": "updated" },
            { "data": "description" },
        ],
    });
  }*/

 /* Insert coupon data into database */
 function addCoupon() {
    $("#add_coupon").on("submit",function(e){
      e.preventDefault();
      var data = $(this).serialize();

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        type : 'POST',
        url : "{{route('addcoupon')}}",
        data: data,
        dataType : "json",
        beforeSend: function()
        {
          $('#loader').show();
          $('.div-loading').addClass('background-load');
        },
        success: function(result){
          if(result.success == true){
            $('#loader').hide();
            $('.div-loading').removeClass('background-load');
            alert(result.message);
            getDiscount();
            emptyCols();
          } else {
            $(".coupon_code").html(result.coupon_code);
            $(".coupon_discount").html(result.coupon_discount);
            $(".coupon_value").html(result.coupon_value);
            $(".valid_until").html(result.valid_until);
            $(".coupon_description").html(result.coupon_description);
          }
        },
        error: function(jqXHR) {
          console.log(jqXHR);
        }
      });
      /* end ajax */  
    });
  };

  /* Edit coupon */
  function editCoupon()
  {
    $("body").on("click",".edit",function(){
      var id = $(this).attr('id'); // get id coupon
      $.ajax({
        type : 'GET',
        url : "{{route('getcoupon')}}",
        data : {'id_coupon':id},
        dataType : "json",
        success: function(result){ 
            $("input[name='edit_coupon_code']").val(result.code);
            $("select[name='edit_coupon_discount'] > option[value="+result.coupon_discount+"]").prop('selected',true);
            //To make discount % column appear if % discount available and otherwise
            if(result.coupon_discount > 0){
                $("input[name='edit_discount']:eq(0)").prop('checked',true);
                $("input[name='edit_discount']:eq(1)").prop('checked',false);
                $('.discount-percent').show();
                $('.discount-cash').hide();
            } else if(result.coupon_value !== null) {
                $("input[name='edit_discount']:eq(0)").prop('checked',false);
                $("input[name='edit_discount']:eq(1)").prop('checked',true);
                $('.discount-percent').hide();
                $('.discount-cash').show();
            } else {
                $("input[name='edit_discount']:eq(0)").prop('checked',false);
                $("input[name='edit_discount']:eq(1)").prop('checked',false);
                $('.discount-percent').hide();
                $('.discount-cash').hide();
            }
            $("input[name='edit_coupon_value']").val(result.coupon_value);
            $("input[name='edit_valid_until']").val(result.valid_until);
            $("textarea[name='edit_coupon_description']").val(result.description);
            $("input[name='edit_id']").val(result.id);
        },
        error: function(jqXHR) {
          console.log(jqXHR);
        }
      });
      /* end ajax */ 
    });
  }

  /* Update coupon */
  function updateCoupon()
  {
    $("body").on("submit","#edit_coupon",function(e){
      e.preventDefault();
       var data = $(this).serialize();

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type : 'POST',
          url : "{{route('updateCoupon')}}",
          data : data,
          dataType : "json",
          success : function(result){
            $(".destroy").html('');
            alert(result.message);
             getData();
          }
        });
       /* end ajax */
    });
  }

  /* Delete coupon */
  function delCoupon()
  {
    var confirm = confirm('Apakah anda sudah yakin akan menghapus?');
    var id = $(this).attr('id'); // get id coupon

    if(confirm == true)
    {
      //ajax
    } else {
      return false;
    }
  }

  /* Display discount type input form */
  function getDiscount()
  {
    $('.discount-percent').hide();
    $('.discount-cash').hide();

    $("body").on('change','input[name="discount"],input[name="edit_discount"]',function(){
       var get_radio_value = $(this).val();
       if(get_radio_value == 0)
       {
          $('.discount-percent').show();
          $('.discount-cash').hide();
       } else {
          $('.discount-percent').hide();
          $('.discount-cash').show();
       }
    });
  }

  /* Make column empty after insert database */
  function emptyCols()
  {
    $("input[name='coupon_code']").val('');
    $("input[name='coupon_value']").val('');
    $("input[name='valid_until']").val('');
    $("textarea").val('');
    $(".error").html('');
    $("input[name='discount']").prop('checked',false);
    $("select[name='coupon_discount'] > option:eq(0)").prop('selected',true);
  }
</script>

@endsection
