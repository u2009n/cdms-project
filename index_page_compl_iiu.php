<?php
ob_start();
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//echo "$_SERVER[PHP_SELF]";
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
    <td >Viev Deployment Orders</td>
  </tr>
</table>

</div>
<div id='main'>";
?>
<script>
function openPopup(winname,url){    
    var popwidth=screen.availWidth-100;
    var popheight=screen.availHeight-100;
    var popleft = Math.round((screen.availWidth - popwidth) / 2);
    var poptop = Math.round((screen.availHeight - popheight) / 2);
	var args = 'toolbar=no,status=no,menubar=no,location=no,directories=no,resizable=no,scrollbars=no,width='+ popwidth+',height='+ popheight+',left='+ popleft+',top='+ poptop;	
	var nw = window.open(url, winname, args);	
	return nw;
}
</script>

<?php
//require_once("../config.php");
date_default_timezone_set('Etc/GMT+3');
$datee=date('Y-m-d');
//require_once('../models/cala.php');
?>
<script language="javascript" type="text/javascript">
    function showoption(auth_id,do_status) {
        document.form.submit();
    }
    </script>

<!--<link href="jquery/css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
<<link href="../Deployment/library/Styles.css" rel="stylesheet" type="text/css">
<<link href="../jquery/css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
<<link href="../jquery/css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">-->
<table>
  <tr bgcolor="#CCCCCC">
    <th width="274" align="left"  scope="col">logged on By : <?php 
$aa=$loggedInUser->displayname; echo $aa;?></th>
    <th width="757">&nbsp;</th>
    <th width="112"  scope="col"><a href="../account.php"> Back </a></th>
  </tr>
</table>
	<form id="form3" name="form3" method="post" action="">
	  <table width="100%" height="106" border="0" align="center" class="style2">
  <th>Date</th>
  <td><input name="textfield1" type="text" id="textfield1" />
      </td>
    <th width="143">Date of Occurrence</th>
    <td width="243" >
          <input type="text" name="occurence_date" size=''/>
    </td>
  </tr>
  <tr>
    <th height="29" >Complainant</th>
    <td> <input name="cmp_name" type="text" id="popup_container1" value="" /></td>
    <th>Status</th>
    <td ><div align="left">
      <select name="select" id="select" >
        <option value="n">---Select Status---</option>
        <option value="On process">On process</option>
        <option value="Waiting for Approving">Waiting for Approving</option>
        <option value="Approved">Approved</option>
        <option value="Denied">Denied</option>
        <option value="Under Investigation">Under Investigation</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <th height="29" >Complaint Details</th>
    <td colspan="3" > <label>
	
	<select name="cmp_details" id="cmp_details" onChange="showsector(this.value);">
		<option value="0"> --Select--</option>
		<?php
		//------------------------------------------This code does list of Investigators---------------------// 
		
		$sql_complaint="SELECT cmp_details FROM `complaints`  WHERE 1=1";
																
																 
		$sql_complaint_row= mysql_query($sql_complaint);
		while ($sql_complaint_result=mysql_fetch_assoc($sql_complaint_row))
		{
		?>
		
		<option value="<?php echo $sql_complaint_result["cmp_details"]; ?>"<?php    
		
		if($sql_complaint_result["cmp_details"]==$_REQUEST["cmp_details"])
		{		
		  echo "Selected";
		
		}
		 ?>>
		 <?php  echo $sql_complaint_result["cmp_details"];?>
		</option>
		<?php 
		} 
		
		?>
		
		</select></label>
	
	   
      <b></b>    <div align="left"></div></td>
	</tr>
  <tr>
    <td height="36" colspan="4" bgcolor="#CCCCCC" ><div align="center">
      <input name="Submit" type="submit" class="T-LA2" value="Search" />
      ...
      <input name="Submit2" type="submit" class="T-LA2" value="Reset Search"   />
    </div>
        <div align="right"></div></td>
  </tr>
      </table>
	</form>
<form id="form1" name="form1" method="post" action="add_complaint.php">
  <div align="center">
    <div align="left">
      <input name="Submit22" type="submit" class="T-LA2" value="Add New Complaint" />
    </div>
  </div>
</form>
	</p>
<table width="100%" height="52" border="1" align="left" style="font-weight: bold">
  <tr>
    <td width="109" bgcolor="#CCCCCC" ><div align="center" class="style2" >Date</div></td>
    <td width="238" bgcolor="#CCCCCC" ><div align="center" class="style2">Complainant (Name/Position)</div></td>
    <td width="109" bgcolor="#CCCCCC" ><div align="center" class="style2">Date Occurrence </div></td>
    <td width="149" bgcolor="#CCCCCC" ><div align="center" class="style2">Place of Occurrence</div></td>
	<td width="210" bgcolor="#CCCCCC" ><div align="center" class="style2">Complaints Details</div></td>
    <td width="165" bgcolor="#CCCCCC" ><div align="center" class="style2" >Status</div></td>
	<td width="54" bgcolor="#CCCCCC" ><div align="center" class="style2" >View</div></td>
	<td width="54" bgcolor="#CCCCCC" ><div align="center" class="style2" >ADD </div></td>
	<td width="54" bgcolor="#CCCCCC" ><div align="center" class="style2" >Dlt</div></td>
  </tr>

  <?php
  $Submit =($_POST['Submit']);
  $date=$_POST['textfield1'];
  $com_name=$_POST['cmp_name'];
  $occurence_date=$_POST['occurence_date'];
  $comp_details=$_POST['cmp_details'];
  $select=$_POST['select'];
  
    
