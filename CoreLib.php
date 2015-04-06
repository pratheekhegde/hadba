<?php 
/* All the core functions and configurations are listed here.
============================================================
*/
//Database connections.
$mysql_hostname = "localhost"; //hostname of the machine
$mysql_user = "root";		//sql login user name
$mysql_password = "";		//sql login password
$mysql_database = "ffs";		//name of the main sql database

//BUILD INFO
$Version="3";
$MajorBuildDate="15.17.03";//BUILD Date in Format YY.DD.MM
//Function to echo BUILD INFO
function GetBUILDinfo(){
		global $Version,$MajorBuildDate;
		echo "<small><b>Dep. of C.S.E</small><br><span class=\"glyphicon glyphicon-copyright-mark\"></span> SMVITM, Bantakal</b>";
}
function GetBUILD(){
		global $Version,$MajorBuildDate;
		return('FFS_v'.$Version.'_<font color="red">BUILD#</font>'.$MajorBuildDate.'');
}
// TO HASH string with the crypt function
function HashString($str){
		return(md5($str));
}
//Function to get class name
function GetClassName($classcode){
	switch($classcode){
		case "Class1A": return("1st Year A Section");
				break;
		case "Class1B": return("1st Year B Section");
				break;
		case "Class1C": return("1st Year C Section");
				break;
		case "Class1D": return("1st Year D Section");
				break;
		case "Class1E": return("1st Year E Section");
				break;
		case "Class1F": return("1st Year F Section");
				break;
		case "Class1G": return("1st Year G Section");
				break;		
		case "Class2A": return("2nd Year C.S.E A Section");
				break;
		case "Class2B": return("2nd Year C.S.E B Section");
				break;
		case "Class2C": return("2nd Year E.C.E A Section");
				break;
		case "Class2D": return("2nd Year E.C.E B Section");
				break;
		case "Class2E": return("2nd Year M.E A Section");
				break;
		case "Class2F": return("2nd Year M.E B Section");
				break;
		case "Class2G": return("2nd Year Civ.E A Section");
				break;
		case "Class3A": return("3rd Year C.S.E A Section");
				break;
		case "Class3B": return("3rd Year C.S.E B Section");
				break;
		case "Class3C": return("3rd Year E.C.E A Section");
				break;
		case "Class3D": return("3rd Year E.C.E B Section");
				break;
		case "Class3E": return("3rd Year M.E A Section");
				break;
		case "Class3F": return("3rd Year M.E B Section");
				break;
		case "Class3G": return("3rd Year Civ.E A Section");
				break;
		case "Class4A": return("4th Year C.S.E A Section");
				break;
		case "Class4B": return("4th Year C.S.E B Section");
				break;
		case "Class4C": return("4th Year E.C.E A Section");
				break;
		case "Class4D": return("4th Year E.C.E B Section");
				break;
		case "Class4E": return("4th Year M.E A Section");
				break;
		case "Class4F": return("4th Year M.E B Section");
				break;
		case "Class4G": return("4th Year Civ.E A Section");
				break;
		default:return("Class Code not defined");
	}
}
		
///////////////////////////////////////////////////////v3 Functions///////////////////////////////////
//*********************************8888*********************************************88888888888888
//Function to strip Faculty Employee Code from allocation code and return it.
function stripFacEmpCode($alloc){
	$string=explode("-",$alloc);
	return($string[0]);
}

//Function to strip Subject Code from allocation code and return it.
function stripSubCode($alloc){
	$string=explode("-",$alloc);
	return($string[1]);
}
//Function to Return faculty name from the faculty Employee code.
function getFacName($empCode){
	global $mysql_hostname,$mysql_user,$mysql_password,$mysql_database;
	 //connect to database
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	//Request Allocation data from the table.
	$query="SELECT * FROM `table_faculty_info` WHERE empcode='$empCode'";
	$QueryResult=mysql_query($query);
	$Array = mysql_fetch_assoc($QueryResult);
	return $Array['name'];
}
//Function to Return Subject name from the Subject code.
function getSubName($subCode){
	global $mysql_hostname,$mysql_user,$mysql_password,$mysql_database;
	 //connect to database
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	//Request Allocation data from the table.
	$query="SELECT * FROM `table_subjects` WHERE subcode='$subCode'";
	$QueryResult=mysql_query($query);
	$Array = mysql_fetch_assoc($QueryResult);
	return $Array['subname'];
}
//Function to Return Department of the subject from the subject code.
function getSubDep($subCode){
	global $mysql_hostname,$mysql_user,$mysql_password,$mysql_database;
	 //connect to database
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	//Request Allocation data from the table.
	$query="SELECT * FROM `table_subjects` WHERE subcode='$subCode'";
	$QueryResult=mysql_query($query);
	$array = mysql_fetch_assoc($QueryResult);
	if($array['dep'] == "BS") return ("Basic Science");
	else if($array['dep'] == "CS") return ("Computer Science Engineering");
	else if($array['dep'] == "EC") return ("Electronics & Communication Engineering");
	else if($array['dep'] == "ME") return ("Mechanical Engineering");
	else if($array['dep'] == "CV") return ("Civil Engineering");
}
?>