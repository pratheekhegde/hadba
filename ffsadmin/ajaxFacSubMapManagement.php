<?php
		require_once '../CoreLib.php';
		session_start();
		//Check for Login Flags
		if(($_SESSION['LoginStatus']==0)||($_SESSION['LoginStatus']==NULL)){
			header("location: ./index.php");
		}
		$ClassId = $_REQUEST['ClassIdToName'];
		$getClassFacSubMap = $_REQUEST['getClassFacSubMap'];
		$getClassFacSubMapJSON = $_REQUEST['getClassFacSubMapJSON'];
		$getSubNameFromSubCode = $_REQUEST['getSubNameFromSubCode'];
		$facSubMappings = $_REQUEST['facSubMappings'];
		if($ClassId != NULL){
			echo GetClassName($ClassId);
		}
		
		//To Save the new FAC SUB Mappings
		if($facSubMappings != NULL){
			for($i=1,$j=1;$i<=10;$i++){
				if($facSubMappings['sub'.$i] != "NO-NO"){
					$classIDDBValues[$j++] = $facSubMappings['sub'.$i];
				}
			}
			//print_r($facSubMappings);echo "<br>";print_r($classIDDBValues);echo "<br>";
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			$query="UPDATE `table_data` SET Data1='".$classIDDBValues[1]."', Data2='".$classIDDBValues[2]."', Data3='".$classIDDBValues[3]."', Data4='".$classIDDBValues[4]."', Data5='".$classIDDBValues[5]."', Data6='".$classIDDBValues[6]."', Data7='".$classIDDBValues[7]."', Data8='".$classIDDBValues[8]."', Data9='".$classIDDBValues[9]."', Data10='".$classIDDBValues[10]."' WHERE ID='".$facSubMappings['mapClassid']."'";
			//echo $query;
			if(!mysql_query($query,$bd)){
				die ("<b>Looks like something went wrong while saving the Faculty-Subject Mappings, Please Try again!</b>");
			}else{
				echo "<h1 class=\"text-center\"> Faculty Subjects Mappings Saved.<br><i class=\"icon-check icon-4x\" style=\"color:#06D206;\"></i></h1>";
			}
		}
		
		//TO get Subject Name From Subject Code
		if($getSubNameFromSubCode != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			//Request Allocation data from the table.
			$query="SELECT subname FROM `table_subjects` WHERE subcode='$getSubNameFromSubCode'";
			$QueryResult=mysql_query($query);
			if(mysql_num_rows($QueryResult) != 0){
				$row=mysql_fetch_array($QueryResult);
				echo $row['subname'];
			}else{
				echo "No";
			}
		}
		//To Get Faculty-Subject Mapping of a class
		if($getClassFacSubMap != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			//Request Allocation data from the table.
			$query="SELECT * FROM `table_data` WHERE ID='$getClassFacSubMap'";
			$QueryResult=mysql_query($query);
			$table="<table class=\"table table-hover table-bordered table-condensed\">
					<tbody>";
					$table.= "<th>Subject #</th><th style=\"text-align:center;\"><span class=\"glyphicon glyphicon-user\" aria-hidden=\"true\"></span> Faculty Name</th><th style=\"text-align:center;\"><span class=\"glyphicon glyphicon-book\" aria-hidden=\"true\"></span> Subject Name</th>";
					$subNum=1;
			if($QueryResult){
					$row=mysql_fetch_array($QueryResult);
					$table.="<tr><td>".$subNum++."</td><td>".getFacName(stripFacEmpCode($row['Data1']))."</td><td>".getSubName(stripSubCode($row['Data1']))."</td></tr>";
					$table.="<tr><td>".$subNum++."</td><td>".getFacName(stripFacEmpCode($row['Data2']))."</td><td>".getSubName(stripSubCode($row['Data2']))."</td></tr>";
					$table.="<tr><td>".$subNum++."</td><td>".getFacName(stripFacEmpCode($row['Data3']))."</td><td>".getSubName(stripSubCode($row['Data3']))."</td></tr>";
					$table.="<tr><td>".$subNum++."</td><td>".getFacName(stripFacEmpCode($row['Data4']))."</td><td>".getSubName(stripSubCode($row['Data4']))."</td></tr>";
					$table.="<tr><td>".$subNum++."</td><td>".getFacName(stripFacEmpCode($row['Data5']))."</td><td>".getSubName(stripSubCode($row['Data5']))."</td></tr>";
					$table.="<tr><td>".$subNum++."</td><td>".getFacName(stripFacEmpCode($row['Data6']))."</td><td>".getSubName(stripSubCode($row['Data6']))."</td></tr>";
					$table.="<tr><td>".$subNum++."</td><td>".getFacName(stripFacEmpCode($row['Data7']))."</td><td>".getSubName(stripSubCode($row['Data7']))."</td></tr>";
					$table.="<tr><td>".$subNum++."</td><td>".getFacName(stripFacEmpCode($row['Data8']))."</td><td>".getSubName(stripSubCode($row['Data8']))."</td></tr>";
					$table.="<tr><td>".$subNum++."</td><td>".getFacName(stripFacEmpCode($row['Data9']))."</td><td>".getSubName(stripSubCode($row['Data9']))."</td></tr>";
					$table.="<tr><td>".$subNum++."</td><td>".getFacName(stripFacEmpCode($row['Data10']))."</td><td>".getSubName(stripSubCode($row['Data10']))."</td></tr>";
					$table.="</tbody></table>";
					echo $table;
				}else{ echo "Something Went Wrong while Getting Faculty List!";}
		}
		
		//To Get Faculty-Subject Mapping of a class in JSON for Editing
		if($getClassFacSubMapJSON != NULL){
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
			//Request Allocation data from the table.
			$query="SELECT * FROM `table_data` WHERE ID='$getClassFacSubMapJSON'";
			$QueryResult=mysql_query($query);
			$subNum=1;
			if($QueryResult){
					$row=mysql_fetch_array($QueryResult);
					$facSubMapData["sub"]["1"]["subDep"]	  = getSubDep(stripSubCode($row['Data1']));
					$facSubMapData["sub"]["1"]["subFacName"] = getFacName(stripFacEmpCode($row['Data1']));
					$facSubMapData["sub"]["1"]["subSubName"] = getSubName(stripSubCode($row['Data1']));
					
					$facSubMapData["sub"]["2"]["subDep"] 	  = getSubDep(stripSubCode($row['Data2']));
					$facSubMapData["sub"]["2"]["subFacName"] = getFacName(stripFacEmpCode($row['Data2']));
					$facSubMapData["sub"]["2"]["subSubName"] = getSubName(stripSubCode($row['Data2']));
					
					$facSubMapData["sub"]["3"]["subDep"] = 	getSubDep(stripSubCode($row['Data3']));
					$facSubMapData["sub"]["3"]["subFacName"] = getFacName(stripFacEmpCode($row['Data3']));
					$facSubMapData["sub"]["3"]["subSubName"] = getSubName(stripSubCode($row['Data3']));
					
					$facSubMapData["sub"]["4"]["subDep"]     = getSubDep(stripSubCode($row['Data4']));
					$facSubMapData["sub"]["4"]["subFacName"] = getFacName(stripFacEmpCode($row['Data4']));
					$facSubMapData["sub"]["4"]["subSubName"] = getSubName(stripSubCode($row['Data4']));
					
					$facSubMapData["sub"]["5"]["subDep"]     = getSubDep(stripSubCode($row['Data5']));
					$facSubMapData["sub"]["5"]["subFacName"] = getFacName(stripFacEmpCode($row['Data5']));
					$facSubMapData["sub"]["5"]["subSubName"] = getSubName(stripSubCode($row['Data5']));
				
				if($row['Data6'] != NULL){	
					$facSubMapData["sub"]["6"]["subDep"]     = getSubDep(stripSubCode($row['Data6']));
					$facSubMapData["sub"]["6"]["subFacName"] = getFacName(stripFacEmpCode($row['Data6']));
					$facSubMapData["sub"]["6"]["subSubName"] = getSubName(stripSubCode($row['Data6']));
				}
				
				if($row['Data7'] != NULL){				
					$facSubMapData["sub"]["7"]["subDep"]     = getSubDep(stripSubCode($row['Data7']));
					$facSubMapData["sub"]["7"]["subFacName"] = getFacName(stripFacEmpCode($row['Data7']));
					$facSubMapData["sub"]["7"]["subSubName"] = getSubName(stripSubCode($row['Data7']));
				}
				
				if($row['Data8'] != NULL){
					$facSubMapData["sub"]["8"]["sub8Dep"]     = getSubDep(stripSubCode($row['Data8']));
					$facSubMapData["sub"]["8"]["sub8FacName"] = getFacName(stripFacEmpCode($row['Data8']));
					$facSubMapData["sub"]["8"]["sub8SubName"] = getSubName(stripSubCode($row['Data8']));
				}	
					
					header('Content-Type:application/json');
					echo json_encode($facSubMapData,JSON_PRETTY_PRINT);
				}else{ echo "Something Went Wrong while Getting Faculty List!";}
		}
		
		//To Return Faculty List of a Department
		$mapClassDep = $_REQUEST['mapClassDep'];
		if($mapClassDep!= NULL ){
				$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
				mysql_select_db($mysql_database, $bd) or die("Could not select database");
				//For Faculty List
				$query="SELECT name,empcode FROM `table_faculty_info` WHERE dep='".$mapClassDep."'";
				$res = mysql_query($query);
				if($res){
					while($result=mysql_fetch_array($res)){
						$facSubMapData['facultyList'][$result['empcode']]=$result['name'];
					}
				}else{ echo "Something Went Wrong while Getting Faculty List!";}
				header('Content-Type:application/json');
				echo json_encode($facSubMapData,JSON_PRETTY_PRINT);
				
		}
		
		
?>