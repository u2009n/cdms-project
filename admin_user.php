<?php 
require_once("../models/config_admin.php");
$userId = $_GET['id'];
//Check if selected user exists
if(!userIdExists($userId)){
	header("Location: admin_users.php"); die();
}

$userdetails = fetchUserDetails(NULL, NULL, $userId); //Fetch user details

//Forms posted
if(!empty($_POST))
{	
	//Delete selected account
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deleteUsers($deletions)) {
			$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");
		}
	}
	else
	{
		//Update display name
		if ($userdetails['display_name'] != $_POST['display']){
			$displayname = trim($_POST['display']);
			
			//Validate display name
			if(displayNameExists($displayname))
			{
				$errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
			}
			elseif(minMaxRange(5,25,$displayname))
			{
				$errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
			}
			elseif(!ctype_alnum($displayname)){
				$errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
			}
			else {
				if (updateDisplayName($userId, $displayname)){
					$successes[] = lang("ACCOUNT_DISPLAYNAME_UPDATED", array($displayname));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
			
		}
		else {
			$displayname = $userdetails['display_name'];
		}
		
		//Activate account
		if(isset($_POST['activate']) && $_POST['activate'] == "activate"){
			if (setUserActive($userdetails['activation_token'])){
				$successes[] = lang("ACCOUNT_MANUALLY_ACTIVATED", array($displayname));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Update email
		if ($userdetails['email'] != $_POST['email']){
			$email = trim($_POST["email"]);
			
			//Validate email
			if(!isValidEmail($email))
			{
				$errors[] = lang("ACCOUNT_INVALID_EMAIL");
			}
			elseif(emailExists($email))
			{
				$errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));
			}
			else {
				if (updateEmail($userId, $email)){
					$successes[] = lang("ACCOUNT_EMAIL_UPDATED");
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Update title
		if ($userdetails['title'] != $_POST['title']){
			$title = trim($_POST['title']);
			
			//Validate title
			if(minMaxRange(1,50,$title))
			{
				$errors[] = lang("ACCOUNT_TITLE_CHAR_LIMIT",array(1,50));
			}
			else {
				if (updateTitle($userId, $title)){
					$successes[] = lang("ACCOUNT_TITLE_UPDATED", array ($displayname, $title));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Remove permission level
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($remove, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_REMOVED", array ($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($add, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_ADDED", array ($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		$userdetails = fetchUserDetails(NULL, NULL, $userId);
	}
}

$userPermission = fetchUserPermissions($userId);
$permissionData = fetchAllPermissions();

require_once("../models/header.php");
if (!securePage($_SERVER['PHP_SELF'])){ echo "<script>";   echo "self.location='../errorscreen.php'";  echo "</script>";} 
?>
<table widht = "100%">
  <tr>
    <th width="274" align="left"  scope="col">logged on By : <?php 
$aa=$loggedInUser->displayname; echo $aa;?></th>
    <th width="757" scope="col">&nbsp;</th>
    <th width="112"  scope="col"><p><a href="../account.php"> Back </a></p></th>
  </tr>
</table>
<style>
    
 .scroll_div     { 
                height: 264px;
                overflow-y: auto;
                 
                }
</style>
<?php 
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
    <td >Admin User</td>
  </tr>
</table>";

echo "
 
<div id='main'>";
 
 ////echo resultBlock($errors,$successes);
 
echo "
 
<form name='adminUser' action='".$_SERVER['PHP_SELF']."?id=".$userId."' method='post'>

        <table width=100%  >
        <tr>
            <th colspan = 4>User Information</th>
        </tr>
        <tr>
            <th>ID </th>
            <td>".$userdetails['id']."</td>
            <th>User Name </th>
            <td>".$userdetails['user_name']."</td>
        </tr>
        <tr>
            <th>Display Name</th>
            <td><input type='text' name='display' value='".$userdetails['display_name']." 'maxlength=50 width=50 /></td>
            <th>Email </th>
            <td><input type='text' name='email' value='".$userdetails['email']."' maxlength=50 width=50 /></td>
        </tr>
        <tr>
            " ;


echo "
</tr>
 <th>Title </th><td>
<input type='text' name='title' value='".$userdetails['title']."'maxlength=50 width=50 /></td>
<tr>
<th>Sign Up </th><td>
".date("j M, Y", $userdetails['sign_up_stamp'])."</td>
 
<th>Last Sign In </th><td>";

//Last sign in, interpretation
if ($userdetails['last_sign_in_stamp'] == '0'){
	echo "Never";	
}
else {
	echo date("j M, Y", $userdetails['last_sign_in_stamp']);
}
 
echo "</td>
</tr>
<tr>

    <th>Active </th><td>";

//Display activation link, if account inactive
if ($userdetails['active'] == '1'){
	echo "Yes </td>";	
}
else{
	echo "No 
 
           </td> 
	<th>Activate</th><td>
	<input type='checkbox' name='activate' id='activate' value='activate' maxlength=50 width=50 >
	</td>";
        
        }
echo "
</tr>
<tr>
<th>Delete </th>
<td>
<input type='checkbox' name='delete[".$userdetails['id']."]' id='delete[".$userdetails['id']."]' value='".$userdetails['id']."'>
</td>
<td colspan = 2 ><div align=center>
<input type='submit' value='Update' class='submit' /></div></td>
</tr>
</table> 
</div>
 <table width= 100%  >  
<tr>
<th >Permission Membership</th >
</tr> </table>

 <div style= width:100% ; > 
 
  <div style=float:left;width:48%; >";

//List of permission levels user is not apart of
echo " <table><tr><th>Add Permission</th></tr></table>";
echo " <div class=scroll_div ><table width= 100% >";

foreach ($permissionData as $v1) {
	if(!isset($userPermission[$v1['id']])){
            echo " <tr><td>"
            . "<input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name']
            .   "</td></tr>";
	}
}

echo"
</table></div> </div>
<div style=float:right;width:48%;  >
    <table><tr><th>Remove Permission </th></tr></table>";
echo " <div class=scroll_div ><table width= 100% >";
//List of permission levels user is apart of
foreach ($permissionData as $v1) {
	if(isset($userPermission[$v1['id']])){
            echo "<tr><td>" 
            . "<input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name']
            .   "</td></tr>";
	}
}
echo "</table></div></div>";
echo " 

</form>
</div></div></div>
<div id='bottom'></div>
</body>
</html>";

 ?>