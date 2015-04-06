<?php 
require_once './CoreLib.php';
	date_default_timezone_set('Asia/Kolkata');
	//connect to database and load startup row
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `table_data` WHERE ID='Startup'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	$Startup=mysql_fetch_assoc($res);
	$status=$Startup['Data1'];
	if($status==0){
		header("location: index.php?e=1");
		exit();
	}
	$Class=$Startup['Data2'];
	session_start();
	$_SESSION['Class']=$Class;
	$ClientIP=HashString($_SERVER['REMOTE_ADDR']);
	//loading faculty allocations
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `table_data` WHERE ID='".$Class."'";
	$res=mysql_query($qry);
	$allocation=mysql_fetch_assoc($res);
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Choosing The Subject</title>
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
	<script type="text/javascript" src ="jquery-1.11.1.min.js"> </script>
	
<style>
.bs-docs-example {
    position: relative;
    padding: 15px;
    background-color: white;
    border: 1px solid #DDD;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
	width: 768px;
}
 
</style>
</head>
<body>
<div class="container">
	<div class=row> 
		<div class="col-md-12">
			<img src="assets/coll_header.jpg" class="center-block">
		</div>
	<div class=row> 	
		<div class="col-md-12 text-center">
			<h3><?php echo GetClassName($Class);?></h3>
			<h2><?php echo date('l F d, Y h:i');?></h2>
		</div>
	</div>
	<form action="form.php" method=post>
	<div class=row> 	
		<div class="col-md-12">
			<div class="bs-docs-example center-block">
			<div id="chosing_subjects">
			<div id="alert" class="alert alert-danger alert-dismissible text-center " role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><b>Please note that the feedback form for each subject can be filled and submitted only once.</b></div>
			<table class="table table-bordered" style="width: auto;">
				<tr><td class="text-center" colspan=2><b>Choose a subject from the drop-down menu below and click the Open Form button to open it's feedback form.</b></td></tr>
				<tr><td><select class="form-control" name="AllocID" id="AllocID"><option value="none">Choose a subject..</option>
		<?php
			//disable options whose feedback was given;
			$n=1;
			$completed_count=0;
			while($allocation["Data$n"]){
				$FacID=strtolower(stripFacEmpCode($allocation["Data$n"]));
				//echo $FacID;
				$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
				mysql_select_db($mysql_database, $bd) or die("Could not select database");
				$qry="SELECT * FROM $FacID WHERE ClientIP='".$ClientIP."' AND Class='".$_SESSION['Class']."'";
				$res=mysql_query($qry);
				$row=mysql_fetch_assoc($res);
				if($row['SubStat']==1){
					$completed_count++;
					$Fbstatus=" Disabled";
				}
				echo "<option value=".$allocation["Data$n"]."".$Fbstatus.">".getSubname(stripSubcode($allocation["Data$n"]))."</option>";
				$Fbstatus="";
				$n++;
			}
		?>	
	</select></td>
	<td align="center"><input class="btn btn-success" type="submit" value="Open Form" id="OpenForm"></form></td></tr>
			</table></div>
			<div id="feedback_status" align="center">
			<table class="table table-bordered table-condensed" style="width: auto;">
			<th colspan=2 bgcolor="#06D206">Feedback Completed Subjects (<?=$completed_count;?>/<?=--$n;?>)</th>
			<?php
			//Show the subjects whose feedbacks have been completed
			$n=1;
			while($allocation["Data$n"]){
				$FacID=strtolower(stripFacEmpCode($allocation["Data$n"]));
				//echo $FacID;
				$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
				mysql_select_db($mysql_database, $bd) or die("Could not select database");
				$qry="SELECT * FROM $FacID WHERE ClientIP='".$ClientIP."' AND Class='".$_SESSION['Class']."'";
				$res=mysql_query($qry);
				$row=mysql_fetch_assoc($res);
				if($row['SubStat']==1){
					echo "<tr><td>".getSubname(stripSubcode($allocation["Data$n"]))."</td><td align=right><span class=\"glyphicon glyphicon-ok-sign\" style=\"color:#06D206\"></span></td></tr>";
				}
				$n=$n+1;
			}
		?>	
		</table>
		</div>
		<div id="feedback_done" style="display:none;" align="center">
			<div class="jumbotron" style="margin-bottom: 0px;">
				 <h1>Thank You! <span class="glyphicon glyphicon-thumbs-up"></span></h1>
				 <p>For submitting your valuable feedbacks.	We hope you enjoyed this session.</p>
				 <h2><span class="label label-success">You can leave now.</span></h2>
				 </div>
			</div>
			</div>
		</div>
	</div>
</div>
<br>
</div>
<div style="position: fixed; bottom: 10px;left: 100px">
		<hr>
	  <p><h2><span class="glyphicon glyphicon-cog"></span> FFS<small><sup>v3</sup></small></h2><?php GetBuildInfo();?>
	  </p> 
</div>
</body>
<script type="text/javascript">
	$(function(){
			$("#feedback_status").hide().fadeIn(1000);
			if(<?=$completed_count;?>==<?=--$n;?>){
				$("#chosing_subjects").slideUp(1200);
				$("#feedback_status").slideUp(1200);
				$("#feedback_done").fadeIn(1500);
				
			}
			
	});
	
	</script>

</html>