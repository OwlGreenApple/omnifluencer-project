<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

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

  <script>
    $(document).ready(function() {
      $('.tooltipstered').tooltipster({
        contentAsHTML: true,
        trigger: 'ontouchstart' in window || navigator.maxTouchPoints ? 'click' : 'hover',
      });
    });
  </script>
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

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{url('faq')}}">
                FAQ
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Blog</a>
            </li>
            <li class="nav-item" style="border-right: 1px solid black">
              <a class="nav-link" href="{{url('pricing')}}">Pricing</a>
            </li>
          
            <!-- Authentication Links -->
            @guest
              <li class="nav-item">
                <a class="nav-link" href="{{url('login')}}">Sign In</a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-block d-sm-block d-md-block d-lg-none" href="{{url('register')}}">
                  Sign Up
                </a>
              </li>
              <button class="btn btn-primary navbar-btn d-none d-sm-none d-md-none d-lg-block btn-signup">
                Sign Up
              </button>
            @else
              <li class="nav-item">
                <a class="nav-link" href="{{asset('dashboard')}}">
                  <i class="fas fa-tachometer-alt icon-menu"></i>
                  Dashboard
                </a>
              </li>

              <li class="nav-item dropdown" >
                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre data-offset="5,10">
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
              <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <img class="profpic-header" src="<?php echo $profpic ?>" altSrc="{{asset('/design/profpic-user.png')}}" onerror="this.src = $(this).attr('altSrc')">
              </a>

              <div class="dropdown-menu dropdown-menu-right profpic-menu" aria-labelledby="navbarDropdown">
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
                      {{ __('Sign Out') }}
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
                <p>Use this tool as test data for an automated system or find your next pen</p>
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
                    <li> <a href="#"> About Us</a> </li>
                    <li> <a href="#"> Blog</a> </li>
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
              <h6> Helps</h6>
              <div class="row ">
                <div class="col">
                  <ul>
                    <li> 
                      <a href="{{url('faq')}}"> 
                        FAQs
                      </a> 
                    </li>
                    <li> <a href="#"> Terms & Conditions</a> </li>
                    <li> <a href="#"> Privacy Policy</a> </li>
                    <li> <a href="#"> Disclaimer</a> </li>
                    <li> <a href="#"> Learn More</a> </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col d-none d-sm-none d-md-none d-lg-block">
              <h6> Contact</h6>
              <div class="row ">
                <div class="col">
                  <ul>
                    <li> <a href="#"> support@omnifluencer.com</a> </li>
                    <li> <a href="#"> Send Us a Query</a> </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-3 d-none d-sm-none d-md-none d-lg-block">
              <h6> Newsletter</h6>
              <p>A rover wearing a fuzzy suit doesn’t alarm the real penguins</p>
              <form class="form-inline form-inline-btm" >
                @csrf
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                <div class="form-check">
                </div>
                <button id="button-subscribe" class="btn btn-primary btn-primary-btm">Submit</button>
              </form>
              <div class="social">
                <a href="#"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a>
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
        email: $("#email").val(),
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
