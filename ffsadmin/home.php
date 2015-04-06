<?php
require_once '../CoreLib.php';

session_start();

if (($_SESSION['LoginStatus'] == 0) || ($_SESSION['LoginStatus'] == NULL)) {
	header("location: index.php");
}

$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysql_select_db($mysql_database, $bd) or die("Could not select database");
$qry = "SELECT * FROM `table_data` LIMIT 29,999999999999";
$res = mysql_query($qry);

if (!mysql_query($qry, $bd)) {
	die("An unexpected error occured while querying, Please try again!");
}

// to load current feedback session class

$qry = "SELECT * FROM `table_data` WHERE ID='Startup'";
$result = mysql_query($qry);

if (!mysql_query($qry, $bd)) {
	die("An unexpected error occured while retriving current feedback session class, Please try again!");
}

$Startup = mysql_fetch_assoc($result);

if ($Startup['Data1'] == 1) {
	$fbClass = GetClassName($Startup['Data2']);
	$fbSessionStat = "
<form action=\"setFBSessionClass.php\" method=\"post\">
<input name=\"classID\" type=\"Hidden\" value=\"EndSession\">
<button type=\"submit\" class=\"btn btn-success center-block\">
<b>
Feedback Session of $fbClass is in Progress, Click this button to End. 
<i class='icon-spin icon-refresh icon-large'>
</i>

</b>
</button>
</form>
";
}
else {
	$fbSessionStat = "
<h3 class=\"text-center\">
<span class=\"label label-danger\">
No Feedback Session is running. Click a class to start a Session.
</span>
</h3>
";
}

$qry = "SELECT * FROM `table_faculty_info` WHERE dep in('CS','ME','EC','CV','BS')";
$facListRes = mysql_query($qry);

while ($facListArray = mysql_fetch_array($facListRes)) {
	if ($facListArray['dep'] == "BS") {
		$bsFacListOptions.= "
<option value=" . $facListArray['empcode'] . ">
" . $facListArray['name'] . "
</option>
";
	}
	else
	if ($facListArray['dep'] == "CS") {
		$csFacListOptions.= "
<option value=" . $facListArray['empcode'] . ">
" . $facListArray['name'] . "
</option>
";
	}
	else
	if ($facListArray['dep'] == "EC") {
		$ecFacListOptions.= "
<option value=" . $facListArray['empcode'] . ">
" . $facListArray['name'] . "
</option>
";
	}
	else
	if ($facListArray['dep'] == "ME") {
		$meFacListOptions.= "
<option value=" . $facListArray['empcode'] . ">
" . $facListArray['name'] . "
</option>
";
	}
	else
	if ($facListArray['dep'] == "CV") {
		$cvFacListOptions.= "
<option value=" . $facListArray['empcode'] . ">
" . $facListArray['name'] . "
</option>
";
	}
}

