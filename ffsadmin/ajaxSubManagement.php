<?php
		require_once '../CoreLib.php';
		session_start();
		//Check for Login Flags
		if(($_SESSION['LoginStatus']==0)||($_SESSION['LoginStatus']==NULL)){
			header("location: ./index.php");
		}
		
		$subSearchQuery = $_REQUEST['subSearchQuery'];
		$subSearchYear = $_REQUEST['subSearchYear'];
		$subSearchDep = $_REQUEST['subSearchDep'];
		$checkNewSubCode = $_REQUEST['checkNewSubCode'];
		
		//New Subject Information to be saved in the database
		$newSubName = $_REQUEST['newSubName'];
		$newSubCode = strtoupper($_REQUEST['newSubCode']);
		$newSubDep = $_REQUEST['newSubDep'];
		$newSubYear = $_REQUEST['newSubYear'];
		//---------------------------------------------------
		//for Updating Edited Subject Information 
		$editSubName = $_REQUEST['editSubName'];
		$editSubCode = $_REQUEST['editSubCode'];
		$editSubDep = $_REQUEST['editSubDep'];
		$editSubYear = $_REQUEST['editSubYear'];
		//---------------------------------------------------
		//for Deleting Subject Information 
		$delSubCode = $_REQUEST['delSubCode'];
		$delSubName = $_REQUEST['delSubName'];	
		
		//Checking for Subject Code
		if($checkNewSubCode != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			$res=mysql_query("SELECT * FROM `table_subjects` WHERE subcode='$checkNewSubCode'");
			//echo $checkNewFacEmpCode;
			if($res) {
				if(mysql_num_rows($res) > 0) {
					echo "No";
				}else echo "Yes";
				
			}else echo "Something Went Wrong while checking for newFacSubCode";
		}
//Loading the Subject List Table based on Search Query
		if(substr($_POST['subSearchQuery'],0,3)==" "){ echo "";exit();}
		if($subSearchQuery != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			#echo $searchQuery;
			$res=mysql_query("SELECT * FROM `table_subjects` WHERE subcode LIKE '%".$subSearchQuery."%' OR subname LIKE '%".$subSearchQuery."%'");
			if(mysql_num_rows($res)==0){
					$result.= "<div class=\"alert alert-danger\" role=\"alert\">
						<b>Sorry</b>, There are no results for Query <big><b>".$subSearchQuery." !</b></big></div>
						<input type=\"hidden\" id=\"lastAjaxQuery\" value=\"subSearchQuery=".$subSearchQuery."\">";
			}else{
					$result="<table class=\"table table-hover table-bordered\">
					<tbody>";
					$result.= "<th>#</th><th>Subject Code</th><th>Name</th><th>Department</th><th>Year</th><th>Options</th>";
					$num=1;
					while($results=mysql_fetch_array($res)){
						$result.= "<tr><td>".$num++."</td><td>".$results['subcode']."</td><td>".$results['subname']."</td><td>".$results['dep']."</td><td>".$results['subyear']."</td>";
						$result.="<td><button type=\"button\" class=\"btn btn-default btn-xs\" data-toggle=\"modal\" data-target=\"#editSubModal\" data-subCode=\"".$results['subcode']."\" data-subName=\"".$results['subname']."\" data-subDep=\"".$results['dep']."\" data-subyear=\"".$results['subyear']."\"><span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Edit The Subject Info\"></span> Edit</button>
									  <button type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#deleteSubModal\" data-subCode=\"".$results['subcode']."\" data-subName=\"".$results['subname']."\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Delete The Subject\"></span> Delete</button>
									</td></tr>
									<input type=\"hidden\" id=\"lastSubAjaxQuery\" value=\"subSearchQuery=".$subSearchQuery."\">";
					}
			}
			$result.="</tbody></table>";
			print $result;
		}
