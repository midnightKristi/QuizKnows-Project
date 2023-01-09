<?php
session_start();
$err = 0;

try {
	if (isset($_POST['adminname'], $_POST['adminpassword'])) {
		$adminname = trim($_POST['adminname']);
		$adminpassword = trim($_POST['adminpassword']);
		$adminemail = trim($_POST['adminemail']);
		
		file_put_contents("./.temp", $adminname.'\n\r'.$adminpassword.'\n\r'.$adminemail.'\n\r'); 
		
		//read .env_temp
		$envContent = file_get_contents("./.env_temp");
		$url = $_SERVER['REQUEST_URI'];
		$url = substr($url, 0, strrpos($url, "/"));
		$url = substr($url, 0, strrpos($url, "/"));
		
		$appKey = generateRandomString(32);
		$envContent = str_replace("{appKey}",$appKey,$envContent);
		$envContent = str_replace("{baseUrl}",$url,$envContent);
		$envContent = str_replace("{hostname}",$_SESSION["temp_hostname"],$envContent);
		$envContent = str_replace("{dbname}",$_SESSION["temp_dbname"],$envContent);
		$envContent = str_replace("{username}",$_SESSION["temp_username"],$envContent);
		$envContent = str_replace("{password}",$_SESSION["temp_password"],$envContent);
		
		//echo $envContent;
		file_put_contents("./../.env", $envContent);

		//set versions automatically
		$versionPos = strpos($envContent, "VERSION");
		$versionStr = substr($envContent, $versionPos);
		$endpos = strpos($versionStr, "\n");

		//get version number
		$version = substr($versionStr, 8, $endpos - 9);

		//replace
		$it = new RecursiveDirectoryIterator("./../app/");
		$allowed=array("php");
		foreach(new RecursiveIteratorIterator($it) as $file) {
			if(in_array(substr($file, strrpos($file, '.') + 1),$allowed)) {
				replace_string_in_file($file, '{version}', $version);
			}
		}
		$it = new RecursiveDirectoryIterator("./../resources/");
		foreach(new RecursiveIteratorIterator($it) as $file) {
			if(in_array(substr($file, strrpos($file, '.') + 1),$allowed)) {
				replace_string_in_file($file, '{version}', $version);
			}
		}

		header('Location: ./../register');
	}
}
catch (Exception $e) {
	$err = 2;
}

function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function replace_string_in_file($filename, $string_to_replace, $replace_with){
	$content=file_get_contents($filename);
	$content_chunks=explode($string_to_replace, $content);
	$content=implode($replace_with, $content_chunks);
	file_put_contents($filename, $content);
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
        alert("Database information is incorrect.\n Please try again with correct information.");
    } else if(err == 2) {
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
		            	<li><i class="fa fa-check">&nbsp;&nbsp;</i>Database</li>
		            	<li><i class="fa fa-circle">&nbsp;&nbsp;</i>Create admin</li>
		            	<li><i class="fa fa-circle-o">&nbsp;&nbsp;</i>Finish</li>
            		</ul>
            	</div>
            </div>
            <div class="col-md-8">
            	<div class="install_content">
            		<form id="postForm" class="form-horizontal" method="post">
	                  <div class="box-body">
	                    <div class="form-group">
	                      <label for="inputText" class="col-sm-3 ">Administrator username</label>
	                      <div class="col-sm-4">
	                        <input type="text" class="form-control" name="adminname" required>
	                      </div>
	                    </div>
	                    <div class="form-group">
	                      <label for="inputText" class="col-sm-3 ">Administrator password</label>
	                      <div class="col-sm-4">
	                        <input type="password" class="form-control" id="adminpassword" name="adminpassword" required>
	                      </div>
	                    </div>
	                    <div class="form-group">
	                      <label for="inputText" class="col-sm-3 ">Confirm administrator password</label>
	                      <div class="col-sm-4">
	                        <input type="password" class="form-control" id="adminpasswordConfirm" required>
	                      </div>
	                    </div>
	                    <div class="form-group">
	                      <label for="inputText" class="col-sm-3 ">Administrator email</label>
	                      <div class="col-sm-4">
	                        <input type="email" class="form-control" id="adminemail" name="adminemail" required>
	                      </div>
	                    </div>
	                    <div class="form-group">
	                      <label for="inputText" class="col-sm-3 ">Confirm administrator email</label>
	                      <div class="col-sm-4">
	                        <input type="email" class="form-control" id="adminemailConfirm" required>
	                      </div>
	                    </div>
		                  <div style="margin-top:30px;">
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
        $("#postForm").submit(function(){
            if($("#adminpassword").val() != $("#adminpasswordConfirm").val()) {
                alert("Password doesn't match");
                return false;
            }
            if($("#adminemail").val() != $("#adminemailConfirm").val()) {
                alert("Email doesn't match");
                return false;
            }
            this.submit();
        })
      });
    </script>
  </body>
</html>
