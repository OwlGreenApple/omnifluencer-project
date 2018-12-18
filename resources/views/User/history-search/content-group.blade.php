<?php if($groups->count()) { ?>
  @foreach($groups as $group)
    <input type="checkbox" class="groupcheck" name="groupid[]" value="{{$group->id}}" id="groupcheck-{{$group->id}}">
    <label class="col-md-12 select-group" for="groupcheck-{{$group->id}}">
      {{$group->group_name}}
    </label>   
    <br>
  @endforeach
<?php } ?>