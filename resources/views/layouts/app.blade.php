<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Link Icon -->
  <link rel='shortcut icon' type='image/png' href="{{ asset('design/favicon.png') }}">

  <!-- Scripts -->
  <script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
  <!--<script src="{{ asset('js/noframework.waypoints.min.js') }}"></script>-->
  <!--<script src="{{ asset('js/waypoints.js') }}"></script>-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.0/jquery.waypoints.min.js"></script>
  <script type="text/javascript" src="{{asset('tooltipster/dist/js/tooltipster.bundle.min.js')}}"></script>
  <script defer src="{{asset('js/all.js')}}"></script>
  <script src="{{ asset('js/numscroller-1.0.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{asset('tooltipster/dist/css/tooltipster.bundle.min.css')}}" />
  <link href="{{ asset('css/all.css') }}" rel="stylesheet">
  <link href="https://unpkg.com/ionicons@4.5.0/dist/css/ionicons.min.css" rel="stylesheet">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-81228145-3"></script>
  <script>
   window.dataLayer = window.dataLayer || [];
   function gtag(){dataLayer.push(arguments);}
   gtag('js', new Date());

   gtag('config', 'UA-81228145-3');
  </script>

  <script>
    $(document).ready(function() {
      $('.tooltipstered').tooltipster({
        contentAsHTML: true,
        trigger: 'ontouchstart' in window || navigator.maxTouchPoints ? 'click' : 'hover',
      });
    });
  </script>

  <!-- Intl Dialing Code -->
  <link href="{{ asset('/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet" />
  <script type="text/javascript" src="{{ asset('/intl-tel-input/js/intlTelInput.js') }}"></script> 

