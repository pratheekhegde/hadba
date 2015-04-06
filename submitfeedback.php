<?php 
require_once './CoreLib.php';
date_default_timezone_set('Asia/Kolkata');
$Timestamp=date('d-m-Y h:i:s');
session_start();
$Class=$_SESSION['Class'];
$ClientIP=HashString($_SERVER['REMOTE_ADDR']);
$FacID=$_POST['FacID'];
$FacName=GetFacName($FacID);
if($FacID==NULL){
	header("location: error.php");
	exit();
}
//echo $_POST['FacID'];
//echo $_POST['21'];
//echo $_SESSION['Class'];echo "<br>";
//echo $_POST['20'];echo "<br>";
//echo $ClientIP;

 //Check if questions were not answered
if(!$_POST['1'] || !$_POST['2'] || !$_POST['3'] || !$_POST['4'] || !$_POST['5'] || !$_POST['6'] || !$_POST['7'] || !$_POST['8'] || !$_POST['9'] || !$_POST['10'] || !$_POST['11'] || !$_POST['12'] || !$_POST['13'] || !$_POST['14'] || !$_POST['15'] || !$_POST['16'] || !$_POST['17'] || !$_POST['18'] || !$_POST['19'] || !$_POST['20']){
	echo "<div class=\"modal fade bs-example-modal-lg\" id=\"feedbackStatus\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel2\" aria-hidden=\"true\">
					<div class=\"modal-dialog\">
						<div class=\"modal-content\">
							<div class=\"modal-header\">
								<h4 class=\"modal-title \" id=\"myModalLabel2\">Feedback Submission Status</h4>
							</div>
							<div class=\"modal-body text-center\">
									<h2>Your Feedback</font> for <b>$FacName</b> <br>was not saved,<br> Since you haven't answered all the questions.</h2>
									<h1 style=\"color:red\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></h1>
								  </div>
					  <div class=\"modal-footer\">
						<button type=\"button\" class=\"btn btn-info\" data-dismiss=\"modal\">Try Again</button>
						<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Goto Subject Lists Page\" onclick=\"location.href='startsession.php'\" class=\"btn btn-warning\">Go Back To Subjects List</button>
					  </div>
					</div>
				  </div>
				</div>";
	
	goto end;
} 
//Check if feedback was already submitted once
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM $FacID WHERE ClientIP='".$ClientIP."' AND Class='".$_SESSION['Class']."'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while checking some things, Please try again!");
	}
	$row=mysql_fetch_assoc($res);
	$status=$row['SubStat'];
	if($status==1){
			echo "<div class=\"modal fade bs-example-modal-lg\" id=\"feedbackStatus\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel2\" aria-hidden=\"true\">
					<div class=\"modal-dialog\">
						<div class=\"modal-content\">
							<div class=\"modal-header\">
								<h4 class=\"modal-title \" id=\"myModalLabel2\">Feedback Submission Status</h4>
							</div>
							<div class=\"modal-body text-center\">
									<h2>Your Feedback</font> for <b>$FacName</b> <br>was not saved,<br> Since you have already submitted it once.</h2>
									<h1 style=\"color:red\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></h1>
								  </div>
					  <div class=\"modal-footer\">
						<button type=\"button\" class=\"btn btn-info\" data-dismiss=\"modal\">Try Again</button>
						<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Goto Subject Lists Page\" onclick=\"location.href='startsession.php'\" class=\"btn btn-warning\">Go Back To Subjects List</button>
					  </div>
					</div>
				  </div>
				</div>";
		goto end;
	}
	$comments=mysql_real_escape_string($_POST['21']);//escaping the special characters
	//connect to database and save
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="UPDATE $FacID SET Timestamp='".$Timestamp."', SubStat='1', Q1='".$_POST['1']."', Q2='".$_POST['2']."', Q3='".$_POST['3']."', Q4='".$_POST['4']."', Q5='".$_POST['5']."', Q6='".$_POST['6']."', Q7='".$_POST['7']."', Q8='".$_POST['8']."', Q9='".$_POST['9']."', Q10='".$_POST['10']."', Q11='".$_POST['11']."', Q12='".$_POST['12']."', Q13='".$_POST['13']."', Q14='".$_POST['14']."', Q15='".$_POST['15']."', Q16='".$_POST['16']."', Q17='".$_POST['17']."', Q18='".$_POST['18']."', Q19='".$_POST['19']."', Q20='".$_POST['20']."',Q21='".$comments."' WHERE ClientIP='".$ClientIP."' AND Class='".$_SESSION['Class']."'";
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	echo "<div class=\"modal fade bs-example-modal-lg\" id=\"feedbackStatus\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel2\" aria-hidden=\"true\">
					<div class=\"modal-dialog\">
						<div class=\"modal-content\">
							<div class=\"modal-header\">
								<h4 class=\"modal-title \" id=\"myModalLabel2\">Feedback Submission Status</h4>
							</div>
							<div class=\"modal-body text-center\">
									<h2>Your Feedback</font> for <b>$FacName</b> <br>has been saved.</h2>
									<h1 style=\"color:#06D206\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></h1>
								  </div>
					  <div class=\"modal-footer\">
						<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Goto Subject Lists Page\" onclick=\"location.href='startsession.php'\" class=\"btn btn-success\">Okay, Go Back To Subjects List</button>
					  </div>
					</div>
				  </div>
				</div>";
	end:
?>



