<?php use App\Helpers\Helper; ?>

@foreach($logs as $log)
  <tr>
    <td data-label="Eng. Rate">
      <?php 
        $eng_rate = $log->eng_rate*100;
        echo $eng_rate.'%';
      ?> 
    </td>
    <td data-label="Total Influenced">
      <?php  
        echo Helper::abbreviate_number(round($log->total_influenced),2)
      ?>
    </td>
    <td data-label="Followers">
      <?php 
        echo Helper::abbreviate_number($log->jml_followers,2)
      ?>
    </td>
    <td data-label="Following">
      <?php 
        echo Helper::abbreviate_number($log->jml_following,2)
      ?>
    </td>
    <td data-label="Post">
      <?php 
        echo Helper::abbreviate_number($log->jml_post,2)
      ?>
    </td>
    <td data-label="Last Post">
      {{ $log->lastpost }}
    </td>
    <td data-label="Avg Likes">
      {{ $log->jml_likes }}
    </td>
    <td data-label="Avg Comments">
      {{ $log->jml_comments }}
    </td>
    <td data-label="Created_at">
      {{ $log->created_at }}
    </td>
  </tr>
@endforeach