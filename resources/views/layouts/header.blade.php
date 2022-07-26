<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="description" content="Miminium Admin Template v.1">
  <meta name="author" content="Isna Nur Azis">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Miminium</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

  <!-- plugins -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css" />
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css" />
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/fullcalendar.min.css" />
  <link href="asset/css/style.css" rel="stylesheet">
  <!-- end: Css -->

  <link rel="shortcut icon" href="asset/img/logomi.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="mimin" class="dashboard">
  <!-- start: Header -->
  <nav class="navbar navbar-default header navbar-fixed-top">
    <div class="col-md-12 nav-wrapper">
      <div class="navbar-header" style="width:100%;">
        <div class="opener-left-menu is-open">
          <span class="top"></span>
          <span class="middle"></span>
          <span class="bottom"></span>
        </div>
        <a href="index.html" class="navbar-brand">
          <b>MIMIN</b>
        </a>

        <ul class="nav navbar-nav navbar-right user-nav">
          <li class="user-name"><span>{{ Auth::user()->name }}</span></li>
          <li class="dropdown avatar-dropdown mr-4">
            <img src="asset/img/avatar.jpg" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" />
            <ul class="dropdown-menu user-dropdown">
              <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  <span class="fa fa-power-off"></span> {{ __('Logout') }}
                </a></li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- end: Header -->

  <div class="container-fluid mimin-wrapper">

    <!-- start:Left Menu -->
    <div id="left-menu">
      <div class="sub-left-menu scroll">
        <ul class="nav nav-list">
          <li>
            <div class="left-bg"></div>
          </li>
          <li class="time">
            <h1 class="animated fadeInLeft">21:00</h1>
            <p class="animated fadeInRight">Sat,October 1st 2029</p>
          </li>
          <li class="active ripple">
            <a class="tree-toggle nav-header"><span class="fa-home fa"></span> Dashboard
              <span class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
              <li><a href="#">Dashboard</a></li>
            </ul>
          </li>
          <li class="ripple"><a class="tree-toggle nav-header"><span class="fa fa-table"></span> Tables <span class="fa-angle-right fa right-arrow text-right"></span> </a>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('users.index') }}">Users</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
    <!-- end: Left Menu -->


    <!-- start: content -->
    <div id="content">
      <div class="panel">
        <div class="panel-body">
          <div class="col-md-6 col-sm-12">
            <h3 class="animated fadeInLeft">Help Desk</h3>
            <p class="animated fadeInDown"><span class="fa  fa-map-marker"></span> Bandung, Indonesia</p>
          </div>
        </div>
      </div>

      <!-- sambungan -->
      @yield('content')

    </div>
    <!-- end: content -->


  </div>

  <!-- start: Mobile -->
  <div id="mimin-mobile" class="reverse">
    <div class="mimin-mobile-menu-list">
      <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
        <ul class="nav nav-list">
          <li class="active ripple">
            <a class="tree-toggle nav-header">
              <span class="fa-home fa"></span>Dashboard
              <span class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
              <li><a href="#">Dashboard</a></li>
            </ul>
          </li>
          <li class="ripple">
            <a class="tree-toggle nav-header">
              <span class="fa fa-table"></span>Tables
              <span class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('users.index') }}">Users</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle btn-danger">
    <span class="fa fa-bars"></span>
  </button>
  <!-- end: Mobile -->

  @extends('layouts.footer')