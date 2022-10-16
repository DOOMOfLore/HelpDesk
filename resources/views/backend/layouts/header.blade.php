<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="description" content="HD">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Help Desk</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="assets/backend/css/bootstrap.min.css">

  <!-- plugins -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/plugins/font-awesome.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/plugins/simple-line-icons.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/plugins/animate.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/plugins/fullcalendar.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/backend/css/style.css') }}" />
  <!-- end: Css -->

  <!-- <link rel="shortcut icon" href="{{ asset('assets/backend/img/logomi.png') }}" /> -->
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="hd" class="dashboard">
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
          <b>Help Desk</b>
        </a>

        <ul class="nav navbar-nav navbar-right user-nav">
          <li class="user-name"><span>{{ Auth::user()->name }}</span></li>
          <li class="dropdown avatar-dropdown mr-4">
            <img src="assets/backend/img/avatar.jpg" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" />
            <ul class="dropdown-menu user-dropdown">
              <li><a id="logout-form">
                  <span class="fa fa-power-off"></span> {{ __('Logout') }}
                </a>
              </li>
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
          <li class="ripple" id="dashboard-menu">
            <a class="tree-toggle nav-header"><span class="fa-home fa"></span> Dashboard
              <span class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('dashboard.index') }}" id="dashboard-menu">Dashboard</a></li>
            </ul>
          </li>
          <li class="ripple" id="tables-menu">
            <a class="tree-toggle nav-header">
              <span class="fa fa-table"></span> Tables
              <span class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('users.index') }}" id="users-menu">Users</a></li>
            </ul>
          </li>
          <li class="ripple" id="master-menu">
            <a class="tree-toggle nav-header">
              <span class="fa fa-table"></span> Master
              <span class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('categories.index') }}" id="categories-menu">Categories</a></li>
            </ul>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('main_menu.index') }}" id="main_menu-menu">Main Menu</a></li>
            </ul>
          </li>
          <li class="ripple" id="complaint-menu">
            <a class="tree-toggle nav-header">
              <span class="fa fa-check-square-o"></span> Complaint
              <span class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('complaint.index') }}" id="complaints-menu">All</a></li>
            </ul>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('release.index') }}" id="release-menu">Release</a></li>
            </ul>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('waiting_approval.index') }}" id="waitingapproval-menu">Waiting Approval</a></li>
            </ul>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('onprocess.index') }}" id="onprocess-menu">On Process</a></li>
            </ul>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('unapproved.index') }}" id="unapproved-menu">Unapproved</a></li>
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
          <li class="ripple" id="dashboard-menu">
            <a class="tree-toggle nav-header">
              <span class="fa-home fa"></span>Dashboard
              <span class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            </ul>
          </li>
          <li class="ripple" id="tables-menu">
            <a class="tree-toggle nav-header">
              <span class="fa fa-table"></span> Tables
              <span class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('users.index') }}" id="users-menu">Users</a></li>
            </ul>
          </li>
          <li class="ripple" id="master-menu">
            <a class="tree-toggle nav-header">
              <span class="fa fa-table"></span> Master
              <span class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('categories.index') }}" id="categories-menu">Categories</a></li>
            </ul>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('main_menu.index') }}" id="main_menu-menu">Main Menu</a></li>
            </ul>
          </li>
          <li class="ripple" id="complaint-menu">
            <a class="tree-toggle nav-header">
              <span class="fa fa-check-square-o"></span> Complaint
              <span class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('complaint.index') }}" id="complaints-menu">All</a></li>
            </ul>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('release.index') }}" id="release-menu">Release</a></li>
            </ul>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('waiting_approval.index') }}" id="waitingapproval-menu">Waiting Approval</a></li>
            </ul>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('onprocess.index') }}" id="onprocess-menu">On Process</a></li>
            </ul>
            <ul class="nav nav-list tree">
              <li><a href="{{ route('unapproved.index') }}" id="unapproved-menu">Unapproved</a></li>
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

  @extends('backend.layouts.footer')