<!-- Facebook Pixel Code TUJUHUB Youtube 100 jt --> <script> !function(f,b,e,v,n,t,s) {if(f.fbq)return;n=f.fbq=function(){n.callMethod? n.callMethod.apply(n,arguments):n.queue.push(arguments)}; if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0'; n.queue=[];t=b.createElement(e);t.async=!0; t.src=v;s=b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s)}(window, document,'script', 'https://connect.facebook.net/en_US/fbevents.js');fbq('init', '386129596178574'); fbq('track', Lead); </script><noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=386129596178574&ev=PageView&noscript=1" /></noscript> <!-- End Facebook Pixel Code -->
</head>
<body>
  <?php  
        use App\Notification;
        use App\Helpers\Helper;

        $countnotif = 0;
        if(Auth::check()){
          $countnotif = Notification::where('user_id',Auth::user()->id)
                      ->where('is_read',0)
                      ->count();

          $notification = Notification::where('user_id',Auth::user()->id)
                  ->orderBy('created_at','desc')
                  ->take(5)
                  ->get();
        }

        $uri = Request::segment(1);

        if($uri == 'checkout' || $uri == 'register-payment')
        {
           $page = false;
        }
        else
        {
           $page = true;
        }
  ?>

  <script type="text/javascript">
    $(document).ready(function() {
      var countnotif = '{{$countnotif}}';

      if(countnotif>0){
        $('#icon-notif').addClass('new');
      } else {
        $('#icon-notif').removeClass('new');
      }
    });    
  </script>

  <div id="app">
    <nav class="navbar navbar-fluid navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="{{url('/')}}" style="padding: 0px; margin-left: 0;">
          <img src="{{asset('design/logobrand.png')}}" style="height: 40px; width: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        @if($page == true)
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item main-menu">
              <a class="nav-link <?php if(Request::is('faq')) echo 'nav-active' ?>" href="{{url('faq')}}">
                FAQ
              </a>
            </li>
            <li class="nav-item main-menu">
              <a class="nav-link <?php if(Request::is('about-us')) echo 'nav-active' ?>" href="{{url('about-us')}}">
                About Us
              </a>
            </li>
            <li class="nav-item main-menu">
              <a class="nav-link" href="https://omnifluencer.com/n/blog-post/">Blog</a>
            </li>
            <li class="nav-item main-menu">
              <a class="nav-link <?php if(Request::is('pricing')) echo 'nav-active' ?>" href="{{url('pricing')}}">
                Pricing 
              </a>
            </li>
             
          
            <!-- Authentication Links -->
            @guest
              <li class="nav-item main-menu">
                <a class="nav-link <?php if(Request::is('login')) echo 'nav-active' ?>" href="{{url('login')}}">
                  Login
                </a>
              </li>
              <li class="nav-item main-menu">
                <a class="nav-link d-block d-sm-block d-md-block d-lg-none" href="{{url('register')}}">
                  Register
                </a>
              </li>
              <button class="btn btn-primary navbar-btn d-none d-sm-none d-md-none d-lg-block btn-signup">
                Register
              </button>
            @else
              <li class="nav-item main-menu">
                <a class="nav-link" href="{{asset('dashboard')}}">
                  <i class="fas fa-tachometer-alt" style="margin-right: 5px;"></i>
                  Dashboard
                </a>
              </li>


              <li class="nav-item dropdown" >
                <a id="navbarDropdown" class="nav-link main-menu" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre data-offset="5,10">
                  <span class="icon-notif" id="icon-notif" data-badge="{{$countnotif}}">
                    <i class="fas fa-bell" style="margin-right: 7px;"></i>
                  </span>
                  Notification
                </a>

                <div class="dropdown-menu dropdown-menu-right profpic-menu" aria-labelledby="navbarDropdown">
                  @foreach($notification as $notif)
                    <span class="dropdown-item">
                      @if($notif->type=='point')
                        <span class="notif-point">
                          <i class="fas fa-coins" style="margin-right: 5px"></i>
                          {{$notif->notification}}
                        </span>
                      @elseif($notif->type=='promo')
                        <span class="notif-promo">
                          <i class="fas fa-star" style="margin-right: 5px"></i>
                          {{$notif->notification}}
                        </span>
                      @else 
                        <span class="notif-promo">
                          <i class="fas fa-shopping-cart" style="margin-right: 5px"></i>
                          {{$notif->notification}}
                        </span>
                      @endif
                      <span style="float: right;font-size: 12px;">
                        <?php 
                          $time = Helper::getTimeAgo($notif->created_at);
                          echo $time;
                        ?>
                      </span>
                    </span>
                  @endforeach  
                  
                  <div class="col-md-12 menu-viewnotif" align="center">
                    <a href="{{url('notifications')}}">
                      View All Notifications
                    </a>
                  </div>
                </div>
              </li>

              <?php 
                $profpic = null;

                if(Auth::user()->prof_pic!=null){
                  $profpic = Storage::url(Auth::user()->prof_pic);
                }
              ?>

              <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link main-menu" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <img class="profpic-header" src="<?php echo $profpic ?>" altSrc="{{asset('/design/profpic-user.png')}}" onerror="this.src = $(this).attr('altSrc')">
              </a>

              <div class="dropdown-menu dropdown-menu-right profpic-menu prof" aria-labelledby="navbarDropdown">
                <div class="container" style="padding-bottom: 10px;">
                  <div class="row">
                    <div class="col-md-4" align="center">
                      <img class="profpic-header-big" src="<?php echo $profpic ?>" altSrc="{{asset('/design/profpic-user.png')}}" onerror="this.src = $(this).attr('altSrc')">
                    </div>

                    <div class="col-md-8" align="left">
                      <b>{{Auth::user()->name}}</b><br>
                      {{Auth::user()->point}} Points<br>
                      <a class="menu-pass" href="{{url('change-password')}}">
                        Change Password
                      </a>
                    </div>  
                  </div>   
                </div>
                
                <div class="col-md-12 menu-signout">
                  <a href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                    <button class="btn btn-primary">
                      Sign Out
                    </button>
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;" >
                    @csrf
                  </form>
                </div>
                
              </div>
            </li>             
            @endguest
          </ul>
        </div>
         @endif
      </div>
    </nav>


    <main>
      @yield('content')
    </main>

    <footer class="container-fluid py-5">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12">
              <div class="logo-part">
                <img src="{{asset('design/logobrand.png')}}" class="w-75">
                <p>Omnifluencer adalah tool untuk mengukur engagement rate akun Instagram.</p>
                <span>Copyright © 2019 Omnifluencer. All rights reserved.</span>
              </div>
            </div>
            <div class="col d-none d-sm-none d-md-none d-lg-block">
              <h6>Omnifluencer</h6>
              <div class="row">
                <div class="col">
                  <ul>
                    <li> 
                      <a href="{{url('/')}}"> Home</a> 
                    </li>
                    <li> <a href="https://omnifluencer.com/n/blog-post/"> Blog</a> </li>
                    <li> 
                      <a href="{{url('pricing')}}"> 
                        Pricing   
                      </a> 
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col d-none d-sm-none d-md-none d-lg-block">
              <h6> Help </h6>
              <div class="row ">
                <div class="col">
                  <ul>
                    <li> 
                      <a href="{{url('faq')}}"> 
                        FAQ
                      </a> 
                    </li>
                    <li> 
                      <a href="{{url('about-us/about-us')}}"> 
                        About Us 
                      </a> 
                    </li>
                    <li> 
                      <a href="{{url('about-us/earnings-disclaimer')}}">
                        Earnings and Legal Disclaimer
                      </a> 
                    </li>
                    <!--
                    <li> 
                      <a href="{{url('about-us/disclaimer')}}"> 
                        Disclaimer
                      </a> 
                    </li>
                    -->
                    <li> 
                      <a href="{{url('about-us/terms-conditions')}}"> 
                        Terms and Conditions 
                      </a> 
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col d-none d-sm-none d-md-none d-lg-block">
              <h6> Contact </h6>
              <div class="row ">
                <div class="col">
                  <ul>
                    <li> 
                      <a href="mailto:omnifluencer@gmail.com?subject=Mail from Our Site"> 
                        omnifluencer
                      </a> 
                    </li>
                    <!--<li> 
                      <p>Send Us a Query</p>
                    </li>-->
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-3 d-none d-sm-none d-md-none d-lg-block">
              <h6> Newsletter </h6>
              <p>Dapatkan informasi terkini mengenai tips influencer, media sosial dan perkembangannya. </p>
              <form class="form-inline form-inline-btm" >
                @csrf
                <input type="email" class="form-control" id="email-sub" placeholder="Enter email" name="email">
                <div class="form-check">
                </div>
                <button id="button-subscribe" class="btn btn-primary btn-primary-btm">Submit</button>
              </form>
              <div class="social">
                <a href="https://www.facebook.com/pg/Omnifluencer-2369637796655735/about/?ref=page_internal" target="_blank">
                  <span class="icon-social">
                    <i class="fa-facebook-f fab"></i>
                  </span>
                </a>
                <a href="https://www.instagram.com/omnifluencer/" target="_blank">
                  <span class="icon-social">
                    <i class="fa-instagram fab"></i> 
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

    <!--Loading Bar-->
    <div class="div-loading">
      <div id="loader" style="display: none;"></div>  
      <div id="progress_bar" style="display: none;">
        <div class="progress-view"></div>
        <div class="progress-status"></div>
      </div>  
    </div>

  </div>

  <!-- Modal Pesan -->
  <div class="modal fade" id="modal-pesan" role="dialog">
    <div class="modal-dialog">
      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modaltitle">
            Message
          </h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body" id="message"></div>

        <div class="modal-footer" align="center">
          <button class="btn btn-primary" data-dismiss="modal">
            OK
          </button>
        </div>
      </div>
        
    </div>
  </div>

<script type="text/javascript">
  $( "body" ).on( "click", ".btn-signup", function() {
    window.location.href = "{{url('register')}}";
  });
  $( "body" ).on( "click", "#button-subscribe", function(e) {
    e.preventDefault();
    $.ajax({
      type : 'post',
      url : "<?php echo url('/subscribe-email') ?>",
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },      
      data: {
        email: $("#email-sub").val(),
      },
      dataType: 'text',
      beforeSend: function()
      {
        $('#loader').show();
        $('.div-loading').addClass('background-load');
      },
      success: function(result) {
        $('#loader').hide();
        $('.div-loading').removeClass('background-load');

        $('#message').html(result);
        $('#modal-pesan').modal('show');

        // var data = jQuery.parseJSON(result);

        // if(data.status == 'success'){
        // } else {
        // }
      }
    });
  });

</script>

</body>
</html>
