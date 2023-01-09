<?php
session_start();
// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FLASHCARD SCRIPT | Install</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="./../public/back/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./../public/back/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="./../public/back/dist/css/skins/_all-skins.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="./../public/back/plugins/iCheck/square/blue.css">
    <!-- jQuery 2.1.4 -->
    <script src="./../public/back/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="./../public/back/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="./../public/back/plugins/iCheck/icheck.min.js"></script>
  </head>
  <body class="hold-transition login-page skin-blue sidebar-mini">
  <div class="wrapper">
      <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="./../public/back/dist/img/logo_mini.png"></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="./../public/back/dist/img/logo.png"></span>
        </a>
      </header>
  </div>
      <div class="login-logo" style="color:#009688;margin-top:70px;">
      	Flashcard Builder Installation
      </div><!-- /.login-logo -->
	<section class="content">
		<div class="row">
            <div class="col-md-2">
            	<div class="install_step">
            		<ul>
		            	<li><i class="fa fa-check">&nbsp;&nbsp;</i>Upgrade</li>
		            	<li><i class="fa fa-circle">&nbsp;&nbsp;</i>Finish</li>
            		</ul>
            	</div>
            </div>
            <div class="col-md-10">
            	<div class="install_content">
            		<p>You have successfully upgraded the Avrasys Vocabulary Builder Script</p>
            		<p>For security purpose please remove the "install" folder from your server.</p>
            		<p>You can access the script by visiting the following URL:</p>
            		<a href="#" id="siteUrl" onclick="goSite();"></a>
            		<br><br>
            		<p><input type="checkbox" id="checkbox">&nbsp;&nbsp;For security purposes click here to remove the install directory.</p>
            	</div>
            </div>
        </div>
	</section>
  	<footer class="main-footer" style="position:absolute;width:100%;margin:0;bottom:0px;">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <center><strong>Copyright &copy; <?php echo date('Y'); ?> <a href="https://flashcardscript.com">Flashcardscript.com</a> -</strong> All rights reserved.</center>
    </footer>

<script>
    var siteUrl = "";
    $(function () {
        var url = location.href;
        url = url.substr(0, url.lastIndexOf("/"));
        url = url.substr(0, url.lastIndexOf("/")) + "/";
        siteUrl = url;
        $("a#siteUrl").html(url);
    });

    function goSite() {
        var param = ""
        if(document.getElementById("checkbox").checked) {
            param = "?remove=true"
        }
        location.href= siteUrl + param;
    }
</script>
  </body>
</html>
