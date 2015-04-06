<?php 
require_once '../CoreLib.php';
session_start();
if($_SESSION['LoginStatus']==NULL){
	header("location: index.php");
}
if(($_POST['adminUname']==NULL) || ($_POST['adminPass']==NULL)){
	header("location: index.php");
}
$uname=HashString($_POST['adminUname']);
$pass=HashString($_POST['adminPass']);

$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `table_data` WHERE ID='Startup'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	$Startup=mysql_fetch_assoc($res);
	if(($Startup['Data3']==$uname) && ($Startup['Data4']==$pass)){
		$_SESSION['LoginStatus']=1;
		$_SESSION['LoginError']=0;
		header("location: home.php");
	}else {
		header("location: index.php");
		$_SESSION['LoginError']=1;
		$_SESSION['LoginStatus']=0;
	}
?>