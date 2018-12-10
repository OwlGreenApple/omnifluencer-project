<img src="{{$account->prof_pic}}" style="max-width:180px"><br>
<p><?php echo '@'.$account->username ?></p>
<p>{{$account->username}}</p>

<div class="row">
  <div class="col-md-6">
    <p>{{$account->jml_post}}</p>
    <p>Post</p>
    <p>{{$account->jml_followers}}</p>
    <p>Followers</p>
    <p>{{$account->jml_following}}</p>
    <p>Following</p>
  </div>

  <div class="col-md-6">
    <p>{{$account->lastpost}}</p>
    <p>Last Post</p>
    <p>{{$account->jml_likes}}</p>
    <p>Avg Like Per Post</p>
    <p>{{$account->jml_comments}}</p>
    <p>Avg Comment Per Post</p>
  </div>
</div>