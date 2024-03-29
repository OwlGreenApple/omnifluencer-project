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
  <script src="{{ asset('js/noframework.waypoints.min.js') }}"></script>
  <script type="text/javascript" src="{{asset('tooltipster/dist/js/tooltipster.bundle.min.js')}}"></script>
  <!--<script src="https://unpkg.com/ionicons@4.5.0/dist/ionicons.js"></script>-->
  <script defer src="{{asset('js/all.js')}}"></script>
  <script src="{{ asset('js/datepicker.js') }}"></script>
  <script src="{{ asset('DataTables/DataTables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('DataTables/Responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('js/moment.js') }}"></script>
  <script src="{{ asset('js/datetime-moment.js') }}"></script>

  <!-- Styles -->
  <link href="{{ asset('css/pointer.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{asset('tooltipster/dist/css/tooltipster.bundle.min.css')}}" />
  <link href="{{ asset('css/all.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

  <link href="{{ asset('DataTables/DataTables/css/jquery.dataTables.min.css') }}" rel="stylesheet"></link>
  <link href="{{ asset('DataTables/Responsive/css/responsive.dataTables.min.css') }}" rel="stylesheet"></link>

  <script>
    $(document).ready(function() {
      $('.tooltipstered').tooltipster({
        contentAsHTML: true,
        trigger: 'ontouchstart' in window || navigator.maxTouchPoints ? 'click' : 'hover',
      });
    });
  </script>
  
