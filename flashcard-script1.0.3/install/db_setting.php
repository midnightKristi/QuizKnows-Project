<?php
session_start();
error_reporting( 0 );

$err = 0;
try {

	if (isset($_POST['hostname'], $_POST['dbname'])) {
		$hostname = trim($_POST['hostname']);
		$dbname = trim($_POST['dbname']);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		# MySQL with PDO_MYSQL
		$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
		
		$query = file_get_contents("./db.sql");
		
		$stmt = $db->prepare($query);
		
		if ($stmt->execute()) {
			$_SESSION["temp_hostname"] = $hostname;
			$_SESSION["temp_dbname"] = $dbname;
			$_SESSION["temp_username"] = $username;
			$_SESSION["temp_password"] = $password;
			header('Location: ./admin_setting.php');
			exit;
		}
		else
			$err = 1;
	}
}
catch (PDOException $e) {
	//echo $e;
	$err = 2;
}
catch (Exception $e) {
	//echo $e;
	$err = 3;
}
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
    <script>
    var err = "<?= $err ?>";
    if(err == 1) {
        alert("Cannot excute sql script");
    } else if(err == 2) {
    	alert("Cannot connect database");
    } else if(err == 3) {
    	alert("Unknow error : please check your system setting.");
    } 
    </script>
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
		            	<li><i class="fa fa-check">&nbsp;&nbsp;</i>Welcome</li>
		            	<li><i class="fa fa-circle">&nbsp;&nbsp;</i>Database</li>
		            	<li><i class="fa fa-circle-o">&nbsp;&nbsp;</i>Create admin</li>
		            	<li><i class="fa fa-circle-o">&nbsp;&nbsp;</i>Finish</li>
            		</ul>
            	</div>
            </div>
            <div class="col-md-10">
            	<div class="install_content">
            		<form class="form-horizontal" method="post">
	                  <div class="box-body">
	                    <div class="form-group">
	                      <label for="inputText" class="col-sm-2 ">Database hostname</label>
	                      <div class="col-sm-4">
	                        <input type="text" class="form-control" name="hostname" required>
	                      </div>
	                    </div>
	                    <div class="form-group">
	                      <label for="inputText" class="col-sm-2 ">Database name</label>
	                      <div class="col-sm-4">
	                        <input type="text" class="form-control" name="dbname" required>
	                      </div>
	                    </div>
	                    <div class="form-group">
	                      <label for="inputText" class="col-sm-2 ">Database username</label>
	                      <div class="col-sm-4">
	                        <input type="text" class="form-control" name="username" required>
	                      </div>
	                    </div>
	                    <div class="form-group">
	                      <label for="inputText" class="col-sm-2 ">Database password</label>
	                      <div class="col-sm-4">
	                        <input type="password" class="form-control" name="password" required>
	                      </div>
	                    </div>
		                  <div style="margin-top:50px;">
		                    <button type="submit" class="btn btn-success">Continue</button>
		                  </div><!-- /.box-footer -->
	                  </div><!-- /.box-body -->
	                </form>
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
      $(function () {
        
      });
    </script>
  </body>
</html>
