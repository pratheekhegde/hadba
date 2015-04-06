<?php 
		require_once '../CoreLib.php';
		session_start();
		//Check for Login Flags
		if(($_SESSION['LoginStatus']==0)||($_SESSION['LoginStatus']==NULL)){
			header("location: ./index.php");
		}
		$searchQuery = $_REQUEST['searchQuery'];
		$checkNewFacEmpCode = $_REQUEST['checkNewFacEmpCode'];
		
		//New Faculty Information to be saved in the database
		$newFacName = $_REQUEST['newFacName'];
		$newFacEmpCode =  strtoupper($_REQUEST['newFacEmpCode']);
		$newFacDep = $_REQUEST['newFacDep'];
		//---------------------------------------------------
		//for Updating Edited Faculty Information 
		$editFacName = $_REQUEST['editFacName'];
		$editFacEmpCode = $_REQUEST['editFacEmpCode'];
		$editFacDep = $_REQUEST['editFacDep'];
		//---------------------------------------------------
		//for Deleting Faculty Information 
		$delFacEmpCode = $_REQUEST['delFacEmpCode'];
		$delFacName = $_REQUEST['delFacName'];	
		//Checking for Employee Code
		if($checkNewFacEmpCode != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			$res=mysql_query("SELECT * FROM `table_faculty_info` WHERE empcode='$checkNewFacEmpCode'");
			//echo $checkNewFacEmpCode;
			if($res) {
				if(mysql_num_rows($res) > 0) {
					echo "No";
				}else echo "Yes";
				
			}else echo "Something Went Wrong while checking for newFacEmpCode";
		}
		
		//Loading the Faculty List Table based on Search Query
		if(substr($_POST['searchQuery'],0,3)==" "){ echo "";exit();}
		if($searchQuery != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			#echo $searchQuery;
			$res=mysql_query("SELECT * FROM `table_faculty_info` WHERE name LIKE '%".$searchQuery."%' OR empCode LIKE '%".$searchQuery."%'");
			if(mysql_num_rows($res)==0){
					$result.= "<div class=\"alert alert-danger\" role=\"alert\">
						<b>Sorry</b>, There are no results for Query <big><b>".$searchQuery." !</b></big></div>";
			}else{
					$result="<table class=\"table table-hover table-bordered\">
					<tbody>";
					$result.= "<th>#</th><th>Employee Code</th><th>Name</th><th>Department</th><th>Options</th>";
					$num=1;
					while($results=mysql_fetch_array($res)){
						$result.= "<tr><td>".$num++."</td><td>".$results['empcode']."</td><td>".$results['name']."</td><td>".$results['dep']."</td>";
						$result.="<td><button type=\"button\" class=\"btn btn-default btn-xs\" data-toggle=\"modal\" data-target=\"#editFacModal\" data-empCode=\"".$results['empcode']."\" data-facName=\"".$results['name']."\" data-facDep=\"".$results['dep']."\"><span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Edit The Faculty Info\"></span> Edit</button>
									  <button type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#deleteFacModal\" data-empCode=\"".$results['empcode']."\" data-facName=\"".$results['name']."\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Delete The Faculty\"></span> Delete</button>
									</td></tr>
									<input type=\"hidden\" id=\"lastFacAjaxQuery\" value=\"searchQuery=".$searchQuery."\">";
					}
			}
			$result.="</tbody></table>";
			print $result;
		}
		
		//Adding a New Faculty
		if($newFacName != NULL & $newFacEmpCode != NULL & $newFacDep != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			$query="INSERT INTO `table_faculty_info` SET empcode='".$newFacEmpCode."',name='".$newFacName."', dep='".$newFacDep."'";
			if(!mysql_query($query,$bd)){
				die ("<b>Looks like something went wrong while saving the new Faculty, Please Try again!</b>");
			}else{
				echo "<h4><b>".$newFacName."</b> has been Saved with Employee Code <b>".$newFacEmpCode."</b>. <span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\" style=\"color:#06D206\"></span></h4>";
			}
		}
		
		//Updating an Existing Faculty
		if($editFacName != NULL & $editFacEmpCode != NULL & $editFacDep != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			$query="UPDATE `table_faculty_info` SET name='".$editFacName."', dep='".$editFacDep."' WHERE empcode='".$editFacEmpCode."'";
			if(!mysql_query($query,$bd)){
				die ("Looks like something went wrong while Updating The Faculty <b>".$editFacEmpCode."</b>, Please Try again!");
			}else{
				echo "<h4 class=\"text-center\">Employee Code <b>".$editFacEmpCode."</b> has been Updated with<br> Name <b>".$editFacName."</b> and Department <b>".$editFacDep."</b>. <span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\" style=\"color:#06D206\"></span></h4>";
			}
		}
		
		//Deleting an Existing Faculty
		if($delFacName != NULL & $delFacEmpCode != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			$query="DELETE from `table_faculty_info` WHERE empcode='".$delFacEmpCode."'";
			if(!mysql_query($query,$bd)){
				die ("Looks like something went wrong while Deleting The Faculty <b>".$delFacEmpCode."</b>, Please Try again!");
			}else{
				echo "<h4><b>".$delFacName."</b> of Employee Code <b>".$delFacEmpCode."</b> <br>has been successfully deleted from the Feedback System. <span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\" style=\"color:#06D206\"></span></h4>";
			}
			
		}
		
?>