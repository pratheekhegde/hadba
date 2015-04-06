<?php
$end=0;
if($_GET['e']!=NULL)$end=$_GET['e'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Student Faculty Feedback</title>
				<script src="pace/pace.js"></script>
				<link href="pace/pace-flash.css" rel="stylesheet" />
				<script type="text/javascript" src ="jquery-1.11.1.min.js"> </script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
				<!-- Customized CSS -->
				<!--<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/custom.css">-->
				<!-- Optional theme -->
				<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">
				<!-- Latest compiled and minified JavaScript -->
				<script src="bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
	 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="bootstrapForIE9/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="bootstrapForIE9/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- Favicons -->
	<link rel="icon" href="http://getbootstrap.com/favicon.ico">
		<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	 <script type="text/javascript">
	 setInterval(CheckStartup,5000);
	 function CheckStartup(){
		 $.get("phpAJAXHandler.php",{ "ID":"startup" },function(data){
															var startup=data;
															console.log(data.Data1);
															if(data.Data1==1){	
																$("#status").fadeOut("slow");
																$("#status").html("<h1 class=\"text-center text-info\">We are <font color=\"green\">Ready</font>,<br>Please click the Start Feedback Button.</h1><Br><button onclick=\"location.href=\'startsession.php\'\" class=\"btn btn-success center-block btn-lg\">Start Feedback</button></div>").fadeIn();
															}
															
														});
	}
	
</script>
  </head>
  <style>
  body{
  display: compact;
	background-repeat:no-repeat;
	background-position:center;
	background-attachment:fixed;
	background-size:cover;
	-o-background-size:cover;
	-webkit-background-size:cover;
	background-image:url(assets/fbimage.jpg);
}
.glyphicon-animate {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
}

@-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
}

@keyframes spin {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
}
</style>
  <body>
  <div class="container">
	<div class=row> 
		<div class="col-md-12 centered">
		<h1>&nbsp;</h1>
		<h1>&nbsp;</h1>
		<h1>&nbsp;</h1>
		<h1>&nbsp;</h1>
		<h1>&nbsp;</h1>
		<?php 
		if($end==0){
			echo "<div id=\"status\">
				<h1 class=\"text-center text-info\">Please wait while we get ready...<br><br>
				<i class='icon-spin icon-refresh icon-large'></i></h1></div>";
			}else{
				echo "<br><h1 class=\"text-center text-info\"><span class=\"label label-success\">The Feedback Session Has Ended.</span><br>
				<span class=\"label label-success\">Thank You for your valuable Feedbacks.</span></h1>";
			}
		?>
		</div>
	</div>
	</div>
	<div class="navbar-fixed-bottom">
  <div class="container">
  <img src="assets/footer.png" class="center-block">
  </div>
</div>
  </body>
  </html>