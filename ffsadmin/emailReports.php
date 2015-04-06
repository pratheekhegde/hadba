<?php
require_once '../CoreLib.php';
$reqClassID =  $_POST['classID'];
//loading faculty allocations
	//**************** USING THE NEW MYSQLI FUNCTIONS*****************************
	$db = new mysqli($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);
	if($db->connect_errno >0){
		die('<br>Unable to connect to database ['.$db->connect_error.']</br>');
	}
	
	$sql="SELECT * FROM `table_data` WHERE ID='$reqClassID'";
	//echo $sql;
	if(!$result = $db->query($sql)){
		die('<br>Unable to execute the SQL Query ['.$db->error.']</br>');
	}
	$subFacMappings = $result->fetch_assoc();
	$i=1;
	while($subFacMappings['Data'.$i]){
		$facEmpID = stripFacEmpCode($subFacMappings['Data'.$i++]);echo "<br>";
	}
	echo "<pre>";print_r($subFacMappings);echo "</pre>";
	//header("location: home.php?select=reportsTab&emailReportSuccess=no&emailReportClass=".$_POST['classID']."");
?>