<?php
require_once("../models/config_admin.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if (isset($_GET['id'])){$pageId = $_GET['id'];} else {$pageId ='';}

//Check if selected pages exist
if(!pageIdExists($pageId)){
	header("Location: admin_pages.php"); die();	
}

$pageDetails = fetchPageDetails($pageId); //Fetch information specific to page

//Forms posted
if(!empty($_POST)){
	$update = 0;
	
	if(!empty($_POST['private'])){ $private = $_POST['private']; }
	
	//Toggle private page setting
	if (isset($private) AND $private == 'Yes'){
		if ($pageDetails['private'] == 0){
			if (updatePrivate($pageId, 1)){
				$successes[] = lang("PAGE_PRIVATE_TOGGLED", array("private"));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
	}
	elseif ($pageDetails['private'] == 1){
		if (updatePrivate($pageId, 0)){
			$successes[] = lang("PAGE_PRIVATE_TOGGLED", array("public"));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
	}
	
	//Remove permission level(s) access to page
	if(!empty($_POST['removePermission'])){
		$remove = $_POST['removePermission'];
		if ($deletion_count = removePage($pageId, $remove)){
			$successes[] = lang("PAGE_ACCESS_REMOVED", array($deletion_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
		
	}
	
	//Add permission level(s) access to page
	if(!empty($_POST['addPermission'])){
		$add = $_POST['addPermission'];
		if ($addition_count = addPage($pageId, $add)){
			$successes[] = lang("PAGE_ACCESS_ADDED", array($addition_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
	}
	
	$pageDetails = fetchPageDetails($pageId);
}

$pagePermissions = fetchPagePermissions($pageId);
$permissionData = fetchAllPermissions();

require_once("../models/header.php");

echo "

<div id='wrapper'>
<div id='content'><br>
        <link rel='stylesheet' type='text/css' href='../style/menu.css'>
        <link href='../style/tablecloth.css' rel='stylesheet' type='text/css' media='screen' />
        <script type='text/javascript' src='../style/tablecloth.js'></script>
<table>
    <tr>
    <th >CENTRAL DATABASE MANAGEMENT SYSTEM</th>
  </tr>
    <tr>
    <td >Admin page</td>
  </tr>
</table>";

echo "
</div>
<div id='main'>";

////echo resultBlock($errors,$successes);

echo "
<form name='adminPage' action='".$_SERVER['PHP_SELF']."?id=".$pageId."' method='post'>
<input type='hidden' name='process' value='1'>
 <div style= width:100% ; > 
 
  <div style=float:left;width:50%; >
<table width=100%  >
<tr><th colspan=2>
<h3>Page Information</h3> </th>
 
</tr><tr>
<th>ID </th><td>
".$pageDetails['id']."</td>
</tr>
<tr>
<th>Name </th><td>
".$pageDetails['page']."</td>
</tr>
<tr>
<th>Private</th><td>";

//Display private checkbox
if ($pageDetails['private'] == 1){
	echo "<input type='checkbox' name='private' id='private' value='Yes' checked>";
}
else {
	echo "<input type='checkbox' name='private' id='private' value='Yes'>";	
}

echo "</td>
</tr>
</table>

</div>
 <div style=float:right;width:50%; >
<table width=100%  >
<tr>
 <th>
<h3>Page Access</h3></th>
 </tr><tr>
<th>
Remove Access</th> ";

//Display list of permission levels with access
foreach ($permissionData as $v1) {
	if(isset($pagePermissions[$v1['id']])){
		echo "<tr><td><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name']
                        ."</td></tr>";
	}
}

echo"
 <tr><th>Add Access</th></tr>";

//Display list of permission levels without access
foreach ($permissionData as $v1) {
	if(!isset($pagePermissions[$v1['id']])){
		echo "<tr><td><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name']
                         ."</td></tr>";
	}
}

echo"
</table>
</div>
 <table><tr>
<th>&nbsp;</th><td>
<input type='submit' value='Update' class='submit' /></td>
</table>
</form>
</div>
<div id='bottom'></div>
</div>
</body>
</html>";

?>
