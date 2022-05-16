<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("../models/header.php");
//require_once("config.php");
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
    <td >Connected Users </td>
  </tr>
</table> 
<div id='main'>
<?php 
  $xx_mins_ago = (time() - 900);

 // remove entries that have expired
 // $del_query="delete from  whos_online where time_last_click < '" . $xx_mins_ago . "'";
  //$del_result = mysql_query($del_query);
  
  $submit=$_POST['logoutuser'];
  if ($submit=="logoutuser")
  {
//  echo "skdnjnsfnsdmnf".$user_cp_logout;
 unset($_SESSION['$user_cp_logout']);
  }
?>
<script type="text/javascript">
window.setTimeout(function(){ document.location.reload(true); }, 15000);
</script>
</head>
<?php 
 
date_default_timezone_set('Etc/GMT+3');
$datee=date('Y-m-d');
$user_cpno=$loggedInUser->cpnomber;
 $xx_mins_ago = (time() - 900);
 
?>
<table width="1000" border="0" align="center">
  <tr >
    <th width="274" align="left" scope="col"  >logged on By : <?php 
$aa=$loggedInUser->displayname; echo $aa;?></th>
    <th width="757"  scope="col">&nbsp;</th>
    <th width="112" scope="col"><p><a href="../account.php"> Back </a></p></th>
  </tr>
</table>
<form id="form2" name="form2" method="post" action="">
<?php
             echo "<table width=900 border=1 align=center>";
             echo '<tr>';
             echo '<th  scope="col" colspan="6">ONLINE USERS </th>';
            echo '</tr>';
            echo '<tr>';
            echo '<th  width=15 scope="col">UN ID</th>';
             echo '<th  scope="col">Full Name</th>';
             echo '<th  scope="col">IP Address</th>';
             echo '<th  scope="col">Entry Time</th>';
             echo '<th  scope="col">Last Click</th>';
             echo '<th  scope="col">Log Out User</th>';
             echo '</tr>';

  $whos_online_query ="select cp_no, full_name, ip_address, time_entry, time_last_click from whos_online";
  $whos_online_result= mysql_query($whos_online_query);
if ($whos_online_result){
  while($whos_online = mysql_fetch_array($whos_online_result)) 
  {
    $user_cp_logout=$whos_online['cp_no'];
    echo "<tr>";
    echo "<td  >" . $whos_online['cp_no'] . "</td>";
	echo "<td >" . $whos_online['full_name'] . "</td>";
	echo "<td >" . $whos_online['ip_address'] . "</td>";
	echo "<td  >" . date('H:i:s', $whos_online['time_entry']) . "</td>";
	echo "<td  >".  date('H:i:s', $whos_online['time_last_click']) . "</td>";
	echo "<td  >*******</td>";
    echo "</tr>";
 } 
echo "</table>"; 
}
?>
</form>
</div>
</div>
</div>

</div><div id='bottom'></div>
</body>
</html> 

<?php
 ob_end_flush();?>
 
