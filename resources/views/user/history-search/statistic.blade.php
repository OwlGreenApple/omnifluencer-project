@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-11">

      	<div class="row">
	        <div class="col-md-8 col-12">
	          <h2><b>Instgram Statistic : {{$influencername}}</b></h2>      
	        </div>
      	</div>
      	
      	<div class="row">
	        <div class="col-md-5 col-12 mb-10">
	          <h5>
	            Select bulk action, save or add it to group
	          </h5>    
	        </div>
	    </div>

	    <hr>

    	<!-- table -->
		<table class="table responsive">
		  <thead>
		    <th class="header menu-nomobile" action="updated_at">
		      Date
		    </th>
		    <th class="header menu-nomobile" action="jml_followers">
		      Followers
		    </th>
		    <th>&nbsp;</th>
		    <th class="header menu-nomobile" action="jml_following">
		      Following
		    </th>
		    <th>&nbsp;</th>
		    <th class="header menu-nomobile" action="jml_post">
		      Media / Post
		    </th>
		    <th>&nbsp;</th>
		  </thead>
		  <tbody>
		  	@if(count($content) > 0)
		  		@foreach($content as $date=>$val)
		  			<tr>
		  				<td>{{$date}}</td>
		  				<td>{{number_format($val['Total_Followers'])}}</td>
		  				<td>
		  					@if($val['FollowerDeviation'] > 0)
		  						<span style="color:#1dbb0a">+{{number_format($val['FollowerDeviation'])}}</span>
		  					@elseif($val['FollowerDeviation'] < 0)
		  						<span style="color:#f14242">{{number_format($val['FollowerDeviation'])}}</span>
		  					@endif
		  				</td>
		  				<td>{{number_format($val['Total_Following'])}}</td>
		  				<td>
		  					@if($val['FollowingDeviation'] > 0)
		  						<span style="color:#1dbb0a">+{{number_format($val['FollowingDeviation'])}}</span>
		  					@elseif($val['FollowingDeviation'] < 0)
		  						<span style="color:#f14242">{{number_format($val['FollowingDeviation'])}}</span>
		  					@endif
		  				</td>
		  				<td>{{number_format($val['Total_Post'])}}</td>
		  				<td>
		  					@if($val['PostDeviation'] > 0)
		  						<span style="color:#1dbb0a">+{{number_format($val['PostDeviation'])}}</span>
		  					@elseif($val['PostDeviation'] < 0)
		  						<span style="color:#f14242">{{number_format($val['PostDeviation'])}}</span>
		  					@endif
		  				</td>
		  			</tr>
		  		@endforeach
		  			<tr>
		  				<td colspan="2" style="color : #b7b7b7">Daily Averages</td>
		  				<td>
		  					@if($totalfollowersdeviation < 0)<span style="color:#f14242">{{number_format($totalfollowersdeviation)}}</span> @else <span style="color:#1dbb0a">+{{number_format($totalfollowersdeviation)}}</span>
		  					@endif
		  				</td>
		  				<td colspan="1">&nbsp;</td>
		  				<td>
		  					@if($totalfollowingsdeviation < 0)<span style="color:#f14242">{{number_format($totalfollowingsdeviation)}}</span> @else <span style="color:#1dbb0a">+{{number_format($totalfollowingsdeviation)}}</span>
		  					@endif
		  				</td>
		  				<td colspan="1">&nbsp;</td>
		  				<td>
		  					@if($totalpostsdeviation < 0)<span style="color:#f14242">{{number_format($totalpostsdeviation)}}</span> @else <span style="color:#1dbb0a">+{{number_format($totalpostsdeviation)}}</span>
		  					@endif
		  				</td>
		  			</tr>
		  			<!--<tr>
		  				<td colspan="2" style="color : #b7b7b7">Monthly Averages</td>
		  				<td>+4</td>
		  				<td colspan="1">&nbsp;</td>
		  				<td>+8</td>
		  				<td colspan="1">&nbsp;</td>
		  				<td>+8</td>
		  			</tr>
		  			-->
		  			<tr>
		  				<td colspan="7"><button class="btn btn-success btn-sm">Download CSV</button></td>
		  			</tr>
		  	@else
		  		<tr><td colspan="7" class="text-center">Currently data is not available</td></tr>
		  	@endif
		  </tbody>
		</table>
		<!-- end table -->

		<hr>
      	<div class="row">
	        <div class="col-md-8 col-12">
	          <h3><b>Instagram Chart History For {{$influencername}}</b></h3>      
	        </div>
      	</div>
      	<hr>

		<!-- Charts -->
		<div class="row">
	        <div class="col-md-12 col-12">
	          <div id="chartContainer" style="height: 360px"></div>  
	        </div>
      	</div>

      	<hr>

      	<div class="row">
	        <div class="col-md-12 col-12">
	          <div id="chartContainerFollowing" style="height: 360px"></div> 
	        </div>
      	</div>

      	<hr>

      	<div class="row">
	        <div class="col-md-12 col-12">
	          <div id="chartContainerPost" style="height: 360px"></div>
	        </div>
      	</div>
		<!-- End Charts -->
    </div>
   </div>
</div>


