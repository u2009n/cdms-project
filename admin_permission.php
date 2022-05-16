<?php

require_once("../models/config_admin.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$permissionId = $_GET['id'];

$pagePermission_sql=get_pagePermission_level();
//Check if selected permission level exists
if(!permissionIdExists($permissionId)){
	header("Location: admin_permissions.php"); die();	
}

$permissionDetails = fetchPermissionDetails($permissionId); //Fetch information specific to permission level

//Forms posted
if(!empty($_POST)){
	
	//Delete selected permission level
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deletePermission($deletions)){
		$successes[] = lang("PERMISSION_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
	}
	else
	{
		//Update permission level name
		if($permissionDetails['name'] != $_POST['name']) {
			$permission = trim($_POST['name']);
			
			//Validate new name
			if (permissionNameExists($permission)){
				$errors[] = lang("ACCOUNT_PERMISSIONNAME_IN_USE", array($permission));
			}
			elseif (minMaxRange(1, 50, $permission)){
				$errors[] = lang("ACCOUNT_PERMISSION_CHAR_LIMIT", array(1, 50));	
			}
			else {
				if (updatePermissionName($permissionId, $permission)){
					$successes[] = lang("PERMISSION_NAME_UPDATE", array($permission));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Remove access to pages
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($permissionId, $remove)) {
				$successes[] = lang("PERMISSION_REMOVE_USERS", array($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Add access to pages
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($permissionId, $add)) {
				$successes[] = lang("PERMISSION_ADD_USERS", array($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Remove access to pages
		if(!empty($_POST['removePage'])){
			$remove = $_POST['removePage'];
			if ($deletion_count = removePage($remove, $permissionId)) {
				$successes[] = lang("PERMISSION_REMOVE_PAGES", array($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Add access to pages
		if(!empty($_POST['addPage'])){
			$add = $_POST['addPage'];
            $plevel= $_POST['p_level'];
			if ($addition_count = addPage($add, $permissionId,$plevel)) {
				$successes[] = lang("PERMISSION_ADD_PAGES", array($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
			$permissionDetails = fetchPermissionDetails($permissionId);
	}
}

$pagePermissions = fetchPermissionPages($permissionId); //Retrieve list of accessible pages
$permissionUsers = fetchPermissionUsers($permissionId); //Retrieve list of users with membership
$userData = fetchAllUsers('cpnom','ASC'); //Fetch all users
$pageData = fetchAllPages(); //Fetch all pages

require_once("../models/header.php");
echo "
<style>
    
 .scroll_div     { 
                height: 200px;
                overflow-y: auto;
                 
                }
</style>
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
    <td >Admin Permission</td>
  </tr>
</table>";

echo "
</div>
<div id='main'>";

////echo resultBlock($errors,$successes);

echo "
<form name='adminPermission' action='".$_SERVER['PHP_SELF']."?id=".$permissionId."' method='post'>
<p>
<label>&nbsp;</label>

</p>
<div style= width:100%; >
<table width= 100%'>
<tr>
    <th colspan =2>
        <h3>Permission Information</h3>
    </th>
 </tr>
 <tr>
    <th>ID </th>
<td>".$permissionDetails['id']."</td>
</tr>
<tr>
<th>Name </th>
<td><input type='text' name='name' value='".$permissionDetails['name']."' /></td>
</tr>
<tr>
    <th>Delete </th>
    <td><div>
    <div align=left> <input type='checkbox' name='delete[".$permissionDetails['id']."]' "
            . "id='delete[".$permissionDetails['id']."]' value='".$permissionDetails['id']."'></div>
       
    </div></td>
</tr>
</table>
</div>
 <div align=right> <input type='submit' value='Update' class='submit' /></div>
<div style= width:100%; > 
   
  <div style=float:left;width:40%; >
    <table width= 100%'>
        <tr>
            <th>
                <h3>Permission Membership</h3>
            </th>
        </tr>
        <tr>
            <th>Remove Members</th>
        </tr> 
        </table>
        <div class=scroll_div >
        <table width= 100%'>";

//List users with permission level
foreach ($userData as $v1) {
	if(isset($permissionUsers[$v1['id']])){
		echo "<tr><td><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".
                        $v1['cpnom']. " ***     ".$v1['display_name'] 
                        ."</tr></td>";
	}
}

echo"</table> </div><table>
 <tr><th>Add Members</th></tr></table><div class=scroll_div ><table>";

//List users without permission level
foreach ($userData as $v1) {
	if(!isset($permissionUsers[$v1['id']])){
		echo "<tr><td><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']
                        ."]' value='".$v1['id']."'> ".$v1['cpnom']. " ***"."     ".$v1['display_name']
                       ."</tr></td> ";
         }
}

echo"
</table>
</div></div>
  <div style=float:right;width:55%; >
    <table width= 100%'>
        <tr>
            <th>
                <h3>Permission Access</h3>
            </th>
        </tr>
        <tr>
            <th >Add Access </th>
        </tr></table><div class=scroll_div ><table width= 100% >";

//List pages inaccessible to permission level
foreach ($pageData as $v1) {
	if(!isset($pagePermissions[$v1['id']]) AND $v1['private'] == 1){
		echo "<tr><td><input type='checkbox' name='addPage[".$v1['id']."]' id='addPage[".$v1['id']."]' value='".$v1['id']."'> ".$v1['page']."---".$v1['url']. "</td>
                  <td><select name=p_level[$v1[id]]>
                  <option value='0'>Staff</option>
                  <option value='1'>Post</option>
                  <option value='2'>Unit</option>
                  <option value='3'>Dept</option>
                  <option value='4'>Sector</option>
                  <option value='5'>All IPOs</option>
                  <option value='6'>All Component</option>
                  </select> </td>
                  </tr>"; 
                }
}

echo"</table></div><table>
    <tr>
        <th >
            Remove Access 
        </th>
    </tr></table><div class=scroll_div ><table width= 100% >";
 
//List pages accessible to permission level
foreach ($pageData as $v1) {
	if(isset($pagePermissions[$v1['id']]) AND $v1['private'] == 1){
		echo "<tr><td><input type='checkbox' name='removePage[".$v1['id']."]' id='removePage[".$v1['id']."]' value='".$v1['id']."'> ".$v1['page']."---".$v1['url']. "</td>
               <td ><div> ".$pagePermissions[$v1['id']]['perm_level']. " </div> </td>
		      </tr>";      
	}
}


echo"</table></div><table>
        <tr>
            <th>
                Public Access
            </th>
        </tr></table><div class=scroll_div ><table width= 100% >";
//List public pages
foreach ($pageData as $v1) {
	if($v1['private'] != 1){
		echo "<tr><td>".$v1['page']. "</td></tr>";
	}
}
echo " 
</table>
</div>
</div>
 

</form>
</div></div></div>
<div id='bottom'></div>
</body>
</html>";

?>