if ($Submit ==="Search")
{
  if (($occurence_date=="" ) and ($select=="0" ) and ($com_name=="") and ($date=="") and ($comp_details==""))
	           {
		        echo "<script>alert(\"faild search , choose somthing for search .....\");</script>";
	           }
  else 
   {
       
     $sql="SELECT * FROM complaints WHERE 1=1 ";
       if ($date!=""){
	       $sql = $sql." and  complaints.cmp_date='$date'  group by complaints.cmp_id;";}
       if ($com_name!=""){
	       $sql = $sql." and complaints.cmp_name='$com_name'  group by complaints.cmp_id;";}
       if ($select!="n"){
	       $sql = $sql." and complaints.cmp_status ='$select' group by complaints.cmp_id";}
	   if  ($comp_details!="0"){
	       $sql = $sql." and complaints.cmp_details='$comp_details' group by complaints.cmp_id";}  
		   
	    if(($select!="n") and ($comp_details!="0")){
	
	  	echo "<script>alert(\"faild search , choose somthing for search .....\");</script>";
		 print "<script>";
	     print "self.location='index_page_compl_iiu.php?destt=$cmp_id'"; 
	     print "</script>";
		
		}
		
      else if ( $date !="" or $com_name!="" or $breaches_desc!="" or $occurence_place!="" or $select!="n" or $comp_details!="0" ){
	        $queryw=mysql_query($sql);
     while ($roww = mysql_fetch_array($queryw))
	    {
            echo "<tr>";
			echo "<td class=input02 align=center>" . $roww['cmp_date'] . "</td>";
            echo "<td class=input02 align=center>" . $roww['cmp_name']. " / " . $roww['cmp_designation'] ." </td>";  
            echo "<td class=input02 align=center>" . $roww['occurence_date']. "</td>";
            echo "<td class=input02 align=center>" . $roww['occurence_place']. "</td>";
			echo "<td class=input02 align=center>" . $roww['cmp_details']. "</td>";
            echo "<td class=input02 align=center>" . $roww['cmp_status'] . "</td>";
			
              $cmp_id=$roww['cmp_id'];
			  /*$encrypted = encryptIt($cmp_id);*/
			 
			  $condtion= $roww['cmp_status'];
			  if (($condtion=="Waiting for Approving") || ($condtion=="Under Investigation") || ($condtion=="Approved") || ($condtion=="Denied"))
			  {
			  echo "<td class=input02 align=center><a href='defendants.php?destt=$cmp_id'>V</a></td>";
              echo "<td class=input02 align=center>+</td>";
			  
               }
			  else if($condtion=="On process")
		      {	   
			  echo "<td class=input02 align=center>v</td>";
              echo "<td class=input02 align=center><a href='add_accused.php?destt=$cmp_id'>+</a></td>";
			  } 
			
	    $sqlCheck="select count(*) as count from defendants where cmp_id=$cmp_id";
		$ResultCheck=mysql_query($sqlCheck);
		$rowsCheck=mysql_fetch_array($ResultCheck);
		$d_count=$rowsCheck['count'];
		if ($d_count <=0){
			 echo "<td align=center><a onclick=\"return confirm('Are you sure you want to delete this Complainant ?')\" href='DeleteComplainant.php?cmp_id=$cmp_id'><img                           																																				src='style/images/ButtonBarDelete.gif' onmouseout=this.src='style/images/ButtonBarDelete.gif' onmouseover=this.src='../style/images/ButtonBarDeleteOver.gif'> </a> </td>";
			 }
			 else
			 {
			 echo "<td class=T-LA1 align=center> $d_count : ipos </td>";
			 }	
            echo "</tr>";
         } 
		 }
echo "</table>"; 

}
}
$Submit2 =($_POST['Submit2']);
if ($Submit2 ==="Reset Search")
    {
		 print "<script>";
	     print "self.location='index_page_compl_iiu.php?cmp_id=$cmp_id'"; 
	     print "</script>";
	 } 
?>

  
  
</tr>
</table>

<p class="style1">&nbsp;</p>
</body>
</html>

</p>
<?php
"</div>
<div id='bottom'></div>
</div>
</body>
</html>";
ob_end_flush();
?> 