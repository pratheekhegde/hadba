<?php
require_once './CoreLib.php';

//connect to database and load startup row
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `table_data` WHERE ID='Startup'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	$Startup=mysql_fetch_assoc($res);
	$Status=$Startup['Data1'];
	$Class=$Startup['Data2'];


session_start();
?>
<DIV STYLE="font-family: 'Lucida Sans';">
<center><h1>Diagnostics</h1>
<table border=0 width=500>
<tr><td>Client IP</td><td>-</td></td><td align=right><?php echo $_SERVER['REMOTE_ADDR'];?></td></tr>
<tr><td>Hashed IP</td><td>-</td><td align=right><?php echo HashString($_SERVER['REMOTE_ADDR']);?></td></tr>
<tr><td>Currrent Selected Class</td><td>-</td><td align=right><?php echo GetClassName($Class);?></td></tr>
<tr><td>Feedback Session</td><td>-</td><td align=right><?php if($Status==0){
								echo "No Session";
								}else{
								echo "Session Running";
							}?></td></tr>
</table>
</div>