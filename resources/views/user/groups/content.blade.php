<?php use App\Save; ?>

@foreach($groups as $group)
  <tr>
    <td>
      <input type="checkbox" class="groupcheckbox" name="groupid[]" value="{{$group->id}}" id="groupcheck-{{$group->id}}">
    </td>
    <td>
      <div class="menu-nomobile">
        <i class="fas fa-folder"></i>
        <a href="{{(url('/groups/'.$group->id.'/'.$group->group_name))}}">
          <b>{{$group->group_name}}</b>
      
          <?php  
            $countgroup = Save::where('user_id',Auth::user()->id)
                              ->where('group_id',$group->id)
                              ->count();

            echo '(<b>'.$countgroup.' Lists</b>)';
          ?>  
        </a>  
      </div>
      
      <div class="menu-mobile">
        <div class="view-details" data-id="{{$group->id}}">
          <i class="fas fa-folder"></i>
          <b>{{$group->group_name}}</b>  
          <span class="menu-mobile" style="float:right;">
            <i class="fas fa-sort-down"></i>
          </span>
        </div>
      </div>
    </td>
    <td class="menu-nomobile">
      {{date("H:i", strtotime($group->created_at))}}
      <br>
      {{date("Y/m/d", strtotime($group->created_at))}}
    </td>
    <td>
      <div class="menu-nomobile">
        <button type="button" class="btn btn-sm btn-primary btn-edit" data-toggle="modal" data-target="#edit-group" data-id="{{$group->id}}" data-name="{{$group->group_name}}">
          <i class="fas fa-pencil-alt"></i>
        </button>

        <button type="button" class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$group->id}}">
          <i class="far fa-trash-alt"></i>
        </button>  
      </div>

      <div class="menu-mobile">
        <span class="menu-savepdf btn-edit" data-id="{{$group->id}}" data-toggle="modal" data-target="#edit-group" data-id="{{$group->id}}" data-name="{{$group->group_name}}">
          Edit
        </span>

        |

        <span class="menu-delete btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$group->id}}">
          Delete
        </span>
      </div>
    </td>
  </tr>

  <tr class="details-{{$group->id}} d-none">
    <td></td>
    <td>
      Total : <b><?php echo $countgroup ?> Lists</b>
    </td>
    <td>
      Date Created : <b>
        {{date("H:i", strtotime($group->created_at))}}
        <br>
        {{date("Y/m/d", strtotime($group->created_at))}}
      </b>
    </td>
  </tr>

    <!--<div class="col-md-4 div-group" data-id="{{$group->id}}" data-name="{{$group->group_name}}">
      <input type="checkbox" class="groupcheck" name="groupid[]" value="{{$group->id}}" id="groupcheck-{{$group->id}}">
      <label class="col-md-12 select-group" for="groupcheck-{{$group->id}}">
        <h5>
          {{$group->group_name}}
          <span style="float: right">
            <?php  
              $countgroup = Save::where('user_id',Auth::user()->id)
                            ->where('group_id',$group->id)
                            ->count();

              echo '('.$countgroup.')';
            ?>
          </span>
        </h5>
      </label> 
    </div>-->
@endforeach