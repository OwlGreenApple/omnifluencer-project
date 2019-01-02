<?php use App\Save; ?>
<div class="row">
  @foreach($groups as $group)
    <div class="col-md-4 div-group" data-id="{{$group->id}}" data-name="{{$group->group_name}}">
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
    </div>
  @endforeach
</div>