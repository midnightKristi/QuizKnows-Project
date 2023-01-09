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
    <title>{{ Config::get('SITE_TITLE') }} | {!! trans('flashcard.forgotPassword') !!}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/back/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/back/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/back/dist/css/skins/_all-skins.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/back/plugins/iCheck/square/blue.css">
  </head>
  <body class="hold-transition login-page skin-blue sidebar-mini">
  <div class="wrapper">
      <header class="main-header">

        <!-- Logo -->
        <a href="{{ Config::get('RELATIVE_URL') }}/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="{{ Config::get('RELATIVE_URL') }}/public/back/dist/img/logo.png"></span>
        </a>
      </header>
  </div>
    <div class="login-box">
      <div class="login-logo">
        {!! trans('flashcard.vocabularyBuilderAdministrator') !!}
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">{!! trans('flashcard.forgotPassword') !!}</p>
        <div class="divide-line"></div>
        @include('common.errors')
        <form action="{{ Config::get('RELATIVE_URL') }}/forgot-password" method="post">
        	{{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="{!! trans('flashcard.email') !!}" name="email" value="{{ old('email') }}">
          </div>
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-success btn-block btn-flat btn-lg">{!! trans('flashcard.sendPassword') !!}</button>
            </div><!-- /.col -->
          </div>
        </form>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
	<footer class="main-footer" style="position:absolute;width:100%;margin:0;bottom:0px;">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <center><strong>Copyright &copy; {{ date('Y') }} <a href="https://flashcardscript.com">Flashcardscript.com</a>-</strong> All rights reserved.</center>
    </footer>

    <!-- jQuery 2.1.4 -->
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="{{ Config::get('RELATIVE_URL') }}/public/back/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>