<!-- Facebook Pixel Code TUJUHUB Youtube 100 jt --> <script> !function(f,b,e,v,n,t,s) {if(f.fbq)return;n=f.fbq=function(){n.callMethod? n.callMethod.apply(n,arguments):n.queue.push(arguments)}; if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0'; n.queue=[];t=b.createElement(e);t.async=!0; t.src=v;s=b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s)}(window, document,'script', 'https://connect.facebook.net/en_US/fbevents.js');fbq('init', '386129596178574'); fbq('track', Lead); </script><noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=386129596178574&ev=PageView&noscript=1" /></noscript> <!-- End Facebook Pixel Code -->  
</head>

<body>
  <?php  
        use App\Notification;
        use App\Helpers\Helper;

        $countnotif = Notification::where('user_id',Auth::user()->id)
                      ->where('is_read',0)
                      ->count();

        $notification = Notification::where('user_id',Auth::user()->id)
                  ->orderBy('created_at','desc')
                  ->take(5)
                  ->get();
  ?>

  <script type="text/javascript">
    var status = 'not-sort';
    var act = '';

    //function saat klik header table (sort asc)
    $(document).on('click', 'th.header', function (e) {
      if(!$(this).hasClass("asc")){
        status = 'asc';
        act = $(this).attr('action');
        
        refresh_page();

        $("th").removeClass("asc");
        $("th").removeClass("desc");
        $(this).addClass("asc");
      }
    });

    //function saat klik header table (sort desc)
    $(document).on('click', 'th.asc', function (e) {
      if(!$(this).hasClass("desc")) {
        status = 'desc';
        act = $(this).attr('action');

        refresh_page();

        $("th").removeClass("asc");
        $("th").removeClass("desc");
        $(this).addClass("desc");
      }
    });
    
    $(document).ready(function() {
      var countnotif = '{{$countnotif}}';

      if(countnotif>0){
        $('#icon-notif').addClass('new');
      } else {
        $('#icon-notif').removeClass('new');
      }

      $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('.div-bgsidebar').addClass('bg-sidebar');
      });
    });

    $(document).on('click', function (e) {
      var sidebar = $("#sidebar, #sidebarCollapse");
      if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0) {
        sidebar.removeClass('active');
        $('.div-bgsidebar').removeClass('bg-sidebar');
      }
    });   

    $(document).on('click', '#reflink-box', function (e) {
      $(this).select();
    });   

    function copylink(){
      $("#reflink-box").select();
      document.execCommand("copy");
      $('#reflink-copy').modal('show');
    } 
  </script>

  <!-- Navbar -->
  <nav class="menu-header">
    <div class="row div-header">
      <div class="col-lg-6 col-md-12 col-12 navbar-reflink menu-nomobile">
        <label class="submenu-header label-reflink">
          <b>Invitation Link</b>
          <span class="tooltipstered" title="Referral link">
            <i class="fas fa-question-circle icon-reflink"></i>
          </span>
        </label>
          
        <input type="text" name="reflink" class="col-md-6 col-4" id="reflink-box" value="<?php echo url('/').'/ref/'.Auth::user()->referral_link ?>" readonly="readonly">
        <button class="btn btn-success btn-sm btn-copy" onclick="copylink()">
          Copy
        </button>    
      </div>

      <div class="col-lg-6 col-md-12 col-12 div-header justify-content-end">
        <button class="navbar-toggler menu-toggle" type="button" id="sidebarCollapse">
          <i class="fas fa-bars"></i>
        </button>

        <!--<span class="submenu-header menu-mobile" style="padding-right: 10px;">
          <span class="icon-header-mobile" onclick="copylink()">
            <i class="fas fa-file-signature"></i>
          </span>
        </span>-->

        <span class="submenu-header"  style="padding-right: 10px;">
          <a href="{{url('/')}}">
            <span class="icon-header-mobile">
              <i class="fas fa-home" style="margin-right: 7px;"></i>
            </span>
            <span class="none-mobile">
              <b>Home</b>
            </span>
          </a>
        </span>

        <span class="submenu-header" style="padding-right: 10px;">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown" >
              <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre data-offset="5,10">
                <span class="icon-notif icon-header-mobile" id="icon-notif" data-badge="{{$countnotif}}">
                  <i class="fas fa-bell" style="margin-right: 7px;"></i>
                </span>
                <span class="none-mobile">
                  <b>Notification</b>
                </span>
              </a>

              <div class="dropdown-menu dropdown-menu-right shadow-lg profpic-menu" aria-labelledby="navbarDropdown">
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
          </ul>
        </span>

        <?php 
          $profpic = null;

          if(Auth::user()->prof_pic!=null){
            $profpic = Storage::url(Auth::user()->prof_pic);
          }
        ?>

        <span class="submenu-header">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <img class="profpic-header" src="<?php echo $profpic ?>" altSrc="{{asset('/design/profpic-user.png')}}" onerror="this.src = $(this).attr('altSrc')">
              </a>

              <div class="dropdown-menu dropdown-menu-right profpic-menu prof shadow-lg" aria-labelledby="navbarDropdown">
                <div class="container" style="padding-bottom: 10px;">
                  <div class="row">
                    <div class="col-md-4" align="center">
                      <img class="profpic-header-big" src="<?php echo $profpic ?>" altSrc="{{asset('/design/profpic-user.png')}}" onerror="this.src = $(this).attr('altSrc')">
                    </div>

                    <div class="col-md-8" align="left">
                      <b>{{Auth::user()->name}}</b><br>

                      <div class="menu-mobile">
                        <hr>

                        <b>Invitation Link</b> <br>
                        <input type="text" name="reflink" class="col-md-6 col-9" id="reflink-box" value="<?php echo url('/').'/ref/'.Auth::user()->referral_link ?>" readonly="readonly">
                        <button class="btn btn-success btn-sm btn-copy" onclick="copylink()">
                          Copy
                        </button> 

                        <hr>
                      </div>

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
          </ul>
        </span>
      </div>
    </div>
  </nav>

  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
      <div class="sidebar-header">
        <a class="navbar-brand" href="{{ url('/') }}">
          <div class="logo-brand">
            <img src="{{asset('/design/logobrand.png')}}">
          </div>
        </a>
      </div>

      @if(Auth::user()->is_admin==0)
      <ul class="list-unstyled components">
        <li class="<?php if(Request::is('dashboard')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('dashboard')}}">
              <i class="fas fa-tachometer-alt icon-menu"></i>
              Dashboard
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('history-influencer') or Request::is('compare-history') or Request::is('saved-profile') or Request::is('groups') or Request::is('groups/*')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="#infSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              <i class="fas fa-certificate icon-menu"></i>
              Influencer
            </a>
          </span>
          
          <ul class="collapse list-unstyled <?php if(Request::is('history-influencer') or Request::is('compare-history') or Request::is('saved-profile') or Request::is('groups') or Request::is('groups/*')) echo 'show' ?>" id="infSubmenu">
            <li class="<?php if(Request::is('history-influencer')) echo 'active' ?>">
              <a href="{{url('history-influencer')}}">
                <i class="fas fa-history icon-menu"></i>
                History Influencer
              </a>
            </li>

            <?php if(Auth::user()->membership=='premium' or Auth::user()->membership=='pro') { ?>
              <li class="<?php if(Request::is('compare-history')) echo 'active' ?>">
                <a href="{{url('compare-history')}}">
                  <i class="fas fa-chart-bar icon-menu"></i>
                  Compare History
                </a>
              </li>

              <li class="<?php if(Request::is('saved-profile')) echo 'active' ?>">
                <a href="{{url('saved-profile')}}">
                  <i class="fas fa-save icon-menu"></i>
                    Saved Profile
                </a>
              </li>

              <li class="<?php if(Request::is('groups') or Request::is('groups/*')) echo 'active' ?>">
                <a href="{{url('groups')}}">
                  <i class="fas fa-folder-plus icon-menu"></i>
                  Groups
                </a>
              </li>
            <?php } ?>
          </ul>
        </li>

        <li class="<?php if(Request::is('upgrade-account')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('upgrade-account')}}">
              <i class="fas fa-rocket icon-menu"></i>
              Upgrade Account
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('billing')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('billing')}}">
              <i class="far fa-money-bill-alt icon-menu"></i>
              Billing
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('reward-points') or Request::is('reward-points/*')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('reward-points')}}">
              <i class="far fa-gem icon-menu"></i>
              Reward Points
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('edit-profile') or Request::is('change-password')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="#settingSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              <i class="fas fa-cog icon-menu"></i>
              Setting
            </a>
          </span>
          
          <ul class="collapse list-unstyled <?php if(Request::is('edit-profile') or Request::is('change-password')) echo 'show' ?>" id="settingSubmenu">
            <li class="<?php if(Request::is('edit-profile')) echo 'active' ?>">
              <a href="{{url('edit-profile')}}">
                <i class="fas fa-pencil-alt icon-menu"></i>
                Edit Profile
              </a>
            </li>
            <li class="<?php if(Request::is('change-password')) echo 'active' ?>">
              <a href="{{url('change-password')}}">
                <i class="fas fa-lock icon-menu"></i>
                Change Password
              </a>
            </li>
          </ul>
        </li>
      </ul>
      @else
      <ul class="list-unstyled components">
        <li class="<?php if(Request::is('list-user')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('list-user')}}">
              <i class="fas fa-user-circle icon-menu"></i>
              Users
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('list-order')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('list-order')}}">
              <i class="fas fa-shopping-cart icon-menu"></i>
              Orders
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('list-coupons')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('list-coupons')}}">
              <i class="fas fa-percent icon-menu"></i>
              Coupons
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('list-transfers')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('list-transfers')}}">
              <i class="fas fa-money-bill-wave icon-menu"></i>
              Transfers
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('list-account')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('list-account')}}">
              <i class="fas fa-users icon-menu"></i>
              Accounts
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('edit-profile') or Request::is('change-password')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="#settingSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              <i class="fas fa-cog icon-menu"></i>
              Setting
            </a>
          </span>
          
          <ul class="collapse list-unstyled" id="settingSubmenu">
            <li class="<?php if(Request::is('change-password')) echo 'active' ?>">
              <a href="{{url('change-password')}}">
                Change Password
              </a>
            </li>
          </ul>
        </li>
      </ul>
      @endif
    </nav>

    <!-- Page Content -->
    <div id="page-content">
      <main class="py-4">
        @yield('content')
      </main>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 footer-txt center-mobile">
          <span>Omnifluencer © 2019</span>
        </div>

        <div class="col-md-10 footer-txt center-mobile" align="right">
          <span style="padding-right: 15px">
            Privacy Policy
          </span>
          <span style="padding-right: 15px">
            Terms of Use
          </span>
          <span>Legal</span>
        </div>
      </div>
    </div>
  </footer>
  
  <!-- Modal Referral Link -->
  <div class="modal fade" id="reflink-copy" role="dialog">
    <div class="modal-dialog">
      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modaltitle">
            Referral Link
          </h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          Copy referral link berhasil!
        </div>
        <div class="modal-footer" id="foot">
          <button class="btn btn-primary" data-dismiss="modal">
            OK
          </button>
        </div>
      </div>
        
    </div>
  </div>

  <!--Loading Bar-->
  <div class="div-loading">
    <div id="loader" style="display: none;"></div>  
  </div>

  <!--Background Sidebar-->
  <div class="div-bgsidebar">
    <div id="loader" style="display: none;"></div>  
  </div>

</body>
</html>