<script>
	$(function() {
		
		var follower = [];
		$.each(<?php echo json_encode($contentfollower);?>, function( i, item ) {
			follower.push({'x': new Date(i), 'y': item.total, 'z':item.deviation});
	 	});

		var options = {
			title: {
				fontSize: 24,
				padding: {
				     top: 10,
				     right: 10,
				     bottom: 5,
				     left: 10
			    },
				fontFamily: "Nunito,sans-serif",
				text: "Total Daily Follower"
			},
			axisX: {
				valueFormatString: "DD-MMM-YY"
			},
			axisY: {
				titleFontFamily: "Nunito,sans-serif",
				labelFontSize: 12,
				titleFontSize : 12,
				title : "Followers",
				titleFontColor: "#b7b7b7"
			},
			toolTip: {
				shared: true,
				contentFormatter: function (e) {
					var content = "";
					var comb = [];

					for (var i = 0; i < e.entries.length; i++) {
						if(parseInt(e.entries[i].dataPoint.z) < 0)
			          	{
			          		comb.push('<span style="color:#f14242">'+e.entries[i].dataPoint.z+'</span>');
			          	}
			          	else if(parseInt(e.entries[i].dataPoint.z) == 0)
			          	{
			          		comb.push(e.entries[i].dataPoint.z);
			          	}
			          	else
			          	{
			          		comb.push('<span style="color:#1dbb0a">+'+e.entries[i].dataPoint.z+'</span>');
			          	}

						content = 'Date : <span style="color:blue">'+CanvasJS.formatDate(e.entries[i].dataPoint.x, "DD-MMM-YYYY")+'</span><br/>Total Followers : <strong>'+e.entries[i].dataPoint.y+'</strong><br/>Deviation : '+comb[i]; 
					}
					return content;
				}
			},
			animationEnabled: true,
			exportEnabled: true,
			data: [
			{
				type: "spline", //change it to line, area, column, pie, etc
				dataPoints: follower
			}
			]
		};
		$("#chartContainer").CanvasJSChart(options);
	});

	/* Daily Following */
	$(function() {
		
		var following = [];
		$.each(<?php echo json_encode($contentfollowing);?>, function( i, item ) {
			following.push({'x': new Date(i), 'y': item.total, 'z':item.deviation});
	 	});

		var optionFollowing = {
			title: {
				fontSize: 24,
				padding: {
				     top: 10,
				     right: 10,
				     bottom: 5,
				     left: 10
			    },
				fontFamily: "Nunito,sans-serif",
				text: "Total Daily Following"
			},
			axisX: {
				valueFormatString: "DD-MMM-YY"
			},
			axisY: {
				titleFontFamily: "Nunito,sans-serif",
				labelFontSize: 12,
				titleFontSize : 12,
				title : "Followings",
				titleFontColor: "#b7b7b7"
			},
			toolTip: {
				shared: true,
				contentFormatter: function (e) {
					var content = "";
					var comb = [];

					for (var i = 0; i < e.entries.length; i++) {
						if(parseInt(e.entries[i].dataPoint.z) < 0)
			          	{
			          		comb.push('<span style="color:#f14242">'+e.entries[i].dataPoint.z+'</span>');
			          	}
			          	else if(parseInt(e.entries[i].dataPoint.z) == 0)
			          	{
			          		comb.push(e.entries[i].dataPoint.z);
			          	}
			          	else
			          	{
			          		comb.push('<span style="color:#1dbb0a">+'+e.entries[i].dataPoint.z+'</span>');
			          	}

						content = 'Date : <span style="color:blue">'+CanvasJS.formatDate(e.entries[i].dataPoint.x, "DD-MMM-YYYY")+'</span><br/>Total Followings : <strong>'+e.entries[i].dataPoint.y+'</strong><br/>Deviation : '+comb[i]; 
					}
					return content;
				}
			},
			animationEnabled: true,
			exportEnabled: true,
			data: [
			{
				type: "spline", //change it to line, area, column, pie, etc
				dataPoints: following
			}
			]
		};
		$("#chartContainerFollowing").CanvasJSChart(optionFollowing);
	});

	/* Daily Post  */

	$(function() {
		
		var posts = [];
		$.each(<?php echo json_encode($contentpost);?>, function( i, item ) {
			posts.push({'x': new Date(i), 'y': item.total, 'z':item.deviation});
	 	});

		var optionPost = {
			title: {
				fontSize: 24,
				padding: {
				     top: 10,
				     right: 10,
				     bottom: 5,
				     left: 10
			    },
				fontFamily: "Nunito,sans-serif",
				text: "Total Daily Post"
			},
			axisX: {
				valueFormatString: "DD-MMM-YY"
			},
			axisY: {
				titleFontFamily: "Nunito,sans-serif",
				labelFontSize: 12,
				titleFontSize : 12,
				title : "Posts",
				titleFontColor: "#b7b7b7"
			},
			toolTip: {
				shared: true,
				contentFormatter: function (e) {
					var content = "";
					var comb = [];

					for (var i = 0; i < e.entries.length; i++) {
						if(parseInt(e.entries[i].dataPoint.z) < 0)
			          	{
			          		comb.push('<span style="color:#f14242">'+e.entries[i].dataPoint.z+'</span>');
			          	}
			          	else if(parseInt(e.entries[i].dataPoint.z) == 0)
			          	{
			          		comb.push(e.entries[i].dataPoint.z);
			          	}
			          	else
			          	{
			          		comb.push('<span style="color:#1dbb0a">+'+e.entries[i].dataPoint.z+'</span>');
			          	}

						content = 'Date : <span style="color:blue">'+CanvasJS.formatDate(e.entries[i].dataPoint.x, "DD-MMM-YYYY")+'</span><br/>Total Posts : <strong>'+e.entries[i].dataPoint.y+'</strong><br/>Deviation : '+comb[i]; 
					}
					return content;
				}
			},
			animationEnabled: true,
			exportEnabled: true,
			data: [
			{
				type: "spline", //change it to line, area, column, pie, etc
				dataPoints: posts
			}
			]
		};
		$("#chartContainerPost").CanvasJSChart(optionPost);
	});
	
 </script>
@endsection