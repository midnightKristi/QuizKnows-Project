<?php
/******************************************************
 * Flashcard script
 * Version : {version}
 * Copyright© 2016 Avrasys Ltd. All Rights Reversed.
 * This file may not be redistributed.
 * Author URL:https://flashcardscript.com
 ******************************************************/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ Config::get('SITE_TITLE') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/back/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/back/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/back/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/back/dist/css/skins/_all-skins.css">
    <!-- jQuery 2.1.4 -->
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/dist/js/app.min.js"></script>
    <!-- Sparkline -->
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/plugins/chartjs/Chart.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
   <!--  <script src="/back/dist/js/pages/dashboard2.js"></script> -->
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="/back/dist/js/demo.js"></script> -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/back/bootstrap/css/bootstrap-formhelpers.min.css">
	<script src="{{ Config::get('RELATIVE_URL') }}/public/back/bootstrap/js/bootstrap-formhelpers.min.js"></script>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="{{ Config::get('RELATIVE_URL') }}/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="{{ Config::get('RELATIVE_URL') }}/public/back/dist/img/logo_mini.png"></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="{{ Config::get('RELATIVE_URL') }}/public/back/dist/img/logo.png"></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div style="float:left;">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="{{ Config::get('RELATIVE_URL') }}/setting">
                  <img src="@if (Sentinel::getUser()->photo == null) {{ Config::get('RELATIVE_URL') }}/public/images/no-image.jpg @else {{ Config::get('RELATIVE_URL') }}/public{{Sentinel::getUser()->photo}} @endif" class="user-image" alt="User Image">
                  <span class="hidden-xs">{{ Sentinel::getUser()->username}}</span>
                </a>                
              </li>
            </ul>
          </div>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
          	<div style="margin:13px 20px 10px 10px;"><a class="btn btn-danger" href="{{ Config::get('RELATIVE_URL') }}/logout">{!! trans('flashcard.logout') !!}</a></div>          
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li>
              <a href="{{ Config::get('RELATIVE_URL') }}/words">
                <i class="fa fa-file-audio-o"></i> <span>{!! trans('flashcard.addWords') !!}</span>
              </a>
            </li>
            <li>
              <a href="{{ Config::get('RELATIVE_URL') }}/cats">
                <i class="fa fa-th"></i> <span>{!! trans('flashcard.addCategories') !!}</span>
              </a>
            </li>
            <li>
              <a href="{{ Config::get('RELATIVE_URL') }}/exercises">
                <i class="fa fa-picture-o"></i> <span>{!! trans('flashcard.addExercises') !!}</span>
              </a>
            </li>
            <li>
              <a href="{{ Config::get('RELATIVE_URL') }}/setting">
                <i class="fa fa-gears"></i> <span>{!! trans('flashcard.settings') !!}</span>
              </a>
            </li>
            <li>
              <a href="{{ Config::get('RELATIVE_URL') }}/profile">
                <i class="fa fa-user"></i> <span>{!! trans('flashcard.profile') !!}</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        @yield('content')
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> {version}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <center><strong>Copyright &copy; {{ date('Y') }} <a href="https://flashcardscript.com">Flashcardscript.com</a> -</strong> All rights reserved.</center>
      </footer>
    </div><!-- ./wrapper -->
  </body>
</html>