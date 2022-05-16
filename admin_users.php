<?php
$order ='';
if(isset($_GET['order'])){$order=$_GET['order'];}
if(isset($_GET['val']))$orderby=$_GET['val'];
require_once("../models/config_admin.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Forms posted
if(!empty($_POST))
{
	$deletions = $_POST['delete'];
	if ($deletion_count = deleteUsers($deletions)){
		$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
	}
	else {
		$errors[] = lang("SQL_ERROR");
	}
}
if (isset($_GET['val'])) {$val1 = $_GET['val'];}
else  {$val1= 'user_name'; }
if (isset($_GET['order'])) {$val2 = $_GET['order'];}
else { $val2= 'ASC';}
        
$userData = fetchAllUsers($val1,$val2); //Fetch information for all users

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
    <td >Admin Users</td>
  </tr>
</table> 
<style>
    
 .scroll_div     {width: 100%;
                height: 595px;
                overflow-y: auto;
                max-width:100%;
                max-height:100%;
                }
</style>
<?php
echo "
</div>
<div id='main'> ";

//echo resultBlock($errors,$successes);
 
echo " 
<form name='adminUsers' action='" .$_SERVER['PHP_SELF']. "' method='post'>";
 ?>   

<table width= 100%>
<tr>
<th width= "10%" >Delete</th>
<th width= "20%" ><a href='?val=user_name&order=<?php  echo $order =='DESC' ? 'ASC' : 'DESC' ?>'>Username </a></th>
<th width= "20%" ><a href='?val=display_name&order=<?php  echo $order =='DESC' ? 'ASC' : 'DESC' ?>'>Display Name</a></th>
<th width= "20%" ><a href='?val=title&order=<?php  echo $order =='DESC' ? 'ASC' : 'DESC' ?>'>Title</a></th>
<th width= "25%" ><a href='?val=last_sign_in_stamp&order=<?php  echo $order =='DESC' ? 'ASC' : 'DESC' ?>'>Last Sign In</a></th>
</tr></table>
  <div class= scroll_div> 
<table width= 100%> 
 <?php


//Cycle through users
foreach ($userData as $v1) {
	echo "
	<tr>
	<td width= 9%><input type='checkbox' name='delete[".$v1['id']."]' id='delete[".$v1['id']."]' value='".$v1['id']."'></td>
	<td width= 20%><a href='admin_user.php?id=".$v1['id']."'>".$v1['user_name']."</a></td>
	<td width= 20% >".$v1['display_name']."</td>
	<td width= 20% >".$v1['title']."</td>
	<td width= 23%>
	";
	
	//Interprety last login
	if ($v1['last_sign_in_stamp'] == '0'){
		echo "Never";	
	}
	else {
          //  echo date_format($v1['last_sign_in_stamp'], 'g:ia \o\n l jS F Y');
		echo date('Y-m-d   H:i:s', $v1['last_sign_in_stamp']);
           
	}
	echo "
	</td>
	</tr>";
}

echo "
</table>
 </div>
 <p></p>
<input type='submit' name='Submit' value='Delete' />
</form>
</div>
<div id='bottom'></div>
</div>
</body>
</html>";

?>
