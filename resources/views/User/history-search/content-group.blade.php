<style type="text/css">
  .groupcheck {
    display: none;
  }

  input[type=checkbox]:checked + label {
    background-color: #B6D9FF;
  }

</style>

<?php if($groups->count()) { ?>
  @foreach($groups as $group)
    <div class="select-group col-md-12" style="border: 1px solid #CCCCCC;background-color:#EBEBEB;">
      <input type="checkbox" class="groupcheck" name="groupid[]" value="{{$group->id}}" id="groupcheck-{{$group->id}}">
      <label for="groupcheck-{{$group->id}}">
        {{$group->group_name}}
      </label>   
    </div>
    
    <br>
  @endforeach
<?php } ?>