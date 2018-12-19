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
  <script src="https://unpkg.com/ionicons@4.5.0/dist/ionicons.js"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="tooltipster/dist/css/tooltipster.main.min.css" />

  <script>
    $(document).ready(function() {
      $('.tooltipstered').tooltipster({
          
      });
    });
  </script>
</head>

<style type="text/css">
  .wrapper {
    display: flex;
    width: 100%;
    height: 100%;
  }

  #sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 999;
    background: #FFFFFF;
    color: #3B3734;
    transition: all 0.3s;
    box-shadow: 0 3px 0 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }

  #sidebar.active {
    margin-left: -250px;
  }

  a[data-toggle="collapse"] {
    position: relative;
  }

  .dropdown-toggle::after {
    display: block;
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
  }

  @media (max-width: 768px) {
    #sidebar {
        margin-left: -250px;
    }
    #sidebar.active {
        margin-left: 0;
    }
  }

  @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";

  body {
      font-family: 'Poppins', sans-serif;
      background: #fafafa;
  }

  p {
      font-family: 'Poppins', sans-serif;
      font-size: 1.1em;
      font-weight: 300;
      line-height: 1.7em;
      color: #999;
  }

  a, a:hover, a:focus {
      color: inherit;
      text-decoration: none;
      transition: all 0.3s;
  }

  #sidebar .sidebar-header {
    padding: 20px;
    background: #FFFFFF;
  }

  

  #sidebar ul p {
      color: #fff;
      padding: 10px;
  }

  #sidebar ul li a {
      padding: 10px;
      font-size: 1.1em;
      display: block;
  }
  #sidebar ul li a:hover {
      color: #3B3734;
      background: #D8D8D8;
  }

  #sidebar ul li.active span > a, a[aria-expanded="true"]
  {
      color: #3B3734;
      background-image: linear-gradient(-135deg, #70C5FF 0%, #49D1EF 52%, #70C5FF 100%);
      box-shadow: 0 2px 3px 1px rgba(183,183,183,0.50);
  }
  ul ul a {
      font-size: 0.9em !important;
      padding-left: 30px !important;
      background: #F1F1F1;
  }

  #page-content{
    width: 100%;
    margin-left: 250px;
  }

  img {
    width: 100%;
  }

  .footer {
    background-color: #444444;
    padding: 15px;
  }

  .footer-txt {
    color: #FFFFFF;
  }

  .menu-header {
    background-image: linear-gradient(-225deg, #13A5F5 0%, #4ABAF1 56%, #13A5F5 100%);
    padding: 15px;
  }

  .submenu-header {
    color:#12425B;
    font-size: 17px;
  }

  #reflink-box {
    margin-right: 5px;
    margin-left: 5px;
  }

  .div-header {
    display: flex; 
    align-items: center;
  }

  .profpic-header {
    max-width:40px;
    border-radius: 50%;
    border: 2px solid #12425B;
  }

  .submenu-navbar {
    color:#12425B;
    font-size: 15px;  
  }

  #sidebar > ul {
    padding-left: 20px;
    padding-right: 20px;
  }

  #sidebar ul li span ion-icon {
    padding-right: 15px;
  }
</style>

<body>

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
        <li>
          <span class="submenu-navbar">
            <a href="{{url('dashboard')}}">
              <ion-icon name="speedometer"></ion-icon>
              Dashboard
            </a>
          </span>
        </li>

        <li>
          <span class="submenu-navbar">
            <a href="{{url('history-search')}}">
              <ion-icon name="timer"></ion-icon>
              History
            </a>
          </span>
        </li>

        <li>
          <span class="submenu-navbar">
            <a href="{{url('history-compare')}}">
              <ion-icon name="podium"></ion-icon>
              Compare History
            </a>
          </span>
        </li>

        <li>
          <span class="submenu-navbar">
            <a href="{{url('saved-profile')}}">
              <ion-icon name="save"></ion-icon>
              Saved Profile
            </a>
          </span>
        </li>

        <li>
          <span class="submenu-navbar">
            <a href="{{url('groups')}}">
              <ion-icon name="filing"></ion-icon>
              Groups
            </a>
          </span>
        </li>

        <li>
          <span class="submenu-navbar">
            <a href="{{url('points')}}">
              <ion-icon name="cash"></ion-icon>
              Points
            </a>
          </span>
        </li>

        <li class="active">
          <span class="submenu-navbar">
            <a href="#settingSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              <ion-icon name="settings"></ion-icon>
              Setting
            </a>
          </span>
          
          <ul class="collapse list-unstyled" id="settingSubmenu">
            <li>
              <a href="{{url('edit-profile')}}">
                Edit Profile
              </a>
            </li>
            <li>
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
      <nav class="menu-header">
        <div class="row div-header">
          <div class="col-md-1"></div>

          <div class="col-md-4">
            <div class="row">
              <label class="submenu-header">
                <b>Referral link  </b>
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
                <ion-icon name="home"></ion-icon>
                <b>Home</b>
              </a>
            </span>

            <span class="submenu-header">
              <ion-icon name="notifications"></ion-icon>
              <b>Notification</b>
            </span>
          </div>

          <div class="col-md-1">
            <img class="profpic-header" src="{{Auth::user()->prof_pic}}">
          </div>
        </div>
      </nav>

      <main class="py-3">
        @yield('content')
      </main>

      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-2 footer-txt">
              <span>Omnifluencer 2018</span>
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
    </div>
</div>

 
</body>
</html>
