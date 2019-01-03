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
  <script src="{{ asset('js/noframework.waypoints.min.js') }}"></script>
  <script type="text/javascript" src="tooltipster/dist/js/tooltipster.main.min.js"></script>
  <script defer src="{{asset('js/all.js')}}"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="tooltipster/dist/css/tooltipster.main.min.css" />
  <link href="{{ asset('css/all.css') }}" rel="stylesheet">

  <script>
    $(document).ready(function() {
      $('.tooltipstered').tooltipster({
        contentAsHTML: true,
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
        <a class="navbar-brand" href="{{ url('/') }}" style="padding: 0px; margin-left: 0;">
          <img src="{{asset('design/logo-color-web.png')}}" style="height: 40px; width: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar 
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{url('referral')}}">
                Referral  
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('search')}}">
                Search
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('history-search')}}">
                History Search
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('edit-profile')}}">
                Edit Profile
              </a>
            </li>
          </ul>-->

          <!-- Right Side Of Navbar -->
          <ul class="nav navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">FAQ</a>
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
                <a class="nav-link" href="#">Sign In</a>
              </li>
              <button class="btn btn-primary navbar-btn">
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

              <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <img class="profpic-header" src="{{Auth::user()->prof_pic}}">
              </a>

              <div class="dropdown-menu dropdown-menu-right profpic-menu" aria-labelledby="navbarDropdown">
                <div class="container" style="padding-bottom: 10px;">
                  <div class="row">
                    <div class="col-md-4" align="center">
                      <img class="profpic-header-big" src="{{Auth::user()->prof_pic}}">
                    </div>

                    <div class="col-md-8" align="left">
                      <b>{{Auth::user()->name}}</b><br>
                      {{Auth::user()->point}} Points<br>
                      Change Password
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
            
            

            <!-- Authentication Links 
            @guest
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
              <li class="nav-item">
                @if (Route::has('register'))
                  <a class="nav-link" href="{{ route('register') }}">
                    {{ __('Register') }}
                  </a>
                @endif
              </li>
            @else
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }} 
                  <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest-->
            </ul>
          </div>
        </div>
      </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <!--Loading Bar-->
        <div class="div-loading">
          <div id="loader" style="display: none;"></div>  
        </div>

    </div>
</body>
</html>
