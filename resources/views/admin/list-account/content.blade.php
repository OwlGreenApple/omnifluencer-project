<?php use App\Helpers\Helper; ?>

@foreach($accounts as $account)
  <tr>
    <td data-label="Instagram">
      <img src="{{$account->prof_pic}}" style="max-width:50px; border-radius:50%;">
      <?php echo '@'.$account->username ?>
    </td>
    <td data-label="Eng. Rate">
      <?php 
        $eng_rate = $account->eng_rate*100;
        echo $eng_rate.'%';
      ?> 
    </td>
    <td data-label="Total Influenced">
      <?php  
        echo Helper::abbreviate_number(round($account->total_influenced),2)
      ?>
    </td>
    <td data-label="Followers">
      <?php 
        echo Helper::abbreviate_number($account->jml_followers,2)
      ?>
    </td>
    <td data-label="Following">
      <?php 
        echo Helper::abbreviate_number($account->jml_following,2)
      ?>
    </td>
    <td data-label="Post">
      <?php 
        echo Helper::abbreviate_number($account->jml_post,2)
      ?>
    </td>
    <td data-label="Last Post">
      {{ $account->lastpost }}
    </td>
    <td data-label="Avg Likes">
      {{ $account->jml_likes }}
    </td>
    <td data-label="Avg Comments">
      {{ $account->jml_comments }}
    </td>
    <td data-label="Total Search">
      {{ $account->total_calc }}
    </td>
    <td data-label="Total Compare">
      {{ $account->total_compare }}
    </td>
    <td data-label="Created_at">
      {{ $account->created_at }}
    </td>

    <td data-label="Action">
      <button type="button" class="btn btn-primary btn-log" data-toggle="modal" data-target="#view-log" data-id="{{$account->id}}">
        Log
      </button>  
    </td>
  </tr>
@endforeach