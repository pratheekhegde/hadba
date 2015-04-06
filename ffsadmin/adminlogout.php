<?php 
require_once '../CoreLib.php';
session_start();
//echo $_POST['val'];
if($_POST['val']==NULL){
goto end;
}
if($_POST['val']=="logout"){
	$_SESSION['LoginStatus']=0;
	$_SESSION['LoginError']=0;
}
end:
header("location: index.php");
?>