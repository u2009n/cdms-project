<?php

require_once("../models/config_admin.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("../models/header.php");
?>

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
    <td >Admin Permissions</td>
  </tr>
</table> 

 
</div>
<div id='main'> 
    <?php
//Forms posted
if(!empty($_POST))
{
	//Delete permission levels
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deletePermission($deletions)){
		$successes[] = lang("PERMISSION_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
	}
	
	//Create new permission level
	if(!empty($_POST['newPermission']))
	 {
		$permission = trim($_POST['newPermission']);
		
		//Validate request
		if (permissionNameExists($permission)){
			$errors[] = lang("PERMISSION_NAME_IN_USE", array($permission));
		}
		elseif (minMaxRange(1, 50, $permission)){
			$errors[] = lang("PERMISSION_CHAR_LIMIT", array(1, 50));	
		}
		else{
			if (createPermission($permission)) {
			$successes[] = lang("PERMISSION_CREATION_SUCCESSFUL", array($permission));
		}
			else 
			{
				$errors[] = lang("SQL_ERROR");
			}
		}
	}
}

$permissionData = fetchAllPermissions(); //Retrieve list of all permission levels
echo "
<form name='adminPermissions' action='".$_SERVER['PHP_SELF']."' method='post'>
   <table>
   <tr>
<th>Add New Permission   </th>
<td><input type='text' name='newPermission' /></td>
 <td>                               
<input type='submit' name='Submit' value='Save' /> 
</td>
</tr><tr>
<th colspan = 3></th></tr>
</table>

<table class='admin' width= 100%>
<tr>
<th width= 15%>Delete</th><th width= 85%>Permission Name</th>
</tr>";

//List each permission level
foreach ($permissionData as $v1) {
	echo "
	<tr>
	<td><input type='checkbox' name='delete[".$v1['id']."]' id='delete[".$v1['id']."]' value='".$v1['id']."'></td>
	<td><a href='admin_permission.php?id=".$v1['id']."'>".$v1['name']."</a></td>
	</tr>";
}

echo "
</table>

</form>
</div>
<div id='bottom'></div>
</div>
</body>
</html>";

?>
