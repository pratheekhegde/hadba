<?php
require_once '../CoreLib.php';
session_start();
if(($_SESSION['LoginStatus']==0)||($_SESSION['LoginStatus']==NULL)){
header("location: index.php");
goto end;
}
$classid=$_POST['classID'];
header("location: home.php");
//echo $classid;
$Startup="Startup";
if($classid==NULL){
//echo "Inside if";
header("location: ../error.php");
goto end;
}
else if($classid=="EndSession"){
 //connect to database
	//echo "inside else if";
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="UPDATE `table_data` SET Data1='0', Data2='' WHERE ID='Startup'";
	if(!mysql_query($qry,$bd)){
		die ("1.An unexpected error occured while saving the record, Please try again!");
	}
	header("location: home.php");
}
else{
	//echo "Inside else";
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="UPDATE `table_data` SET Data1='1', Data2='".$classid."' WHERE ID='Startup'";
	if(!mysql_query($qry,$bd)){
		die ("2.An unexpected error occured while saving the record, Please try again!");
	}
}
end:


?>