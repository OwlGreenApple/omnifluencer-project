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
  <!--<script src="https://unpkg.com/ionicons@4.5.0/dist/ionicons.js"></script>-->
  <script defer src="{{asset('js/all.js')}}"></script>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="tooltipster/dist/css/tooltipster.main.min.css" />
  <link href="{{ asset('css/all.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

  <script>
    $(document).ready(function() {
      $('.tooltipstered').tooltipster({
          
      });
    });
  </script>
</head>

<body>
  <!-- Navbar -->
  <nav class="menu-header">
    <div class="row div-header">
      <div class="col-md-1"></div>

      <div class="col-md-4">
        <div class="row">
          <label class="submenu-header">
            <b>Referral link</b>
            <i class="fas fa-question-circle"></i>
          </label>
          
          <input type="text" name="reflink" class="col-md-6" id="reflink-box" value="<?php echo url('/').'/ref/'.Auth::user()->referral_link ?>">
          <button class="btn btn-default btn-sm btn-copy" onclick="copylink()">
            Copy
          </button>    
        </div>
      </div>

      <div class="col-md-6" align="right">
        <span class="submenu-header" style="padding-right: 20px;">
          <a href="{{url('/')}}">
            <i class="fas fa-home"></i>
            <b>Home</b>
          </a>
        </span>

        <span class="submenu-header">
          <i class="fas fa-bell"></i>
          <b>Notification</b>
        </span>
      </div>

      <div class="col-md-1">
        <img class="profpic-header" src="{{Auth::user()->prof_pic}}">
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

      <ul class="list-unstyled components">
        <li class="<?php if(Request::is('dashboard')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('dashboard')}}">
              <i class="fas fa-tachometer-alt icon-menu"></i>
              Dashboard
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('history-search')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('history-search')}}">
              <i class="fas fa-history icon-menu"></i>
              History
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('history-compare')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('history-compare')}}">
              <i class="fas fa-chart-bar icon-menu"></i>
              Compare History
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('saved-profile')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('saved-profile')}}">
              <i class="fas fa-save icon-menu"></i>
              Saved Profile
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('groups')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('groups')}}">
              <i class="fas fa-folder-plus icon-menu"></i>
              Groups
            </a>
          </span>
        </li>

        <li class="<?php if(Request::is('points')) echo 'active' ?>">
          <span class="submenu-navbar">
            <a href="{{url('points')}}">
              <i class="fas fa-coins icon-menu"></i>
              Points
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
            <li class="<?php if(Request::is('edit-profile')) echo 'active' ?>">
              <a href="{{url('edit-profile')}}">
                Edit Profile
              </a>
            </li>
            <li class="<?php if(Request::is('change-password')) echo 'active' ?>">
              <a href="{{url('change-password')}}">
                Change Password
              </a>
            </li>
          </ul>
        </li>
      </ul>
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
        <div class="col-md-2 footer-txt">
          <span>Omnifluencer © 2018</span>
        </div>

        <div class="col-md-10 footer-txt" align="right">
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
  
  <!--Loading Bar-->
  <div class="div-loading">
    <div id="loader" style="display: none;"></div>  
  </div>

</body>
</html>
