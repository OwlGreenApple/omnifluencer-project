<?php use App\Helpers\Helper; ?>

  <tr>
    <td data-label="Eng. Rate">
       <?php  
        if(!empty($logs['eng_rate']))
        {
          $eng_rate = $logs['eng_rate']*100;
          echo $eng_rate.'%';
        }
        else
        {
           echo 0;
        }
      ?>
    </td>
    <td data-label="Total Influenced">
      <?php  
        if(!empty($logs['total_influenced']))
        {
           echo Helper::abbreviate_number(round($logs['total_influenced']),2);
        }
        else
        {
           echo 0;
        }
      ?>
    </td>
    <td data-label="Followers">
      <?php 
        echo Helper::abbreviate_number($logs['jml_followers'],2)
      ?>
    </td>
    <td data-label="Following">
      <?php 
        echo Helper::abbreviate_number($logs['jml_following'],2)
      ?>
    </td>
    <td data-label="Post">
      <?php 
        echo Helper::abbreviate_number($logs['jml_post'],2)
      ?>
    </td>
    <td data-label="Last Post">
      {{ $logs['lastpost'] }}
    </td>
    <td data-label="Avg Likes">
      {{ $logs['jml_likes'] }}
    </td>
    <td data-label="Avg Comments">
      {{ $logs['jml_comments'] }}
    </td>
    <td data-label="Created_at">
      {{ $logs['created_at'] }}
    </td>  
    <td data-label="Updated_at">
      {{ $logs['updated_at'] }}
    </td>
  </tr>