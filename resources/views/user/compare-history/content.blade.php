<?php use App\Account; ?>

@foreach($compares as $compare)
  <tr>
    <td>
      <input type="checkbox" class="checkcompareid" name="compareid[]" value="{{$compare->id}}">
    </td>
    <td data-label="Instagram">
      <div class="view-details" data-id="{{$compare->id}}">
        <div class="menu-mobile">
          <span style="display: inline-block; float: right;">
            <i class="fas fa-sort-down"></i>
          </span>    
        </div>
      </div>

      <?php 
          $akun = '';

          if(!is_null($compare->account_id_1)){
            $akun = '@'.$compare->acc1username.' ';       
          }  

          if(!is_null($compare->account_id_2)){
            if($akun!=''){
              $akun = $akun.'<br class="menu-mobile"><i class="fas fa-arrows-alt-h icon-arrow"></i>';
            }
            
            $akun = $akun.'@'.$compare->acc2username.' ';
          }

          if(!is_null($compare->account_id_3)){
            if($akun!=''){
              $akun = $akun.'<br class="menu-mobile"><i class="fas fa-arrows-alt-h icon-arrow"></i>';
            }
            $akun = $akun.'@'.$compare->acc3username.' ';
          }

          if(!is_null($compare->account_id_4)){
            if($akun!=''){
              $akun = $akun.'<br class="menu-mobile"><i class="fas fa-arrows-alt-h icon-arrow"></i>';
            }
            $akun = $akun.'@'.$compare->acc4username.' ';
          } 

          echo $akun;
      ?>
    </td>
    <td class="menu-nomobile" data-label="Date">
      {{ date("H:i", strtotime($compare->updated_at))  }}
      <br>
      {{ date("Y/m/d", strtotime($compare->updated_at))  }}
    </td> 
    <td data-label="Action">
      <div class="menu-nomobile">
        @if(Auth::user()->membership=='pro' or Auth::user()->membership=='premium')
          <button type="button" class="btn btn-sm btn-primary btn-profile" data-id="{{$compare->id}}" data-type="pdf" data-toggle="modal" data-target="#send-file">
            <i class="fas fa-file-pdf"></i>
          </button>
        @endif

        @if(Auth::user()->membership=='premium')
          <button type="button" class="btn btn-sm btn-primary btn-profile" data-id="{{$compare->id}}" data-type="csv" data-toggle="modal" data-target="#send-file">
            <i class="fas fa-file-excel"></i>
          </button>
        @endif

        <button type="button" class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$compare->id}}">
          <i class="far fa-trash-alt"></i>
        </button>
      </div>

      <div class="menu-mobile">
        <span class="menu-savepdf btn-profile" data-id="{{$compare->id}}" data-type="pdf" data-toggle="modal" data-target="#send-file">
          Save PDF 
        </span>

        |

        <span class="menu-delete btn-delete" data-toggle="modal" data-toggle="modal" data-target="#confirm-delete" data-id="{{$compare->id}}">
          Delete
        </span>
      </div>
    </td>
  </tr>

  <tr class="details-{{$compare->id}} d-none">
    <td></td>
    <td>
      Search on : <b>{{date("H:i", strtotime($compare->updated_at))}}</b>
      <br>
      <b>{{date("Y/m/d", strtotime($compare->updated_at))}}</b>
    </td>
    <td></td>
  </tr>
@endforeach