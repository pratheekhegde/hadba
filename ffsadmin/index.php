<?php 
require_once '../CoreLib.php';
session_start();
if($_SESSION['LoginStatus']==1){
	header("location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Panel</title>
				<script src="../pace/pace.js"></script>
				<link href="../pace/pace-flash.css" rel="stylesheet" />
				<script type="text/javascript" src ="../jquery-1.11.1.min.js"> </script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="../bootstrap-3.3.2-dist/css/bootstrap.min.css">
				<!-- Customized CSS -->
				<!--<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/custom.css">-->
				<!-- Optional theme -->
				<link rel="stylesheet" href="../bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">
				<!-- Latest compiled and minified JavaScript -->
				<script src="../bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
	 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="bootstrapForIE9/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="bootstrapForIE9/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- Favicons -->
	<link rel="icon" href="http://getbootstrap.com/favicon.ico">
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
	<style>
	.bs-docs-example {
		position: relative;
		padding: 15px;
		background-color: white;
		border: 1px solid #DDD;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		
	}
	 
	</style>
</head>
<body>
<div class="container">
	<div class="row"> 
		<div class="col-md-12 text-center">
			<img src="../assets/coll_header.jpg" class="center-block">
			<h1>ADMIN PANEL</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
		<div class="bs-docs-example center-block">
				<form class="form-horizontal" action="adminLogin.php" method="post">
				  <div class="form-group">
					<label for="adminUname" class="col-sm-4 control-label">Username :</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="adminUname" name="adminUname" placeholder="Username">
					</div>
				  </div>
				  <div class="form-group">
					<label for="adminPass" class="col-sm-4 control-label">Password :</label>
					<div class="col-sm-8">
					  <input type="password" class="form-control" id="adminPass" name="adminPass" placeholder="Password">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-12 text-center">
					  <button type="submit" class="btn btn-primary">Sign in</button>
					  <?php if($_SESSION['LoginError']==1) echo "<h3><span class=\"label label-danger\">Username  Or Password Incorrect!</span></h3>";?>
					</div>
				  </div>
				</form>
		</div>
		</div>
	</div>
	<div class="row">
	<div class="col-md-8 col-md-offset-2">
	<hr>
	  <h2><span class="glyphicon glyphicon-cog"></span> FFS<small><sup>v3</sup></small></h2> <?php GetBuildInfo();?>
	 </div>
	</div>
</div>
</body>
</html>