//Loading Subject list based on custom search
		if($subSearchYear != NULL && $subSearchDep != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			#echo $searchQuery;
			$res=mysql_query("SELECT * FROM `table_subjects` WHERE subyear LIKE '%".$subSearchYear."%' AND dep LIKE '%".$subSearchDep."%'");
			if(mysql_num_rows($res)==0){
					$result.= "<div class=\"alert alert-danger\" role=\"alert\">
						<b>Sorry</b>, There are no <B>Subjects</b> for the Year <big><b>".$subSearchYear."</b></big> and Department <big><b>".$subSearchDep."!</b></big></div>
						<input type=\"hidden\" id=\"lastAjaxQuery\" value=\"subSearchYear=".$subSearchYear."&subSearchDep=".$subSearchDep."\">";
			}else{
					$result="<table class=\"table table-hover table-bordered\">
					<tbody>";
					$result.= "<th>#</th><th>Subject Code</th><th>Name</th><th>Department</th><th>Year</th><th>Options</th>";
					$num=1;
					while($results=mysql_fetch_array($res)){
						$result.= "<tr><td>".$num++."</td><td>".$results['subcode']."</td><td>".$results['subname']."</td><td>".$results['dep']."</td><td>".$results['subyear']."</td>";
						$result.="<td><button type=\"button\" class=\"btn btn-default btn-xs\" data-toggle=\"modal\" data-target=\"#editSubModal\" data-subCode=\"".$results['subcode']."\" data-subName=\"".$results['subname']."\" data-subDep=\"".$results['dep']."\" data-subyear=\"".$results['subyear']."\"><span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Edit The Subject Info\"></span> Edit</button>
									  <button type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#deleteSubModal\" data-subCode=\"".$results['subcode']."\" data-subName=\"".$results['subname']."\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Delete The Subject\"></span> Delete</button>
									</td></tr>
									<input type=\"hidden\" id=\"lastSubAjaxQuery\" value=\"subSearchYear=".$subSearchYear."&subSearchDep=".$subSearchDep."\">";
					}
			}
			$result.="</tbody></table>";
			print $result;
		}
		
		//Adding a New Subject
		if($newSubName != NULL & $newSubCode != NULL & $newSubDep != NULL & $newSubYear != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			$query="INSERT INTO `table_subjects` SET subcode='".$newSubCode."',subname='".$newSubName."', dep='".$newSubDep."', subyear='".$newSubYear."'";
			if(!mysql_query($query,$bd)){
				die ("<b>Looks like something went wrong while saving the new Subject, Please Try again!</b>");
			}else{
				echo "<h4><b>".$newSubName."</b> has been Saved with Subject Code <b>".$newSubCode."</b>. <span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\" style=\"color:#06D206\"></span></h4>";
			}
		}
		
		//Updating an Existing Subject
		if($editSubName != NULL & $editSubCode != NULL & $editSubDep != NULL & $editSubYear != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			$query="UPDATE `table_subjects` SET subname='".$editSubName."', dep='".$editSubDep."', subyear='".$editSubYear."' WHERE subcode='".$editSubCode."'";
			if(!mysql_query($query,$bd)){
				die ("Looks like something went wrong while Updating The Subject <b>".$editSubCode."</b>, Please Try again!");
			}else{
				echo "<h4 class=\"text-center\">Subject Code <b>".$editSubCode."</b> has been Updated with Name <b>".$editSubName."</b>, Department <b>".$editSubDep."</b> and Year <b>".$editSubYear."</b>. <span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\" style=\"color:#06D206\"></span></h4>";
			}
		}
		//Deleting an Existing Subject
		if($delSubName != NULL & $delSubCode != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			$query="DELETE from `table_subjects` WHERE subcode='".$delSubCode."'";
			if(!mysql_query($query,$bd)){
				die ("Looks like something went wrong while Deleting The Subject <b>".$delSubEmpCode."</b>, Please Try again!");
			}else{
				echo "<h4><b>".$delSubName."</b> of Subject Code <b>".$delSubCode."</b> has been successfully deleted from the Feedback System. <span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\" style=\"color:#06D206\"></span></h4>";
			}
			
		}
?>