if (!mysql_query($qry, $bd)) {
	die("An unexpected error occured while querying Faculty list, Please try again!");
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    Admin Page
  </title>
  <script src="../pace/pace.js">
  </script>
  <link href="../pace/pace-flash.css" rel="stylesheet" />
  <script
  type="text/javascript" src ="../jquery-1.11.1.min.js">
    </script>
  <?php if ($_GET['select'] != "reportsTab") goto loadNormal;?>
  <script>
    $(function(){
      $('#mainTab a[href="#reports"]').tab('show');
    }
     );
  </script>
  <?php loadNormal:?>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="../bootstrap-3.3.2-dist/css/bootstrap.min.css">
  <!-- Customized CSS -->
  <!--
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/custom.css">
-->
  <!-- Optional theme -->
  <link rel="stylesheet" href="../bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">
  <!-- Latest compiled and minified JavaScript -->
  <script src="../bootstrap-3.3.2-dist/js/bootstrap.min.js">
  </script>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
<script src="bootstrapForIE9/html5shiv/3.7.2/html5shiv.min.js">
</script>
<script src="bootstrapForIE9/respond/1.4.2/respond.min.js">
</script>
<![endif]-->
  <!-- Favicons -->
  <link rel="icon" href="http://getbootstrap.com/favicon.ico">
  <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
  <style>
	.bs-docs-example {
		position: relative;
		padding: 15px;
		background-color: white;
		border: 1px solid #DDD;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		width: 768px;
      }
      
  </style>  
  </head>
  <body>
    <div class="container">
      <div class="row">
        
		<div class="col-md-12 text-center">
          <img src="../assets/coll_header.jpg" class="center-block">
          <h1>
            ADMIN PANEL
          </h1>
      </div>
  </div>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="bs-docs-example center-block">
        <div role="tabpanel" id="mainTab">
          
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
              <a href="#fbSessions" aria-controls="fbSessions" role="tab" data-toggle="tab">
                Feedback Session
              </a>
            </li>
            <li role="presentation">
              <a href="#reports" aria-controls="reports" role="tab" data-toggle="tab">
                Reports
              </a>
            </li>
            <li role="presentation" class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                Configuration 
                <span class="caret">
                </span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>
                   <a href="#FacSubMappings" aria-controls="FacSubMappings" role="tab" data-toggle="tab">
                    Faculty-Subject Mappings
                  </a>
                </li>
                <li class="divider">
                </li>
                <li>
                  <a href="#subManagement" aria-controls="subManagement" role="tab" data-toggle="tab">
                    Add/Remove Subject
                  </a>
                </li>
                <li>
                  <a href="#facManagement" aria-controls="facManagement" role="tab" data-toggle="tab">
                    Add/Remove Faculty
                  </a>
                </li>
              </ul>
            </li>
            <form action="adminlogout.php" method="post">
              <input type=hidden name=val value="logout">
              <button type="submit" class="btn btn-danger pull-right">
                Logout
              </button>
            </form>
          </ul>
          <br>
          <!-- Tab panes -->
          <div class="tab-content">
            <!-- feedbackSession Tab Content -->
            <div role="tabpanel" class="tab-pane fade in active" id="fbSessions">
              <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                  <b>
                    Click a Class to start it's Feedback Session.
                  </b>
                </div>
                <table class="table table-hover table-bordered">
                  <tbody>
                    <tr>
                      <td>
                        <big>
                          <span class="label label-primary">
                            1
                            <sup>
                              st
                            </sup>
                            Year
                          </span>
                        </big>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class1A">
                          <button class="btn btn-default" type="submit">
                            A Sec
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class1B">
                          <button class="btn btn-default" type="submit">
                            B Sec
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class1C">
                          <button class="btn btn-default" type="submit">
                            C Sec
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class1D">
                          <button class="btn btn-default" type="submit">
                            D Sec
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class1E">
                          <button class="btn btn-default" type="submit">
                            E Sec
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class1F">
                          <button class="btn btn-default" type="submit">
                            F Sec
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class1G">
                          <button class="btn btn-default" type="submit">
                            G Sec
                          </button>
                        </form>
                      </td>
                      
                    </tr>
                    <tr>
                      <td>
                        <big>
                          <span class="label label-primary">
                            2
                            <sup>
                              nd
                            </sup>
                            Year
                          </span>
                        </big>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class2A">
                          <button class="btn btn-default" type="submit">
                            <b>
                              C.S.E
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class2B">
                          <button class="btn btn-default" type="submit">
                            <b>
                              C.S.E
                            </b>
                            B
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class2C">
                          <button class="btn btn-default" type="submit">
                            <b>
                              E.C
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class2D">
                          <button class="btn btn-default" type="submit">
                            <b>
                              E.C
                            </b>
                            B
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class2E">
                          <button class="btn btn-default" type="submit">
                            <b>
                              M.E
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class2F">
                          <button class="btn btn-default" type="submit">
                            <b>
                              M.E
                            </b>
                            B
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class2G">
                          <button class="btn btn-default" type="submit">
                            <b>
                              Civ. E
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      
                    </tr>
                    <tr>
                      <td>
                        <big>
                          <span class="label label-primary">
                            3
                            <sup>
                              rd
                            </sup>
                            Year
                          </span>
                        </big>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class3A">
                          <button class="btn btn-default" type="submit">
                            <b>
                              C.S.E
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class3B">
                          <button class="btn btn-default" type="submit">
                            <b>
                              C.S.E
                            </b>
                            B
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class3C">
                          <button class="btn btn-default" type="submit">
                            <b>
                              E.C
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class3D">
                          <button class="btn btn-default" type="submit">
                            <b>
                              E.C
                            </b>
                            B
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class3E">
                          <button class="btn btn-default" type="submit">
                            <b>
                              M.E
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class3F">
                          <button class="btn btn-default" type="submit">
                            <b>
                              M.E
                            </b>
                            B
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class3G">
                          <button class="btn btn-default" type="submit">
                            <b>
                              Civ. E
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      
                    </tr>
                    <tr>
                      <td>
                        <big>
                          <span class="label label-primary">
                            4
                            <sup>
                              th
                            </sup>
                            Year
                          </span>
                        </big>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class4A">
                          <button class="btn btn-default" type="submit">
                            <b>
                              C.S.E
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class4B">
                          <button class="btn btn-default" type="submit">
                            <b>
                              C.S.E
                            </b>
                            B
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class4C">
                          <button class="btn btn-default" type="submit">
                            <b>
                              E.C
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class4D">
                          <button class="btn btn-default" type="submit">
                            <b>
                              E.C
                            </b>
                            B
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class4E">
                          <button class="btn btn-default" type="submit">
                            <b>
                              M.E
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class4F">
                          <button class="btn btn-default" type="submit">
                            <b>
                              M.E
                            </b>
                            B
                          </button>
                        </form>
                      </td>
                      <td>
                        <form action="setFBSessionClass.php" method="post">
                          <input name="classID" type="hidden" value="Class4G">
                          <button class="btn btn-default" type="submit">
                            <b>
                              Civ. E
                            </b>
                            A
                          </button>
                        </form>
                      </td>
                      
                    </tr>
                  </table>
              </div>
              <?php echo $fbSessionStat;?>
            </div>
            
            <!-- report Tab Content -->
            <div role="tabpanel" class="tab-pane fade" id="reports">
              <div class="alert alert-info" role="alert">
                <b>
                  For the Faculty and the Class you choose, Reports can be downloaded only if a feedback session was conducted.
                </b>
              </div>
              <b>
               Download the Reports:
              </b>
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                  <a href="#bsFacList" aria-controls="home" role="tab" data-toggle="tab">
                    Basic Science
                  </a>
                </li>
                <li role="presentation">
                  <a href="#csFacList" aria-controls="profile" role="tab" data-toggle="tab">
                    Comp. Science Eng.
                  </a>
                </li>
                <li role="presentation">
                  <a href="#ecFacList" aria-controls="profile" role="tab" data-toggle="tab">
                    Electronics & Com. Eng.
                  </a>
                </li>
                <li role="presentation">
                  <a href="#meFacList" aria-controls="profile" role="tab" data-toggle="tab">
                    Mechanical Eng.
                  </a>
                </li>
                <li role="presentation">
                  <a href="#cvFacList" aria-controls="profile" role="tab" data-toggle="tab">
                    Civil Eng.
                  </a>
                </li>
              </ul>
              <br>
              <div class="tab-content">
                <!-- feedbackSession Tab Content -->
                <div role="tabpanel" class="tab-pane fade in active" id="bsFacList">
                  <form class="form-inline" method="POST" action="GeneratePDF.php">
                    <div class="form-group">
                      <div class="col-sm-4">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">
                            <b>
                              Faculty :
                            </b>
                          </span>
                          <select class="form-control id="facID" name="facID">
<?php echo $bsFacListOptions;?>
</select>
</div>
</div>
<div class="col-sm-4">
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">
<b>
Class :
</b>
</span>
<select class="form-control id="classID" name="classID">
  <option value=Class1A>
    1st Year A Section
  </option>
  <option value=Class1B>
    1st Year B Section
  </option>
  <option value=Class1C>
    1st Year C Section
  </option>
  <option value=Class1D>
    1st Year D Section
  </option>
  <option value=Class1E>
    1st Year E Section
  </option>
  <option value=Class1F>
    1st Year F Section
  </option>
  <option value=Class1G>
    1st Year G Section
  </option>
  <option value=Class2A>
    2nd Year C.S.E A Section
  </option>
  <option value=Class2B>
    2nd Year C.S.E B Section 
  </option>
  <option value=Class2C>
    2nd Year E.C.E A Section
  </option>
  <option value=Class2D>
    2nd Year E.C.E B Section
  </option>
  <option value=Class2E>
    2nd Year M.E A Section
  </option>
  <option value=Class2F>
    2nd Year M.E B Section
  </option>
  <option value=Class2G>
    2nd Year Civ.E A Section
  </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-success">
                          <span class="glyphicon glyphicon-file" aria-hidden="true">
                          </span>
                          
                          <b>
                            Download PDF Report
                          </b>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                
                
                <div role="tabpanel" class="tab-pane fade" id="csFacList">
                  
                  <form class="form-inline" method="POST" action="GeneratePDF.php">
                    <div class="form-group">
                      <div class="col-sm-4">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">
                            <b>
                              Faculty :
                            </b>
                          </span>
                          <select class="form-control id="facID" name="facID">
<?php echo $csFacListOptions;?>
</select>
</div>
</div>
<div class="col-sm-4">
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">
<b>
Class :
</b>
</span>
<select class="form-control id="classID" name="classID">
  <option value=Class1A>
    1st Year A Section
  </option>
  <option value=Class1B>
    1st Year B Section
  </option>
  <option value=Class1C>
    1st Year C Section
  </option>
  <option value=Class1D>
    1st Year D Section
  </option>
  <option value=Class1E>
    1st Year E Section
  </option>
  <option value=Class1F>
    1st Year F Section
  </option>
  <option value=Class1G>
    1st Year G Section
  </option>
  <option value=Class2A>
    2nd Year C.S.E A Section
  </option>
  <option value=Class2B>
    2nd Year C.S.E B Section 
  </option>
  <option value=Class3A>
    3rd Year C.S.E A Section
  </option>
  <option value=Class3B>
    3rd Year C.S.E B Section
  </option>
  <option value=Class4A>
    4th Year C.S.E A Section 
  </option>
  <option value=Class3D>
    3rd Year E.C.E B Section 
  </option>
  <option value=Class3C>
    3rd Year E.C.E A Section 
  </option>
  <option value=Class4C>
    4th Year E.C.E A Section
  </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-success">
                          <span class="glyphicon glyphicon-file" aria-hidden="true">
                          </span>
                          
                          <b>
                            Download PDF Report
                          </b>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                
                <div role="tabpanel" class="tab-pane fade" id="ecFacList">
                  <form class="form-inline" method="POST" action="GeneratePDF.php">
                    <div class="form-group">
                      <div class="col-sm-4">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">
                            <b>
                              Faculty :
                            </b>
                          </span>
                          <select class="form-control id="facID" name="facID">
<?php echo $ecFacListOptions;?>
</select>
</div>
</div>
<div class="col-sm-4">
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">
<b>
Class :
</b>
</span>
<select class="form-control id="classID" name="classID">
  <option value=Class1A>
    1st Year A Section
  </option>
  <option value=Class1B>
    1st Year B Section
  </option>
  <option value=Class1C>
    1st Year C Section
  </option>
  <option value=Class1D>
    1st Year D Section
  </option>
  <option value=Class1E>
    1st Year E Section
  </option>
  <option value=Class1F>
    1st Year F Section
  </option>
  <option value=Class1G>
    1st Year G Section
  </option>
  <option value=Class2C>
    2nd Year E.C.E A Section
  </option>
  <option value=Class2D>
    2nd Year E.C.E B Section
  </option>
  <option value=Class3C>
    3rd Year E.C.E A Section
  </option>
  <option value=Class3D>
    3rd Year E.C.E B Section
  </option>
  <option value=Class4C>
    4th Year E.C.E A Section
  </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-success">
                          <span class="glyphicon glyphicon-file" aria-hidden="true">
                          </span>
                          
                          <b>
                            Download PDF Report
                          </b>
                        </button>
                      </div>
                    </div>
                  </form>
                  
                </div>
                
                <div role="tabpanel" class="tab-pane fade" id="meFacList">
                  <form class="form-inline" method="POST" action="GeneratePDF.php">
                    <div class="form-group">
                      <div class="col-sm-4">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">
                            <b>
                              Faculty :
                            </b>
                          </span>
                          <select class="form-control id="facID" name="facID">
<?php echo $meFacListOptions;?>
</select>
</div>
</div>
<div class="col-sm-4">
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">
<b>
Class :
</b>
</span>
<select class="form-control id="classID" name="classID">
  <option value=Class1A>
    1st Year A Section
  </option>
  <option value=Class1B>
    1st Year B Section
  </option>
  <option value=Class1C>
    1st Year C Section
  </option>
  <option value=Class1D>
    1st Year D Section
  </option>
  <option value=Class1E>
    1st Year E Section
  </option>
  <option value=Class1F>
    1st Year F Section
  </option>
  <option value=Class1G>
    1st Year G Section
  </option>
  <option value=Class2E>
    2nd Year M.E A Section
  </option>
  <option value=Class2F>
    2nd Year M.E B Section
  </option>
  <option value=Class3E>
    3rd Year M.E A Section
  </option>
  <option value=Class3F>
    3rd Year M.E B Section
  </option>
  <option value=Class4E>
    4th Year M.E A Section
  </option>
  <option value=Class4F>
    4th Year M.E B Section
  </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-success">
                          <span class="glyphicon glyphicon-file" aria-hidden="true">
                          </span>
                          
                          <b>
                            Download PDF Report
                          </b>
                        </button>
                      </div>
                    </div>
                  </form>
                  
                </div>
                
                <div role="tabpanel" class="tab-pane fade" id="cvFacList">
                  <form class="form-inline" method="POST" action="GeneratePDF.php">
                    <div class="form-group">
                      <div class="col-sm-4">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">
                            <b>
                              Faculty :
                            </b>
                          </span>
                          <select class="form-control id="facID" name="facID">
<?php echo $cvFacListOptions;?>
</select>
</div>
</div>
<div class="col-sm-4">
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">
<b>
Class :
</b>
</span>
<select class="form-control id="classID" name="classID">
  <option value=Class1A>
    1st Year A Section
  </option>
  <option value=Class1B>
    1st Year B Section
  </option>
  <option value=Class1C>
    1st Year C Section
  </option>
  <option value=Class1D>
    1st Year D Section
  </option>
  <option value=Class1E>
    1st Year E Section
  </option>
  <option value=Class1F>
    1st Year F Section
  </option>
  <option value=Class1G>
    1st Year G Section
  </option>
  <option value=Class2G>
    2nd Year Civ.E A Section
  </option>
  <option value=Class3G>
    3rd Year Civ.E A Section
  </option>
  <option value=Class4G>
    4th Year Civ.E A Section
  </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-success">
                          <span class="glyphicon glyphicon-file" aria-hidden="true">
                          </span>
                          
                          <b>
                            Download PDF Report
                          </b>
                        </button>
                      </div>
                    </div>
                  </form>
                  
                </div>
              </div>
              <br>
              <?php if($_GET['reports'] == "no"){
echo "
<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
<span aria-hidden=\"true\">
&times;
</span>
</button>
<strong>
No Reports Found!
</strong>
Maybe the Feedback Session was not conducted, Try Another Faculty or Class.
</div>
";
}
?>
				<b>
                Email the Reports:
              </b>
			  <form class="form-inline" method="POST" action="emailReports.php">
                    <div class="form-group">
                      <div class="col-md-12 col-md-offset-3">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
							<b>
							Class :
							</b>
							</span>
							<select class="form-control id=" name="classID">
							  <option value="Class1A">
								1st Year A Section
							  </option>
							  <option value="Class1B">
								1st Year B Section
							  </option>
							  <option value="Class1C">
								1st Year C Section
							  </option>
							  <option value="Class1D">
								1st Year D Section
							  </option>
							  <option value="Class1E">
								1st Year E Section
							  </option>
							  <option value="Class1F">
								1st Year F Section
							  </option>
							  <option value="Class1G">
								1st Year G Section
							  </option>
							  <option value="Class2A">
								2nd Year C.S.E A Section
							  </option>
							  <option value="Class2B">
								2nd Year C.S.E B Section 
							  </option>
							  <option value="Class2C">
								2nd Year E.C.E A Section
							  </option>
							  <option value="Class2D">
								2nd Year E.C.E B Section
							  </option>
							  <option value="Class2E">
								2nd Year M.E A Section
							  </option>
							  <option value="Class2F">
								2nd Year M.E B Section
							  </option>
							  <option value="Class2G">
								2nd Year Civ.E A Section
							  </option>
													  </select>
                        </div>
							&nbsp;&nbsp;
					      <button type="submit" class="btn btn-success">
                          <span class="glyphicon glyphicon-paperclip" aria-hidden="true">
                          </span>
                          
                          <b>
                            Email PDF Report
                          </b>
                        </button>
						</div>
						
					 </div>
				</form>
				<br>			<?php if($_GET['emailReportSuccess'] == 'yes'){
										echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
										  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
										  <strong>Email Sent!</strong> Reports of class <b>".$_GET['emailReportClass']." </b>has been emailed to Principal and Dean.</div>";
										}else if($_GET['emailReportSuccess'] == 'no'){
										echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">
										  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
										  <strong>Email Sent!</strong> Reports of class <b>".$_GET['emailReportClass']." </b>could not be emailed to Principal and Dean.</div>";
										}
							?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="facManagement">
			<big><b>Faculty Management:</b></big>
			<form class="form-horizontal">
			<div class="form-group">
			<div class="col-sm-2">
             <button class="btn btn-info" type="button" data-toggle="modal" data-target="#addNewFacultyModal">
                      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Faculty
             </button>
			 </div>
			 <div class="col-sm-3">
             <button class="btn btn-info" type="button" id="showAllFacList">
                      <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Show All Faculty List
             </button>
			 </div>
			 </div>
			 </form>
				
                <div class="input-group">
                  <input type="text" class="form-control" id="facSearchBox" placeholder="Enter a Faculty Name or an Employee Code">
                  <span class="input-group-btn">
                    <button class="btn btn-success" type="button" id="facSearchBtn">
                      <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                    </button>
                  </span>
                </div>
				
                <hr>
				<div id="ajaxFacListDisplay">
				
				</div>
				<!-- Modal For Adding New Faculty-->
				<div class="modal fade" id="addNewFacultyModal" tabindex="-1" role="dialog" aria-labelledby="addNewFacultyModal" aria-hidden="true">
				  <div class="modal-dialog modal-md">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="addNewFacultyModal">Adding a New Faculty</h4>
					  </div>
					  <div class="modal-body">
					  <div class="form-group" id="newFacEmpCodeInputGroup">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Employee Code:</b></span>
							  <input name="empcode" id="newFacEmpCode" type="text" class="form-control" placeholder="Unique Employee Code">
						</div>
						</div>
						<div class="form-group">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Name:</b></span>
							  <input type="text" id="newFacName" class="form-control" placeholder="Name of the Faculty">
						</div>
						</div>
						<div class="form-group">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Department:</b></span>
								<select id="newFacDep" class="form-control">
								<option value="BS">Basic Science</option>
								<option value="CS">Computer Science Engineering</option>
								<option value="EC">Electronics & Communication Engineering</option>
								<option value="ME">Mechanical Engineering</option>
								<option Value="CV">Civil Engineering</option>
								</select>
						</div>
						</div>
						<div class="form-group">
						<button type="button" id="saveNewFac" class="btn btn-success center-block" disabled="disabled">Save New Faculty</button>
						</div>
						<div class="text-center" id="saveNewFacStatus">
						</div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
					</div>
				  </div>
				</div>
				<!-- Modal For Editing Faculty-->
				<div class="modal fade" id="editFacModal" tabindex="-1" role="dialog" aria-labelledby="editFacModal" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="editFacModal">Edit a Faculty</h4>
					  </div>
					  <div class="modal-body">
						  <div class="form-group" id="editFacEmpCodeInputGroup">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Employee Code:</b></span>
							  <input id="editFacEmpCode" type="text" class="form-control" placeholder="Unique Employee Code"disabled="disabled">
						</div>
						</div>
						<div class="form-group">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Name:</b></span>
							  <input type="text" id="editFacName" class="form-control" placeholder="Name of the Faculty">
						</div>
						</div>
						<div class="form-group">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Department:</b></span>
								<select id="editFacDep" class="form-control">
								<option value="BS">Basic Science</option>
								<option value="CS">Computer Science Engineering</option>
								<option value="EC">Electronics & Communication Engineering</option>
								<option value="ME">Mechanical Engineering</option>
								<option Value="CV">Civil Engineering</option>
								</select>
						</div>
						</div>
						<big><span class="label label-danger"><b>To Edit Employee Code, Delete the Faculty and Add it again with the new Employee Code.</b></span></big>
						<div id="saveEditFacStatus"></div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="updateFacInfoBtn">Update Information</button>
					  </div>
					</div>
				  </div>
				</div>
				
				<!-- Modal For Deleting Faculty-->
				<div class="modal fade" id="deleteFacModal" tabindex="-1" role="dialog" aria-labelledby="deleteFacModal" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="deleteFacModal">Delete a Faculty</h4>
					  </div>
					  <div class="modal-body">
						<div id="deleteFacModalBody"></div>
						<input type="hidden" id="delFacEmpCode">
						<input type="hidden" id="delFacName">
						<div id="deleteFacStatus" class="text-center"></div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="deleteFacInfoBtn">Yes, Delete</button>
					  </div>
					</div>
				  </div>
				</div>
            </div>
			<!-- SubManagement Tab-->
			<div role="tabpanel" class="tab-pane fade" id="subManagement">
			<big><b>Subject Management:</b></big>
			<form class="form-horizontal">
			<div class="form-group">
			<div class="col-sm-2">
             <button class="btn btn-info" type="button" data-toggle="modal" data-target="#addNewSubjectModal">
                      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Subject
             </button>
			 </div>
			 <div class="col-sm-3">
             <button class="btn btn-info" type="button" id="showAllSubList">
                      <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Show All Subject List
             </button>
			 </div>
			  <div class="col-sm-2 col-md-push-1" style="padding-right:0px;">
			 <div class="input-group">
                  <select class="form-control" id="subSearchYear">
						<option value="1">1st Year</option>
						<option value="2">2nd Year</option>
						<option value="3">3rd Year</option>
						<option value="4">4th Year</option>
						<option value="%">All Years</option>
				</select>
			
				
                </div>
				</div>
				<div class="col-sm-4 pull-right" style="padding-left:0px;">
				 <div class="input-group">
                  <select class="form-control" id="subSearchDep">
						<option value="BS">Basic Science</option>
								<option value="CS">C.S.E</option>
								<option value="EC">E.C.E</option>
								<option value="ME">M.E</option>
								<option Value="CV">Civ.E</option>
								<option value="%">All Branches</option>
						</select>
					 <span class="input-group-btn">
                    <button class="btn btn-info" type="button" id="subListBtn">List Subjects
                    </button>
					</span>
				
                </div>
				</div>
			 </div>
			 </form>
				
                <div class="input-group">
                  <input type="text" class="form-control" id="subSearchBox" placeholder="Enter a Subject Name or Subject Code">
                  <span class="input-group-btn">
                    <button class="btn btn-success" type="button" id="subSearchBtn">
                      <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                    </button>
                  </span>
                </div>
				
                <hr>
				<div id="ajaxSubListDisplay">
				
				</div>
<!--Modal for Subject Management Begins-->
<!-- Modal For Adding New Subject-->
				<div class="modal fade" id="addNewSubjectModal" tabindex="-1" role="dialog" aria-labelledby="addNewSubjectModal" aria-hidden="true">
				  <div class="modal-dialog modal-md">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="addNewSubjectModal">Adding a New Subject</h4>
					  </div>
					  <div class="modal-body">
					  <div class="form-group" id="newSubCodeInputGroup">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Subject Code:</b></span>
							  <input name="subcode" id="newSubCode" type="text" class="form-control" placeholder="Unique Subject Code">
						</div>
						</div>
						<div class="form-group">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Subject Name:</b></span>
							  <input type="text" id="newSubName" class="form-control" placeholder="Name of the Subject">
						</div>
						</div>
						<div class="form-group">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Department:</b></span>
								<select id="newSubDep" class="form-control">
								<option value="BS">Basic Science</option>
								<option value="CS">Computer Science Engineering</option>
								<option value="EC">Electronics & Communication Engineering</option>
								<option value="ME">Mechanical Engineering</option>
								<option Value="CV">Civil Engineering</option>
								</select>
						</div>
						</div>
						<div class="form-group">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Year:</b></span>
								<select id="newSubYear" class="form-control">
								<option value="1">1<sup>st</sup> Year</option>
								<option value="2">2<sup>nd</sup> Year</option>
								<option value="3">3<sup>rd</sup> Year</option>
								<option value="4">4<sup>th</sup> Year</option>
								</select>
						</div>
						</div>
						<div class="form-group">
						<button type="button" id="saveNewSub" class="btn btn-success center-block" disabled="disabled">Save New Subject</button>
						</div>
						<div class="text-center" id="saveNewSubStatus">
						</div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
					</div>
				  </div>
				</div>
<!-- Modal For Editing Subjects-->
				<div class="modal fade" id="editSubModal" tabindex="-1" role="dialog" aria-labelledby="editSubModal" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="editSubModal">Edit a Subject</h4>
					  </div>
					  <div class="modal-body">
						  <div class="form-group" id="editFacEmpCodeInputGroup">
						  
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Subject Code:</b></span>
							  <input id="editSubCode" type="text" class="form-control" placeholder="Unique Subject Code "disabled="disabled">
						</div>
						</div>
						<div class="form-group">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Subject Name:</b></span>
							  <input type="text" id="editSubName" class="form-control" placeholder="Name of the Subject">
						</div>
						</div>
						<div class="form-group">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Department:</b></span>
								<select id="editSubDep" class="form-control">
								<option value="BS">Basic Science</option>
								<option value="CS">Computer Science Engineering</option>
								<option value="EC">Electronics & Communication Engineering</option>
								<option value="ME">Mechanical Engineering</option>
								<option Value="CV">Civil Engineering</option>
								</select>
						</div>
						</div>
						<div class="form-group">
						<div class="input-group">
							  <span class="input-group-addon" id="sizing-addon1"><b>Year:</b></span>
								<select id="editSubYear" class="form-control">
								<option value="1">1<sup>st</sup> Year</option>
								<option value="2">2<sup>nd</sup> Year</option>
								<option value="3">3<sup>rd</sup> Year</option>
								<option value="4">4<sup>th</sup> Year</option>
								</select>
						</div>
						</div>
						<big><span class="label label-danger"><b>To Edit Subject Code, Delete the Subject and Add it again with the new Subject Code.</b></span></big>
						<div id="saveEditSubStatus"></div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="updateSubInfoBtn">Update Information</button>
					  </div>
					</div>
				  </div>
				</div>
				
				<!-- Modal For Deleting Faculty-->
				<div class="modal fade" id="deleteSubModal" tabindex="-1" role="dialog" aria-labelledby="deleteSubModal" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="deleteSubModal">Delete a Subject</h4>
					  </div>
					  <div class="modal-body">
						<div id="deleteSubModalBody"></div>
						<input type="hidden" id="delSubCode">
						<input type="hidden" id="delSubName">
						<div id="deleteSubStatus" class="text-center"></div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="deleteSubInfoBtn">Yes, Delete</button>
					  </div>
					</div>
				  </div>
				</div>
            </div>
			
			<!--End Of Subject Management Tab-->
<!--Start of Subject-Faculty Mapping Tab-->
			<div role="tabpanel" class="tab-pane fade" id="FacSubMappings">
				<div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                  <b>
                    Click a Class to View/Edit it's Faculty-Subject Mappings.
                  </b>
                </div>
                <table class="table table-hover table-bordered">
                  <tbody>
                    <tr>
                      <td>
                        <big>
                          <span class="label label-success">
                            1
                            <sup>
                              st
                            </sup>
                            Year
                          </span>
                        </big>
                      </td>
                      <td>
                           <button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class1A">
                            A Sec
                          </button>
                      </td>
                      <td>
                         <button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class1B">
                            B Sec
                          </button>
                      </td>
                      <td>
                        <button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class1C">
                            C Sec
                      </td>
                      <td>
                       <button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class1D">
                            D Sec
                      </td>
                      <td>
                       <button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class1E">
                            E Sec
                      </td>
                      <td>
                       <button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class1F">
                            F Sec
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class1G">
                            G Sec
                      </td>
                      
                    </tr>
                    <tr>
                      <td>
                        <big>
                          <span class="label label-success">
                            2
                            <sup>
                              nd
                            </sup>
                            Year
                          </span>
                        </big>
                      </td>
                      <td>
					  <button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class2A">
                            <b>
                              C.S.E
                            </b>
                            A
							</td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class2B">
                            <b>
                              C.S.E
                            </b>
                            B
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class2C">
                            <b>
                              E.C
                            </b>
                            A
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class2D">
                            <b>
                              E.C
                            </b>
                            B
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class2E">
                            <b>
                              M.E
                            </b>
                            A
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class2F">
                              M.E
                            </b>
                            B
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class2G">
                            <b>
                              Civ. E
                            </b>
                            A
                      </td>
                      
                    </tr>
                    <tr>
                      <td>
                        <big>
                          <span class="label label-success">
                            3
                            <sup>
                              rd
                            </sup>
                            Year
                          </span>
                        </big>
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class3A">
                            <b>
                              C.S.E
                            </b>
                            A
                      </td>
                      <td>
                         <button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class3B">
                            <b>
                              C.S.E
                            </b>
                            B
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class3C">
                            <b>
                              E.C
                            </b>
                            A
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class3D">
                            <b>
                              E.C
                            </b>
                            B
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class3E">
                            <b>
                              M.E
                            </b>
                            A
                      </td>
                      <td>
                         <button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class3F">
                            <b>
                              M.E
                            </b>
                            B
                      
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class3G">
                            <b>
                              Civ. E
                            </b>
                            A
                      </td>
                      
                    </tr>
                    <tr>
                      <td>
                        <big>
                          <span class="label label-success">
                            4
                            <sup>
                              th
                            </sup>
                            Year
                          </span>
                        </big>
                      </td>
                      <td>
					  <button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class4A">
                            <b>
                              C.S.E
                            </b>
                            A
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class4B">
                            <b>
                              C.S.E
                            </b>
                            B
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class4C">
                            <b>
                              E.C
                            </b>
                            A
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class4D">
                            <b>
                              E.C
                            </b>
                            B
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class4E">
                            <b>
                              M.E
                            </b>
                            A
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class4F">
                            <b>
                              M.E
                            </b>
                            B
                      </td>
                      <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#facSubMappingModal" data-classid="Class4G">
                            <b>
                              Civ. E
                            </b>
                            A
                      </td>
                      
                    </tr>
                  </table>
              </div>
			  <!--Faculty-Subject Mappping Modal-->
				<div class="modal fade" id="facSubMappingModal" tabindex="-1" role="dialog" aria-labelledby="facSubMappingModal" aria-hidden="true">
						  <div class="modal-dialog modal-lg">
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="facSubMappingModalLabel"></h4>
							  </div>
							  <div class="modal-body">
								<input type="hidden" id="mapClassid">
								<div id="viewMappingsTable">
								
								</div>
								<div id="editMappingsTable">
								<table class="table table-hover table-bordered table-condensed">
								<tbody>
										<th width="10">#</th><th colspan="2" style="text-align:center;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Faculty Name</th><th style="text-align:center;"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Subject Name</th>
										<tr><td>1</td><td width="200"><select id="sub1dep" class="form-control input-sm" onchange="loadFacListFromDep('sub1');">
														<option value="choose">-- Choose a Department --</option>
														<option value="BS">Basic Science</option>
														<option value="CS">Computer Science Engineering</option>
														<option value="EC">Electronics & Communication Engineering</option>
														<option value="ME">Mechanical Engineering</option>
														<option Value="CV">Civil Engineering</option>
														<option value="no">-- No Subject --</option>
														</select>
										</td><td width="210"><select id="sub1FacName" class="form-control input-sm" disabled="disabled"></select></td>
										<td><div class="input-group"><input class="form-control input-sm" placeholder="Subject Code" id="sub1SubCode" disabled="disabled" type="text" maxlength="6" size="4" onkeyup="loadSubNameFromSubCode('sub1');">
															<span class="input-group-addon" id="sub1SubName"><b><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Enter Subject Code</b></span></div></div></td></tr>
										<tr><td>2</td><td><select id="sub2dep" class="form-control input-sm" onchange="loadFacListFromDep('sub2');">
														<option value="choose">-- Choose a Department --</option>
														<option value="BS">Basic Science</option>
														<option value="CS">Computer Science Engineering</option>
														<option value="EC">Electronics & Communication Engineering</option>
														<option value="ME">Mechanical Engineering</option>
														<option Value="CV">Civil Engineering</option>
														<option value="no">-- No Subject --</option>
														</select>
										</td><td><select id="sub2FacName" class="form-control input-sm" disabled="disabled"></select></td>
										<td><div class="input-group"><input class="form-control input-sm" placeholder="Subject Code" id="sub2SubCode" disabled="disabled" type="text" maxlength="6" size="4" onkeyup="loadSubNameFromSubCode('sub2');">
															<span class="input-group-addon" id="sub2SubName"><b><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Enter Subject Code</b></span></div></div></td></tr>
										<tr><td>3</td><td><select id="sub3dep" class="form-control input-sm" onchange="loadFacListFromDep('sub3');">
														<option value="choose">-- Choose a Department --</option>
														<option value="BS">Basic Science</option>
														<option value="CS">Computer Science Engineering</option>
														<option value="EC">Electronics & Communication Engineering</option>
														<option value="ME">Mechanical Engineering</option>
														<option Value="CV">Civil Engineering</option>
														<option value="no">-- No Subject --</option>
														</select>
										</td><td><select id="sub3FacName" class="form-control input-sm" disabled="disabled"></select></td><td><div class="input-group"><input class="form-control input-sm" placeholder="Subject Code" id="sub3SubCode" disabled="disabled" type="text" maxlength="6" size="4" onkeyup="loadSubNameFromSubCode('sub3');">
															<span class="input-group-addon" id="sub3SubName"><b><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Enter Subject Code</b></span></div></div></td></tr>
										<tr><td>4</td><td><select id="sub4dep" class="form-control input-sm" onchange="loadFacListFromDep('sub4');">
														<option value="choose">-- Choose a Department --</option>
														<option value="BS">Basic Science</option>
														<option value="CS">Computer Science Engineering</option>
														<option value="EC">Electronics & Communication Engineering</option>
														<option value="ME">Mechanical Engineering</option>
														<option Value="CV">Civil Engineering</option>
														<option value="no">-- No Subject --</option>
														</select>
										</td><td><select id="sub4FacName" class="form-control input-sm" disabled="disabled"></td><td><div class="input-group"><input class="form-control input-sm" placeholder="Subject Code" id="sub4SubCode" disabled="disabled" type="text" maxlength="6" size="4" onkeyup="loadSubNameFromSubCode('sub4');">
															<span class="input-group-addon" id="sub4SubName"><b><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Enter Subject Code</b></span></div></div></td></tr>
										<tr><td>5</td><td><select id="sub5dep" class="form-control input-sm" onchange="loadFacListFromDep('sub5');">
														<option value="choose">-- Choose a Department --</option>
														<option value="BS">Basic Science</option>
														<option value="CS">Computer Science Engineering</option>
														<option value="EC">Electronics & Communication Engineering</option>
														<option value="ME">Mechanical Engineering</option>
														<option Value="CV">Civil Engineering</option>
														<option value="no">-- No Subject --</option>
														</select>
										</td><td><select id="sub5FacName" class="form-control input-sm" disabled="disabled"></td><td><div class="input-group"><input class="form-control input-sm" placeholder="Subject Code" id="sub5SubCode" disabled="disabled" type="text" maxlength="6" size="4" onkeyup="loadSubNameFromSubCode('sub5');">
															<span class="input-group-addon" id="sub5SubName"><b><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Enter Subject Code</b></span></div></div></td></tr>
										<tr><td>6</td><td><select id="sub6dep" class="form-control input-sm" onchange="loadFacListFromDep('sub6');">
														<option value="choose">-- Choose a Department --</option>
														<option value="BS">Basic Science</option>
														<option value="CS">Computer Science Engineering</option>
														<option value="EC">Electronics & Communication Engineering</option>
														<option value="ME">Mechanical Engineering</option>
														<option Value="CV">Civil Engineering</option>
														<option value="no">-- No Subject --</option>
														</select>
										</td><td><select id="sub6FacName" class="form-control input-sm" disabled="disabled"></td><td><div class="input-group"><input class="form-control input-sm" placeholder="Subject Code" id="sub6SubCode" disabled="disabled" type="text" maxlength="6" size="4" onkeyup="loadSubNameFromSubCode('sub6');">
															<span class="input-group-addon" id="sub6SubName"><b><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Enter Subject Code</b></span></div></div></td></tr>
										<tr><td>7</td><td><select id="sub7dep" class="form-control input-sm" onchange="loadFacListFromDep('sub7');">
														<option value="choose">-- Choose a Department --</option>
														<option value="BS">Basic Science</option>
														<option value="CS">Computer Science Engineering</option>
														<option value="EC">Electronics & Communication Engineering</option>
														<option value="ME">Mechanical Engineering</option>
														<option Value="CV">Civil Engineering</option>
														<option value="no">-- No Subject --</option>
														</select>
										</td><td><select id="sub7FacName" class="form-control input-sm" disabled="disabled"></td><td><div class="input-group"><input class="form-control input-sm" placeholder="Subject Code" id="sub7SubCode" disabled="disabled" type="text" maxlength="6" size="4" onkeyup="loadSubNameFromSubCode('sub7');">
															<span class="input-group-addon" id="sub7SubName"><b><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Enter Subject Code</b></span></div></div></td></tr>
										<tr><td>8</td><td><select id="sub8dep" class="form-control input-sm" onchange="loadFacListFromDep('sub8');">
														<option value="choose">-- Choose a Department --</option>
														<option value="BS">Basic Science</option>
														<option value="CS">Computer Science Engineering</option>
														<option value="EC">Electronics & Communication Engineering</option>
														<option value="ME">Mechanical Engineering</option>
														<option Value="CV">Civil Engineering</option>
														<option value="no">-- No Subject --</option>
														</select>
										</td><td><select id="sub8FacName" class="form-control input-sm" disabled="disabled"></td><td><div class="input-group"><input class="form-control input-sm" placeholder="Subject Code" id="sub8SubCode" disabled="disabled" type="text" maxlength="6" size="4" onkeyup="loadSubNameFromSubCode('sub8');">
															<span class="input-group-addon" id="sub8SubName"><b><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Enter Subject Code</b></span></div></div></td></tr>
										<tr><td>9</td><td><select id="sub9dep" class="form-control input-sm" onchange="loadFacListFromDep('sub9');">
														<option value="choose">-- Choose a Department --</option>
														<option value="BS">Basic Science</option>
														<option value="CS">Computer Science Engineering</option>
														<option value="EC">Electronics & Communication Engineering</option>
														<option value="ME">Mechanical Engineering</option>
														<option Value="CV">Civil Engineering</option>
														<option value="no">-- No Subject --</option>
														</select>
										</td><td><select id="sub9FacName" class="form-control input-sm" disabled="disabled"></td><td><div class="input-group"><input class="form-control input-sm" placeholder="Subject Code" id="sub9SubCode" disabled="disabled" type="text" maxlength="6" size="4" onkeyup="loadSubNameFromSubCode('sub9');">
															<span class="input-group-addon" id="sub9SubName"><b><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Enter Subject Code</b></span></div></div></td></tr>
										<tr><td>10</td><td><select id="sub10dep" class="form-control input-sm" onchange="loadFacListFromDep('sub10');">
														<option value="choose">-- Choose a Department --</option>
														<option value="BS">Basic Science</option>
														<option value="CS">Computer Science Engineering</option>
														<option value="EC">Electronics & Communication Engineering</option>
														<option value="ME">Mechanical Engineering</option>
														<option Value="CV">Civil Engineering</option>
														<option value="no">-- No Subject --</option>
														</select>
										</td><td><select id="sub10FacName" class="form-control input-sm" disabled="disabled"></td><td><div class="input-group"><input class="form-control input-sm" placeholder="Subject Code" id="sub10SubCode" disabled="disabled" type="text" maxlength="6" size="4" onkeyup="loadSubNameFromSubCode('sub10');">
															<span class="input-group-addon" id="sub10SubName"><b><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Enter Subject Code</b></span></div></div></td></tr>
								</tbody>
								</table>
								</div>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary" id="viewExistingFacSubMappingBtn">View Existing Mappings</button>
								<button type="button" class="btn btn-primary" id="editFacSubMappingBtn">Edit Mappings</button>
								<button type="button" class="btn btn-primary" id="saveFacSubMappingBtn">Save Mappings</button>
							  </div>
							</div>
						  </div>
						</div>
			  
			  
			  
			  
				</div>
			</div>
          </div>
          
        </div>
        
      </div>
	</div>
  </div>
 <div style="position: fixed; bottom: 20px;left: 100px">
		<hr>
	  <p><h2><span class="glyphicon glyphicon-cog"></span> FFS<small><sup>v3</sup></small></h2><?php GetBuildInfo();?>
	  </p> 
</div>
  </div>
  <br>
  </body>
  <script type="text/javascript">
		var searchAJreq=null;
		var empCodeCheckAJreq=null;
		var subCodeCheckAJreq=null;
		var newEmpCodeStatus;
		var newSubCodeStatus;
	
///////////////////////////////////All Functions and Code For Faculty Management/////////////////////////////////
		//Modal config for editing faculty
		$('#editFacModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) // Button that triggered the modal 
			  $('#editFacEmpCode').val(button.data('empcode'));
			  $('#editFacName').val(button.data('facname'));
			  $('#editFacDep').val(button.data('facdep'));
		})
		
		//modal config for deleting faculty
		$('#deleteFacModal').on('show.bs.modal', function (event) {
			$("#deleteFacModalBody").show();
			  var button = $(event.relatedTarget) // Button that triggered the modal 
			  var deleteFacEmpCode = button.data('empcode')
			  var deleteFacName = button.data('facname')
			  $('#delFacName').val(button.data('facname'));
			  $('#delFacEmpCode').val(button.data('empcode'));
			  var modal = $(this)
				modal.find('.modal-title').text('Delete Faculty - ' + deleteFacName)
				modal.find('.modal-body div#deleteFacModalBody').html('<h3 class="text-center">Do you really want to delete<br> <b>'+ deleteFacName + '</b><br> Employee Code : <b>'+ deleteFacEmpCode +'</b><br>from the Feedback System ?</h3><div class="alert alert-danger text-center" role="alert"><b>After Deleting, You Will Not be able to Generate any Reports of this faculty!<b></div>');
				$('#deleteFacInfoBtn').removeAttr('disabled','disabled');
				$("#deleteFacStatus").hide();
		})
		//Updating the Faculty List table after a new faculty is added or if any faculty is updated or deleted
		$('#addNewFacModal').on('hide.bs.modal', function (event) {
			var lastAjaxQuery=$('#lastFacAjaxQuery').val();
			 //console.log(lastAjaxQuery);
			 $.post('ajaxFacManagement.php?'+lastAjaxQuery,function(data){
						$('#ajaxFacListDisplay').html(data);
			 });
		})
		$('#editFacModal').on('hide.bs.modal', function (event) {
			var lastAjaxQuery=$('#lastFacAjaxQuery').val();
			 //console.log(lastAjaxQuery);
			 $.post('ajaxFacManagement.php?'+lastAjaxQuery,function(data){
						$('#ajaxFacListDisplay').html(data);
			 });
		})
		$('#deleteFacModal').on('hide.bs.modal', function (event) {
			var lastAjaxQuery=$('#lastFacAjaxQuery').val();
			 //console.log(lastAjaxQuery);
			 $.post('ajaxFacManagement.php?'+lastAjaxQuery,function(data){
						$('#ajaxFacListDisplay').html(data);
			 });
		})
		
		function submit(){query=$("#facSearchBox").val();
							
							query=query.replace(/^\s+|[_|%|\"|\;|\,|.]|\s+$/gm,'');
							$("#ajaxFacListDisplay").html("<h2 class=\"text-center\"><i class='icon-spin icon-refresh icon-large'></i> Please Wait.. </b></h2>");
							 searchAJreq = $.ajax({
								type:"POST",
								url:"ajaxFacManagement.php",
								data:{"searchQuery":query},
								beforeSend:function(){if(searchAJreq!=null){searchAJreq.abort();}},
								success:function(data,textStatus){$("#ajaxFacListDisplay").hide().html(data).slideDown('500','swing');}
							});
								
		}
		function checkNewFacultyEmpCode(){newFacEmpCode = $("#newFacEmpCode").val();
							newFacEmpCode=newFacEmpCode.replace(/^\s+|[_|%|\"|\;|\,|.]|\s+$/gm,'');
							empCodeCheckAJreq= $.ajax({
								type:"POST",
								url:"ajaxFacManagement.php",
								data:{"checkNewFacEmpCode":newFacEmpCode},
								beforeSend:function(){if(searchAJreq!=null){searchAJreq.abort();}$("#saveNewFacStatus").slideUp('500','swing');},
								success:function(data,textStatus){
									if(data == "Yes"){$('#newFacEmpCodeInputGroup').attr('class','form-group has-success');
											if($("#newFacName").val()!=""){
														$('#saveNewFac').removeAttr('disabled','disabled');
											}
											var facName=$("#newFacName").val();
											if(facName==""){
														$('#saveNewFac').attr('disabled','disabled');
											}
									}else if(data == "No"){$('#newFacEmpCodeInputGroup').attr('class','form-group has-error');
														$('#saveNewFac').attr('disabled','disabled');
									}else{
											$('#saveNewFac').attr('disabled','disabled');
									}
								}
							});
		}
		function checkEditFacultyEmpCode(){editFacEmpCode = $("#editFacEmpCode").val();
							editFacEmpCode=editFacEmpCode.replace(/^\s+|[_|%|\"|\;|\,|.]|\s+$/gm,'');
							empCodeCheckAJreq= $.ajax({
								type:"POST",
								url:"ajaxFacManagement.php",
								data:{"checkNewFacEmpCode":editFacEmpCode},
								beforeSend:function(){if(searchAJreq!=null){searchAJreq.abort();}$("#saveEditFacStatus").slideUp('500','swing');},
								success:function(data,textStatus){
									if(data == "Yes"){$('#editFacEmpCodeInputGroup').attr('class','form-group has-success');
											if($("#editFacName").val()!=""){
														$('#updateFacInfoBtn').removeAttr('disabled','disabled');
											}
											var facName=$("#editFacName").val();
											if(facName==""){
														$('#updateFacInfoBtn').attr('disabled','disabled');
											}
									}else if(data == "No"){
										var facName=$("#editFacName").val();
											if(facName==""){
												$('#updateFacInfoBtn').attr('disabled','disabled');
											}else{
												$('#updateFacInfoBtn').removeAttr('disabled','disabled');
											}
									}else{
											$('#updateFacInfoBtn').attr('disabled','disabled');
									}
								}
							});
		}
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////All Functions and Code For Subject Management////////////////////////////////////
		//Modal config for editing Subject
		$('#editSubModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) // Button that triggered the modal 
			  $('#editSubCode').val(button.data('subcode'));
			  $('#editSubName').val(button.data('subname'));
			  $('#editSubDep').val(button.data('subdep'));
			  $('#editSubYear').val(button.data('subyear'));
		})
		//modal config for deleting Subject
		$('#deleteSubModal').on('show.bs.modal', function (event) {
			$("#deleteSubModalBody").show();
			  var button = $(event.relatedTarget) // Button that triggered the modal 
			  var deleteSubCode = button.data('subcode')
			  var deleteSubName = button.data('subname')
			  $('#delSubName').val(button.data('subname'));
			  $('#delSubCode').val(button.data('subcode'));
			  var modal = $(this)
				modal.find('.modal-title').text('Delete Subject - ' + deleteSubName)
				modal.find('.modal-body div#deleteSubModalBody').html('<h3 class="text-center">Do you really want to delete<br> <b>'+ deleteSubName + '</b><br> Subject Code : <b>'+ deleteSubCode +'</b><br>from the Feedback System ?</h3><div class="alert alert-danger text-center" role="alert"><b>Deletion will affect all the Reports belonging to this subject!<b></div>');
				$('#deleteSubInfoBtn').removeAttr('disabled','disabled');
				$("#deleteSubStatus").hide();
		})
		
		//Updating the Subject List table after a new subject is added or if any subject is updated or deleted
		$('#addNewSubjectModal').on('hide.bs.modal', function (event) {
			var lastAjaxQuery=$('#lastSubAjaxQuery').val();
			 //console.log(lastAjaxQuery);
			 $.post('ajaxSubManagement.php?'+lastAjaxQuery,function(data){
						$('#ajaxSubListDisplay').html(data);
			 });
		})
		$('#editSubModal').on('hide.bs.modal', function (event) {
			var lastAjaxQuery=$('#lastSubAjaxQuery').val();
			 //console.log(lastAjaxQuery);
			 $.post('ajaxSubManagement.php?'+lastAjaxQuery,function(data){
						$('#ajaxSubListDisplay').html(data);
			 });
		})
		$('#deleteSubModal').on('hide.bs.modal', function (event) {
			var lastAjaxQuery=$('#lastSubAjaxQuery').val();
			 //console.log(lastAjaxQuery);
			 $.post('ajaxSubManagement.php?'+lastAjaxQuery,function(data){
						$('#ajaxSubListDisplay').html(data);
			 });
		})
		
		function submitSubSearchQuery(){query=$("#subSearchBox").val();
							
							query=query.replace(/^\s+|[_|%|\"|\;|\,|.]|\s+$/gm,'');
							$("#ajaxSubListDisplay").html("<h2 class=\"text-center\"><i class='icon-spin icon-refresh icon-large'></i> Please Wait.. </b></h2>");
							 searchAJreq = $.ajax({
								type:"POST",
								url:"ajaxSubManagement.php",
								data:{"subSearchQuery":query},
								beforeSend:function(){if(searchAJreq!=null){searchAJreq.abort();}},
								success:function(data,textStatus){$("#ajaxSubListDisplay").hide().html(data).slideDown('500','swing');}
							});
								
		}
		function checkNewSubjectCode(){newSubCode = $("#newSubCode").val();
							newSubCode=newSubCode.replace(/^\s+|[_|%|\"|\;|\,|.]|\s+$/gm,'');
							subCodeCheckAJreq= $.ajax({
								type:"POST",
								url:"ajaxSubManagement.php",
								data:{"checkNewSubCode":newSubCode},
								beforeSend:function(){if(subCodeCheckAJreq!=null){subCodeCheckAJreq.abort();}$("#saveNewSubStatus").slideUp('500','swing');},
								success:function(data,textStatus){
									if(data == "Yes"){$('#newSubCodeInputGroup').attr('class','form-group has-success');
											if($("#newSubName").val()!=""){
														$('#saveNewSub').removeAttr('disabled','disabled');
											}
											var subName=$("#newSubName").val();
											if(subName==""){
														$('#saveNewSub').attr('disabled','disabled');
											}
									}else if(data == "No"){$('#newSubCodeInputGroup').attr('class','form-group has-error');
														$('#saveNewSub').attr('disabled','disabled');
									}else{
											$('#saveNewSub').attr('disabled','disabled');
									}
								}
							});
		}
		function checkEditSubjectCode(){editSubCode = $("#editSubCode").val();
							editSubCode=editSubCode.replace(/^\s+|[_|%|\"|\;|\,|.]|\s+$/gm,'');
							subCodeCheckAJreq= $.ajax({
								type:"POST",
								url:"ajaxSubManagement.php",
								data:{"checkNewSubCode":editSubCode},
								beforeSend:function(){if(subCodeCheckAJreq!=null)subCodeCheckAJreq.abort();$("#saveEditSubStatus").slideUp('500','swing');},
								success:function(data,textStatus){
									if(data == "Yes"){$('#editSubCodeInputGroup').attr('class','form-group has-success');
											if($("#editSubName").val()!=""){
														$('#updateSubInfoBtn').removeAttr('disabled','disabled');
											}
											var subName=$("#editSubName").val();
											if(subName==""){
														$('#updateSubInfoBtn').attr('disabled','disabled');
											}
									}else if(data == "No"){
										var subName=$("#editSubName").val();
											if(subName==""){
												$('#updateSubInfoBtn').attr('disabled','disabled');
											}else{
												$('#updateSubInfoBtn').removeAttr('disabled','disabled');
											}
									}else{
											$('#updateSubInfoBtn').attr('disabled','disabled');
									}
								}
							});
		}
//***********************************************************************************************************
//*************************************************************************************************************
/////////////////////////////////FACULTY-SUBJECT MAPPING/////////////////////////////////////////////////////
				$('#facSubMappingModal').on('show.bs.modal', function (event) {
					 $('#viewMappingsTable').html("<h1 class=\"text-center\"><i class='icon-spin icon-refresh icon-2x' style=\"color:#06D206;\"></i><br>Fetching Mappings... </b></h2>");
						$('#editMappingsTable').hide();
						$('#saveFacSubMappingBtn').attr('disabled','disabled').hide();
						$('#editFacSubMappingBtn').hide();
						$("#viewExistingFacSubMappingBtn").hide();
					  var button = $(event.relatedTarget) // Button that triggered the modal 
					  var mapForClassid = button.data('classid');
					  $('#mapClassid').val(mapForClassid);
					   var modal = $(this)
						
						$.get('ajaxFacSubMapManagement.php?ClassIdToName='+mapForClassid,function(data){
							modal.find('.modal-title').html('Faculty Subject Mappings - <b>' + data+'</b>')
						});
										
						//to show mapping data 
						$.get('ajaxFacSubMapManagement.php?getClassFacSubMap='+mapForClassid,function(data){
							$('#viewMappingsTable').html(data).fadeIn();
							$('#editFacSubMappingBtn').show();
						});
						
				});
				$('#facSubMappingModal').on('hide.bs.modal', function (event) {
					 $('#editFacSubMappingBtn').show();
					 $('#viewMappingsTable').show();
					 for(var subNum=1;subNum<=10;subNum++){
						$("#sub"+subNum+"SubCode").attr('disabled','disabled').val("No");
						$('#sub'+subNum+'SubName').html('<b><span class=\"glyphicon glyphicon-arrow-left\" aria-hidden=\"true\"></span> Enter Subject Code</b>');
						$('#sub'+subNum+'FacName').empty();
						$('#sub'+subNum+'FacName').attr('disabled','disabled');
						$('#sub'+subNum+'FacName').append($('<option>').text("-- Choose a Department --").attr('value','No'));
					}
					
				});
				function loadFacListFromDep(subNumber){
						var incompleteFlag = 0;
						for(var subNum=1;subNum<=10;subNum++){
								if($("#sub"+subNum+"dep").val() == "choose"){
								
									incompleteFlag = 1;
								}
						}
						if(incompleteFlag == 1){$('#saveFacSubMappingBtn').attr('disabled','disabled');}
						else{ $('#saveFacSubMappingBtn').removeAttr('disabled','disabled');}
						var selectedDep = $('select#'+subNumber+'dep option:selected').val();
						if(selectedDep == "choose" || selectedDep == "no"){
							$('#'+subNumber+'SubName').html('<b><span class=\"glyphicon glyphicon-arrow-left\" aria-hidden=\"true\"></span> Enter Subject Code</b>');
							$('#'+subNumber+'SubCode').val("No").attr('disabled','disabled');
							$('#'+subNumber+'FacName').empty();
							$('#'+subNumber+'FacName').attr('disabled','disabled');
							$('#'+subNumber+'FacName').append($('<option>').text("-- Choose a Department --").attr('value','No'));
							
							return;
						}
						$.get('ajaxFacSubMapManagement.php?mapClassDep='+selectedDep,
							function(data){
								$('#'+subNumber+'FacName').empty();
								$('#'+subNumber+'SubCode').val("")
								if(!jQuery.isEmptyObject(data.facultyList)){
										$.each(data.facultyList,function(i,value){
											$('#'+subNumber+'FacName').append($('<option>').text(value).attr('value',i));
										});
										$('#'+subNumber+'FacName').removeAttr('disabled','disabled');
										$('#'+subNumber+'SubCode').removeAttr('disabled','disabled');
								}else{
										$('#'+subNumber+'FacName').append($('<option>').text("No Faculty Available").attr('value','No'));
										$('#'+subNumber+'FacName').attr('disabled','disabled');
										$('#'+subNumber+'SubCode').attr('disabled','disabled');
								}
							},
							'json');
				}
				function loadSubNameFromSubCode(subNumber){
					var typedSubCode = $('#'+subNumber+'SubCode').val().toUpperCase();
					if(typedSubCode.length >=4){
						$.get('ajaxFacSubMapManagement.php?getSubNameFromSubCode='+typedSubCode,
							function(data){
								if(data =="No"){
										$('#'+subNumber+'SubName').html("<b>No Subject</b>");
								}else{
										$('#'+subNumber+'SubName').html("<b><span class=\"glyphicon glyphicon-book\" aria-hidden=\"true\"></span> "+data+"</b>");
								}
							});
					}else{
						$('#'+subNumber+'SubName').html("<b>Invalid Subject Code</b>");
					}
				}
				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///**********************************************************************************************************************////
		$(function(){
				$(document).keydown(function(e){if(!e){e=windows.event;}if(e.keyCode==13){
					//submit();
					//submitSubSearchQuery();
					//TODO: when enter is pressed both forms are submitted!!
					}});
			
///////////////////////////////FACULTY MANAGEMENT /////////////////////////////////////////////////
				//Adding new faculty
				//checking unique employee code for faculty
				$("#newFacEmpCode").keyup(function (){
									if($("#newFacEmpCode").val().length >=0){checkNewFacultyEmpCode();}
								});	
				//for new Fac Name
				$("#newFacName").keyup(function (){
									checkNewFacultyEmpCode();
								});
				//for saving new Fac Info
				$("#saveNewFac").click(function(){
						var newFacName=$("#newFacName").val();
						var newFacEmpCode=$("#newFacEmpCode").val();
						var newFacDep=$("#newFacDep").val();
						$.ajax({
								type:"POST",
								url:"ajaxFacManagement.php",
								data:{"newFacEmpCode":newFacEmpCode,"newFacName":newFacName,"newFacDep":newFacDep},
								beforeSend:function(){$('#saveNewFac').attr('disabled','disabled');},
								success:function(data,textStatus){
									$("#saveNewFacStatus").hide().html(data).slideDown('500','swing');
									
								}
							});
				});
				////////////////////////////////////////////////////////////////////////////
				//////////////////////////////////////////////////////////////////////////
				//updating existing faculty
				//for unique employee code
				$("#editFacEmpCode").keyup(function (){
									if($("#editFacEmpCode").val().length >=0){checkEditFacultyEmpCode();}
								});	
				//for editing Fac Name
				$("#editFacName").keyup(function (){
									checkEditFacultyEmpCode();
								});
				//for saving edited Fac Info
				$("#updateFacInfoBtn").click(function(){
						var editFacName=$("#editFacName").val();
						var editFacEmpCode=$("#editFacEmpCode").val();
						var editFacDep=$("#editFacDep").val();
						$.ajax({
								type:"POST",
								url:"ajaxFacManagement.php",
								data:{"editFacEmpCode":editFacEmpCode,"editFacName":editFacName,"editFacDep":editFacDep},
								beforeSend:function(){$('#updateFacInfoBtn').attr('disabled','disabled');},
								success:function(data,textStatus){
									$("#saveEditFacStatus").hide().html(data).slideDown('500','swing');
									
								}
							});
				});
				//deleting faculty
				$("#deleteFacInfoBtn").click(function(){
						var delFacName=$("#delFacName").val();
						var delFacEmpCode=$("#delFacEmpCode").val();
						$.ajax({
								type:"POST",
								url:"ajaxFacManagement.php",
								data:{"delFacEmpCode":delFacEmpCode,"delFacName":delFacName},
								beforeSend:function(){$('#deleteFacInfoBtn').attr('disabled','disabled');},
								success:function(data,textStatus){
									$("#deleteFacModalBody").slideUp('500','swing');
									$("#deleteFacStatus").hide().html(data).slideDown('500','swing');
									
								}
							});
				});
				//////////////////////////////////////////////////////////////////////////////////////
				//for faculty searchbox
				$("#facSearchBox").keyup(function (){
									if($("#facSearchBox").val().length >=6){submit();}
								});	
				$("#facSearchBtn").click(function(){submit();});	
				$("#showAllFacList").click(function(){
						$("#ajaxFacListDisplay").html("<h2 class=\"text-center\"><i class='icon-spin icon-refresh icon-large'></i> Please Wait.. </b></h2>");
							 searchAJreq = $.ajax({
								type:"POST",
								url:"ajaxFacManagement.php",
								data:{"searchQuery":"%"},
								beforeSend:function(){if(searchAJreq!=null){searchAJreq.abort();}},
								success:function(data,textStatus){$("#ajaxFacListDisplay").hide().html(data).slideDown('500','swing');}
							});
				
				});
//////////////////////////////////////////SUBJECT MANAGEMENT////////////////////////////////////////////////////////
				//Adding new Subject
				//checking unique subject code for subject
				$("#newSubCode").keyup(function (){
									if($("#newSubCode").val().length >=0){checkNewSubjectCode();}
								});	
				//for new Subject Name
				$("#newSubName").keyup(function (){
									checkNewSubjectCode();
								});
				//for saving new Fac Info
				$("#saveNewSub").click(function(){
						var newSubName=$("#newSubName").val();
						var newSubCode=$("#newSubCode").val();
						var newSubDep=$("#newSubDep").val();
						var newSubYear=$("#newSubYear").val();
						$.ajax({
								type:"POST",
								url:"ajaxSubManagement.php",
								data:{"newSubCode":newSubCode,"newSubName":newSubName,"newSubDep":newSubDep,"newSubYear":newSubYear},
								beforeSend:function(){$('#saveNewFac').attr('disabled','disabled');},
								success:function(data,textStatus){
									$("#saveNewSubStatus").hide().html(data).slideDown('500','swing');
									
								}
							});
				});
				////////////////////////////////////////////////////////////////////////////
				//////////////////////////////////////////////////////////////////////////
				//updating existing Subject
				//for unique Subject code
				$("#editSubCode").keyup(function (){
									if($("#editSubCode").val().length >=0){checkEditSubjectCode();}
								});	
				//for editing Subject Name
				$("#editSubName").keyup(function (){
									checkEditSubjectCode();
								});
				//for saving edited Subject Info
				$("#updateSubInfoBtn").click(function(){
						var editSubName=$("#editSubName").val();
						var editSubCode=$("#editSubCode").val();
						var editSubDep=$("#editSubDep").val();
						var editSubYear=$("#editSubYear").val();
						$.ajax({
								type:"POST",
								url:"ajaxSubManagement.php",
								data:{"editSubCode":editSubCode,"editSubName":editSubName,"editSubDep":editSubDep,"editSubYear":editSubYear},
								beforeSend:function(){$('#updateSubInfoBtn').attr('disabled','disabled');},
								success:function(data,textStatus){
									$("#saveEditSubStatus").hide().html(data).slideDown('500','swing');
									
								}
							});
				});

				//deleting Subject
				$("#deleteSubInfoBtn").click(function(){
						var delSubName=$("#delSubName").val();
						var delSubCode=$("#delSubCode").val();
						$.ajax({
								type:"POST",
								url:"ajaxSubManagement.php",
								data:{"delSubCode":delSubCode,"delSubName":delSubName},
								beforeSend:function(){$('#deleteSubInfoBtn').attr('disabled','disabled');},
								success:function(data,textStatus){
									$("#deleteSubModalBody").slideUp('500','swing');
									$("#deleteSubStatus").hide().html(data).slideDown('500','swing');
									
								}
							});
				});
				
				
				
				
				
				//for subject searchbox
				$("#subSearchBox").keyup(function (){
									if($("#subSearchBox").val().length >=6){submitSubSearchQuery();}
								});	
				$("#subSearchBtn").click(function(){submitSubSearchQuery();});	
				//Listing all subjects
				$("#showAllSubList").click(function(){
						$("#ajaxSubListDisplay").html("<h2 class=\"text-center\"><i class='icon-spin icon-refresh icon-large'></i> Please Wait.. </b></h2>");
							 searchAJreq = $.ajax({
								type:"POST",
								url:"ajaxSubManagement.php",
								data:{"subSearchQuery":"%"},
								beforeSend:function(){if(searchAJreq!=null){searchAJreq.abort();}},
								success:function(data,textStatus){$("#ajaxSubListDisplay").hide().html(data).slideDown('500','swing');}
							});
				
				});
				//Listing specific subjects
				$("#subListBtn").click(function(){
						var subSearchYear=$("#subSearchYear").val();
						var subSearchDep=$("#subSearchDep").val();
						$("#ajaxSubListDisplay").html("<h2 class=\"text-center\"><i class='icon-spin icon-refresh icon-large'></i> Please Wait.. </b></h2>");
							 searchAJreq = $.ajax({
								type:"POST",
								url:"ajaxSubManagement.php",
								data:{"subSearchYear":subSearchYear,"subSearchDep":subSearchDep},
								beforeSend:function(){if(searchAJreq!=null){searchAJreq.abort();}},
								success:function(data,textStatus){$("#ajaxSubListDisplay").hide().html(data).slideDown('500','swing');}
							});
				
				});
				////////////////////////////////////////////////////////////////////////////////////////
	////////FACULTY-SUBJECT MAPPING//////////////////////////////////////////
				//Edit Mapping Button
				$("#editFacSubMappingBtn").click(function(){
					$("#editFacSubMappingBtn").hide();
					$('#viewMappingsTable').fadeToggle({complete:function(){
						$('#editMappingsTable').fadeToggle({complete:function(){
						$("#viewExistingFacSubMappingBtn").show();
						$("#saveFacSubMappingBtn").show();
					}});
					}});
					
					
				});
				//view Existing Mapping Button
				$("#viewExistingFacSubMappingBtn").click(function(){
					$("#viewExistingFacSubMappingBtn").hide();
					$("#saveFacSubMappingBtn").hide();
					$('#editMappingsTable').fadeToggle({complete:function(){
						$('#viewMappingsTable').fadeToggle({complete:function(){
						$("#editFacSubMappingBtn").show();
						
					}});
					}});
					
					
				});
				//Saving New Faculty-Subject Mapping
				$("#saveFacSubMappingBtn").click(function(){
								var emptySubCodeFlag = 0;
								var invalidOrNoSubFlag = 0;
					for(var subNum=1;subNum<=10;subNum++){
								if($("#sub"+subNum+"SubCode").val() == ""){
									emptySubCodeFlag = 1;
								}
								if($("#sub"+subNum+"SubName").text() == "Invalid Subject Code" || $("#sub"+subNum+"SubName").text() == "No Subject" ){
									invalidOrNoSubFlag = 1;
								}
					}
					if(emptySubCodeFlag == 1){alert(" One or More Subject Code is Missing!"); return;}
					if(invalidOrNoSubFlag == 1){alert(" One or More Subject Code is Invalid!"); return;}
					$("#viewExistingFacSubMappingBtn").hide();
					$("#saveFacSubMappingBtn").hide();
					var mapClassid=$("#mapClassid").val();
					$('#editMappingsTable').fadeToggle({complete:function(){
						$('#viewMappingsTable').html("<h1 class=\"text-center\"><i class='icon-spin icon-refresh icon-2x' style=\"color:#06D206;\"></i><br>Saving New Mappings... </b></h2>");
						$('#viewMappingsTable').fadeToggle({complete:function(){
							facSubMappings = new Object();
							facSubMappings["mapClassid"] = mapClassid;
							for(var subNum=1;subNum<=10;subNum++){
									facCode = $("#sub"+subNum+"FacName").val().toUpperCase();
									subCode = $("#sub"+subNum+"SubCode").val().toUpperCase();
									facSubMappings["sub"+subNum] = facCode+"-"+subCode;
							}
							var facSubMappingsJSON = JSON.stringify(facSubMappings);
							$.ajax({
								type: 'POST',
								url: "ajaxFacSubMapManagement.php",
								data:{facSubMappings:facSubMappings},
								success:function(data){
									$('#viewMappingsTable').html(data);
								}
							});	
							
					}});
					}});
					
					
				});
		});
</script>
</html>