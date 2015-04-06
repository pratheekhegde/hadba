<?php 
require_once './CoreLib.php';
header('Content-Type:application/json');
if($_GET['ID']=="startup"){
//connect to database
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `table_data` WHERE ID='Startup'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	$startup=mysql_fetch_assoc($res);
	$status=$startup['Data1'];
	echo json_encode($startup,JSON_PRETTY_PRINT);
	
}

?>